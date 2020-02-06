<div class="form-group">
    <div class="form-check">
        @isset($wrap_label_tag)<{{ $wrap_label_tag }}>@endisset
        
        <input type="checkbox" name="{{ $name }}" id="{{ $name }}" {{ old($name, $checked ?? false) ? 'checked' : '' }}
            class="form-check-input"
            @if($required ?? False) required @endif
        >

        <label for="{{ $name }}" class="form-check-label">{{ $slot ?? $label }}</label>

        @isset($wrap_label_tag)</{{ $wrap_label_tag }}>@endisset

        @error($name)
        <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </div>
        @enderror

        @if($help_text ?? False)
        <small class="form-text text-muted">
            {{ $help_text }}
        </small>
        @endif
    </div>
</div>