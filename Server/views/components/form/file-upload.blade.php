{{-- ============================================================
     FILE UPLOAD COMPONENT
     File: resources/views/components/form/file-upload.blade.php

     Usage:
       <x-form.file-upload name="thumbnail" label="Thumbnail Image" accept="image/*" required />
       <x-form.file-upload name="slider_images[]" label="Slider Images" accept="image/*" multiple />
     ============================================================ --}}

@props([
    'name',
    'label'    => null,
    'accept'   => '*',
    'multiple' => false,
    'required' => false,
    'hint'     => null,
    'colClass' => 'col-12',
])

@php
    $fieldName = $multiple ? rtrim($name, '[]') . '[]' : $name;
    $fieldId   = 'fc_' . str_replace(['[',']'], '_', $name);
    $previewId = 'fc_preview_' . str_replace(['[',']'], '_', $name);
@endphp

<div class="{{ $colClass }}">
  <div class="fc-group">

    @if($label)
      <label class="fc-label">
        {{ $label }}
        @if($required) <span class="fc-required">*</span> @endif
      </label>
    @endif

    <label class="fc-file-drop" for="{{ $fieldId }}">
      <i class="fa fa-cloud-arrow-up"></i>
      <span class="fc-file-drop-text">
        {{ $multiple ? 'Click or drop files to upload' : 'Click or drop file to upload' }}
      </span>
      <span class="fc-file-drop-sub">{{ $hint ?? ($multiple ? 'Multiple files allowed' : '') }}</span>
      <input
        type="file"
        id="{{ $fieldId }}"
        name="{{ $fieldName }}"
        accept="{{ $accept }}"
        {{ $multiple  ? 'multiple'  : '' }}
        {{ $required  ? 'required'  : '' }}
        class="fc-file-input {{ $errors->has(rtrim($name,'[]')) ? 'fc-input-error' : '' }}"
        data-preview="{{ $previewId }}"
        data-multiple="{{ $multiple ? 'true' : 'false' }}"
      />
    </label>

    <div class="fc-preview-wrap" id="{{ $previewId }}"></div>

    @if($hint)
      <span class="fc-hint">{{ $hint }}</span>
    @endif

    @error(rtrim($name, '[]'))
      <span class="fc-error-msg">
        <i class="fa fa-circle-exclamation"></i> {{ $message }}
      </span>
    @enderror

  </div>
</div>
