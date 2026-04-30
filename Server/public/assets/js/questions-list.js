(function (dataFetchUrl, editUrl, deleteUrl, toggleUrl, csrf) {
  let dtPage = 1;
  let dtPerPage = 8;
  let dtSortCol = null;
  let dtSortDir = 1;
  let dtTotal = 0;
  let dtQuery = "";
  let dtSortKey = "";
  let dtSortDirStr = "asc";
  let dtFetching = false;

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
      },
      dataType: "json",
      success: function (data) {
        if (!data || !data.data || data.data.length === 0) {
          dtTotal = 0;
          dtRender([]);
          return;
        }
        dtTotal = data.total || 0;
        dtRender(data.data);
      },
      error: function () {
        $("#dtBody").html(
          `<tr><td colspan="6" class="dt-empty text-danger"><i class="fa fa-triangle-exclamation"></i> Something went wrong</td></tr>`,
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

    if (!rows || rows.length === 0) {
      body.innerHTML = `<tr><td colspan="6" class="dt-empty"><i class="fa fa-circle-question"></i> No questions found</td></tr>`;
    } else {
      body.innerHTML = rows
        .map((r, i) => {
          const badge =
            r.status == 1
              ? `<span class="dt-badge dt-badge-active">Enabled</span>`
              : `<span class="dt-badge dt-badge-inactive">Disabled</span>`;

          return `<tr>
                    <td>${start + i + 1}</td>
                    <td>${r.question_type ?? "-"}</td>
                    <td>${r.question ?? "-"}</td>
                    <td>${r.answer ?? "-"}</td>
                    <td>${badge}</td>
                    <td>
                        <div class="dt-action-wrap">
                            <button type="button" data-id="${r.encrypt_id}" data-status="${r.status}" class="dt-action toggle-btn" title="Toggle Status">
                                <i class="fa ${r.status == 1 ? "fa-toggle-on" : "fa-toggle-off"}"></i>
                            </button>
                            <a href="${editUrl.replace(":id", r.encrypt_id)}" class="dt-action dt-action-edit">
                                <i class="fa fa-pen"></i>
                            </a>
                            <button type="button" data-id="${r.encrypt_id}" class="dt-action dt-action-delete delete-btn">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
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

  let dtSearchTimer;
  $("#dtSearch").on("input", function () {
    clearTimeout(dtSearchTimer);
    dtSearchTimer = setTimeout(() => {
      dtQuery = this.value.trim();
      dtPage = 1;
      dtFetch();
    }, 350);
  });

  $(".data-sort").click(function () {
    const col = parseInt(this.dataset.col);
    const keys = ["id", "question_type", "question", "answer", "status"];
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

  function dtBuildPagination() {
    const pages = Math.ceil(dtTotal / dtPerPage);
    const wrap = document.getElementById("dtPagination");
    let html = `<button class="dt-page-btn" data-page="${dtPage - 1}" ${dtPage === 1 ? "disabled" : ""}><i class="fa fa-chevron-left" style="font-size:.7rem;"></i></button>`;
    dtPageRange(dtPage, pages).forEach((p) => {
      html +=
        p === "…"
          ? `<button class="dt-page-btn" disabled>…</button>`
          : `<button class="dt-page-btn ${p === dtPage ? "dt-page-active" : ""}"  data-page="${p}">${p}</button>`;
    });
    html += `<button class="dt-page-btn" data-page="${dtPage + 1}" ${dtPage === pages ? "disabled" : ""}><i class="fa fa-chevron-right" style="font-size:.7rem;"></i></button>`;
    wrap.innerHTML = html;
  }

  function dtPageRange(cur, total) {
    if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
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

  $(document).on("click", ".toggle-btn", function () {
    const id = $(this).data("id");
    const url = toggleUrl.replace(":id", id);
    $("#pageLoader").removeClass("d-none");
    $.ajax({
      url: url,
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

  $(document).on("click", ".delete-btn", function () {
    const id = $(this).data("id");
    const url = deleteUrl.replace(":id", id);
    Swal.fire({
      title: "Are you sure?",
      text: "This question will be deleted permanently!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (!result.isConfirmed) return;
      $("#pageLoader").removeClass("d-none");
      $.ajax({
        url: url,
        type: "POST",
        data: { _token: csrf, _method: "DELETE" },
        success: function (res) {
          Swal.fire(
            res.status
              ? {
                  icon: "success",
                  title: "Deleted!",
                  text: res.message || "Question deleted successfully",
                  timer: 1500,
                  showConfirmButton: false,
                }
              : {
                  icon: "error",
                  title: "Oops!",
                  text: res.message || "Something went wrong!",
                },
          );
          dtFetch();
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
  });

  dtFetch();
})(dataFetchUrl, editUrl, deleteUrl, toggleUrl, csrf);
