{{-- resources/views/components/form/datepicker.blade.php --}}

@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => 'DD/MM/YYYY',
    'required' => false,
    'hint' => null,
    'format' => 'dd/mm/yyyy',
    'minDate' => null,
    'maxDate' => null,
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

        {{-- Plain wrapper — NO input-group / NO date class on parent --}}
        <div class="fc-icon-wrap">
            <span class="fc-icon-addon" onclick="$('#fc_{{ $name }}').datepicker('show')">
                <i class="fa fa-calendar-days"></i>
            </span>
            <input type="hidden" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}">
            <input type="text" id="fc_{{ $name }}" placeholder="{{ $placeholder }}"
                data-field-name="{{ $name }}" value="{{ old($name, date('d/m/Y', strtotime($value))) }}"
                autocomplete="off" readonly data-date-format="{{ $format }}" data-date-autoclose="true"
                data-date-today-highlight="true"
                @if ($minDate) data-date-start-date="{{ $minDate }}" @endif
                @if ($maxDate) data-date-end-date="{{ $maxDate }}" @endif
                {{ $required ? 'required' : '' }}
                {{ $attributes->merge(['class' => 'fc-input fc-input-addon fc-datepicker' . ($errors->has($name) ? ' fc-input-error' : '')]) }} />
        </div>

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
