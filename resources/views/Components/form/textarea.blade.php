{{-- ============================================================
     TEXTAREA COMPONENT
     File: resources/views/components/form/textarea.blade.php

     Usage:
       <x-form.textarea name="description" label="Description" />
       <x-form.textarea name="notes" label="Notes" :rows="6" required />
     ============================================================ --}}

@props([
    'name',
    'label'       => null,
    'value'       => null,
    'placeholder' => '',
    'required'    => false,
    'rows'        => 4,
    'hint'        => null,
    'colClass'    => 'col-12',
    'disabled'    => false,
])

<div class="{{ $colClass }}">
  <div class="fc-group">

    @if($label)
      <label class="fc-label" for="fc_{{ $name }}">
        {{ $label }}
        @if($required) <span class="fc-required">*</span> @endif
      </label>
    @endif

    <textarea
      id="fc_{{ $name }}"
      name="{{ $name }}"
      rows="{{ $rows }}"
      placeholder="{{ $placeholder }}"
      {{ $required ? 'required' : '' }}
      {{ $disabled ? 'disabled' : '' }}
      {{ $attributes->merge(['class' => 'fc-input fc-textarea' . ($errors->has($name) ? ' fc-input-error' : '')]) }}
    >{{ old($name, $value) }}</textarea>

    @if($hint)
      <span class="fc-hint">{{ $hint }}</span>
    @endif

    @error($name)
      <span class="fc-error-msg">
        <i class="fa fa-circle-exclamation"></i> {{ $message }}
      </span>
    @enderror

  </div>
</div>
