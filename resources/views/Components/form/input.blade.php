{{-- ============================================================
     INPUT COMPONENT
     File: resources/views/components/form/input.blade.php

     Usage:
       <x-form.input name="title" label="Content Title" />
       <x-form.input name="email" label="Email" type="email" required />
       <x-form.input name="phone" label="Phone" type="tel" hint="10 digits" />
     ============================================================ --}}

@props([
    'name',
    'label'       => null,
    'type'        => 'text',
    'value'       => null,
    'placeholder' => '',
    'required'    => false,
    'hint'        => null,
    'colClass'    => 'col-12',
    'readonly'    => false,
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

    <input
      type="{{ $type }}"
      id="fc_{{ $name }}"
      name="{{ $name }}"
      value="{{ old($name, $value) }}"
      placeholder="{{ $placeholder }}"
      {{ $required  ? 'required'  : '' }}
      {{ $readonly  ? 'readonly'  : '' }}
      {{ $disabled  ? 'disabled'  : '' }}
      {{ $attributes->merge(['class' => 'fc-input' . ($errors->has($name) ? ' fc-input-error' : '')]) }}
    />

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
