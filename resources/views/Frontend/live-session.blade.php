@extends('Frontend.layouts.app')
@section('title', 'Allergy & Immunotherapy Sensitization Webinar')

@push('styles')
    {{-- <style>
        :root {
            --primary: #1e2557;
            --accent: #e8292b;
            --gold: #c9973a;
        }

        /* ══ HERO SLIDER ══ */
        .hero-slider {
            position: relative;
            overflow: hidden;
            background: transparent;
        }

        .hero-slide {
            display: none;
            position: relative;
            min-height: 360px;
            margin: 20px 0;
            overflow: hidden;
        }

        .hero-slide.active {
            display: block;
        }

        /* dna watermark left */
        .hero-slide::before {
            content: '';
            position: absolute;
            left: -40px;
            top: 50%;
            transform: translateY(-50%);
            width: 180px;
            height: 320px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 60 200'%3E%3Cpath d='M10 0 Q50 25 10 50 Q-30 75 10 100 Q50 125 10 150 Q-30 175 10 200' stroke='%231e255720' stroke-width='2' fill='none'/%3E%3Cpath d='M50 0 Q10 25 50 50 Q90 75 50 100 Q10 125 50 150 Q90 175 50 200' stroke='%231e255715' stroke-width='2' fill='none'/%3E%3C/svg%3E") no-repeat center;
            background-size: contain;
            opacity: .6;
            pointer-events: none;
        }

        .hero-inner {
            max-width: 1160px;
            margin: 0 auto;
            padding: 0 24px;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 24px;
        }

        /* Left — VPCI logo */
        .hero-vpci {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-shrink: 0;
        }

        .hero-vpci-box {
            width: 84px;
            padding: 8px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
            text-align: center;
        }

        .hero-vpci-box img {
            width: 100%;
        }

        .hero-vpci-placeholder {
            font-size: .6rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1.3;
        }

        .hero-vpci-placeholder span {
            color: var(--accent);
            font-size: .9rem;
        }

        /* Center — content */
        .hero-content {
            min-width: 0;
        }

        .hero-discussion {
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: var(--gold);
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .hero-title {
            font-size: clamp(1.4rem, 3vw, 2.1rem);
            font-weight: 800;
            color: var(--primary);
            line-height: 1.2;
            margin-bottom: 14px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--gold);
            color: #fff;
            border-radius: 6px;
            padding: 4px 14px;
            font-size: .72rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .hero-points {
            list-style: disc;
            padding-left: 18px;
            margin-bottom: 18px;
        }

        .hero-points li {
            font-size: .85rem;
            color: #333;
            margin-bottom: 3px;
        }

        /* CTA buttons */
        .hero-cta {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }

        .btn-live {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: .84rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
            transition: background .2s;
        }

        .btn-live:hover {
            background: #c0201f;
            color: #fff;
        }

        .btn-live .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #fff;
            opacity: .9;
            animation: blink 1s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: .9
            }

            50% {
                opacity: .3
            }
        }

        /* Explore button + dropdown */
        .explore-wrap {
            position: relative;
        }

        .btn-explore {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            color: var(--primary);
            border: 2px solid #c8d0e4;
            border-radius: 8px;
            padding: 9px 18px;
            font-size: .9rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
            transition: all .2s;
            user-select: none;
        }

        .btn-explore:hover {
            border-color: var(--primary);
        }

        .btn-explore i {
            font-size: .75rem;
            color: #aaa;
        }

        .explore-arrow {
            font-size: .65rem !important;
            transition: transform .3s;
        }

        .explore-dropdown {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            background: #fff;
            border: 1.5px solid #e0e4f0;
            border-radius: 10px;
            box-shadow: 0 8px 28px rgba(0, 0, 0, .12);
            overflow: hidden;
            min-width: 200px;
            max-height: 0;
            opacity: 0;
            pointer-events: none;
            transition: max-height .35s ease, opacity .25s ease;
            z-index: 100;
        }

        .explore-wrap:hover .explore-dropdown,
        .explore-wrap.open .explore-dropdown {
            max-height: 400px;
            opacity: 1;
            pointer-events: all;
        }

        .explore-wrap:hover .explore-arrow,
        .explore-wrap.open .explore-arrow {
            transform: rotate(180deg);
        }

        .explore-dropdown a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            font-size: .82rem;
            font-weight: 600;
            color: #333;
            text-decoration: none;
            transition: background .15s;
            border-bottom: 1px solid #f3f4f9;
        }

        .explore-dropdown a:last-child {
            border-bottom: none;
        }

        .explore-dropdown a:hover {
            background: #f0f3fb;
            color: var(--primary);
        }

        .explore-dropdown a i {
            width: 18px;
            text-align: center;
            color: var(--primary);
            font-size: .85rem;
        }

        /* Right — doctors + brand */
        .hero-right {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
            flex-shrink: 0;
        }

        .hero-doctors {
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }

        .hero-doctor {
            text-align: center;
        }

        .hero-doctor-img {
            width: 90px;
            height: 100px;
            border-radius: 12px;
            background: linear-gradient(160deg, #c0cce0, #9aaac0);
            display: flex;
            align-items: flex-end;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .hero-doctor-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-doctor-img-f {
            background: linear-gradient(160deg, #c8c0d8, #a898c0);
        }

        .hero-doctor-icon {
            position: absolute;
            bottom: 6px;
            font-size: 2.8rem;
            color: rgba(255, 255, 255, .35);
        }

        .hero-doctor-name {
            font-size: .7rem;
            font-weight: 600;
            color: var(--primary);
            margin-top: 6px;
        }

        .hero-brand-badge {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            border: 3px solid #c8d0e4;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 6px;
            font-size: .45rem;
            font-weight: 700;
            color: var(--accent);
            line-height: 1.3;
            position: absolute;
            top: 16px;
            right: 20px;
        }

        /* Product image (right-most) */
        .hero-product {
            position: absolute;
            right: 110px;
            bottom: 0;
            top: 0;
            width: 120px;
            overflow: hidden;
            opacity: .7;
            display: flex;
            align-items: flex-end;
        }

        .hero-product img {
            width: 100%;
        }

        .hero-product-placeholder {
            width: 60px;
            margin: auto;
            font-size: 3rem;
            color: #b0bcd4;
            text-align: center;
        }

        /* ══ SLIDER CONTROLS ══ */
        .hero-slider-nav {
            position: absolute;
            bottom: 14px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 6px;
            z-index: 10;
        }

        .hero-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(30, 37, 87, .2);
            cursor: pointer;
            transition: background .2s;
        }

        .hero-dot.active {
            background: var(--primary);
        }

        .hero-prev,
        .hero-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .7);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            color: var(--primary);
            cursor: pointer;
            z-index: 10;
            transition: background .2s;
        }

        .hero-prev:hover,
        .hero-next:hover {
            background: #fff;
        }

        .hero-prev {
            left: 10px;
        }

        .hero-next {
            right: 10px;
        }

        /* ══ ACTIVITY BAR ══ */
        .activity-bar {
            background: #fff;
            border-bottom: 1px solid #eaecf4;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .04);
        }

        .activity-inner {
            max-width: 1160px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: stretch;
        }

        .act-item {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 13px 10px;
            border-right: 1px solid #f0f2f8;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            transition: background .2s;
        }

        .act-item:last-child {
            border-right: none;
        }

        .act-item:hover {
            background: #f8f9fd;
        }

        .act-agenda {
            flex: 1.3;
            justify-content: center;
            border: 2px solid #d0d5e8 !important;
            border-radius: 8px;
            margin: 8px 10px;
            font-weight: 700;
            font-size: .85rem;
            color: var(--primary);
            gap: 8px;
            background: #fff;
        }

        .act-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #f0f3fb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            color: var(--primary);
            flex-shrink: 0;
        }

        .act-label {
            font-size: .76rem;
            font-weight: 700;
            color: #1a1a1a;
        }

        .act-sub {
            font-size: .65rem;
            color: #888;
            margin-top: 1px;
        }

        /* ══ RESPONSIVE ══ */
        @media (max-width: 767px) {
            .hero-inner {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .hero-vpci,
            .hero-right {
                display: none;
            }

            .hero-product {
                display: none;
            }

            .hero-brand-badge {
                width: 50px;
                height: 50px;
                font-size: .38rem;
                right: 10px;
                top: 10px;
            }

            .hero-slide {
                min-height: auto;
                padding: 24px 0 40px;
            }

            .activity-inner {
                min-width: 600px;
            }
        }

        /* Background image */
        .hero-bg-img {
            width: 100%;
            height: 380px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Overlay position */
        .hero-overlay {
            position: absolute;
            bottom: 20px;
            left: 20px;
            z-index: 1020;
        }

        /* Optional dark overlay for readability */
        .hero-slide::after {
            content: "";
            position: absolute;
            inset: 0;
            background: transparent;
            border-radius: 10px;
        }
    </style> --}}
@endpush

@section('main')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <section class="hero-slider swiper mySwiper d-none mb-5">

        <div class="swiper-slide hero-slide">

            <!-- Background Image -->
            <img class="hero-bg-img" src="https://picsum.photos/id/1015/1200">
            <!-- Overlay Content -->
            <div class="hero-overlay">
                <div class="hero-cta">

                    <a class="btn-live" href="">
                        <span class="pulse-dot"></span> JOIN LIVE SESSION
                    </a>

                    <div class="explore-wrap">
                        <a class="btn-explore" href="#" onclick="return false;">
                            <i class="fa fa-calendar-check"></i> Explore
                            <i class="fa fa-chevron-down explore-arrow"></i>
                        </a>

                        <div class="explore-dropdown">
                            <a href=""><i class="fa fa-book-open"></i> Pre-read</a>
                            <a href=""><i class="fa fa-circle-play"></i> Teaser</a>
                            <a href=""><i class="fa fa-calendar-check"></i> View Agenda</a>
                            <a href=""><i class="fa fa-list-check"></i> Assessment</a>
                            <a href=""><i class="fa fa-file-lines"></i> Summary</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <button class="hero-prev" onclick="heroSlide(-1)"><i class="fa fa-chevron-left"></i></button>
        <button class="hero-next" onclick="heroSlide(1)"><i class="fa fa-chevron-right"></i></button>

        <div id="heroDots" class="hero-slider-nav"></div>

    </section>
    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        /* Dropdown width like design */
        .explore-dropdown {
            min-width: 700px;
            border-radius: 12px;
        }

        /* Item */
        .explore-item {
            min-width: 120px;
        }

        /* Icons */
        .icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 5px;
            font-size: 20px;
        }

        /* Colors */
        .bg-light-primary {
            background: #e7f0ff;
        }

        .bg-light-success {
            background: #e6f7ee;
        }

        .bg-light-purple {
            background: #f3e8ff;
        }

        .bg-light-warning {
            background: #fff4e5;
        }

        /* Title */
        .title {
            font-weight: 600;
            font-size: 14px;
        }

        /* Mobile fix */
        @media(max-width:768px) {
            .explore-dropdown {
                min-width: 100%;
            }
        }

        /* HERO */
        .heroSwiper {
            height: 420px;
        }

        .hero-slide {
            position: relative;
        }

        .hero-slide img {
            width: 100%;
            height: 420px;
            object-fit: cover;
        }

        /* Overlay buttons */
        .overlay-btns {
            position: absolute;
            bottom: 60px;
            left: 80px;
        }

        .btn-live {
            background: linear-gradient(to right, #ff3b3b, #c40000);
            color: #fff;
            border: none;
        }

        .btn-outline-custom {
            border: 2px solid #2d3e66;
            color: #2d3e66;
            background: #fff;
        }

        /* MODULE SECTION */
        .modules {
            background: #f4f7fb;
        }

        .module-card {
            border-radius: 16px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
        }

        .module-card img {
            border-radius: 10px;
        }

        .badge-live {
            background: #28c76f;
        }

        .badge-upcoming {
            background: #ffb020;
        }

        /* RESPONSIVE */
        @media(max-width:768px) {
            .overlay-btns {
                left: 20px;
                bottom: 30px;
            }
        }
    </style>

    <!-- ================= HERO ================= -->
    <div class="swiper heroSwiper">
        <div class="swiper-wrapper">

            <div class="swiper-slide hero-slide">
                <img src="https://images.unsplash.com/photo-1580281657527-47b3c97d5b7c?q=80&w=1600">

                <div class="overlay-btns d-flex gap-3">
                    <button class="btn btn-live px-4 py-2">🔴 JOIN LIVE SESSION</button>
                    <div class="dropdown">
                        <button class="btn btn-outline-custom dropdown-toggle px-4 py-2" data-bs-toggle="dropdown">
                            📄 Explore
                        </button>

                        <!-- DROPDOWN PANEL -->
                        <div class="dropdown-menu explore-dropdown border-0 p-3 shadow">

                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                                <div class="explore-item text-center">
                                    <div class="icon bg-light-primary">📘</div>
                                    <div class="title">Pre-read</div>
                                    <small>Read before session</small>
                                </div>

                                <div class="explore-item text-center">
                                    <div class="icon bg-light-success">▶️</div>
                                    <div class="title">Teaser</div>
                                    <small>Watch session teaser</small>
                                </div>

                                <div class="explore-item highlight text-center">
                                    <button class="btn btn-outline-primary px-3">
                                        📄 VIEW AGENDA
                                    </button>
                                </div>

                                <div class="explore-item text-center">
                                    <div class="icon bg-light-purple">📝</div>
                                    <div class="title">Assessment</div>
                                    <small>Take the assessment</small>
                                </div>

                                <div class="explore-item text-center">
                                    <div class="icon bg-light-warning">📄</div>
                                    <div class="title">Summary</div>
                                    <small>View summary</small>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-slide hero-slide">
                <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=1600">

                <div class="overlay-btns d-flex gap-3">
                    <button class="btn btn-live px-4 py-2">🔴 JOIN LIVE SESSION</button>
                    <button class="btn btn-outline-custom px-4 py-2">📄 Explore</button>
                </div>
            </div>

        </div>

        <div class="swiper-pagination"></div>
    </div>

    <!-- ================= MODULES ================= -->
    <section class="modules py-4">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-primary mb-0">Explore Modules</h4>
                <a class="text-decoration-none" href="#">View All →</a>
            </div>

            <div class="swiper moduleSwiper">
                <div class="swiper-wrapper">

                    <!-- CARD -->
                    <div class="swiper-slide">
                        <div class="card module-card p-2">

                            <span class="badge badge-live mb-2 text-white">LIVE NOW</span>

                            <img class="img-fluid" src="https://picsum.photos/200/150?1">

                            <small class="text-muted mt-2">MODULE 1</small>
                            <h6>Basics of Allergy</h6>

                            <small>👨‍⚕️ Dr. P. Mahesh</small><br>
                            <small>📅 15 June | 07:00 PM</small>

                            <button class="btn btn-light w-100 mt-2">Watch</button>

                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card module-card p-2">

                            <span class="badge badge-upcoming mb-2 text-white">UPCOMING</span>

                            <img class="img-fluid" src="https://picsum.photos/200/150?2">

                            <small class="text-muted mt-2">MODULE 2</small>
                            <h6>Aerobiology - Clinical aspects</h6>

                            <small>👨‍⚕️ Dr. Sonam</small><br>
                            <small>📅 22 June | 07:00 PM</small>

                            <button class="btn btn-light w-100 mt-2">Coming Soon</button>

                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card module-card p-2">

                            <span class="badge badge-upcoming mb-2 text-white">UPCOMING</span>

                            <img class="img-fluid" src="https://picsum.photos/200/150?3">

                            <small class="text-muted mt-2">MODULE 3</small>
                            <h6>Food Allergy - Management</h6>

                            <small>👨‍⚕️ Dr. P. Mahesh</small><br>
                            <small>📅 29 June | 07:00 PM</small>

                            <button class="btn btn-light w-100 mt-2">Coming Soon</button>

                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card module-card p-2">

                            <span class="badge badge-upcoming mb-2 text-white">UPCOMING</span>

                            <img class="img-fluid" src="https://picsum.photos/200/150?4">

                            <small class="text-muted mt-2">MODULE 4</small>
                            <h6>Immunotherapy - An Update</h6>

                            <small>👨‍⚕️ Dr. Sonam</small><br>
                            <small>📅 06 July | 07:00 PM</small>

                            <button class="btn btn-light w-100 mt-2">Coming Soon</button>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        new Swiper(".heroSwiper", {
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            }
        });

        new Swiper(".moduleSwiper", {
            spaceBetween: 20,
            breakpoints: {
                0: {
                    slidesPerView: 1.2
                },
                576: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 3
                },
                992: {
                    slidesPerView: 4
                }
            }
        });
    </script>

@endsection

@push('scripts')
    <script>
        (function() {
            var slides = document.querySelectorAll('.hero-slide');
            var dotsWrap = document.getElementById('heroDots');
            var current = 0;
            var timer;

            function buildDots() {
                dotsWrap.innerHTML = '';
                slides.forEach(function(_, i) {
                    var d = document.createElement('span');
                    d.className = 'hero-dot' + (i === 0 ? ' active' : '');
                    d.addEventListener('click', function() {
                        goTo(i);
                    });
                    dotsWrap.appendChild(d);
                });
            }

            function goTo(idx) {
                slides[current].classList.remove('active');
                dotsWrap.children[current].classList.remove('active');
                current = (idx + slides.length) % slides.length;
                slides[current].classList.add('active');
                dotsWrap.children[current].classList.add('active');
            }

            window.heroSlide = function(dir) {
                clearInterval(timer);
                goTo(current + dir);
                startAuto();
            };

            function startAuto() {
                timer = setInterval(function() {
                    goTo(current + 1);
                }, 5000);
            }

            buildDots();
            startAuto();

            /* ── Explore dropdown: keep open on click (mobile) ── */
            var exploreWrap = document.getElementById('exploreWrap');
            if (exploreWrap) {
                exploreWrap.addEventListener('click', function(e) {
                    if (e.target.closest('a[href]') && !e.target.closest('#exploreBtn')) return;
                    this.classList.toggle('open');
                });
                document.addEventListener('click', function(e) {
                    if (exploreWrap && !exploreWrap.contains(e.target)) {
                        exploreWrap.classList.remove('open');
                    }
                });
            }
        })();
        document.querySelectorAll(".explore-wrap").forEach(wrap => {
            wrap.addEventListener("click", function(e) {
                e.stopPropagation();
                this.classList.toggle("open");
            });
        });

        document.addEventListener("click", () => {
            document.querySelectorAll(".explore-wrap").forEach(w => w.classList.remove("open"));
        });
        const swiper = new Swiper(".mySwiper", {
            loop: true,

            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },

            navigation: {
                nextEl: ".hero-next",
                prevEl: ".hero-prev",
            },

            pagination: {
                el: ".hero-slider-nav",
                clickable: true,
            },

            effect: "slide", // can change to fade
        });
    </script>
@endpush
