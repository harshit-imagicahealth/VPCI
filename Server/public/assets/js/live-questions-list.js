(function (dataFetchUrl, markReadUrl, markUnreadUrl, csrf) {
  let dtPage = 1;
  let dtPerPage = 8;
  let dtSortCol = null;
  let dtSortDir = 1;
  let dtTotal = 0;
  let dtQuery = "";
  let dtSortKey = "created_at";
  let dtSortDirStr = "desc";
  let dtFetching = false;
  let activeTab = "unread";

  function dtFetch() {
    if (dtFetching) return;
    dtFetching = true;
    $("#pageLoader").removeClass("d-none");

    $.ajax({
      url: dataFetchUrl,
      type: "GET",
      data: {
        page: dtPage,
        perPage: dtPerPage,
        search: dtQuery,
        sortCol: dtSortKey,
        sortDir: dtSortDirStr,
        tab: activeTab,
      },
      dataType: "json",
      success: function (data) {
        dtTotal = data.total || 0;
        dtUnreadCount = data.unread_count || 0;
        dtReadCount = data.read_count || 0;
        dtRender(data.data || []);
        updateTabCount(activeTab, dtUnreadCount, dtReadCount);
      },
      error: function () {
        $("#dtBody").html(
          `<tr><td colspan="5" class="dt-empty text-danger"><i class="fa fa-triangle-exclamation"></i> Something went wrong</td></tr>`,
        );
      },
      complete: function () {
        $("#pageLoader").addClass("d-none");
        dtFetching = false;
      },
    });
  }

  function dtRender(rows) {
    const start = (dtPage - 1) * dtPerPage;
    const body = document.getElementById("dtBody");

    if (!rows.length) {
      body.innerHTML = `<tr><td colspan="5" class="dt-empty"><i class="fa fa-inbox"></i> No questions found</td></tr>`;
    } else {
      body.innerHTML = rows
        .map((r, i) => {
          const actionBtn =
            r.is_read == 0
              ? `<button class="btn-mark-read" data-id="${r.encrypt_id}"><i class="fa fa-envelope-open"></i> Mark as Read</button>`
              : `<button class="btn-mark-unread" data-id="${r.encrypt_id}"><i class="fa fa-envelope"></i> Mark as Unread</button>`;

          return `<tr>
                    <td>${start + i + 1}</td>
                    <td><div class="lq-question-text">${r.short}</div></td>
                    <td>${r.user_name}</td>
                    <td>${r.created_at}</td>
                    <td>${actionBtn}</td>
                </tr>`;
        })
        .join("");
    }

    const to = Math.min(start + dtPerPage, dtTotal);
    document.getElementById("dtInfo").textContent = dtTotal
      ? `Showing ${start + 1}–${to} of ${dtTotal} entries`
      : "No entries";
    dtBuildPagination();
  }

  function updateTabCount(tab, unreadCount, readCount) {
    const unreadEl = document.getElementById("unreadCount");
    const readEl = document.getElementById("readCount");
    if (unreadEl) unreadEl.textContent = unreadCount;
    if (readEl) readEl.textContent = readCount;
  }

  /* ── Tabs ── */
  document.querySelectorAll(".lq-tab").forEach((btn) => {
    btn.addEventListener("click", function () {
      document
        .querySelectorAll(".lq-tab")
        .forEach((b) => b.classList.remove("active"));
      this.classList.add("active");
      activeTab = this.dataset.tab;
      dtPage = 1;
      dtFetch();
    });
  });

  /* ── Search ── */
  let dtSearchTimer;
  document.getElementById("dtSearch").addEventListener("input", function () {
    clearTimeout(dtSearchTimer);
    dtSearchTimer = setTimeout(() => {
      dtQuery = this.value.trim();
      dtPage = 1;
      dtFetch();
    }, 350);
  });

  /* ── Sort ── */
  document.querySelectorAll(".data-sort").forEach((th) => {
    th.addEventListener("click", function () {
      const col = parseInt(this.dataset.col);
      const keys = ["id", "question", "created_at"];
      if (dtSortCol === col) {
        dtSortDir = -dtSortDir;
        dtSortDirStr = dtSortDir === 1 ? "asc" : "desc";
      } else {
        dtSortCol = col;
        dtSortDir = 1;
        dtSortDirStr = "asc";
      }
      dtSortKey = keys[col];
      document
        .querySelectorAll(".dt-sort-icon")
        .forEach((i) => (i.className = "fa fa-sort dt-sort-icon"));
      this.querySelector(".dt-sort-icon").className =
        `fa fa-sort-${dtSortDir === 1 ? "up" : "down"} dt-sort-icon`;
      dtPage = 1;
      dtFetch();
    });
  });

  /* ── Pagination ── */
  function dtBuildPagination() {
    const pages = Math.ceil(dtTotal / dtPerPage);
    const wrap = document.getElementById("dtPagination");
    let html = `<button class="dt-page-btn" onclick="dtGoPage(${dtPage - 1})" ${dtPage === 1 ? "disabled" : ""}><i class="fa fa-chevron-left" style="font-size:.7rem;"></i></button>`;
    dtPageRange(dtPage, pages).forEach((p) => {
      html +=
        p === "…"
          ? `<button class="dt-page-btn" disabled>…</button>`
          : `<button class="dt-page-btn ${p === dtPage ? "dt-page-active" : ""}" onclick="dtGoPage(${p})">${p}</button>`;
    });
    html += `<button class="dt-page-btn" onclick="dtGoPage(${dtPage + 1})" ${dtPage === pages ? "disabled" : ""}><i class="fa fa-chevron-right" style="font-size:.7rem;"></i></button>`;
    wrap.innerHTML = html;
  }

  function dtPageRange(cur, total) {
    if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
    if (cur <= 4) return [1, 2, 3, 4, 5, "…", total];
    if (cur >= total - 3)
      return [1, "…", total - 4, total - 3, total - 2, total - 1, total];
    return [1, "…", cur - 1, cur, cur + 1, "…", total];
  }

  window.dtGoPage = function (p) {
    const pages = Math.ceil(dtTotal / dtPerPage);
    if (p < 1 || p > pages) return;
    dtPage = p;
    dtFetch();
  };

  /* ── Mark Read / Unread ── */
  $(document).on("click", ".btn-mark-read, .btn-mark-unread", function () {
    const id = $(this).data("id");
    const isRead = $(this).hasClass("btn-mark-read");
    const url = isRead
      ? markReadUrl.replace(":id", id)
      : markUnreadUrl.replace(":id", id);

    $("#pageLoader").removeClass("d-none");
    $.ajax({
      url,
      type: "POST",
      data: { _token: csrf },
      success: function (res) {
        if (res.status) dtFetch();
        else
          Swal.fire({
            icon: "error",
            title: "Oops!",
            text: res.message || "Something went wrong!",
          });
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Oops!",
          text: "Something went wrong!",
        });
      },
      complete: function () {
        $("#pageLoader").addClass("d-none");
      },
    });
  });

  dtFetch();
})(dataFetchUrl, markReadUrl, markUnreadUrl, csrf);
