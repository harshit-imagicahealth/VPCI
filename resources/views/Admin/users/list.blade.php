@extends('Admin.layouts.main')
@section('title', 'Users')
@push('breadcrumbs')
    <li class="breadcrumb-item active">Users</li>
@endpush

@push('styles')
    <style>

    </style>
@endpush

@section('content')

    {{-- ── Toolbar ── --}}
    <div class="dt-card p-4">

        <div class="dt-toolbar">
            {{-- Search --}}
            <div class="dt-search">
                <i class="fa fa-magnifying-glass"></i>
                <input type="text" id="dtSearch" placeholder="Search..." oninput="dtFilter()" />
            </div>

            {{-- Actions --}}
            <div class="dt-actions">
                <button class="dt-btn dt-btn-outline" onclick="dtExportCSV()">
                    <i class="fa fa-download"></i>
                    <span>CSV</span>
                </button>
                <button class="dt-btn dt-btn-primary" onclick="location.href='#'">
                    <i class="fa fa-plus"></i>
                    <span>Add User</span>
                </button>
            </div>
        </div>

        {{-- ── Table ── --}}
        <div class="dt-table-wrap">
            <table id="dtTable" class="dt-table">
                <thead>
                    <tr>
                        {{-- <th style="width:42px;">
                            <input type="checkbox" id="dtCheckAll" class="dt-check" onchange="dtToggleAll(this)" />
                        </th> --}}
                        <th data-col="0" onclick="dtSort(this)"># <i class="fa fa-sort dt-sort-icon"></i></th>
                        <th data-col="1" onclick="dtSort(this)">Name <i class="fa fa-sort dt-sort-icon"></i></th>
                        <th data-col="2" onclick="dtSort(this)">Email <i class="fa fa-sort dt-sort-icon"></i></th>
                        <th data-col="3" onclick="dtSort(this)">Mobile <i class="fa fa-sort dt-sort-icon"></i></th>
                        <th data-col="4" onclick="dtSort(this)">Hospital / Clinic <i class="fa fa-sort dt-sort-icon"></i>
                        </th>
                        <th data-col="5" onclick="dtSort(this)">Degree <i class="fa fa-sort dt-sort-icon"></i></th>
                        <th data-col="6" onclick="dtSort(this)">Status <i class="fa fa-sort dt-sort-icon"></i></th>
                        {{-- <th>Actions</th> --}}
                    </tr>
                </thead>
                <tbody id="dtBody"></tbody>
            </table>
        </div>

        {{-- ── Footer: info + pagination ── --}}
        <div class="dt-footer">
            <div id="dtInfo" class="dt-info">Showing 0 of 0 entries</div>
            <div id="dtPagination" class="dt-pagination"></div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        let dataFetchUrl = "{{ route('admin.users.list.data') }}";
        let exportUrl = null;
    </script>
    <script src="{{ asset('assets/js/users-list.js?v=') . time() }}"></script>
    {{-- <script>
        /* ── Sample data (replace with server data) ── */
        const dtData = [{
                id: 1,
                name: 'Dr. Priya Sharma',
                email: 'priya@example.com',
                mobile: '9876543210',
                hospital: 'Apollo Hospital',
                degree: 'M.D. Nutrition',
                status: 'active'
            },
            {
                id: 2,
                name: 'Mr. Rahul Mehta',
                email: 'rahul@example.com',
                mobile: '9123456780',
                hospital: 'City Clinic',
                degree: 'B.Sc Dietetics',
                status: 'pending'
            },
            {
                id: 3,
                name: 'Ms. Anjali Singh',
                email: 'anjali@example.com',
                mobile: '9988776655',
                hospital: 'Fortis Hospital',
                degree: 'M.Sc Nutrition',
                status: 'active'
            },
            {
                id: 4,
                name: 'Mrs. Kavita Desai',
                email: 'kavita@example.com',
                mobile: '9871234560',
                hospital: 'Care Wellness',
                degree: 'Ph.D Nutrition',
                status: 'inactive'
            },
            {
                id: 5,
                name: 'Dr. Anil Kumar',
                email: 'anil@example.com',
                mobile: '9000123456',
                hospital: 'Max Healthcare',
                degree: 'M.D. Dietology',
                status: 'active'
            },
            {
                id: 6,
                name: 'Ms. Pooja Rao',
                email: 'pooja@example.com',
                mobile: '9321654870',
                hospital: 'Narayana Health',
                degree: 'B.Sc Nutrition',
                status: 'active'
            },
            {
                id: 7,
                name: 'Mr. Suresh Nair',
                email: 'suresh@example.com',
                mobile: '9012345678',
                hospital: 'Lilavati Hospital',
                degree: 'M.Sc Dietetics',
                status: 'pending'
            },
            {
                id: 8,
                name: 'Dr. Neha Gupta',
                email: 'neha@example.com',
                mobile: '9876001234',
                hospital: 'Hinduja Hospital',
                degree: 'M.D. Nutrition',
                status: 'active'
            },
            {
                id: 9,
                name: 'Mrs. Ritu Joshi',
                email: 'ritu@example.com',
                mobile: '9765432100',
                hospital: 'Kokilaben Hospital',
                degree: 'B.Sc Dietetics',
                status: 'inactive'
            },
            {
                id: 10,
                name: 'Mr. Vivek Patil',
                email: 'vivek@example.com',
                mobile: '9654321098',
                hospital: 'Wockhardt Hospital',
                degree: 'M.Sc Nutrition',
                status: 'active'
            },
            {
                id: 11,
                name: 'Dr. Sneha Kulkarni',
                email: 'sneha@example.com',
                mobile: '9543210987',
                hospital: 'Ruby Hall Clinic',
                degree: 'Ph.D Dietology',
                status: 'active'
            },
            {
                id: 12,
                name: 'Ms. Meera Iyer',
                email: 'meera@example.com',
                mobile: '9432109876',
                hospital: 'Manipal Hospital',
                degree: 'B.Sc Nutrition',
                status: 'pending'
            },
        ];

        let dtFiltered = [...dtData];
        let dtPage = 1;
        let dtPerPage = 8;
        let dtSortCol = null;
        let dtSortDir = 1;

        /* ── Render ── */
        function dtRender() {
            const start = (dtPage - 1) * dtPerPage;
            const rows = dtFiltered.slice(start, start + dtPerPage);
            const body = document.getElementById('dtBody');

            if (!rows.length) {
                body.innerHTML =
                    `<tr><td colspan="9" class="dt-empty"><i class="fa fa-users-slash"></i>No records found</td></tr>`;
            } else {
                body.innerHTML = rows.map((r, i) => {
                    const init = r.name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
                    const badge = r.status === 'active' ?
                        `<span class="dt-badge dt-badge-active">Active</span>` :
                        r.status === 'pending' ?
                        `<span class="dt-badge dt-badge-pending">Pending</span>` :
                        `<span class="dt-badge dt-badge-inactive">Inactive</span>`;
                    return `
      <tr>
        <td><input type="checkbox" class="dt-check dt-row-check"/></td>
        <td>${start + i + 1}</td>
        <td>
          <div class="dt-name-cell">
            <div class="dt-avatar">${init}</div>
            <div>
              <div class="dt-name">${r.name}</div>
              <div class="dt-sub">${r.degree}</div>
            </div>
          </div>
        </td>
        <td>${r.email}</td>
        <td>${r.mobile}</td>
        <td>${r.hospital}</td>
        <td>${r.degree}</td>
        <td>${badge}</td>
        <td>
          <div class="dt-action-wrap">
            <button class="dt-action dt-action-view"   title="View">  <i class="fa fa-eye"></i></button>
            <button class="dt-action dt-action-edit"   title="Edit">  <i class="fa fa-pen"></i></button>
            <button class="dt-action dt-action-delete" title="Delete"><i class="fa fa-trash"></i></button>
          </div>
        </td>
      </tr>`;
                }).join('');
            }

            const total = dtFiltered.length;
            const to = Math.min(start + dtPerPage, total);
            document.getElementById('dtInfo').textContent =
                total ? `Showing ${start + 1}–${to} of ${total} entries` : 'No entries';
            dtBuildPagination();
        }

        /* ── Filter ── */
        function dtFilter() {
            const q = document.getElementById('dtSearch').value.toLowerCase();
            dtFiltered = dtData.filter(r =>
                Object.values(r).join(' ').toLowerCase().includes(q)
            );
            dtPage = 1;
            dtRender();
        }

        /* ── Sort ── */
        function dtSort(th) {
            const col = parseInt(th.dataset.col);
            const keys = ['id', 'id', 'name', 'email', 'mobile', 'hospital', 'degree', 'status'];
            dtSortDir = (dtSortCol === col) ? -dtSortDir : 1;
            dtSortCol = col;
            dtFiltered.sort((a, b) => {
                const k = keys[col];
                return String(a[k]).localeCompare(String(b[k])) * dtSortDir;
            });
            document.querySelectorAll('.dt-sort-icon').forEach(i => i.className = 'fa fa-sort dt-sort-icon');
            th.querySelector('.dt-sort-icon').className = `fa fa-sort-${dtSortDir === 1 ? 'up' : 'down'} dt-sort-icon`;
            dtPage = 1;
            dtRender();
        }

        /* ── Pagination ── */
        function dtBuildPagination() {
            const pages = Math.ceil(dtFiltered.length / dtPerPage);
            const wrap = document.getElementById('dtPagination');
            if (pages <= 1) {
                wrap.innerHTML = '';
                return;
            }

            let html = `<button class="dt-page-btn" onclick="dtGoPage(${dtPage-1})" ${dtPage===1?'disabled':''}>
                <i class="fa fa-chevron-left" style="font-size:.7rem;"></i></button>`;

            const range = dtPageRange(dtPage, pages);
            range.forEach(p => {
                if (p === '…') {
                    html += `<button class="dt-page-btn" disabled>…</button>`;
                } else {
                    html +=
                        `<button class="dt-page-btn ${p===dtPage?'dt-page-active':''}" onclick="dtGoPage(${p})">${p}</button>`;
                }
            });

            html += `<button class="dt-page-btn" onclick="dtGoPage(${dtPage+1})" ${dtPage===pages?'disabled':''}>
             <i class="fa fa-chevron-right" style="font-size:.7rem;"></i></button>`;
            wrap.innerHTML = html;
        }

        function dtPageRange(cur, total) {
            if (total <= 7) return Array.from({
                length: total
            }, (_, i) => i + 1);
            if (cur <= 4) return [1, 2, 3, 4, 5, '…', total];
            if (cur >= total - 3) return [1, '…', total - 4, total - 3, total - 2, total - 1, total];
            return [1, '…', cur - 1, cur, cur + 1, '…', total];
        }

        function dtGoPage(p) {
            const pages = Math.ceil(dtFiltered.length / dtPerPage);
            if (p < 1 || p > pages) return;
            dtPage = p;
            dtRender();
        }

        /* ── Select all ── */
        function dtToggleAll(cb) {
            document.querySelectorAll('.dt-row-check').forEach(c => c.checked = cb.checked);
        }

        /* ── CSV Export ── */
        function dtExportCSV() {
            const headers = ['#', 'Name', 'Email', 'Mobile', 'Hospital/Clinic', 'Degree', 'Status'];
            const rows = dtFiltered.map((r, i) => [i + 1, r.name, r.email, r.mobile, r.hospital, r.degree, r.status]);
            const csv = [headers, ...rows].map(r => r.map(v => `"${v}"`).join(',')).join('\n');
            const blob = new Blob([csv], {
                type: 'text/csv'
            });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'users.csv';
            a.click();
        }

        /* ── Init ── */
        dtRender();
    </script> --}}
@endpush
