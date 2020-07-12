<div class="form-group">
    <label for="{{ $name }}">{{ $slot }}</label>

    <textarea name="{{ $name }}" id="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror"
        @if($required ?? true) required @endif
        @if($disabled ?? false) disabled @endif
        @if($autofocus ?? false) autofocus @endif
        @if($autocomplete ?? false) autocomplete="{{ $autocomplete }}" @endif>{{ old($name, $initial ?? '') }}</textarea>

    @error($name)
    <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
    </div>
    @enderror

    @isset($help_text)
    <small class="form-text text-muted">{{ $help_text }}</small>
    @endisset
</div>