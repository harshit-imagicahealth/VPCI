@extends('Frontend.layouts.app')
@section('title', '')

@push('styles')
    <style>

    </style>
@endpush

@section('main')
    {{-- about us section --}}
    <section class="about-section">
        <div class="container">

            <h2 class="about-heading text-center">About Us</h2>

            <!-- LEFT CONTENT -->
            <div class="mb-4">
                <div class="row align-items-start about-box w-100 h-100 align-items-center mx-auto">
                    <div class="col-md-12">
                        <h2>About Airway Excellence Program</h2>
                        <p class="text-muted">
                            ACE is a structured 3-month academic initiative featuring expert-led modules.
                            pre-learning material, and concise post-session summaries, delivered through a
                            dedicated
                            microsite.
                        </p>
                        <p class="text-muted">
                            The program comprises 6 focused modules led by distinguished faculty, ensuring
                            clinically
                            relevant and evidence-based insights.
                        </p>
                        <p class="text-muted">
                            Upon successful completion & assessment, participants will receive
                            <strong>certification from Vallabhbhai Patel Chest Institute (VPCI).</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script></script>
@endpush
