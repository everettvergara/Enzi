@if (($disabled ?? '0') === '0')
    <div class="{{ $col ?? 'col-lg-4 col-md-6 col-sm-12' }}">
        <label for="{{ $name }}" class="form-label  mt-3">{{ $label ?? strtoupper(str_replace('_', ' ', $name)) }}</label>
        <input type="password" name="{{ $name }}" id="{{ $name }}" class="form-control {{ $name }}" value="{{ $value ?? old($name) }}" >
    </div>
@else
    <div class="{{ $col ?? 'col-lg-4 col-md-6 col-sm-12' }}">
        <label for="{{ $label ?? $name }}" class="form-label  mt-3">{{ strtoupper(str_replace('_', ' ', $name)) }}</label>
        <input type="password" name="{{ $name }}" id="{{ $name }}" class="form-control {{ $name }}" value="{{ $value ?? old($name) }}"  readonly>
    </div>
@endif