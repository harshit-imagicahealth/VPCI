@props([
    'name',
    'label' => '',
    'placeholder' => 'Type and press Enter...',
    'selected' => [],
    'colClass' => 'col-12',
    'required' => false,
])

@php
    $selected = is_array($selected) ? $selected : (is_string($selected) ? json_decode($selected, true) ?? [] : []);
    $componentId = 'tag-select-' . str_replace(['[', ']', '.', '-'], '_', $name);
@endphp

<div class="{{ $colClass }}">
    <div class="fc-group">

        @if ($label)
            <label class="fc-label">
                {{ $label }}
                @if ($required)
                    <span class="fc-required">*</span>
                @endif
            </label>
        @endif

        <div id="{{ $componentId }}" class="fc-tag-select">
            <div id="{{ $componentId }}-box" class="fc-tag-box">
                <input type="text" id="{{ $componentId }}-input" placeholder="{{ $placeholder }}"
                    class="fc-tag-input fc-input" autocomplete="off"
                    {{ $attributes->merge(['class' => 'fc-input' . ($errors->has($name) ? ' fc-input-error' : '')]) }} />
            </div>
            <p class="fc-tag-hint">Press <kbd>Enter</kbd> or <kbd>,</kbd> to add a tag</p>
        </div>

        <div id="{{ $componentId }}-inputs"></div>

        @error($name)
            <span class="fc-error-msg"><i class="fa fa-circle-exclamation"></i> {{ $message }}</span>
        @enderror

    </div>
</div>

@once
    @push('styles')
        <style>
            .fc-tag-select {
                position: relative;
            }

            .fc-tag-box {
                min-height: 42px;
                border-radius: 8px;
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
                align-items: center;
                background: #fff;
                transition: border-color 0.15s, box-shadow 0.15s;
                cursor: text;
            }

            .fc-tag-input::placeholder {
                color: #9ca3af;
            }

            .fc-tag-chip {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                background: var(--primaryThemeColorLight);
                color: white;
                font-size: 12px;
                font-weight: 500;
                padding: 3px 8px 3px 10px;
                border-radius: 20px;
                white-space: nowrap;
                animation: chipPop .15s ease;
            }

            @keyframes chipPop {
                from {
                    transform: scale(.8);
                    opacity: 0;
                }

                to {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .fc-tag-chip-remove {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 15px;
                height: 15px;
                border-radius: 50%;
                background: var(--primaryThemeColorDark);
                color: white;
                font-size: 9px;
                cursor: pointer;
                border: none;
                padding: 0;
                line-height: 1;
                flex-shrink: 0;
                transition: background 0.15s;
            }

            .fc-tag-chip-remove:hover {
                background: var(--primaryThemeColorLight);
            }

            .fc-tag-hint {
                font-size: 11px;
                color: #9ca3af;
                margin: 4px 2px 0;
            }

            .fc-tag-hint kbd {
                background: #f3f4f6;
                border: 1px solid #d1d5db;
                border-radius: 4px;
                padding: 1px 5px;
                font-size: 10px;
                color: #6b7280;
            }
        </style>
    @endpush
@endonce

@push('scripts')
    <script>
        (function() {
            const id = @json($componentId);
            const inputName = @json($name);
            const init = @json($selected);

            const box = document.getElementById(id + '-box');
            const textInput = document.getElementById(id + '-input');
            const inputsWrap = document.getElementById(id + '-inputs');

            let tags = [...init];

            function render() {
                box.querySelectorAll('.fc-tag-chip').forEach(el => el.remove());
                inputsWrap.innerHTML = '';

                tags.forEach(tag => {
                    const chip = document.createElement('span');
                    chip.className = 'fc-tag-chip';
                    chip.innerHTML =
                        `${tag}<button type="button" class="fc-tag-chip-remove" data-tag="${tag}"><i class="fa fa-xmark"></i></button>`;
                    box.insertBefore(chip, textInput);

                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = inputName;
                    hidden.value = tag;
                    inputsWrap.appendChild(hidden);
                });
            }

            function addTag(raw) {
                const val = raw.trim().replace(/,+$/, '').trim();
                if (!val || tags.includes(val)) return;
                tags.push(val);
                render();
            }

            function removeTag(val) {
                tags = tags.filter(t => t !== val);
                render();
            }

            textInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ',') {
                    e.preventDefault();
                    addTag(this.value);
                    this.value = '';
                    return;
                }
                if (e.key === 'Backspace' && this.value === '' && tags.length) {
                    removeTag(tags[tags.length - 1]);
                }
            });

            textInput.addEventListener('blur', function() {
                if (this.value.trim()) {
                    addTag(this.value);
                    this.value = '';
                }
            });

            box.addEventListener('click', function(e) {
                const btn = e.target.closest('.fc-tag-chip-remove');
                if (btn) {
                    removeTag(btn.dataset.tag);
                    return;
                }
                textInput.focus();
            });

            render();
        })();
    </script>
@endpush
