@extends('Admin.layouts.main')
@section('title', 'Category')
@push('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('admin.category.index') }}">
        Category
    </a>
</li>
<li class="breadcrumb-item active">Index</li>
@endpush

@push('styles')
@endpush

@section('content')

{{-- ── Toolbar ── --}}
<div class="dt-card p-4">

    <div class="dt-toolbar">
        {{-- Search --}}
        <div class="dt-search">
            <i class="fa fa-magnifying-glass"></i>
            <input type="text" id="dtSearch" placeholder="Search..." />
        </div>

        {{-- Actions --}}
        <div class="dt-actions">
            {{-- <button class="dt-btn dt-btn-outline" onclick="dtExportCSV()">
                    <i class="fa fa-download"></i>
                    <span>CSV</span>
                </button> --}}
            <a class="dt-btn dt-btn-primary" href="{{ route('admin.category.create') }}">
                <i class="fa fa-plus"></i>
                <span>Add</span>
            </a>
        </div>
    </div>

    {{-- ── Table ── --}}
    <div class="dt-table-wrap">
        <table id="dtTable" class="dt-table">
            <thead>
                <tr>
                    <th class="data-sort" data-col="0"># <i class="fa fa-sort dt-sort-icon"></i></th>
                    <th class="data-sort" data-col="1">Name <i class="fa fa-sort dt-sort-icon"></i></th>
                    <th>Actions</th>
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
    let dataFetchUrl = "{{ route('admin.category.list.data') }}";
    let exportUrl = null;
    let editUrl = "{{ route('admin.category.edit', ['id' => ':id']) }}";
    let deleteUrl = "{{ route('admin.category.delete', ['id' => ':id']) }}";
    let csrf = "{{ csrf_token() }}";
</script>
<script src="{{ asset('public/assets/js/category-list.js?v=') . time() }}"></script>
@endpush