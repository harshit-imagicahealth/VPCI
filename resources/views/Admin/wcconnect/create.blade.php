{{-- ============================================================
     WEBCAST CONNECT — Add / Edit Form
     File: resources/views/admin/webcast/form.blade.php

     In controller pass:
       $categories  = Category::pluck('name','id')
       $hours       = collect(range(1,12))->mapWithKeys(fn($h)=>[$h=>str_pad($h,2,'0',STR_PAD_LEFT)])->all()
       $minutes     = ['00'=>'00','05'=>'05','10'=>'10','15'=>'15','20'=>'20','25'=>'25',
                       '30'=>'30','35'=>'35','40'=>'40','45'=>'45','50'=>'50','55'=>'55']
       $ampm        = ['AM'=>'AM','PM'=>'PM']
     ============================================================ --}}

@extends('Admin.layouts.main')

@section('title', 'WebCast Connect')
@push('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.wc_connect.index') }}">
            WebCast Connect
        </a>
    </li>
    <li class="breadcrumb-item active">{{ isset($webcast) ? 'Edit' : 'Add' }}</li>
@endpush

@section('content')

    <div class="dt-card">

        {{-- Header --}}
        <div class="form-card-header">
            <div class="form-card-icon">
                <i class="fa fa-video"></i>
            </div>
            <div>
                <h6 class="form-card-title">
                    {{ isset($webcast) ? 'Edit Webcast Connect' : 'Add Webcast Connect' }}
                </h6>
                <p class="form-card-sub">
                    {{ isset($webcast) ? 'Update webcast details' : 'Fill in details to create a new webcast' }}
                </p>
            </div>
        </div>

        <div class="form-card-body">

            <form
                action="{{ isset($webcast) ? route('admin.wc_connect.update', ['id' => encrypt($webcast?->id)]) : route('admin.wc_connect.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($webcast))
                    @method('PUT')
                @endif
                @php
                    $hours = config('wc_connect.hours');
                    $minutes = config('wc_connect.minutes');
                    $ampm = config('wc_connect.ampm');
                @endphp

                <div class="row g-3">

                    {{-- Content Title --}}
                    <x-form.input name="content_title" placeholder="Enter content title" label="Content Title"
                        :value="old('content_title', $webcast?->content_title ?? '') ?? null" required col-class=" col-md-6 " />

                    {{-- Activity Name --}}
                    <x-form.input name="activity_name" placeholder="Enter activity name" label="Activity Name"
                        :value="old('activity_name', $webcast?->activity_name ?? '') ?? null" required col-class=" col-md-6" />

                    {{-- Dr Name --}}
                    <x-form.input name="dr_name" placeholder="Enter doctor name without Dr prefix" label="Dr. Name"
                        :value="old('dr_name', $webcast?->dr_name ?? '') ?? null" required col-class=" col-md-6" />

                    {{-- Date --}}
                    <x-form.datepicker name="webcast_date" placeholder="DD/MM/YYYY" label="Date" :value="old(
                        'webcast_date',
                        isset($webcast) ? date('Y-m-d', strtotime($webcast?->webcast_date)) : '',
                    ) ?? null"
                        required col-class="col-md-6" />

                    {{-- Time row: Hour / Minute / AM-PM --}}
                    <div class="col-md-12">
                        <div class="fc-group">
                            <label class="fc-label">
                                Time <span class="fc-required">*</span>
                            </label>
                            <div class="fc-time-row">

                                {{-- Hours --}}
                                <x-form.select2 name="webcast_hour" placeholder="Select Hour" :options="$hours" required
                                    :selected="old('webcast_hour', $webcast?->webcast_hour ?? '')" col-class="col-12 col-md-3" />

                                {{-- <span class="fc-time-sep d-none d-lg-block">:</span> --}}

                                {{-- Minutes --}}
                                <x-form.select2 name="webcast_minute" placeholder="Select Minute" :options="$minutes" required
                                    :selected="old('webcast_minute', $webcast?->webcast_minute ?? '')" col-class="col-12 col-md-3" />

                                {{-- <span class="fc-time-sep d-none d-lg-block">:</span> --}}

                                {{-- AM/PM --}}
                                <x-form.select2 name="webcast_ampm" placeholder="Select AM/PM" :options="$ampm" required
                                    :selected="old('webcast_ampm', $webcast?->webcast_ampm ?? '')" col-class="col-12 col-md-3" />

                            </div>
                            @error('webcast_hour')
                                <span class="fc-error-msg"><i class="fa fa-circle-exclamation"></i> {{ $message }}</span>
                            @enderror
                            @error('webcast_minute')
                                <span class="fc-error-msg"><i class="fa fa-circle-exclamation"></i> {{ $message }}</span>
                            @enderror
                            @error('webcast_ampm')
                                <span class="fc-error-msg"><i class="fa fa-circle-exclamation"></i> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Thumbnail Image --}}
                    <x-form.file-upload name="thumbnail" label="Thumbnail Image" accept="image/*" hint="JPG, PNG — max 2MB"
                        :required="!isset($webcast)" col-class="col-md-6" />

                    {{-- Slider Images --}}
                    <x-form.file-upload name="slider_images[]" label="Slider Images" accept="image/*" :multiple="true"
                        hint="Select multiple — JPG, PNG — max 5MB each" col-class="col-md-6" />
                    <div class="row">
                        @if (isset($webcast) && $webcast->thumbnail)
                            <div class="col-md-6 mt-2">
                                <img class="img-preview-thumb" src="{{ asset('storage/' . $webcast->thumbnail) }}"
                                    alt="Thumbnail">
                            </div>
                        @endif
                        @if (isset($webcast) && $webcast->slider_images)
                            <div class="col-md-6 d-flex mt-2 flex-wrap gap-2">

                                @foreach (json_decode($webcast->slider_images, true) as $img)
                                    <div class="position-relative">
                                        <img class="img-preview-slider" src="{{ asset('storage/' . $img) }}"
                                            alt="Slider Image">
                                    </div>
                                @endforeach

                            </div>
                        @endif
                    </div>

                    {{-- Status --}}
                    <x-form.check type="radio" name="status" label="Status" :options="['upcoming' => 'Upcoming', 'live' => 'Live Now', 'completed' => 'Completed']" :selected="$webcast->status ?? 'upcoming'"
                        :inline="true" required col-class="col-12" />

                </div>{{-- /row --}}

                <div class="fc-actions mt-4">
                    <button type="submit" class="dt-btn dt-btn-primary">
                        {{-- <i class="fa {{ isset($webcast) ? 'fa-floppy-disk' : 'fa-plus' }}"></i> --}}
                        {{ isset($webcast) ? 'Update Activity' : 'Save Activity' }}
                    </button>
                    <a class="dt-btn dt-btn-outline" href="{{ route('admin.wc_connect.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

            </form>

        </div>
    </div>

@endsection
