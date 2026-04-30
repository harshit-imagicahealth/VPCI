@extends('Frontend.layouts.app')
@section('title', 'Assessment Result')
@push('styles')
@endpush
@section('main')
    <div class="assessment-wrap">
        <div class="assessment-card result-card">

            {{-- Header --}}
            <div class="result-header">
                <a class="result-back-link" href="{{ route('home') }}">
                    <i class="fa fa-arrow-left"></i> Back to Home
                </a>
                <div class="result-header-right">
                    <span class="asmnt-badge">Result</span>
                </div>
            </div>

            {{-- Score Summary --}}
            <div class="result-summary">

                <div class="result-score-block">
                    <div class="score-circle-wrap">
                        <svg class="score-circle-svg" viewBox="0 0 120 120">
                            <circle class="score-circle-bg" cx="60" cy="60" r="52" />
                            <circle id="scoreCircle" class="score-circle-fill" cx="60" cy="60" r="52"
                                stroke-dasharray="326.7" stroke-dashoffset="{{ 326.7 - ($percentage / 100) * 326.7 }}" />
                        </svg>
                        <div class="score-circle-text">
                            <span class="score-num">{{ $percentage }}%</span>
                            <span class="score-denom">Score</span>
                        </div>
                    </div>
                </div>

                <div class="result-summary-info">
                    {{-- <div class="result-verdict {{ $percentage >= 60 ? 'verdict-pass' : 'verdict-fail' }}">
                        @if ($percentage >= 60)
                            <i class="fa fa-check"></i> Passed
                        @else
                            <i class="fa fa-times"></i> Failed
                        @endif
                    </div> --}}
                    <h2 class="result-name">Assessment Quiz Result</h2>
                    <p class="result-date">
                        <i class="fa fa-calendar"></i>
                        <span class="text">Completed on {{ $completedAt->format('d M Y, h:i A') }}</span>
                    </p>

                    <div class="result-stats">
                        <div class="result-stat result-stat-correct">
                            <span class="text-success">{{ $correct }}</span>
                            <small><i class="fa fa-check"></i> Correct</small>
                        </div>
                        <div class="result-stat-divider"></div>
                        <div class="result-stat result-stat-wrong">
                            <span class="text-danger">{{ $wrong }}</span>
                            <small><i class="fa fa-times"></i> Wrong</small>
                        </div>
                        <div class="result-stat-divider"></div>
                        <div class="result-stat result-stat-total">
                            <span class="text-primary">{{ $total }}</span>
                            <small><i class="fa fa-list"></i> Total</small>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Divider --}}
            <div class="result-divider">
                <span>Question Review</span>
            </div>

            {{-- Questions Review --}}
            <div class="result-review-grid">
                @foreach ($answers as $index => $item)
                    <div class="result-review-item {{ $item['is_correct'] ? 'review-correct' : 'review-wrong' }}">

                        <div class="review-item-header">
                            <span class="review-q-num">Q{{ $index + 1 }}</span>
                            <span class="review-verdict-badge {{ $item['is_correct'] ? 'badge-correct' : 'badge-wrong' }}">
                                @if ($item['is_correct'])
                                    <i class="fa fa-check"></i> Correct
                                @else
                                    <i class="fa fa-times"></i> Wrong
                                @endif
                            </span>
                        </div>

                        <p class="review-q-text">{{ $item['question'] }}</p>

                        <div class="review-options">
                            @foreach ($item['options'] as $opt)
                                @php
                                    $isUserAnswer = $opt === $item['user_answer'];
                                    $isCorrectAnswer = $opt === $item['correct_answer'];
                                    $optClass = '';
                                    if ($isCorrectAnswer) {
                                        $optClass = 'opt-correct';
                                    } elseif ($isUserAnswer && !$item['is_correct']) {
                                        $optClass = 'opt-wrong';
                                    }
                                @endphp
                                <div class="review-option {{ $optClass }}">
                                    <span class="review-option-dot"></span>
                                    <span class="review-option-text">{{ $opt }}</span>
                                    @if ($isCorrectAnswer)
                                        <span class="review-option-tag tag-correct"><i class="fa fa-check"></i>
                                            Correct</span>
                                    @elseif($isUserAnswer && !$item['is_correct'])
                                        <span class="review-option-tag tag-wrong"><i class="fa fa-times"></i> Yours</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection
@push('scripts')
@endpush
