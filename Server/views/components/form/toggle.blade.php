@props(['name', 'label' => '', 'checked' => true, 'colClass' => 'col-12'])

<div class="{{ $colClass }}">
    <div class="fc-group">
        @if ($label)
            <label class="fc-label">{{ $label }}</label>
        @endif
        <div class="fc-toggle-wrap">
            <label class="fc-toggle-switch">
                <input type="hidden" name="{{ $name }}" value="0">
                <input type="checkbox" name="{{ $name }}" value="1" {{ $checked ? 'checked' : '' }}>
                <span class="fc-toggle-slider"></span>
            </label>
            <span class="fc-toggle-label">{{ $checked ? 'Enabled' : 'Disabled' }}</span>
        </div>
    </div>
</div>
