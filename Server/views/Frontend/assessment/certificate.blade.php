@extends('Frontend.layouts.app')
@section('title', 'Certificate')
@push('styles')
    <style>

    </style>
@endpush
@section('main')
    @php
        $user = auth()->user();
    @endphp
    <div class="cert-page-wrap">

        <div class="cert-page-card">

            {{-- Header --}}
            <div class="cert-page-header">
                <a class="cert-back-link" href="{{ route('home') }}">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <span class="cert-page-badge">
                    <i class="fa fa-certificate"></i> Certificate
                </span>
            </div>

            <div class="certificate-completion-title my-3 text-center">
                <span class="text-primary fw-bold">Certificate Of Completion</span>
            </div>

            {{-- Canvas wrapper --}}
            <div class="cert-canvas-wrap">
                <canvas id="certCanvas"></canvas>
                <div id="certLoader" class="cert-canvas-loader">
                    <div class="cert-spinner"></div>
                    <p>Generating your certificate...</p>
                </div>
            </div>

            {{-- Download --}}
            <div class="cert-download-bar">
                <div class="cert-download-info">
                    <i class="bi bi-award-fill"></i>
                    <div>
                        <p class="cert-download-title">Your certificate is ready</p>
                        <p class="cert-download-sub">{{ $user->name }} {{--  &mdash; {{ $activity->activity_name ?? 'Course' }} --}}
                        </p>
                    </div>
                </div>
                <button id="btnDownload" class="cert-download-btn">
                    <i class="fa fa-download"></i> Download Certificate
                </button>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            const userName = @json($user->name);
            const certImageUrl = @json(asset('public/assets/images/certificate1.png'));
            const fileName = 'certificate-{{ Str::slug($user->name) }}.png';

            const canvas = document.getElementById('certCanvas');
            const ctx = canvas.getContext('2d');
            const loader = document.getElementById('certLoader');
            const btnDown = document.getElementById('btnDownload');

            const CERT_W = 1240;
            const CERT_H = 877;

            /* Name position on the certificate — adjust Y to match your template */
            const NAME_X = CERT_W / 2;
            const NAME_Y = 325;

            canvas.width = CERT_W;
            canvas.height = CERT_H;

            const img = new Image();
            img.crossOrigin = 'anonymous';
            img.src = certImageUrl;

            img.onload = function() {
                ctx.drawImage(img, 0, 0, CERT_W, CERT_H);
                drawName(userName);
                loader.style.display = 'none';
            };

            img.onerror = function() {
                loader.innerHTML = '<p style="color:#dc2626;">Failed to load certificate template.</p>';
            };

            function drawName(name) {
                ctx.save();

                /* Cursive name style — matches the certificate design */
                ctx.font = 'italic 70px Georgia, "Times New Roman", serif';
                ctx.fillStyle = '#1a3c6e';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';

                /* Subtle shadow for depth */
                ctx.shadowColor = 'rgba(26,60,110,0.12)';
                ctx.shadowBlur = 6;
                ctx.shadowOffsetX = 2;
                ctx.shadowOffsetY = 2;

                ctx.fillText(name, NAME_X, NAME_Y);
                ctx.restore();
            }

            btnDown.addEventListener('click', function() {
                const link = document.createElement('a');
                link.download = fileName;
                link.href = canvas.toDataURL('image/png', 1.0);
                link.click();
            });
        })();
    </script>
@endpush
