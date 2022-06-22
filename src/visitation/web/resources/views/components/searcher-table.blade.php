@forelse ($elements as $key_2 => $element)
    <tr>
        <td>{{ $loop->iteration }}</td>
        @foreach ($columns as $key_3 => $column)
            @switch(true)
                @case($column == 'id')
                    <td>
                        <a href="#" class="{{ $key }}Modal_result" data-id="{{ $element[$column] }}" data-name="{{ $element['name'] }}">
                            {{ sprintf('%08d', $element[$column]) }}
                        </a>
                    </td>
                    @break
                @case(strstr($column, 'is_'))
                    <td><input type="checkbox" value="{{ $element[$column] }}" {{ ($element[$column]??0) == 1 ? "checked":""}} disabled></td>
                    @break
                @default
                    <td>{{ $element[$column] }}</td>
            @endswitch
        @endforeach
    </tr>
@empty
@endforelse