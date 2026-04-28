@extends('Frontend.layouts.app')
@section('title', 'Allergy & Immunotherapy Sensitization Webinar')

@push('styles')
@endpush

@section('main')
    <section class="container-fluid px-0">
        <div class="position-relative imageSlider-wrapper mx-0">
            <div class="swiper imageSlider">
                <div class="swiper-wrapper">

                    <!-- Slide -->
                    <div class="swiper-slide">
                        <div class="slider-card">
                            <img class="img-fluid" src="https://picsum.photos/1200/400" alt="slide">

                            <!-- Overlay Buttons -->
                            <div class="slider-overlay">
                                <button class="btn btn-danger join-btn">
                                    <i class="fa fa-video me-1"></i> Join Live Session
                                </button>

                                <div class="custom-dropdown">
                                    <button class="btn btn-light explore-btn">
                                        Explore <i class="fa fa-chevron-down ms-1"></i>
                                    </button>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Slide -->
                    <div class="swiper-slide">
                        <div class="slider-card">
                            <img class="img-fluid" src="https://picsum.photos/1200/400" alt="slide">

                            <!-- Overlay Buttons -->
                            <div class="slider-overlay">
                                <button class="btn btn-danger join-btn">
                                    <i class="fa fa-video me-1"></i> Join Live Session
                                </button>

                                <div class="custom-dropdown">
                                    <button class="btn btn-light explore-btn">
                                        Explore <i class="fa fa-chevron-down ms-1"></i>
                                    </button>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>
            <div class="custom-nav">
                <div class="swiper-button-prev-image"></div>
                <div class="swiper-button-next-image"></div>
            </div>
        </div>
        <div class="dropdown-box">
            <a href="#">Option 1</a>
            <a href="#">Option 2</a>
        </div>
    </section>
    <section id="headerExploreFeatureTab" class="top-feature-bar d-none">
        <div class="container-fluid">
            <div class="feature-wrapper mx-3">

                <!-- Item -->
                <div class="feature-item">
                    <div class="icon blue">
                        <i class="fa fa-book-open"></i>
                    </div>
                    <div class="text">
                        <h6>Pre-read</h6>
                        <small>Read before the session</small>
                    </div>
                </div>

                <!-- Item -->
                <div class="feature-item">
                    <div class="icon green">
                        <i class="fa fa-play"></i>
                    </div>
                    <div class="text">
                        <h6>Teaser</h6>
                        <small>Watch session teaser</small>
                    </div>
                </div>

                <!-- Button -->
                <div class="feature-item">
                    <button class="btn btn-outline-primary">
                        <i class="fa fa-calendar me-2"></i> VIEW AGENDA
                    </button>
                </div>

                {{-- <!-- Item -->
                <div class="feature-item">
                    <div class="icon purple">
                        <i class="fa fa-clipboard-check"></i>
                    </div>
                    <div class="text">
                        <h6>Assessment</h6>
                        <small>Take the assessment</small>
                    </div>
                </div> --}}

                <!-- Item -->
                <div class="feature-item">
                    <div class="icon orange">
                        <i class="fa fa-file-alt"></i>
                    </div>
                    <div class="text">
                        <h6>Summary</h6>
                        <small>View session summary</small>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="module-section py-4">
        <div class="position-relative mx-3">
            <div class="d-flex justify-content-between">
                <h5 class="explore-modules-heading mb-3">Explore Modules</h5>
                {{-- <div class="custom-nav w-25">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div> --}}
            </div>

            <div class="swiper mySwiper mx-3">
                <div class="swiper-wrapper">

                    <!-- Slide 1 — LIVE NOW -->
                    <div class="swiper-slide">
                        <div class="module-card active-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start gap-1">
                                    <div class="content">
                                        <span class="badge bg-success">LIVE NOW</span>
                                        <h6 class="mb-1 mt-2">MODULE 1</h6>
                                        <h5 class="mb-2">Basics of Allergy</h5>
                                    </div>
                                    <div class="image">
                                        <img class="img-fluid rounded" src="https://placehold.co/70x70?text=70px"
                                            alt="module">
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="small mb-1">
                                        <i class="bi bi-person"></i> Dr. P. Mahesh
                                    </span>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar"></i> 15 June 2024 | 07:00 PM
                                    </small>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-outline-dark btn-logout w-100">Watch</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="swiper-pagination mt-3"></div>
                {{-- <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div> --}}
            </div>
            <div class="custom-nav">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
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
            var swiper = new Swiper(".mySwiper", {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: false,

                centeredSlides: true, // ✅ MAIN FIX
                centerInsufficientSlides: true, // ✅ keeps center when few slides

                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },

                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },

                breakpoints: {
                    576: {
                        slidesPerView: 1,
                        centeredSlides: true
                    },
                    768: {
                        slidesPerView: 2,
                        centeredSlides: false // ❗ better UX for 2+
                    },
                    1024: {
                        slidesPerView: 3,
                        centeredSlides: false // ❗ avoid awkward spacing
                    },
                    1300: {
                        slidesPerView: 4,
                        centeredSlides: false // ❗ avoid awkward spacing
                    }
                }
            });
        });
        // Custom dropdown
        let dropdown = $("#headerExploreFeatureTab");

        $(".explore-btn").hover(
            function() {
                dropdown.stop(true, true)
                    .removeClass("d-none")
                    .addClass("d-flex")
                    .hide()
                    .slideDown(200);
            },
            function() {
                setTimeout(() => {
                    if (!dropdown.is(":hover")) {
                        dropdown.stop(true, true).slideUp(200, function() {
                            dropdown.removeClass("d-flex").addClass("d-none");
                        });
                    }
                }, 200);
            }
        );

        // keep open when hovering dropdown
        dropdown.hover(
            function() {},
            function() {
                dropdown.stop(true, true).slideUp(200, function() {
                    dropdown.removeClass("d-flex").addClass("d-none");
                });
            }
        );
    </script>
@endpush
