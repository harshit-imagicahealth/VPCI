@extends('Admin.layouts.main')

@section('title', 'WebCast Resources')
@push('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.wc_resource.index') }}">WebCast Resources</a>
    </li>
    <li class="breadcrumb-item active">Edit</li>
@endpush

@push('styles')
    <style>
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

        <div class="form-card-header">
            <div class="form-card-icon"><i class="fa fa-video"></i></div>
            <div>
                <h6 class="form-card-title">Edit Webcast Resources</h6>
                <p class="form-card-sub">Update webcast resource details</p>
            </div>
        </div>

        <div class="form-card-body">
            <div id="formErrors" class="alert alert-danger d-none"></div>

            <form id="wcResourceForm" action="{{ route('admin.wc_resource.update', ['id' => encrypt($wcResource->id)]) }}"
                method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="fc-group">
                            <label class="fc-label">
                                Select WebCast Activity <span class="fc-required">*</span>
                            </label>
                            <x-form.select2 name="webcast_activity_id" placeholder="Select WebCast Activity" disabled
                                :options="$webcastActivities" :disabled-options="[]" :selected="$wcResource->webcast_activity_id" required col-class="col-md-12" />
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <div class="fc-group">
                        <label class="fc-label">Button Settings</label>
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
                        Update Activity
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
        let alreadyAddedButtons = @json($allreadyAddedButtons);
        let existingItems = @json($existingItems);

        $(document).ready(function() {
            if (existingItems.length > 0) {
                existingItems.forEach(item => addCard(item));
            } else {
                addCard();
            }
        });

        $('[name="webcast_activity_id"]').on('change', function() {
            $('#cardContainer').html('');
            index = 0;
            selectedActivities = [];
            addCard();
        });

        function addCard(prefill = null) {
            let buttons = @json(config('wc_connect.module_resource_options'));
            let selectedModule = $('[name="webcast_activity_id"]').val();
            let disabledButtons = alreadyAddedButtons[String(selectedModule)] || [];

            let options = Object.entries(buttons).map(([key, value]) => {
                let isDisabled = disabledButtons.includes(key) && (!prefill || prefill.activity_type !== key);
                let isSelected = prefill && prefill.activity_type === key ? 'selected' : '';
                return `<option value="${key}" ${isDisabled ? 'disabled' : ''} ${isSelected}>${value}</option>`;
            }).join('');

            let typeOptions = `
            <option value="">Select Type</option>
            <option value="pdf"  ${prefill && prefill.button_type === 'pdf' ? 'selected' : ''}>PDF Url</option>
            <option value="url"  ${prefill && prefill.button_type === 'url' ? 'selected' : ''}>URL</option>
        `;

            let contentHtml = '';
            if (prefill) {
                if (prefill.button_type === 'pdf' || prefill.button_type === 'url') {
                    contentHtml =
                        `<input type="text" name="items[${index}][content]" class="fc-input" value="${prefill.content}" placeholder="Enter ${prefill.button_type === 'pdf' ? 'PDF URL' : 'URL'}">`;
                }
            } else {
                contentHtml = `<span class="fc-hint">Select type first</span>`;
            }

            let html = `
            <div class="button-card">
                <div class="row g-2">
                    <div class="col-md-4">
                        <select name="items[${index}][activity_type]"
                                class="fc-input activity-select"
                                onchange="handleActivityChange(this)">
                            ${options}
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="items[${index}][button_type]"
                                class="fc-input type-select"
                                onchange="changeType(this)">
                            ${typeOptions}
                        </select>
                    </div>
                    <div class="col-md-4 content-box">
                        ${contentHtml}
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn-remove" onclick="removeCard(this)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>`;

            $('#cardContainer').append(html);

            if (prefill && prefill.activity_type) {
                let lastSelect = $('#cardContainer .activity-select').last();
                lastSelect.data('old', prefill.activity_type);
                selectedActivities.push(prefill.activity_type);
            }

            index++;
            updateDropdowns();
        }

        function handleActivityChange(el) {
            let newVal = $(el).val();
            let oldVal = $(el).data('old');
            if (oldVal) selectedActivities = selectedActivities.filter(v => v !== oldVal);
            if (newVal) {
                selectedActivities.push(newVal);
                $(el).data('old', newVal);
            }
            updateDropdowns();
        }

        function updateDropdowns() {
            $('.activity-select').each(function() {
                let currentVal = $(this).val();
                let selectedModule = $('[name="webcast_activity_id"]').val();
                let disabledButtons = alreadyAddedButtons[String(selectedModule)] || [];

                $(this).find('option').each(function() {
                    let val = $(this).val();
                    if (!val) return;
                    let disabledBySelected = selectedActivities.includes(val) && val !== currentVal;
                    let disabledByAdded = disabledButtons.includes(val) && val !== currentVal;
                    $(this).prop('disabled', disabledBySelected || disabledByAdded);
                });
            });
        }

        function changeType(el) {
            let type = $(el).val();
            let container = $(el).closest('.row').find('.content-box');
            let name = $(el).attr('name').replace('button_type', 'content');
            let html = '';
            if (type === 'pdf') {
                html = `<input type="text" name="${name}" class="fc-input" placeholder="Enter PDF URL">`;
            } else if (type === 'url') {
                html = `<input type="text" name="${name}" class="fc-input" placeholder="Enter URL">`;
            }
            container.html(html);
        }

        function removeCard(btn) {
            let select = $(btn).closest('.button-card').find('.activity-select');
            let val = select.val();
            if (val) selectedActivities = selectedActivities.filter(v => v !== val);
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

                if (!$('[name="webcast_activity_id"]').val()) {
                    isValid = false;
                    errors.push("Please select Webcast Activity");
                }
                if ($('.button-card').length === 0) {
                    isValid = false;
                    errors.push("At least one button is required");
                }

                $('.button-card').each(function() {
                    if (!$(this).find('.activity-select').val()) {
                        isValid = false;
                        errors.push("Button Name is required");
                    }
                    if (!$(this).find('.type-select').val()) {
                        isValid = false;
                        errors.push("Button Type is required");
                    }
                    if (!$(this).find('[name*="[content]"]').val()) {
                        isValid = false;
                        errors.push("Content field is required");
                    }
                });

                if (!isValid) {
                    let errorHtml = '<ul class="mb-0">' + errors.map(e => `<li>${e}</li>`).join('') + '</ul>';
                    $('#formErrors').removeClass('d-none').html(errorHtml);
                    $('html, body').animate({
                        scrollTop: $('#formErrors').offset().top - 100
                    }, 300);
                }
                return isValid;
            }

            $('#wcResourceSubmit').on('click', function(e) {
                e.preventDefault();
                if (!validateForm()) return;

                let form = $('#wcResourceForm')[0];
                let formData = new FormData(form);
                formData.append('webcast_activity_id', @json($wcResource?->webcast_activity_id));
                $('.text-danger').remove();

                $.ajax({
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status) {
                            showAlert(res.message, "success");
                            setTimeout(() => window.location.href = res.redirect, 800);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, val) {
                                $('[name="' + key + '"]').after(
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
