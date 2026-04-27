@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Select...',
    'required' => false,
    'disabled' => false,
    'hint' => null,
    'colClass' => 'col-12',
])

<div class="{{ $colClass }}">
    <div class="fc-group">

        @if ($label)
            <label class="fc-label" for="fc_{{ $name }}">
                {{ $label }}
                @if ($required)
                    <span class="fc-required">*</span>
                @endif
            </label>
        @endif

        <select id="fc_{{ $name }}" name="{{ $name }}" {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge(['class' => 'fc-input fc-select' . ($errors->has($name) ? ' fc-input-error' : '')]) }}>
            @if ($placeholder)
                <option value="" disabled
                    {{ old($name, $selected) === null || old($name, $selected) === '' ? 'selected' : '' }}>
                    {{ $placeholder }}
                </option>
            @endif

            @foreach ($options as $val => $lbl)
                <option value="{{ $val }}" {{ old($name, $selected) == $val ? 'selected' : '' }}>
                    {{ $lbl }}
                </option>
            @endforeach
        </select>

        @if ($hint)
            <span class="fc-hint">{{ $hint }}</span>
        @endif

        @error($name)
            <span class="fc-error-msg">
                <i class="fa fa-circle-exclamation"></i> {{ $message }}
            </span>
        @enderror

    </div>
</div>
