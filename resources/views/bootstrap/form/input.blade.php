<div class="form-group">
    <label for="{{ $name }}">{{ $slot }}</label>
    <input type="{{ $type ?? 'text' }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name) }}"
        class="form-control @error($name) is-invalid @enderror"
        @if($required ?? true) required @endif
        @if($autofocus ?? false) autofocus @endif
        @if($autocomplete ?? false) autocomplete="{{ $autocomplete }}" @endif
    >

    @error($name)
    <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
    </div>
    @enderror
</div>