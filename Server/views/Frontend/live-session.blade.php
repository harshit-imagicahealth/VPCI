@extends('Frontend.layouts.app')
@section('title', 'Allergy & Immunotherapy Sensitization Webinar')

@push('styles')
@endpush

@section('main')
    <section class="container-fluid px-0">
        <div class="position-relative imageSlider-wrapper mx-0">
            <div class="swiper imageSlider">
                <div class="swiper-wrapper">
                    @isset($liveSession)
                        @php
                            $images = isset($liveSession->slider_images)
                                ? json_decode($liveSession->slider_images ?? '[]')
                                : [];
                            // {{ config('filesystems.disks.spaces.cdn_url') . '/ACE/webcasts/sliders/' . $image }}
                        @endphp
                        @foreach ($images as $image)
                            <!-- Slide -->
                            <div class="swiper-slide">
                                <div class="slider-card">
                                    <img class="img-fluid"
                                        src="{{ config('filesystems.disks.spaces.cdn_url') . '/ACE/webcasts/sliders/' . $image }}"
                                        alt="slide">

                                    <!-- Overlay Buttons -->
                                    <div class="slider-overlay">
                                        <a class="text-decoration-none"
                                            href="{{ route('webinars.videoStream', ['webcast_id' => encrypt($liveSession->id)]) }}">
                                            <button type="button" class="btn btn-danger join-btn">
                                                <i class="fa fa-video me-1"></i> Join Live Session
                                            </button>
                                        </a>

                                        <div class="custom-dropdown">
                                            <div type="button" class="btn btn-light explore-btn">
                                                Explore <i class="fa fa-chevron-down ms-1"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    @endisset

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
    <section id="headerExploreFeatureTab" class="top-feature-bar d-none">
        <div class="container-fluid">
            <div class="feature-wrapper mx-3">
                @php
                    $feature_items = config('wc_connect.feature_items');
                @endphp
                @isset($liveSession)
                    @foreach ($feature_items as $item)
                        <a class="text-decoration-none text-primary"
                            href="{{ $item['pdf']
                                ? route('webinars.pdfStream', [
                                    'webcast_id_pdf' => encrypt($liveSession->id),
                                    'type' => strtolower(str_replace(' ', '-', $item['heading'])),
                                ])
                                : ($item['video']
                                    ? route('webinars.videoStream', [
                                        'webcast_id' => encrypt($liveSession->id),
                                        'teaser' => true,
                                    ])
                                    : '#') }}">
                            <div class="feature-item">

                                @if ($item['type'] === 'button')
                                    <!-- BUTTON -->
                                    <button class="btn btn-outline-primary">
                                        <i class="fa {{ $item['icon'] }} me-2"></i>
                                        {{ $item['heading'] }}
                                    </button>
                                @else
                                    <!-- ICON ITEM -->
                                    <div class="icon {{ $item['colorClass'] }}">
                                        <i class="fa {{ $item['icon'] }}"></i>
                                    </div>

                                    <div class="text">
                                        <h6>{{ $item['heading'] }}</h6>
                                        <small>{{ $item['subHeading'] }}</small>
                                    </div>
                                @endif

                            </div>
                        </a>
                    @endforeach
                @endisset

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
                    @foreach ($modules ?? [] as $module)
                        @php
                            $allstatus = config('wc_connect.status');
                            $status = $allstatus[$module->status];
                            $statusValue = $status['value'];
                            $statusClass = $status['class'];
                            $image = isset($module->thumbnail)
                                ? config('filesystems.disks.spaces.cdn_url') .
                                    '/ACE/webcasts/thumbnails/' .
                                    $module->thumbnail
                                : null;
                        @endphp
                        <!-- Slide 1 — LIVE NOW -->
                        <div class="swiper-slide" data-url="{{ route('live-session', ['id' => encrypt($module->id)]) }}">
                            <div class="module-card active-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start gap-1">
                                        <div class="content">
                                            <span class="badge bg-{{ $statusClass }}">{{ $statusValue }}</span>
                                            <h6 class="mb-1 mt-2">{{ $module->content_title }}</h6>
                                            <h5 class="mb-2">{{ $module->activity_name }}</h5>
                                        </div>
                                        <div class="image">
                                            <img class="img-fluid rounded" src="{{ $image }}" alt="module">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="small mb-1">
                                            <i class="fa fa-user me-1"></i> Dr. {{ $module->dr_name }}
                                        </span>
                                        <small class="text-muted">
                                            <i class="fa fa-calendar me-1"></i>
                                            {{ $module->webcast_date }} |
                                            {{ $module->webcast_time }}
                                        </small>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    @if (in_array($module->status, ['live', 'complated']))
                                        <a class="btn btn-outline-dark btn-logout w-100"
                                            href="{{ route('webinars.videoStream', ['webcast_id' => encrypt($module->id)]) }}">
                                            <i class="fa fa-video me-1"></i> Watch Now
                                        </a>
                                    @else
                                        <button type="button" class="btn btn-outline-dark btn-logout w-100">
                                            <i class="fa fa-clock me-1"></i> Coming Soon
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
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

                // pagination: {
                //     el: ".swiper-pagination",
                //     clickable: true,
                // },

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
        // Custom dropdown on hover
        // let dropdown = $("#headerExploreFeatureTab");

        // $(".explore-btn").hover(
        //     function() {
        //         dropdown.stop(true, true)
        //             .removeClass("d-none")
        //             .addClass("d-flex")
        //             .hide()
        //             .slideDown(200);
        //     },
        //     function() {
        //         setTimeout(() => {
        //             if (!dropdown.is(":hover")) {
        //                 dropdown.stop(true, true).slideUp(200, function() {
        //                     dropdown.removeClass("d-flex").addClass("d-none");
        //                 });
        //             }
        //         }, 200);
        //     }
        // );

        // // keep open when hovering dropdown
        // dropdown.hover(
        //     function() {},
        //     function() {
        //         dropdown.stop(true, true).slideUp(200, function() {
        //             dropdown.removeClass("d-flex").addClass("d-none");
        //         });
        //     }
        // );

        let dropdown = $("#headerExploreFeatureTab");

        $(document).on("click", ".explore-btn", function(e) {
            e.stopPropagation();

            let btn = $(this); // ✅ correct

            if (dropdown.is(":visible")) {
                dropdown.stop(true, true).slideUp(200, function() {
                    dropdown.removeClass("d-flex").addClass("d-none");
                });

                btn.removeClass("active"); //  reset arrow
            } else {
                dropdown.removeClass("d-none")
                    .addClass("d-flex")
                    .hide()
                    .slideDown(200);

                btn.addClass("active"); //  rotate arrow
            }
        });

        // Close when clicking outside
        $(document).on("click", function() {
            dropdown.stop(true, true).slideUp(200, function() {
                dropdown.removeClass("d-flex").addClass("d-none");
            });
        });

        $('.module-section .swiper-slide').click(function() {
            let url = $(this).data('url');
            window.location.href = url;
        });
    </script>
@endpush
