@extends('layouts.app')
@section('dashboard') MODULE GROUPS @endsection
@section('content')
<div class="card shadow">
    <div class="card-header">
        FILTERS
    </div>
    <div class="card-body">
        <form method="GET" action="{{route('mod-groups.index')}}" >
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
                        <td>@sortablelink('menu', 'MENU')</td>
                        <td>@sortablelink('ref_mod_name', 'REF MOD GROUP NAME')</td>
                        <td>@sortablelink('seq', 'SEQUENCE')</td>
                        <td>ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mod_groups as $mod_group)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{  sprintf('%08d', $mod_group->id ) }}</td>
                            <td>{{ $mod_group->code }}</td>
                            <td>{{ $mod_group->name }}</td>
                            <td>{{ $mod_group->menu }}</td>
                            <td>{{ $mod_group->ref_mod_name }}</td>
                            <td>{{ $mod_group->seq }}</td>
                            <td>
                                <div class="form d-inline">
                                    <a href="{{ route('mod-groups.edit', ['mod_group' => $mod_group->id]) }}"
                                        class="btn btn-secondary action-btn">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                </div>
                                <form method="POST" class="d-inline"
                                        action="{{ route('mod-groups.destroy', ['mod_group' => $mod_group->id]) }} " class="d-inline">
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
                <a href="{{ route('mod-groups.create') }}"
                    class="btn btn-secondary mb-3 create-btn">
                    <i class="fa-regular fa-plus"></i> New Record
                </a>
            </div>
             {!! $mod_groups->appends(\Request::except('page'))->render() !!} 
        </div>
    </div>
@endsection