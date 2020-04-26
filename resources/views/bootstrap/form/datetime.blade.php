<div class="form-group">
    <label for="{{ $name }}__date">{{ $slot }}</label>
    
    <div class="input-group">
    	<input type="date" name="{{ $name }}__date" id="{{ $name }}__date" value="{{ old($name . '__date', ($initial ?? false) ? $initial->format('Y-m-d') : '') }}"
    	    class="form-control @error(array_name_2_dotted($name . '__date')) is-invalid @enderror"
    	    @if($required ?? true) required @endif
    	    @if($disabled ?? false) disabled @endif
    	    placeholder="AAAA-MM-DD"
    	    @if($title ?? false) title="{{ $title }}" @endif
    	>
    	<input type="time" name="{{ $name }}__time" id="{{ $name }}__time" value="{{ old($name . '__time', ($initial ?? false) ? $initial->format('H:i') : '') }}"
    	    class="form-control @error(array_name_2_dotted($name . '__time')) is-invalid @enderror"
    	    @if($required ?? true) required @endif
    	    @if($disabled ?? false) disabled @endif
    	    placeholder="HH:mm"
    	    @if($title ?? false) title="{{ $title }}" @endif
        >
        
        @error(array_name_2_dotted($name . '__date'))
        <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </div>
        @enderror
        @error(array_name_2_dotted($name . '__time'))
        <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </div>
        @enderror
    </div>

    @isset($help_text)
    <small class="form-text text-muted">{{ $help_text }}</small>
    @endisset
</div>