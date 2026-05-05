(function (dataFetchUrl, exportUrl) {
  $(document).ready(() => {
    let dtPage = 1;
    let dtPerPage = 8;
    let dtSortCol = null;
    let dtSortDir = 1;
    let dtTotal = 0;
    let dtQuery = "";
    let dtSortKey = "";
    let dtSortDirStr = "asc";
    let dtFetching = false;

    /* ── Fetch page from server ── */
    function dtFetch() {
      if (dtFetching) return;
      dtFetching = true;

      const loader = $("#pageLoader");

      const params = {
        page: dtPage,
        perPage: dtPerPage,
        search: dtQuery,
        sortCol: dtSortKey,
        sortDir: dtSortDirStr,
      };
      loader.removeClass("d-none"); // 🔥 show loader

      $.ajax({
        url: dataFetchUrl,
        type: "GET",
        data: params,
        dataType: "json",

        success: function (data) {
          if (!data || !data.data || data.data.length === 0) {
            dtTotal = 0;
            dtRender([]);
            loader.addClass("d-none"); // 🔥 hide loader
            return;
          }

          dtTotal = data.total || 0;
          dtRender(data.data);
          loader.addClass("d-none"); // 🔥 hide loader
        },

        error: function () {
          $("#dtBody").html(`
              <tr>
                  <td colspan="9" class="dt-empty text-danger">
                      <i class="fa fa-triangle-exclamation"></i>
                      Something went wrong
                  </td>
              </tr>
          `);
        },

        complete: function () {
          dtFetching = false;
        },
      });
    }

    /* ── Render ── */
    function dtRender(rows) {
      const start = (dtPage - 1) * dtPerPage;
      const body = document.getElementById("dtBody");

      if (!rows || rows.length === 0) {
        body.innerHTML = `
                        <tr>
                            <td colspan="9" class="dt-empty">
                                <i class="fa fa-users-slash"></i>
                                No records found
                            </td>
                        </tr>`;
      } else {
        body.innerHTML = rows
          .map((r, i) => {
            const init = (r.name || "")
              .split(" ")
              .map((w) => w[0])
              .join("")
              .substring(0, 2)
              .toUpperCase();

            const badge =
              r.status === "active"
                ? `<span class="dt-badge dt-badge-active">Active</span>`
                : r.status === "pending"
                  ? `<span class="dt-badge dt-badge-pending">Pending</span>`
                  : `<span class="dt-badge dt-badge-inactive">Inactive</span>`;

            return `
                            <tr>
                                <!-- <td><input type="checkbox" class="dt-check dt-row-check"/></td> --!>
                                <td>${start + i + 1}</td>
                                <td>
                                    <div class="dt-name-cell">
                                        <!-- <div class="dt-avatar">${init}</div> --!>
                                        <div>
                                            <div class="dt-name">${r.name ?? "-"}</div>
                                            <div class="dt-sub">${r.degree ?? "-"}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>${r.email ?? "-"}</td>
                                <td>${r.mobile ?? "-"}</td>
                                <td>${r.hospital ?? "-"}</td>
                                <td>${r.degree ?? "-"}</td>
                                <td>${badge}</td>
                                <!-- <td>
                                    <div class="dt-action-wrap">
                                        <button class="dt-action dt-action-view"><i class="fa fa-eye"></i></button>
                                        <button class="dt-action dt-action-edit"><i class="fa fa-pen"></i></button>
                                        <button class="dt-action dt-action-delete"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td> --!>
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

    /* ── Search (debounced) ── */
    let dtSearchTimer;

    function dtFilter() {
      clearTimeout(dtSearchTimer);
      dtSearchTimer = setTimeout(() => {
        dtQuery = document.getElementById("dtSearch").value.trim();
        dtPage = 1;
        dtFetch();
      }, 350);
    }

    /* ── Sort ── */
    function dtSort(th) {
      const col = parseInt(th.dataset.col);
      const keys = [
        "id",
        "id",
        "name",
        "email",
        "mobile",
        "hospital",
        "degree",
        "status",
      ];
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
      th.querySelector(".dt-sort-icon").className =
        `fa fa-sort-${dtSortDir === 1 ? "up" : "down"} dt-sort-icon`;
      dtPage = 1;
      dtFetch();
    }

    /* ── Pagination ── */
    function dtBuildPagination() {
      const pages = Math.ceil(dtTotal / dtPerPage);
      const wrap = document.getElementById("dtPagination");
      // if (pages <= 1) {
      //     wrap.innerHTML = "";
      //     return;
      // }

      let html = `<button class="dt-page-btn" data-page="${dtPage - 1}" ${dtPage === 1 ? "disabled" : ""}>
                        <i class="fa fa-chevron-left" style="font-size:.7rem;"></i></button>`;

      dtPageRange(dtPage, pages).forEach((p) => {
        if (p === "…") {
          html += `<button class="dt-page-btn" disabled>…</button>`;
        } else {
          html += `<button class="dt-page-btn ${p === dtPage ? "dt-page-active" : ""}" data-page="${p}">${p}</button>`;
        }
      });

      html += `<button class="dt-page-btn" data-page="${dtPage + 1}"  ${dtPage === pages ? "disabled" : ""}>
                     <i class="fa fa-chevron-right" style="font-size:.7rem;"></i></button>`;
      wrap.innerHTML = html;
    }

    function dtPageRange(cur, total) {
      if (total <= 7)
        return Array.from(
          {
            length: total,
          },
          (_, i) => i + 1,
        );
      if (cur <= 4) return [1, 2, 3, 4, 5, "…", total];
      if (cur >= total - 3)
        return [1, "…", total - 4, total - 3, total - 2, total - 1, total];
      return [1, "…", cur - 1, cur, cur + 1, "…", total];
    }

    function dtGoPage(p) {
      const pages = Math.ceil(dtTotal / dtPerPage);
      if (p < 1 || p > pages) return;
      dtPage = p;
      dtFetch();
    }

    $(document).on("click", ".dt-page-btn", function () {
      let page = $(this).data("page");
      if (page === "") return;
      dtGoPage(page);
    });

    /* ── Select all ── */
    function dtToggleAll(cb) {
      document
        .querySelectorAll(".dt-row-check")
        .forEach((c) => (c.checked = cb.checked));
    }

    /* ── CSV Export (current filtered set, server-side) ── */
    function dtExportCSV() {
      const params = new URLSearchParams({
        search: dtQuery,
        sortCol: dtSortKey,
        sortDir: dtSortDirStr,
        export: "csv",
      });
      // window.location.href = `${exportUrl}?${params}`;
    }

    /* ── Init ── */
    dtFetch();
  });
})(dataFetchUrl, exportUrl);
