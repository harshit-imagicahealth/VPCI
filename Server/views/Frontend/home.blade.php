@extends('Frontend.layouts.app')
@section('title', 'Home ')

@push('styles')
    <style>

    </style>
@endpush

@section('main')
    <!-- HERO BANNER -->
    {{-- <div class="main-banner">
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
    </div> --}}
    <section class="container-fluid px-0">
        <div class="position-relative imageSlider-wrapper mx-0">
            <div class="swiper imageSlider">
                <div class="swiper-wrapper">
                    @php
                        $images = [
                            asset('public/assets/images/home-header-banner-10.png'),
                            asset('public/assets/images/home-header-banner-20.png'),
                        ];
                        // {{ config('filesystems.disks.spaces.cdn_url') . '/ACE/webcasts/sliders/' . $image }}
                    @endphp
                    @foreach ($images as $image)
                        <!-- Slide -->
                        <div class="swiper-slide">
                            <div class="slider-card">
                                <img class="img-fluid" src="{{ $image }}" alt="slide">
                            </div>
                        </div>
                    @endforeach

                </div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>
            <div class="custom-nav">
                <div class="swiper-button-prev-image"></div>
                <div class="swiper-button-next-image"></div>
            </div>
        </div>
    </section>

    <!-- FEATURE CARDS -->
    <section class="feature-section">
        {{-- <div class="container"> --}}
        <div class="row justify-content-center gy-3">

            <div class="col-sm-6 col-md-3">
                <a class="text-decoration-none" href="{{ route('live-session') }}">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <img src="{{ asset('public/assets/images/icon/WebcastConnect.svg') }}" alt="">
                        </div>
                        <span>Modules</span>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="{{ asset('public/assets/images/icon/support.png') }}" alt="">
                    </div>
                    <span>Pre-Read</span>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <a class="text-decoration-none" href="{{ route('about-us') }}">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <img src="{{ asset('public/assets/images/icon/Contactus.svg') }}" alt="">
                        </div>
                        <span>About Us</span>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-3">
                <a class="text-decoration-none" href="{{ route('about-us') }}">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <img src="{{ asset('public/assets/images/icon/writing.png') }}" alt="">
                        </div>
                        <span>Module Summary</span>
                    </div>
                </a>
            </div>

        </div>
        {{-- </div> --}}
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var swiper = new Swiper(".imageSlider", {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: true,

                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next-image",
                    prevEl: ".swiper-button-prev-image",
                },
            });
        });
    </script>
@endpush
