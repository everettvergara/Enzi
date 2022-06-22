@extends('layouts.app')
@section('dashboard') USERS @endsection
@section('content')
<div class="card shadow">
    <div class="card-header">
        FILTERS
    </div>
    <div class="card-body">
        <form method="GET" action="{{route('users.index')}}" >
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
                    <td>@sortablelink('name', 'NAME')</td>
                    <td>@sortablelink('email', 'EMAIL')</td>
                    <td>ACTIONS</td>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ sprintf('%08d', $user->id ) }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @can('update', $user)
                                <div class="form d-inline">
                                    <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-secondary action-btn">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                </div>
                            @endcan
                            @can('update', $user)
                                <div class="form d-inline">
                                    <a href="{{ route('users.edit-pw', ['user' => $user->id]) }}" class="btn btn-secondary action-btn">
                                        <i class="fa-solid fa-key"></i>
                                    </a>
                                </div>
                            @endcan

                            @can('delete', $user)
                                <form method="POST" class="form d-inline "
                                    action="{{ route('users.destroy', ['user' => $user->id]) }} " class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" value="Delete!" class="btn btn-danger action-btn" onclick="return confirm('Are you sure you want to delete? This action is final')">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>

        <div class="form d-inline">
            <a href="{{ route('users.create') }}"
                class="btn btn-secondary mb-3 create-btn">
                <i class="fa-regular fa-plus"></i> New Record
            </a>
        </div>
         {!! $users->appends(\Request::except('page'))->render() !!} 
    </div>
</div>
@endsection