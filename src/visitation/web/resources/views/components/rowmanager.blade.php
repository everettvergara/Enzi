<div class="card mt-3 mb-3">
    <div class="form d-inline">
        <a href="{{ route($route_create) }}"
            class="btn btn-primary mt-3 mb-3">
            Create
        </a>
    </div>
    <div class="card-header"> 
        {{ $card_header }}
    </div>
    <div class ="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    @forelse ($column_headers as $column)
                        <th scope="col">{{ $column }}</th>
                    @empty    
                    @endforelse
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($elements as $element)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        @forelse ($column_items as $column)
                            <td>{{ $element[$column] }}</td>
                        @empty
                        @endforelse
                        <td>
                            <div class="form d-inline">
                                <a href="{{ route($route_edit, [$param => $element['id']]) }}"
                                    class="btn btn-primary">
                                    Edit
                                </a>
                            </div>
                        
                            <form method="POST" class="d-inline"
                            action="{{ route($route_delete, [$param => $element['id']]) }} " class="d-inline">
                            @csrf
                            @method('DELETE')
                                <input type="submit" value="Delete!" class="btn btn-danger delete" onclick="return confirm('Are you sure you want to delete? This action is final')"/>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- {!! $customers->links() !!} --}}{{ $paginate ?? '' }}
    </div>
    {{--  --}}
    <div class="form d-inline">
        <a href="{{ route($route_create) }}"
            class="btn btn-primary mb-3">
            Create
        </a>
    </div>
</div>