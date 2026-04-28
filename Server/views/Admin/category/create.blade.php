@extends('Admin.layouts.main')
@section('title', 'Category')
@push('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.category.index') }}">
            Category
        </a>
    </li>
    <li class="breadcrumb-item active">Create</li>
@endpush

@push('styles')
    <style>

    </style>
@endpush

@section('content')
    <div class="dt-card">

        <div class="form-card-header">
            <div class="form-card-icon">
                <i class="fa fa-tag"></i>
            </div>
            <div>
                <h6 class="form-card-title">{{ isset($category) ? 'Edit Category' : 'Add Category' }}</h6>
                <p class="form-card-sub">{{ isset($category) ? 'Update the category name' : 'Create a new category' }}</p>
            </div>
        </div>

        <div class="form-card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ol class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ol>
                </div>
            @endif
            <form
                action="{{ isset($category) ? route('admin.category.update', $category->id) : route('admin.category.store') }}"
                method="POST">
                @csrf
                @if (isset($category))
                    @method('PUT')
                @endif

                <div class="fc-group">
                    <label class="fc-label" for="categoryName">
                        Category Name <span class="fc-required">*</span>
                    </label>
                    <input type="text" id="categoryName" name="name" placeholder="Enter category name"
                        class="fc-input @error('name') fc-input-error @enderror"
                        value="{{ old('name', $category->name ?? '') }}" autocomplete="off" />
                    @error('name')
                        <span class="fc-error-msg">
                            <i class="fa fa-circle-exclamation"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="fc-actions">
                    <button type="submit" class="dt-btn dt-btn-primary">
                        {{ isset($category) ? 'Update' : 'Submit' }}
                    </button>
                    <a class="dt-btn dt-btn-outline" href="{{ route('admin.category.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
