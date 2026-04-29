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

@section('title', 'WebCast Resources')
@push('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('admin.wc_resource.index') }}">
        WebCast Resources
    </a>
</li>
<li class="breadcrumb-item active">{{ isset($webcast) ? 'Edit' : 'Add' }}</li>
@endpush

@push('styles')
<style>
    /* new css */
    .button-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 12px;
        background: #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .button-card .row {
        align-items: center;
    }

    .btn-remove {
        background: #ffeaea;
        color: #d33;
        border: none;
        padding: 6px 10px;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-add-row {
        color: #fff;
        border: none;
        padding: 8px 14px;
        border-radius: 6px;
    }

    .fc-input {
        width: 100%;
        padding: 6px 8px;
    }
</style>
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
                {{ isset($wcResource) ? 'Edit Webcast Resources' : 'Add Webcast Resources' }}
            </h6>
            <p class="form-card-sub">
                {{ isset($wcResource) ? 'Update webcast details' : 'Fill in details to create a new webcast Resource' }}
            </p>
        </div>
    </div>

    <div class="form-card-body">
        <div id="formErrors" class="alert alert-danger d-none"></div>
        <form id="wcResourceForm"
            action="{{ isset($wcResource) ? route('admin.wc_resource.update', ['id' => encrypt($wcResource?->id)]) : route('admin.wc_resource.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($wcResource))
            @method('PUT')
            @endif
            @php
            $hours = config('wc_connect.hours');
            $minutes = config('wc_connect.minutes');
            $ampm = config('wc_connect.ampm');
            @endphp

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="fc-group">
                        <label class="fc-label">

                            Select WebCast Activity<span class="fc-required">*</span>
                        </label>
                        <x-form.select2 name="webcast_activity_id" placeholder="Select WebCast Activity"
                            :options="$webcastActivities" required :selected="old('webcast_activity_id', $webcast?->webcast_activity_id ?? '')" col-class="col-md-12" />
                    </div>
                </div>

            </div>{{-- /row --}}

            {{-- ── Dynamic rows: resource items ── --}}
            <div class="col-12 mt-3">
                <div class="fc-group">
                    <label class="fc-label">Add Button Settings</label>

                    <div id="cardContainer"></div>

                    <div class="mt-2">
                        <button type="button" class="btn-add-row dt-btn-primary" onclick="addCard()">
                            <i class="fa fa-plus"></i> Add Button
                        </button>
                    </div>
                </div>
            </div>

            <div class="fc-actions justify-content-end mt-4">
                <button type="button" id="wcResourceSubmit" class="dt-btn dt-btn-primary">
                    {{-- <i class="fa {{ isset($webcast) ? 'fa-floppy-disk' : 'fa-plus' }}"></i> --}}
                    {{ isset($webcast) ? 'Update Activity' : 'Save Activity' }}
                </button>
                <a class="dt-btn dt-btn-outline" href="{{ route('admin.wc_resource.index') }}">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>

        </form>

    </div>
</div>

@endsection

@push('scripts')
<script>
    let index = 0;
    let selectedActivities = [];

    // ✅ Load default 1 card
    $(document).ready(function() {
        addCard();
    });

    // ✅ Add Card
    function addCard() {

        let options = `
                    <option value="">Select Button Name</option>
                    <option value="pre_read">Pre-read</option>
                    <option value="teaser">Teaser</option>
                    <option value="view_agenda">View Agenda</option>
                    <!-- <option value="assessment">Assessment</option> --!>
                    <option value="summary">Summary</option>
                    <option value="vimeo_url">Vimeo Url</option>
                    <option value="custom">Custom</option>
                `;

        let html = `
                    <div class="button-card">
                        <div class="row g-2">

                            <!-- Activity -->
                            <div class="col-md-4">
                                <select name="items[${index}][activity_type]" 
                                        class="fc-input activity-select" 
                                        onchange="handleActivityChange(this)">
                                    ${options}
                                </select>
                            </div>

                            <!-- Button Type -->
                            <div class="col-md-3">
                                <select name="items[${index}][button_type]" 
                                        class="fc-input type-select" 
                                        onchange="changeType(this)">
                                    <option value="">Select Type</option>
                                    <option value="pdf">PDF Url</option>
                                    <option value="url">URL</option>
                                    <!-- <option value="file_upload">File Upload</option> --!>
                                </select>
                            </div>

                            <!-- Content -->
                            <div class="col-md-4 content-box">
                                <span class="fc-hint">Select type first</span>
                            </div>

                            <!-- Delete -->
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn-remove" onclick="removeCard(this)">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </div>

                        </div>
                    </div>
                    `;

        $('#cardContainer').append(html);
        index++;

        updateDropdowns();
    }

    // ✅ Handle Activity Selection
    function handleActivityChange(el) {

        let newVal = $(el).val();
        let oldVal = $(el).data('old');

        // Remove old value
        if (oldVal) {
            selectedActivities = selectedActivities.filter(v => v !== oldVal);
        }

        // Add new value
        if (newVal) {
            selectedActivities.push(newVal);
            $(el).data('old', newVal);
        }

        updateDropdowns();
    }

    // ✅ Disable selected options in other dropdowns
    function updateDropdowns() {

        $('.activity-select').each(function() {

            let currentVal = $(this).val();

            $(this).find('option').each(function() {

                let val = $(this).val();

                if (!val) return;

                if (selectedActivities.includes(val) && val !== currentVal) {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }

            });

        });
    }

    // ✅ Change content based on type
    function changeType(el) {

        let type = $(el).val();
        let container = $(el).closest('.row').find('.content-box');
        let name = $(el).attr('name').replace('button_type', 'content');

        let html = '';

        if (type === 'pdf') {
            html = `<input type="text" name="${name}" class="fc-input" placeholder="Enter PDF URL">`;
        } else if (type === 'url') {
            html = `<input type="text" name="${name}" class="fc-input" placeholder="Enter URL">`;
        } else if (type === 'file_upload') {
            html = `<input type="file" name="${name}" class="fc-input" placeholder="Upload File Hear.">`;
        }

        container.html(html);
    }

    // ✅ Remove card
    function removeCard(btn) {

        let select = $(btn).closest('.button-card').find('.activity-select');
        let val = select.val();

        if (val) {
            selectedActivities = selectedActivities.filter(v => v !== val);
        }

        $(btn).closest('.button-card').remove();

        updateDropdowns();
    }
</script>
<script>
    $(document).ready(function() {
        function validateForm() {

            let isValid = true;
            let errors = [];

            $('#formErrors').addClass('d-none').html('');

            //  Webcast required
            let webcast = $('[name="webcast_activity_id"]').val();
            if (!webcast) {
                isValid = false;
                errors.push("Please select Webcast Activity");
            }

            //  At least one card
            if ($('.button-card').length === 0) {
                isValid = false;
                errors.push("At least one button is required");
            }

            let selected = [];

            //  Validate each card
            $('.button-card').each(function() {

                let activity = $(this).find('.activity-select').val();
                let type = $(this).find('.type-select').val();
                let content = $(this).find('[name*="[content]"]').val();

                if (!activity) {
                    isValid = false;
                    errors.push("Button Name is required");
                }

                if (!type) {
                    isValid = false;
                    errors.push("Button Type is required");
                }

                if (!content) {
                    isValid = false;
                    errors.push("Content field is required");
                }

                if (activity) {
                    selected.push(activity);
                }
            });

            // //  Required buttons check
            // let requiredButtons = ['pre_read', 'teaser', 'view_agenda', 'summary'];

            // let missing = requiredButtons.filter(btn => !selected.includes(btn));

            // if (missing.length > 0) {
            //     isValid = false;
            //     errors.push("All default buttons must be selected (except Custom)");
            // }

            //  Show errors in top box
            if (!isValid) {

                let errorHtml = '<ul class="mb-0">';
                errors.forEach(err => {
                    errorHtml += `<li>${err}</li>`;
                });
                errorHtml += '</ul>';

                $('#formErrors')
                    .removeClass('d-none')
                    .html(errorHtml);

                // scroll to top
                $('html, body').animate({
                    scrollTop: $('#formErrors').offset().top - 100
                }, 300);
            }

            return isValid;
        }

        $('#wcResourceSubmit').on('click', function(e) {
            e.preventDefault();

            if (!validateForm()) {
                return;
            }

            let form = $('#wcResourceForm')[0];
            let formData = new FormData(form);

            // Clear old errors
            $('.text-danger').remove();

            $.ajax({
                url: $(form).attr('action'),
                method: $(form).find('input[name="_method"]').val() ?? 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {

                    if (res.status) {
                        showAlert(res.message, "success");
                        // redirect
                        setTimeout(() => {
                            window.location.href = res.redirect;
                        }, 800);
                    }
                },
                error: function(xhr) {

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        $.each(errors, function(key, val) {
                            // showAlert(@json(session('success')), "success");

                            let field = key.replace(/\./g, '_');

                            let input = $('[name="' + key + '"]');

                            if (input.length === 0) {
                                input = $('[name^="' + key.split('.')[0] + '"]');
                            }

                            input.after(
                                `<span class="text-danger">${val[0]}</span>`);
                        });

                    } else {
                        toastr.error('Something went wrong');
                    }
                }
            });

        });

    });
</script>
@endpush