(function (dataFetchUrl, exportUrl, deleteUrl, editUrl, csrf) {
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
                    return;
                }

                dtTotal = data.total || 0;
                dtRender(data.data);
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
                loader.addClass("d-none"); // 🔥 hide loader
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
                        <td colspan="7" class="dt-empty">
                            <i class="fa fa-video-slash"></i>
                            No webcasts found
                        </td>
                    </tr>`;
        } else {
            body.innerHTML = rows
                .map((r, i) => {
                    // Time format
                    const time = `${String(r.webcast_hour).padStart(2, "0")}:${r.webcast_minute} ${r.webcast_ampm}`;

                    // Status badge
                    const badge =
                        r.status === "live"
                            ? `<span class="dt-badge dt-badge-active">Live</span>`
                            : r.status === "upcoming"
                              ? `<span class="dt-badge dt-badge-pending">Upcoming</span>`
                              : `<span class="dt-badge dt-badge-inactive">Completed</span>`;

                    return `
                            <tr>
                                <td>${start + i + 1}</td>

                                <td>${r.content_title ?? "-"}</td>

                                <td>${r.activity_name ?? "-"}</td>

                                <td>${r.dr_name ?? "-"}</td>

                                <td>${r.webcast_date ?? "-"}</td>

                                <td>${time}</td>

                                <td>${badge}</td>

                                <td>
                                    <div class="dt-action-wrap">

                                        <!-- Edit -->
                                        <a href="${editUrl.replace(":id", r.encrypt_id)}" 
                                        class="dt-action dt-action-edit">
                                        <i class="fa fa-pen"></i>
                                        </a>

                                        <!-- Delete -->
                                        <button type="button" data-id="${r.encrypt_id}" class="dt-action dt-action-delete delete-btn">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            `;
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
    $("#dtSearch").on("input", dtFilter);

    /* ── Sort ── */
    function dtSort(th) {
        const col = parseInt(th.dataset.col);
        const keys = [
            "id",
            "content_title",
            "activity_name",
            "dr_name",
            "webcast_date",
            "webcast_hour",
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
    $(".data-sort").click(function () {
        dtSort(this);
    });

    /* ── Pagination ── */
    function dtBuildPagination() {
        const pages = Math.ceil(dtTotal / dtPerPage);
        const wrap = document.getElementById("dtPagination");
        // if (pages <= 1) {
        //     wrap.innerHTML = "";
        //     return;
        // }

        let html = `<button class="dt-page-btn" onclick="dtGoPage(${dtPage - 1})" ${dtPage === 1 ? "disabled" : ""}>
                        <i class="fa fa-chevron-left" style="font-size:.7rem;"></i></button>`;

        dtPageRange(dtPage, pages).forEach((p) => {
            if (p === "…") {
                html += `<button class="dt-page-btn" disabled>…</button>`;
            } else {
                html += `<button class="dt-page-btn ${p === dtPage ? "dt-page-active" : ""}" onclick="dtGoPage(${p})">${p}</button>`;
            }
        });

        html += `<button class="dt-page-btn" onclick="dtGoPage(${dtPage + 1})" ${dtPage === pages ? "disabled" : ""}>
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

    /* ── Delete script swal model alert ── */

    $(document).on("click", ".delete-btn", function () {
        const id = $(this).data("id");
        const url = deleteUrl.replace(":id", id);

        Swal.fire({
            title: "Are you sure?",
            text: "This webcast will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $("#pageLoader").removeClass("d-none"); // show loader

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: csrf,
                        _method: "DELETE",
                    },

                    success: function (res) {
                        if (!res.status) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops!",
                                text: res.message || "Something went wrong!",
                            });
                        } else {
                            Swal.fire({
                                icon: "success",
                                title: "Deleted!",
                                text:
                                    res.message ||
                                    "Webcast deleted successfully",
                                timer: 1500,
                                showConfirmButton: false,
                            });
                        }
                        dtFetch(); // reload table
                    },

                    error: function () {
                        Swal.fire({
                            icon: "error",
                            title: "Oops!",
                            text: "Something went wrong!",
                        });
                    },

                    complete: function () {
                        $("#pageLoader").addClass("d-none"); // hide loader
                    },
                });
            }
        });
    });

    /* ── search ── */

    /* ── Init ── */
    dtFetch();
})(dataFetchUrl, exportUrl, deleteUrl, editUrl, csrf);
