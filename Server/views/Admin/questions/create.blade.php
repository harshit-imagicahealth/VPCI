@extends('Admin.layouts.main')
@section('title', 'Activity Questions')

@push('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('admin.questions.index') }}">Activity Questions</a>
</li>
<li class="breadcrumb-item active">{{ isset($question) ? 'Edit' : 'Add' }}</li>
@endpush

@section('content')

<div class="dt-card">

    <div class="form-card-header">
        <div class="form-card-icon">
            <i class="fa fa-circle-question"></i>
        </div>
        <div>
            <h6 class="form-card-title">
                {{ isset($question) ? 'Edit Question' : 'Add Question' }}
            </h6>
            <p class="form-card-sub">
                {{ isset($question) ? 'Update question details' : 'Fill in details to create a new question' }}
            </p>
        </div>
    </div>

    <div class="form-card-body">

        <form
            action="{{ isset($question) ? route('admin.questions.update', encrypt($question->id)) : route('admin.questions.store') }}"
            method="POST">
            @csrf
            @if(isset($question))
            @method('PUT')
            @endif

            <div class="row g-3">

                {{-- Question Type --}}
                @php
                $question_types = config('wc_connect.question_types');
                @endphp
                <x-form.select
                    name="question_type"
                    label="Question Type"
                    placeholder="Select question type"
                    :options="$question_types"
                    :selected="old('question_type', $question->question_type ?? '')"
                    required
                    col-class="col-md-6" />

                {{-- Status Toggle --}}
                <x-form.toggle
                    name="status"
                    label="Is Active?"
                    :checked="old('status', $question->status ?? 1) == 1"
                    col-class="col-md-6" />

                {{-- Question --}}
                <x-form.input
                    name="question"
                    label="Question"
                    placeholder="Enter question text"
                    :value="old('question', $question->question ?? '')"
                    required
                    col-class="col-md-6" />

                {{-- Answer --}}
                <x-form.input
                    name="answer"
                    label="Answer"
                    placeholder="Enter answer text"
                    :value="old('answer', $question->answer ?? '')"
                    required
                    col-class="col-md-6" />

                <x-form.tag-select
                    name="options[]"
                    label="Answer Options"
                    placeholder="Type an option and press Enter..."
                    :selected="old('options', isset($question) ? json_decode($question->options, true) ?? [] : [])"
                    required
                    col-class="col-md-12" />



            </div>

            <div class="fc-actions mt-4">
                <button type="submit" class="dt-btn dt-btn-primary">
                    {{ isset($question) ? 'Update Question' : 'Save Question' }}
                </button>
                <a class="dt-btn dt-btn-outline" href="{{ route('admin.questions.index') }}">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.fc-toggle-switch input[type="checkbox"]').forEach(function(cb) {
        cb.addEventListener('change', function() {
            const label = this.closest('.fc-toggle-wrap').querySelector('.fc-toggle-label');
            if (label) label.textContent = this.checked ? 'Enabled' : 'Disabled';
        });
    });
</script>
@endpush