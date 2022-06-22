@extends('layouts.app')
@section('dashboard') STATUS @endsection
@section('content')
<div class="card shadow">
    <div class="card-header">
        FILTERS
    </div>
    <div class="card-body">
        <form method="GET" action="{{route('statuses.index')}}" >
            @csrf
            <div class="form d-inline mb-3">
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
                        <td>@sortablelink('is_for_posting', 'FOR POSTING')</td>
                        <td>@sortablelink('is_cancelled', 'CANCELLED')</td>
                        <td>@sortablelink('is_posted', 'POSTED')</td>
                        <td>ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($statuses as $status)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ sprintf('%08d', $status->id) }}</td>
                            <td>{{ $status->code }}</td>
                            <td>{{ $status->name }}</td>
                            <td><input class="" type="checkbox" value="1" {{ ($status->is_for_posting??0) == 1 ? "checked":""}} disabled></td>
                            <td><input class="" type="checkbox" value="1" {{ ($status->is_cancelled??0) == 1 ? "checked":""}} disabled></td>
                            <td><input class="" type="checkbox" value="1" {{ ($status->is_posted??0) == 1 ? "checked":""}} disabled></td>
                            
                            <td>
                                <div class="form d-inline">
                                    <a href="{{ route('statuses.edit', ['status' => $status->id]) }}"
                                        class="btn btn-secondary action-btn">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                </div>
                                <form method="POST" class="d-inline"
                                        action="{{ route('statuses.destroy', ['status' => $status->id]) }} " class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" value="Delete!" class="btn btn-danger action-btn" onclick="return confirm('Are you sure you want to delete? This action is final')">
                                            <i class="fa-regular fa-trash-can "></i>
                                        </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>

            <div class="form d-inline">
                <a href="{{ route('statuses.create') }}"
                    class="btn btn-secondary mb-3 create-btn">
                    <i class="fa-regular fa-plus"></i> New Record
                </a>
            </div>
             {!! $statuses->appends(\Request::except('page'))->render() !!} 
        </div>
    </div>
@endsection