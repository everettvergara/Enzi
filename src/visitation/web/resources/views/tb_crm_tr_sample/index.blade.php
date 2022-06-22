@extends('layouts.app')
@section('dashboard') SAMPLES @endsection
@section('content')
<div class="card mt-3 mb-3">
        <div class ="card-body">
            <table class="table table-striped">
                <div class="form d-inline">
                    <a href="{{ route('samples.create') }}"
                    class="btn btn-secondary mb-3 create-btn">
                    <i class="fa-regular fa-plus"></i> New Record
                    </a>
                </div>
                <thead class="table-light-blue">
                    <tr>
                        <td>NO.</td>
                        <td>@sortablelink('id', 'ID')</td>
                        <td>@sortablelink('sample_date', 'SAMPLE DATE')</td>
                        <td>@sortablelink('remarks', 'REMARKS')</td>
                        <td>@sortablelink('status_name', 'STATUS')</td>
                        <td>ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($samples as $sample)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="{{ route('samples.show', ['sample' => $sample->id]) }}">{{  sprintf('%08d', $sample->id ) }}</a></td>
                            <td>{{ date('Y-m-d', strtotime($sample->sample_date)) }}</td>
                            <td>{{ $sample->remarks }}</td>
                            <td>{{ $sample->status_name }}</td>
                            <td>
                                <div class="form d-inline">
                                    <a href="{{ route('samples.edit', ['sample' => $sample->id]) }}"
                                        class="btn btn-secondary action-btn">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                </div>
                                <form method="POST" class="d-inline"
                                        action="{{ route('samples.destroy', ['sample' => $sample->id]) }} " class="d-inline">
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
                <a href="{{ route('samples.create') }}"
                    class="btn btn-secondary mb-3 create-btn">
                    <i class="fa-regular fa-plus"></i> New Record
                </a>
            </div>
            {!! $samples->appends(\Request::except('page'))->render() !!}
        </div>
    </div>
@endsection