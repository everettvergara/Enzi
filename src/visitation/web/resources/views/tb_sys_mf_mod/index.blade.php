@extends('layouts.app')
@section('dashboard')MODS @endsection
@section('content')
<div class="card shadow">
    <div class="card-header">
        FILTERS
    </div>
    <div class="card-body">
        <form method="GET" action="{{route('mods.index')}}" >
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
                        <td>@sortablelink('mod_group_name', 'MODULE GROUP')</td>
                        <td>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mods as $mod)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ sprintf('%08d', $mod->id ) }}</td>
                            <td>{{ $mod->code }}</td>
                            <td>{{ $mod->name }}</td>
                            <td>{{ $mod->menu }}</td>
                            <td>{{ $mod->mod_group_name }}</td>
                            <td>
                                <div class="form d-inline">
                                    <a href="{{ route('mods.edit', ['mod' => $mod->id]) }}"
                                        class="btn btn-secondary action-btn">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                </div>
                                <form method="POST" class="d-inline"
                                        action="{{ route('mods.destroy', ['mod' => $mod->id]) }} " class="d-inline">
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
                <a href="{{ route('mods.create') }}"
                    class="btn btn-secondary mb-3 create-btn">
                    <i class="fa-regular fa-plus"></i> New Record
                </a>
            </div>
             {!! $mods->appends(\Request::except('page'))->render() !!} 
        </div>
    </div>
@endsection