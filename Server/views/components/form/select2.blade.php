{{-- ============================================================
     SELECT2 COMPONENT
     File: resources/views/components/form/select2.blade.php

     Usage (static options):
       <x-form.select2
           name="category_id"
           label="Category"
           :options="$categories"
           placeholder="Select category"
           required
       />

     Usage (AJAX):
       <x-form.select2
           name="doctor_id"
           label="Doctor"
           ajax-url="{{ route('admin.doctors.search') }}"
           placeholder="Search doctor..."
       />

     Usage (multiple):
       <x-form.select2
           name="tags[]"
           label="Tags"
           :options="$tags"
           :selected="$post->tags->pluck('id')->toArray()"
           multiple
       />
     ============================================================ --}}

@props([
    'name',
    'label'       => null,
    'options'     => [],           // ['value' => 'Label']
    'selected'    => null,
    'placeholder' => 'Select...',
    'required'    => false,
    'multiple'    => false,
    'ajaxUrl'     => null,
    'hint'        => null,
    'colClass'    => 'col-12',
    'disabled'    => false,
])

@php
    $fieldName = $multiple ? rtrim($name, '[]') . '[]' : $name;
    $fieldId   = 'fc_' . str_replace(['[',']'], '_', $name);
    $oldVal    = old(rtrim($name, '[]'), $selected);
@endphp

<div class="{{ $colClass }}">
  <div class="fc-group">

    @if($label)
      <label class="fc-label" for="{{ $fieldId }}">
        {{ $label }}
        @if($required) <span class="fc-required">*</span> @endif
      </label>
    @endif

    <select
      id="{{ $fieldId }}"
      name="{{ $fieldName }}"
      class="fc-select2 {{ $errors->has(rtrim($name,'[]')) ? 'fc-input-error' : '' }}"
      data-placeholder="{{ $placeholder }}"
      @if($ajaxUrl)  data-ajax-url="{{ $ajaxUrl }}" @endif
      @if($multiple) multiple @endif
      @if($required) required @endif
      @if($disabled) disabled @endif
    >
      @if(!$multiple)
        <option value=""></option>
      @endif

      @foreach($options as $val => $lbl)
        @php
          $isSelected = $multiple
            ? in_array($val, is_array($oldVal) ? $oldVal : [])
            : $oldVal == $val;
        @endphp
        <option value="{{ $val }}" {{ $isSelected ? 'selected' : '' }}>
          {{ $lbl }}
        </option>
      @endforeach
    </select>

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
