@extends('Frontend.layouts.app')
@section('title', 'Webinars')

@push('styles')
@endpush

@section('main')
    <section class="preread-section py-5">
        <div class="container px-0">

            <div class="preread-wrapper">

                {{-- TOP HEADER --}}
                <div class="preread-header-back-url">
                    <a class="back-link text-primary text-decoration-none"
                        href="{{ route('live-session', ['id' => encrypt($data['id'])]) }}">
                        <i class="fa fa-arrow-left"></i> Back to Module
                    </a>
                </div>
                <div class="preread-header">
                    <div class="preread-header-left">
                        <div class="preread-title-block">
                            <span class="preread-label">Pre-read Material -</span>
                            <span class="preread-title">{{ $data['activity_name'] ? $data['activity_name'] : '' }}</span>
                        </div>
                        <p class="preread-subtitle">Read this material before attending the live session.</p>
                    </div>
                    <div class="preread-header-right d-none">
                        <a class="btn-download-pdf mt-2" href="#">
                            <i class="fa fa-download"></i> Download PDF
                        </a>
                    </div>
                </div>

                {{-- PDF VIEWER AREA --}}
                <div class="pdf-viewer-area">
                    @php
                        $collection = collect($data['resources']);
                        $pdfUrl = isset($data['resources'])
                            ? $collection
                                ->where('activity_type', str_replace(' ', '_', str_replace('-', '_', $type)))
                                ->first()?->pdf_url
                            : '';
                    @endphp
                    {{-- IFRAME EMBED --}}
                    <div class="pdf-embed-wrapper">
                        @if (isset($pdfUrl))
                            <div style="padding:56.25% 0 0 0; position:relative;">
                                <iframe src="{{ isset($pdfUrl) ? $pdfUrl : '' }}" frameborder="0" {{-- allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share" --}}
                                    referrerpolicy="strict-origin-when-cross-origin"
                                    style="position:absolute;top:0;left:0;width:100%;height:100%;"
                                    title="Pre-read Material - Basics of Allergy">
                                </iframe>
                            </div>
                        @else
                            <div class="p-5">
                                <div class="d-flex justify-content-center align-items-center no-video-found text-danger">
                                    Opps! No PDF Found.
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
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
