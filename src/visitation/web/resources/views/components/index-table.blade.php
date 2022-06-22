<table class="table table-striped">
    <thead class="table-light-blue">
        <tr>
            <td>NO.</td>
            @foreach ($index_columns as $key => $column)
                <td>@sortablelink($column['name'], $column['label'])</td>
            @endforeach
            <td>ACTIONS</td>
        </tr>
    </thead>
    <tbody>
        @forelse ($elements as $element)
            <tr>
                <td>{{ $loop->iteration }}</td>
                @foreach ($index_columns as $key => $column)
                    @switch(true)
                        @case(false)
                        @break
                        @case($column['name'] == 'id')
                            <td><a href="{{ route($route.'.show', [$route_param => $element->id]) }}">{{ sprintf('%08d', $element[$column['name']]) }}</a></td>
                            @break
                        @case(strstr($column['name'], 'is_'))
                            <td><input type="checkbox" value="{{ $element[$column['name']] }}" {{ ($element[$column['name']]??0) == 1 ? "checked":""}} disabled></td>
                            @break
                        @default
                            <td>{{ $element[$column['name']] }}</td>
                    @endswitch
                @endforeach
                <td>
                    <div class="form d-inline">
                        <a href="{{ route($route.'.edit', [$route_param => $element->id]) }}"
                            class="btn btn-secondary action-btn">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </div>
                    <form method="POST" class="d-inline" action="{{ route($route.'.destroy', [$route_param => $element->id]) }} " class="d-inline">
                            @csrf
                            @method('DELETE')          
                            <button type="submit" value="Delete!" class="btn btn-danger action-btn" onclick="return confirm('Are you sure you want to delete? This action is final')">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                    </form>
                </td>
            </tr>
        @empty
        @endforelse
    </tbody>

</table>

    {!! $elements->appends(\Request::except('page'))->render() !!} 

    <div class="form d-inline">
        <a href="{{ route($route.'.create') }}"
            class="btn btn-secondary mb-3 create-btn">
            <i class="fa-regular fa-plus"></i> New Record
        </a>
    </div>
