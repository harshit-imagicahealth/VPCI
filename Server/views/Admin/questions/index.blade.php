@extends('Admin.layouts.main')
@section('title', 'Activity Questions')
@push('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.questions.index') }}">Activity Questions</a></li>
<li class="breadcrumb-item active">Index</li>
@endpush

@section('content')
<div class="dt-card p-4">
    <div class="dt-toolbar">
        <div class="dt-search">
            <i class="fa fa-magnifying-glass"></i>
            <input type="text" id="dtSearch" placeholder="Search..." />
        </div>
        <div class="dt-actions">
            <a class="dt-btn dt-btn-primary" href="{{ route('admin.questions.create') }}">
                <i class="fa fa-plus"></i>
                <span>Add</span>
            </a>
        </div>
    </div>

    <div class="dt-table-wrap">
        <table id="dtTable" class="dt-table">
            <thead>
                <tr>
                    <th class="data-sort" data-col="0"># <i class="fa fa-sort dt-sort-icon"></i></th>
                    <th class="data-sort" data-col="1">Question Type <i class="fa fa-sort dt-sort-icon"></i></th>
                    <th class="data-sort" data-col="2">Question <i class="fa fa-sort dt-sort-icon"></i></th>
                    <th class="data-sort" data-col="3">Answer <i class="fa fa-sort dt-sort-icon"></i></th>
                    <th class="data-sort" data-col="4">Status <i class="fa fa-sort dt-sort-icon"></i></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="dtBody"></tbody>
        </table>
    </div>

    <div class="dt-footer">
        <div id="dtInfo" class="dt-info">Showing 0 of 0 entries</div>
        <div id="dtPagination" class="dt-pagination"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let dataFetchUrl = "{{ route('admin.questions.list.data') }}";
    let editUrl = "{{ route('admin.questions.edit', ':id') }}";
    let deleteUrl = "{{ route('admin.questions.destroy', ':id') }}";
    let toggleUrl = "{{ url('admin/questions/:id/toggle') }}";
    let csrf = "{{ csrf_token() }}";
</script>
<script src="{{ asset('public/assets/js/questions-list.js?v=') . time() }}"></script>
@endpush