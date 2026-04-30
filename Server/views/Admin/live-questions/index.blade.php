@extends('Admin.layouts.main')
@section('title', 'Live Questions')

@push('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">WebCast</a></li>
    <li class="breadcrumb-item active">Live Questions</li>
@endpush

@section('content')
    <div class="dt-card p-4">

        {{-- Tabs --}}
        <div class="lq-tabs">
            <button class="lq-tab active" data-tab="unread">
                <i class="fa fa-envelope"></i> Unread
                <span id="unreadCount" class="lq-tab-count">0</span>
            </button>
            <button class="lq-tab" data-tab="read">
                <i class="fa fa-envelope-open"></i> Read
                <span id="readCount" class="lq-tab-count">0</span>
            </button>
        </div>

        {{-- Toolbar --}}
        <div class="dt-toolbar mt-3">
            <div class="dt-search">
                <i class="fa fa-magnifying-glass"></i>
                <input type="text" id="dtSearch" placeholder="Search question or user..." />
            </div>
        </div>

        {{-- Table --}}
        <div class="dt-table-wrap">
            <table class="dt-table">
                <thead>
                    <tr>
                        <th class="data-sort" data-col="0"># <i class="fa fa-sort dt-sort-icon"></i></th>
                        <th class="data-sort" data-col="1">Question <i class="fa fa-sort dt-sort-icon"></i></th>
                        <th>Asked By</th>
                        <th class="data-sort" data-col="2">Date <i class="fa fa-sort dt-sort-icon"></i></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="dtBody"></tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="dt-footer">
            <div id="dtInfo" class="dt-info">Showing 0 of 0 entries</div>
            <div id="dtPagination" class="dt-pagination"></div>
        </div>

    </div>
@endsection

@push('styles')
    <style>

    </style>
@endpush

@push('scripts')
    <script>
        const dataFetchUrl = "{{ route('admin.live-questions.list.data', $activityId) }}";
        const markReadUrl = "{{ route('admin.live-questions.mark.read', ['id' => ':id']) }}";
        const markUnreadUrl = "{{ route('admin.live-questions.mark.unread', ['id' => ':id']) }}";
        const csrf = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('public/assets/js/live-questions-list.js?v=') . time() }}"></script>
@endpush
