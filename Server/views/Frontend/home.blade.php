@extends('Frontend.layouts.app')
@section('title', 'Home ')

@push('styles')
    <style>

    </style>
@endpush

@section('main')
    <!-- HERO BANNER -->
    <div class="main-banner">
        <div class="main-slider nav-style-1">
            <div class="banner-slide text-left">
                <a target="_blank" href="">
                    <figure data-overlay="8">
                        <picture>
                            <!-- Mobile Image -->
                            <source srcset="{{ asset('public/assets/images/home-banner.png') }}" media="(max-width: 767px)">

                            <!-- Desktop Image -->
                            <source srcset="{{ asset('public/assets/images/home-banner.png') }}" media="(min-width: 768px)">

                            <!-- Fallback for Older Browsers -->
                            <img class="img-fluid" src="{{ asset('public/assets/images/home-banner.png') }}" alt="slide"
                                style="width: 100%; height: auto;">
                        </picture>
                    </figure>
                </a>
            </div>
        </div>
    </div>

    <!-- FEATURE CARDS -->
    <section class="feature-section">
        <div class="container">
            <div class="row justify-content-center g-3">

                <div class="col-12 col-sm-6 col-md-4">
                    <a class="text-decoration-none" href="{{ route('live-session') }}">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <img src="{{ asset('public/assets/images/icon/WebcastConnect.svg') }}" alt="">
                            </div>
                            <span>Webcast Connect</span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <img src="{{ asset('public/assets/images/icon/support.png') }}" alt="">
                        </div>
                        <span>Resource</span>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <a class="text-decoration-none" href="{{ route('about-us') }}">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <img src="{{ asset('public/assets/images/icon/Contactus.svg') }}" alt="">
                            </div>
                            <span>About Us</span>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script></script>
@endpush
