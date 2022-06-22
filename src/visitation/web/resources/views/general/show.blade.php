@extends('layouts.app')
@section('title'){{ $title }} @endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        @field([
            'element'       => $element,
            'fields'        => $fields,
            'ddl'           => $ddl,
            'disabled'      => $disabled,
            'column_num'    => $column_num,
        ])
        @endfield
        <a href="{{route($route.'.edit', [$route_param =>  $element->id])}}" class="btn btn-secondary mt-3 create-btn"><i class="fa-solid fa-pencil"></i></a>
    </div>
    {{--  @errors
    @enderrors  --}}
</div>

@endsection