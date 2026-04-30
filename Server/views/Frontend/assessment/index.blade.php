@extends('Frontend.layouts.app')
@section('title', 'Assessment')
@push('styles')
@endpush
@section('main')
    <div class="assessment-wrap">

        {{-- QUESTIONS PAGE --}}
        <div id="assessmentPage">

            <div class="assessment-card">

                {{-- Header --}}
                <div class="asmnt-header">
                    <div class="asmnt-meta">
                        {{-- <span class="asmnt-badge">Assessment</span> --}}
                        <h2 class="asmnt-title">Assessment Quiz</h2>
                    </div>
                    <div class="asmnt-progress-info">
                        <span id="qCounter" class="asmnt-counter">1 / {{ count($questions) }}</span>
                    </div>
                </div>

                {{-- Progress bar --}}
                <div class="asmnt-progress-bar-wrap">
                    <div id="progressBar" class="asmnt-progress-bar"
                        style="width: {{ count($questions) ? round((1 / count($questions)) * 100) : 0 }}%"></div>
                </div>

                {{-- Questions --}}
                <div id="questionsWrap">
                    @foreach ($questions as $index => $q)
                        <div class="asmnt-question-block {{ $index > 0 ? 'd-none' : '' }}" data-index="{{ $index }}">

                            <p class="asmnt-q-label">Question {{ $index + 1 }}</p>
                            <h4 class="asmnt-q-text">{{ $q->question }}</h4>

                            <div class="asmnt-options">
                                @php $opts = is_array($q->options) ? $q->options : json_decode($q->options, true) ?? []; @endphp
                                @foreach ($opts as $opt)
                                    <label class="asmnt-option" data-qid="{{ $q->id }}">
                                        <input type="radio" name="question_{{ $q->id }}" class="asmnt-radio"
                                            value="{{ $opt }}">
                                        <span class="asmnt-option-box">
                                            <span class="asmnt-option-dot"></span>
                                            <span class="asmnt-option-text">{{ $opt }}</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- Footer nav --}}
                <div class="asmnt-footer">
                    <button id="btnPrev" class="asmnt-btn asmnt-btn-outline" disabled>
                        <i class="bi bi-arrow-left"></i> Previous
                    </button>
                    <button id="btnNext" class="asmnt-btn asmnt-btn-primary">
                        Next <i class="bi bi-arrow-right"></i>
                    </button>
                    <button id="btnSubmit" class="asmnt-btn asmnt-btn-success d-none">
                        <i class="bi bi-check-circle"></i> Submit
                    </button>
                </div>

            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            const questions = @json($questions);
            const submitUrl = @json(route('webinars.assessment.store'));
            const csrf = @json(csrf_token());
            const total = questions.length;

            let current = 0;
            let answers = {};

            const blocks = document.querySelectorAll('.asmnt-question-block');
            const btnPrev = document.getElementById('btnPrev');
            const btnNext = document.getElementById('btnNext');
            const btnSubmit = document.getElementById('btnSubmit');
            const counter = document.getElementById('qCounter');
            const progress = document.getElementById('progressBar');

            function showQuestion(idx) {
                blocks.forEach(b => b.classList.add('d-none'));
                blocks[idx].classList.remove('d-none');

                counter.textContent = `${idx + 1} / ${total}`;
                progress.style.width = `${Math.round((idx + 1) / total * 100)}%`;

                btnPrev.disabled = idx === 0;

                const isLast = idx === total - 1;
                btnNext.classList.toggle('d-none', isLast);
                btnSubmit.classList.toggle('d-none', !isLast);

                const saved = answers[questions[idx].id];
                if (saved) {
                    const radio = blocks[idx].querySelector(`input[value="${CSS.escape(saved)}"]`);
                    if (radio) radio.checked = true;
                }
            }

            function getSelected(idx) {
                return blocks[idx].querySelector('.asmnt-radio:checked')?.value ?? null;
            }

            btnNext.addEventListener('click', function() {
                const selected = getSelected(current);
                if (!selected) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Select an option',
                        text: 'Please choose an answer before proceeding.',
                        confirmButtonColor: '#4f46e5'
                    });
                    return;
                }
                answers[questions[current].id] = selected;
                current++;
                showQuestion(current);
            });

            btnPrev.addEventListener('click', function() {
                const selected = getSelected(current);
                if (selected) answers[questions[current].id] = selected;
                current--;
                showQuestion(current);
            });

            btnSubmit.addEventListener('click', function() {
                const selected = getSelected(current);
                if (!selected) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Select an option',
                        text: 'Please choose an answer before submitting.',
                        confirmButtonColor: '#4f46e5'
                    });
                    return;
                }
                answers[questions[current].id] = selected;

                Swal.fire({
                    title: 'Submit Assessment?',
                    text: 'Are you sure you want to submit your answers?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, Submit!'
                }).then(result => {
                    if (!result.isConfirmed) return;

                    $("#pageLoader").removeClass("d-none");

                    $.ajax({
                        url: submitUrl,
                        type: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({
                            _token: csrf,
                            answers: answers
                        }),
                        success: function(res) {
                            if (res.status) window.location.href = res.redirect_url;
                            else Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: res.message || 'Something went wrong!'
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: 'Something went wrong!'
                            });
                        },
                        complete: function() {
                            $("#pageLoader").addClass("d-none");
                        }
                    });
                });
            });

            function showScore(res) {
                document.getElementById('assessmentPage').classList.add('d-none');
                document.getElementById('scorePage').classList.remove('d-none');

                const correct = res.correct;
                const wrong = res.wrong;
                const tot = res.total;
                const pct = Math.round(correct / tot * 100);

                document.getElementById('correctCount').textContent = correct;
                document.getElementById('wrongCount').textContent = wrong;
                document.getElementById('totalCount').textContent = tot;
                document.getElementById('scoreDenom').textContent = `/ ${tot}`;

                const isPassed = pct >= 60;
                document.getElementById('scoreIconWrap').textContent = isPassed ? '🎉' : '📝';
                document.getElementById('scoreTitle').textContent = isPassed ? 'Congratulations!' : 'Keep Practicing!';
                document.getElementById('scoreSubtitle').textContent = isPassed ?
                    `You scored ${pct}% — well done!` :
                    `You scored ${pct}% — review the material and try again.`;

                const circle = document.getElementById('scoreCircle');
                const circumference = 326.7;
                circle.style.stroke = isPassed ? '#4f46e5' : '#f59e0b';

                setTimeout(() => {
                    const offset = circumference - (pct / 100 * circumference);
                    circle.style.strokeDashoffset = offset;

                    let n = 0;
                    const numEl = document.getElementById('scoreNum');
                    const step = Math.ceil(correct / 40);
                    const timer = setInterval(() => {
                        n = Math.min(n + step, correct);
                        numEl.textContent = n;
                        if (n >= correct) clearInterval(timer);
                    }, 25);
                }, 100);
            }

            showQuestion(0);
        })();
    </script>
@endpush
