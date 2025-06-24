<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type ?? 'text' }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value ?? '') }}" class="form-control">
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>