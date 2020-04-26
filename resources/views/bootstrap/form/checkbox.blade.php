<div class="form-group">
    <div class="form-check">
        @isset($wrap_label_tag)<{{ $wrap_label_tag }}>@endisset
        
        <input type="checkbox" name="{{ $name }}" id="{{ $name }}" {{ old($name, $checked ?? false) ? 'checked' : '' }}
            class="form-check-input @error($name) is-invalid @enderror"
            value="{{ $value ?? 1 }}"
            @if($required ?? False) required @endif
        >

        <label for="{{ $name }}" class="form-check-label">{{ $slot ?? $label }}</label>


        @error($name)
        <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </div>
        @enderror

        @isset($wrap_label_tag)</{{ $wrap_label_tag }}>@endisset

        @if($help_text ?? False)
        <small class="form-text text-muted">
            {{ $help_text }}
        </small>
        @endif
    </div>
</div>