@if (($disabled ?? '0') === '0')
<div class="form-check">
    <input type="hidden" name="{{ $name }}" value="0"/>
    <input class="form-check-input {{ $name }}" type="checkbox" value="1" id="{{ $name }}" name="{{ $name }}"  {{ ($value??0) == 1 ? "checked":""}}>
    <label class="form-check-label" for="{{ $name }}">
        {{ $label ?? strtoupper(str_replace('_', ' ', str_replace('_id', '',$name))) }}
    </label>
</div>
@else
<div class="form-check">
    <input type="hidden" name="{{ $name }}" value="0"/>
    <input class="form-check-input {{ $name }}" type="checkbox" value="1" id="{{ $name }}" name="{{ $name }}"  {{ ($value??0) == 1 ? "checked":""}} disabled>
    <label class="form-check-label" for="{{ $name }}">
        {{ $label ?? strtoupper(str_replace('_', ' ', str_replace('_id', '',$name))) }}
    </label>
</div>
@endif