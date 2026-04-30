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
                @php
                    $vimeoUrl = null;
                    $collection = collect($data['resources']);
                    // dd($collection, isset($teaser), isset($data['resources']));
                    if (isset($data['resources'])) {
                        $vimeoUrl = isset($teaser)
                            ? $collection->where('activity_type', 'teaser')->first()?->url
                            : $collection->where('activity_type', 'vimeo_url')->first()?->url ?? '';
                    }
                @endphp
                {{-- VIDEO EMBED --}}
                <div class="video-wrapper vh-50">
                    @if (isset($vimeoUrl))
                        <div style="padding:56.25% 0 0 0; position:relative;">
                            <iframe id="vimeoPlayer" src="{{ isset($vimeoUrl) ? $vimeoUrl : '' }}" frameborder="0"
                                allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"
                                referrerpolicy="strict-origin-when-cross-origin"
                                style="position:absolute;top:0;left:0;width:100%;height:100%;"
                                title="Basics of Allergy - Live Session">
                            </iframe>
                        </div>
                    @else
                        <div class="p-5">
                            <div class="d-flex justify-content-center align-items-center no-video-found text-primary">No
                                video found
                            </div>
                        </div>
                    @endif
                </div>

                {{-- ASK A QUESTION BUTTON --}}
                @if ($type == 'video')
                    <div class="mt-4 text-center">

                        <!-- QUESTION FORM -->
                        <div id="questionBox" class="question-box d-none mt-3">
                            <form id="questionForm" class="d-flex align-items-center gap-3" action="#" method="POST">
                                @csrf

                                <input type="text" id="questionInput" placeholder="Type your question..."
                                    class="form-control">

                                <!-- AUTOCOMPLETE LIST -->
                                <div id="autocompleteList" class="autocomplete-box"></div>

                                <button type="button" class="btn btn-primary submit-icon-btn"
                                    data-submit-url="{{ route('live.questions.submit') }}">
                                    <i class="fa fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                        <button type="button" id="showQuestionBox" class="btn-ask-question">
                            <i class="fa fa-comment-dots me-1"></i>
                            Ask a Question
                        </button>

                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://player.vimeo.com/api/player.js"></script>
    <script>
        const trackUrl = @json(route('track-video-complete'));
        var iframe = document.getElementById('vimeoPlayer');
        var player = new Vimeo.Player(iframe);

        player.on('ended', function() {
            // Call backend(AJAX)
            fetch(trackUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    video_type: @json($type),
                    web_cast_id: @json($data['id'])
                })
            });
        });
    </script>
    <script>
        // Show form on button click
        $("#showQuestionBox").click(function() {
            $("#questionBox").slideToggle().toggleClass("d-none");
        });
        // Submit Form
        $('.submit-icon-btn').click(function() {
            const submitUrl = $(this).attr("data-submit-url");
            let web_cast_activity_id = @json($data['id']);
            let user_id = @json(auth()->user()->id);

            let question = $("#questionInput").val();

            if (!question) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please enter a question',
                });
                return;
            }

            $.ajax({
                url: submitUrl,
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    question: question,
                    webcast_activity_id: web_cast_activity_id, // hidden input
                    user_id: user_id // hidden input (or from backend)
                },
                success: function(response) {
                    if (response.status) {
                        $("#questionInput").val('');
                        $("#autocompleteList").hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong',
                    });
                }
            });
        });

        // Hide autocomplete on outside click
        $(document).click(function(e) {
            if (!$(e.target).closest(".position-relative").length) {
                $("#autocompleteList").hide();
            }
        });
    </script>
@endpush
