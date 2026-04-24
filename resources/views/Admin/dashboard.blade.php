@extends('Admin.layouts.main')
@section('title', 'Dashboard')
@push('breadcrumbs')
    <li class="breadcrumb-item active">Dashboard</li>
@endpush

@push('styles')
    <style>

    </style>
@endpush

@section('content')
    <!-- Demo dashboard content -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:var(--primaryThemeColor)"><i class="fa fa-users"></i></div>
                <div>
                    <h3>1,248</h3>
                    <p>Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:var(--accentColor)"><i class="fa fa-user-check"></i></div>
                <div>
                    <h3>984</h3>
                    <p>Active Users</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#22a762"><i class="fa fa-video"></i></div>
                <div>
                    <h3>56</h3>
                    <p>Webcasts</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#f7941d"><i class="fa fa-book-open"></i></div>
                <div>
                    <h3>120</h3>
                    <p>Resources</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Placeholder card -->
    <div style="background:#fff;border-radius:12px;padding:28px;box-shadow:0 2px 14px rgba(0,0,0,.06);">
        <p style="color:var(--textMuted);font-size:.88rem;margin:0;">
            <i class="fa fa-info-circle me-1"></i>
            Main content area — replace with your view content.
        </p>
    </div>
@endsection

@push('scripts')
    <script></script>
@endpush
