<div class="form-group">
    <label for="{{ $name }}">{{ $slot }}</label>

    <select name="{{ $name }}" id="{{ $name }}"
        class="custom-select @error($name) is-invalid @enderror"
        @if($autofocus ?? false) autofocus @endif
        @if($disabled ?? false) disabled @endif
        @if($autocomplete ?? false) autocomplete="{{ $autocomplete }}" @endif>
        @unless($required ?? false)
        <option value=""></option>
        @endif
        @foreach ($options ?? [] as $option => $name)
        <option value="{{ $option }}" @if(old($name, $initial ?? '') == $option) selected @endif>{{ $name }}</option>
        @endforeach
    </select>

    @error($name)
    <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
    </div>
    @enderror
</div>