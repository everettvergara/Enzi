<div class="row">

    @foreach($fields as $key => $field)
            @switch(true)
                @case($field == 'text' || $field == 'number')
                    @if($key != 'id')
                        @text([
                            'name' => $key,
                            'label' => isset($labels[$key]) ? $labels[$key] : null,
                            'placeholder' => 'Enter the '.$key,
                            'value' => isset($element) ? $element->$key : null,
                            'col'   => isset($column_num) ? $column_num: null,
                            'disabled'  => isset($disabled) ? $disabled : null,
                        ])@endtext
                    @else
                        @text([
                            'name' => $key,
                            'label' => isset($labels[$key]) ? $labels[$key] : null,
                            'value' => isset($element) ? $element->$key : null,
                            'col'   => isset($column_num) ? $column_num: null,
                            'disabled'  => 1,
                        ])@endtext
                    @endif
                    @break
                @case($field == 'textarea')
                    @textarea([
                        'name' => $key,
                        'label' => isset($labels[$key]) ? $labels[$key] : null,
                        'placeholder' => 'Enter the '.$key,
                        'value' => isset($element) ? $element->$key : null,
                        'col'   => isset($column_num) ? $column_num: null,
                        'disabled'  => isset($disabled) ? $disabled : null,
                    ])@endtextarea
                    @break
                @case($field == 'select')
                    @if ($key == 'status_id')
                        @select([
                            'name'  => $key,
                            'label' => isset($labels[$key]) ? $labels[$key] : null,
                            'elements'  => $ddl[$key],
                            'value' => isset($element) ? $element->$key : null,
                            'col'   => isset($column_num) ? $column_num: null,
                            'disabled'  => 1,
                        ])@endselect
                    @else
                        @select([
                            'name'  => $key,
                            'label' => isset($labels[$key]) ? $labels[$key] : null,
                            'elements'  => $ddl[$key],
                            'value' => isset($element) ? $element->$key : null,
                            'col'   => isset($column_num) ? $column_num: null,
                            'disabled'  =>  isset($disabled) ? $disabled : null,
                        ])@endselect
                    @endif
                    @break
                @case($field == 'select-dynamic')
                    @select([
                        'name'  => $key,
                        'label' => isset($labels[$key]) ? $labels[$key] : null,
                        'elements'  => $ddl[$key],
                        'value' => isset($element) ? $element->$key : null,
                        'col'   => isset($column_num) ? $column_num: null,
                        'disabled'  =>  isset($disabled) ? $disabled : null,
                    ])@endselect
                    @break
                @case($field == 'searcher')
                    @searcher([
                        'name'      => $key,
                        'elements'  => $ddl[$key],
                        'value'     => isset($element) ? $element->$key : null,
                        'col'       => isset($column_num) ? $column_num: null,
                        'disabled'  =>  isset($disabled) ? $disabled : null,
                    ])@endsearcher
                    @break
                @case($field == 'date')
                    @datefield([
                        'name'  => $key,
                        'label' => isset($labels[$key]) ? $labels[$key] : null,
                        'value' => isset($element) ? date('Y-m-d', strtotime($element->$key)) : null,
                        'col'   => isset($column_num) ? $column_num: null,
                        'disabled'  => isset($disabled) ? $disabled : null,
                    ])@enddatefield()
                @break
                @case($field == 'checkbox')
                    <div class="{{ isset($column_num) ? $column_num: null, }} mt-3">
                        @checkbox([
                            'name' => $key,
                            'label' => isset($labels[$key]) ? $labels[$key] : null,
                            'value' => isset($element) ? $element->$key : null,
                            'disabled'  => isset($disabled) ? $disabled : null,
                        ])@endcheckbox
                    </div>
                    @break
                @default
                    <div>{{ $field . '|' . $key . ' INPUT NOT SUPPORTED!' }}  </div>
            @endswitch
    @endforeach

</div>