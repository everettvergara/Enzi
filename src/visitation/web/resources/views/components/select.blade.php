@if (($disabled ?? '0') === '0' )
<div class="{{ $col ?? 'col-lg-4 col-md-6 col-sm-12' }}">
    <label for="{{ $name }}" class="form-label mt-3" id="{{ $name }}_label">{{ $label ?? strtoupper(str_replace('_', ' ', str_replace('_id', '',$name))) }}</label>
    <select class="form-select {{ $name }}"  name="{{ $name }}" id="{{ $name }}" >
        <option value="{{ null }}">{{ 'Select the ' . strtoupper(str_replace('_', ' ', str_replace('_id', '', $label ?? $name)))  }}</option>
    @foreach ($elements as $element)
        <option value="{{ $element->id }}" {{ (($value ?? old($name)) == $element->id ? "selected":"") }}>{{ $element->name }}</option>
    @endforeach
    </select>
</div>
@else
<div class="{{ $col ?? 'col-lg-4 col-md-6 col-sm-12' }}">
    <label for="{{ $name }}" class="form-label mt-3" id="{{ $name }}_label">{{ $label ?? strtoupper(str_replace('_', ' ', str_replace('_id', '',$name))) }}</label>
    <select class="form-select {{ $name }}"  name="{{ $name }}" id="{{ $name }}" disabled>
        <option value="{{ null }}">{{ 'Select the ' . strtoupper(str_replace('_', ' ', str_replace('_id', '', $label ?? $name)))  }}</option>
    @foreach ($elements as $element)
        <option value="{{ $element->id }}" {{ (($value ?? old($name)) == $element->id ? "selected":"") }}>{{ $element->name }}</option>
    @endforeach
    </select>
</div>
@endif