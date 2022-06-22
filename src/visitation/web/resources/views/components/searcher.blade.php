@if (($disabled ?? '0') === '0' )
<div class="{{ $col ?? 'col-lg-4 col-md-6 col-sm-12' }}">
    <label for="{{ $name }}" class="form-label mt-3">{{ $label ?? strtoupper(str_replace('_', ' ', str_replace('_id', '',$name))) }}</label>
    <div class="input-group">
        <select class="form-select select-readonly {{ $name }}" name="{{ $name }}" id="{{ $name }}" tabindex="-1" aria-disabled="true">
            <option value="{{ null }}">{{ 'Select the ' . strtoupper(str_replace('_', ' ', str_replace('_id', '', $label ?? $name)))  }}</option>
        @foreach ($elements as $element)
            <option value="{{ $element->id }}" {{ (($value ?? old($name)) == $element->id ? "selected":"") }}>{{ $element->name }}</option>
        @endforeach
        </select>
        <button class="btn btn-outline-secondary action-btn" type="button" id="{{ $name }}ModalBtn">
            <i class="fa-solid fa-ellipsis"></i>
        </button>

    </div>

</div>
@else
<div class="{{ $col ?? 'col-lg-4 col-md-6 col-sm-12' }}">
    <label for="{{ $name }}" class="form-label mt-3">{{ $label ?? strtoupper(str_replace('_', ' ', str_replace('_id', '',$name))) }}</label>
    <div class="input-group">
        <select class="form-select select-readonly {{ $name }}" name="{{ $name }}" id="{{ $name }}" tabindex="-1" aria-disabled="true">
            <option value="{{ null }}">{{ 'Select the ' . strtoupper(str_replace('_', ' ', str_replace('_id', '', $label ?? $name)))  }}</option>
        @foreach ($elements as $element)
            <option value="{{ $element->id }}" {{ (($value ?? old($name)) == $element->id ? "selected":"") }}>{{ $element->name }}</option>
        @endforeach
        </select>
        <button class="btn btn-outline-secondary action-btn " type="button" id="{{ $name }}ModalBtn" disabled>
            <i class="fa-solid fa-ellipsis"></i>
        </button>
    </div>
</div>
@endif