@if (($disabled ?? '0') === '0')
    <div class="{{ $col ?? 'col-lg-4 col-md-6 col-sm-12' }}">
        <label for="{{ $name }}" class="form-label mt-3 d-flex">{{ $label ?? strtoupper(str_replace('_', ' ', $name)) }}</label>
        <input type="date" class="form-control" id="{{ $name }}" name="{{ $name }}" value="{{ $value ?? old($name) }}">
    </div>
@else
        <div class="{{ $col ?? 'col-lg-4 col-md-6 col-sm-12' }}">
        <label for="{{ $name }}" class="form-label mt-3 d-flex" >{{ $label ?? strtoupper(str_replace('_', ' ', $name)) }}</label>
        <input type="date" class="form-control" id="{{ $name }}" name="{{ $name }}" value="{{ $value ?? old($name) }}" readonly>
    </div>
@endif