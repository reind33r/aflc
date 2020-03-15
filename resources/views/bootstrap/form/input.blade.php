<div class="form-group">
    <label for="{{ $name }}">{{ $slot }}</label>
    <input type="{{ $type ?? 'text' }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $initial ?? '') }}"
        class="form-control @error(array_name_2_dotted($name)) is-invalid @enderror"
        @if($required ?? true) required @endif
        @if($autofocus ?? false) autofocus @endif
        @if($disabled ?? false) disabled @endif
        @if($autocomplete ?? false) autocomplete="{{ $autocomplete }}" @endif
        @if($placeholder ?? false) placeholder="{{ $placeholder }}" @endif
        @if($title ?? false) title="{{ $title }}" @endif
    >

    @error(array_name_2_dotted($name))
    <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
    </div>
    @enderror

    @isset($help_text)
    <small class="form-text text-muted">{{ $help_text }}</small>
    @endisset
</div>