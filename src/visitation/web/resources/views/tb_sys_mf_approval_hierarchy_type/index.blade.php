@extends('layouts.app')
@section('dashboard')APPROVAL HIERARCHY TYPES @endsection
@section('content')
<div class="card shadow">
    <div class="card-header">
        FILTERS
    </div>
    <div class="card-body">
        <form method="GET" action="{{route('apr-types.index')}}" >
            @csrf
            <div class="form d-inline">
                @text([
                    'name' => 'name',
                    'placeholder' => 'Enter the Name',
                    'col'   => 'col-lg-4 col-md-6 col-sm-12 px-0',
                ])@endtext
                <button type="submit" class="btn btn-secondary form-btn mt-3"><i class="far fa-search" style="font-weight: 900"></i> Search</button>
            </div>
        </form>
    </div>
</div>
<div class="card shadow mt-3 mb-3">
        <div class ="card-body">
            <table class="table table-striped">
                <thead class="table-light-blue">
                    <tr>
                        <td>NO.</td>
                        <td>@sortablelink('id', 'ID')</td>
                        <td>@sortablelink('code', 'CODE')</td>
                        <td>@sortablelink('name', 'NAME')</td>
                        <td>@sortablelink('description', 'DESCRIPTION')</td>
                        <td>ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($apr_types as $apr_type)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ sprintf('%08d', $apr_type->id ) }}</td>
                            <td>{{ $apr_type->code }}</td>
                            <td>{{ $apr_type->name }}</td>
                            <td>{{ $apr_type->description }}</td>
                            <td>
                                <div class="form d-inline">
                                    <a href="{{ route('apr-types.edit', ['apr_type' => $apr_type->id]) }}"
                                        class="btn btn-secondary action-btn">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                </div>
                                <form method="POST" class="d-inline"
                                        action="{{ route('apr-types.destroy', ['apr_type' => $apr_type->id]) }} " class="d-inline">
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

            <div class="form d-inline">
                <a href="{{ route('apr-types.create') }}"
                    class="btn btn-secondary mb-3 create-btn">
                    <i class="fa-regular fa-plus"></i> New Record
                </a>
            </div>
             {!! $apr_types->appends(\Request::except('page'))->render() !!} 
        </div>
    </div>
@endsection