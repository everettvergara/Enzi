@if (($disabled ?? '0') === '0')
    <div class="{{ $col ?? 'col-lg-4 col-md-6 col-sm-12' }}">
        <label for={{ $name }} class="form-label mt-3">{{ $label ?? strtoupper(str_replace('_', ' ', $name)) }}</label>
        <textarea class="form-control {{ $name }}" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder ?? null }}">{{ $value ?? old($name) }}</textarea>
    </div>
@else
    <div class="{{ $col ?? 'col-lg-4 col-md-6 col-sm-12' }}">
        <label for={{ $name }} class="form-label mt-3">{{ $label ?? strtoupper(str_replace('_', ' ', $name)) }}</label>
        <textarea class="form-control {{ $name }}" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder ?? null }}" readonly>{{ $value ?? old($name) }}</textarea>
    </div>
@endif