<div class="form-group">
    <div class="form-check">
        <input type="checkbox" name="{{ $name }}" id="{{ $name }}" {{ old($name) ? 'checked' : '' }}
            class="form-check-input"
            @if($required ?? False) required @endif
        >

        <label for="{{ $name }}" class="form-check-label">{{ $label }}</label>

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