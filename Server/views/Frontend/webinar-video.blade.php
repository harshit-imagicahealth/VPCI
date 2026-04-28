@extends('Frontend.layouts.app')
@section('title', 'Webinars')

@push('styles')
@endpush

@section('main')
    <section class="live-session-section py-5">
        <div class="container">
            <div class="live-session-wrapper">

                {{-- TOP BAR --}}
                <div class="live-top-bar d-flex align-items-center mb-3 gap-3">
                    <span class="badge-live-now">
                        <span class="live-dot"></span> LIVE NOW
                    </span>
                    <div class="module-title-bar">
                        {{ $data['content_title'] ? $data['content_title'] . ' : ' . $data['activity_name'] : '' }}
                    </div>
                </div>
                {{-- @dd($data['resources']); --}}
                @php
                    $vimeoUrl = isset($data['resources'])
                        ? collect($data['resources'])->where('activity_type', 'vimeo_url')->first()->pdf_url
                        : '';
                @endphp
                {{-- @dd($vimeoUrl); --}}
                {{-- VIDEO EMBED --}}
                <div class="video-wrapper">
                    <div style="padding:56.25% 0 0 0; position:relative;">
                        <iframe
                            src="{{ isset($vimeoUrl) ? $vimeoUrl : 'https://player.vimeo.com/video/954655325?badge=0&autopause=0&player_id=0&app_id=58479' }}"
                            frameborder="0"
                            allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"
                            referrerpolicy="strict-origin-when-cross-origin"
                            style="position:absolute;top:0;left:0;width:100%;height:100%;"
                            title="Basics of Allergy - Live Session">
                        </iframe>
                    </div>
                </div>

                {{-- ASK A QUESTION BUTTON --}}
                <div class="mt-4 text-center">

                    <!-- QUESTION FORM -->
                    <div id="questionBox" class="question-box d-none mt-3">
                        <form id="questionForm" class="d-flex align-items-center">
                            {{-- <div class="position-relative"> --}}

                            <input type="text" id="questionInput" placeholder="Type your question..."
                                class="form-control" autocomplete="off">

                            <!-- AUTOCOMPLETE LIST -->
                            <div id="autocompleteList" class="autocomplete-box"></div>

                            {{-- </div> --}}

                            <button type="button" class="btn btn-primary submit-icon-btn">
                                <i class="fa fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                    <button id="showQuestionBox" class="btn-ask-question">
                        <i class="fa fa-comment-dots me-1"></i>
                        Ask a Question
                    </button>

                </div>
                {{-- <div class="mt-4 text-center">
                    <button class="btn-ask-question">
                        <i class="fa fa-comment-dots me-1"></i>
                        Ask a Question
                    </button>
                </div> --}}
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://player.vimeo.com/api/player.js"></script>
    <script>
        // Show form on button click
        // $("#showQuestionBox").click(function() {
        //     $("#questionBox").slideToggle().toggleClass("d-none");
        // });

        // Sample suggestions (replace with API later)
        let suggestions = [
            "What is allergy?",
            "How to treat asthma?",
            "What are symptoms of allergy?",
            "Best medicine for sinus?",
            "How to prevent asthma attacks?"
        ];

        // Autocomplete
        $("#questionInput").on("keyup", function() {
            let value = $(this).val().toLowerCase();
            let list = $("#autocompleteList");

            list.empty();

            if (value === "") {
                list.hide();
                return;
            }

            let filtered = suggestions.filter(item =>
                item.toLowerCase().includes(value)
            );

            if (filtered.length === 0) {
                list.hide();
                return;
            }

            filtered.forEach(item => {
                list.append(`<div>${item}</div>`);
            });

            list.show();
        });

        // Click suggestion
        $(document).on("click", "#autocompleteList div", function() {
            $("#questionInput").val($(this).text());
            $("#autocompleteList").hide();
        });

        // Submit form
        // $("#questionForm").submit(function(e) {
        //     e.preventDefault();

        //     let question = $("#questionInput").val();

        //     if (!question) {
        //         alert("Please enter a question");
        //         return;
        //     }

        //     console.log("Submitted Question:", question);

        //     // TODO: send via AJAX
        //     // $.post('/submit-question', { question: question })

        //     $("#questionInput").val('');
        //     $("#autocompleteList").hide();
        //     alert("Question submitted!");
        // });

        // Hide autocomplete on outside click
        $(document).click(function(e) {
            if (!$(e.target).closest(".position-relative").length) {
                $("#autocompleteList").hide();
            }
        });
    </script>
@endpush
