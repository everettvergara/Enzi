@if (($disabled ?? '0') === '0')
<div class="{{ $col ?? 'col-lg-4 col-md-6 col-sm-12' }}">
    <label for="{{ $name }}" class="form-label mt-3">{{ $label ?? strtoupper(str_replace('_', ' ', $name)) }}</label>
    <input type="file" class="form-control {{ $name }}" id="{{ $name }}" name="{{ $name }}" aria-label="{{ $name }}">
</div>
@else
<div class="{{ $col ?? 'col-lg-4 col-md-6 col-sm-12' }}">
    <label for="{{ $name }}" class="form-label mt-3">{{ $label ?? strtoupper(str_replace('_', ' ', $name)) }}</label>
    <input type="file" class="form-control {{ $name }}" id="{{ $name }}" name="{{ $name }}" aria-label="{{ $name }}" disabled>
</div>
@endif


{{-- Make sure to add enctype="multipart/form-data" attribute in the form--}}