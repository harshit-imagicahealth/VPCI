{{-- ============================================================
     RADIO & CHECKBOX COMPONENT
     File: resources/views/components/form/check.blade.php

     Usage (radio):
       <x-form.check
           type="radio"
           name="status"
           label="Status"
           :options="['upcoming'=>'Upcoming','live'=>'Live Now','completed'=>'Completed']"
           selected="upcoming"
           inline
       />

     Usage (checkbox group):
       <x-form.check
           type="checkbox"
           name="tags[]"
           label="Tags"
           :options="['php'=>'PHP','laravel'=>'Laravel']"
           :selected="['php']"
           inline
       />

     Usage (single checkbox):
       <x-form.check
           type="checkbox"
           name="agree"
           label="I agree to terms"
           single
       />
     ============================================================ --}}

@props([
    'name',
    'type'     => 'radio',        // radio | checkbox
    'label'    => null,
    'options'  => [],             // ['value' => 'Label']
    'selected' => null,           // string for radio, array for checkbox
    'required' => false,
    'inline'   => false,
    'single'   => false,          // single standalone checkbox (no options loop)
    'hint'     => null,
    'colClass' => 'col-12',
])

<div class="{{ $colClass }}">
  <div class="fc-group">

    @if($label && !$single)
      <label class="fc-label">
        {{ $label }}
        @if($required) <span class="fc-required">*</span> @endif
      </label>
    @endif

    {{-- Single standalone checkbox --}}
    @if($single)
      @php $singleId = 'fc_' . $name; @endphp
      <label class="fc-check-label" for="{{ $singleId }}">
        <input
          type="checkbox"
          id="{{ $singleId }}"
          name="{{ $name }}"
          value="1"
          class="fc-check-input"
          {{ old($name) ? 'checked' : '' }}
          {{ $required ? 'required' : '' }}
        />
        <span class="fc-check-box"></span>
        <span class="fc-check-text">{{ $label }}</span>
      </label>

    {{-- Options loop --}}
    @else
      <div class="fc-check-group {{ $inline ? 'fc-check-inline' : '' }}">
        @foreach($options as $val => $lbl)
          @php
            $optId    = 'fc_' . str_replace(['[',']'], '_', $name) . '_' . \Illuminate\Support\Str::slug($val);
            $checked  = $type === 'radio'
              ? (old($name, $selected) == $val)
              : in_array($val, old($name, is_array($selected) ? $selected : []));
          @endphp

          <label class="fc-check-label" for="{{ $optId }}">
            <input
              type="{{ $type }}"
              id="{{ $optId }}"
              name="{{ $name }}"
              value="{{ $val }}"
              class="fc-check-input"
              {{ $checked  ? 'checked'  : '' }}
              {{ $required ? 'required' : '' }}
            />

            @if($type === 'radio')
              <span class="fc-radio-dot"></span>
            @else
              <span class="fc-check-box"></span>
            @endif

            <span class="fc-check-text">{{ $lbl }}</span>
          </label>

        @endforeach
      </div>
    @endif

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
