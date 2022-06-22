@extends('layouts.app')
@section('dashboard')CREATE SAMPLE @endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{route('samples.store')}}">
            @csrf

            <div class="row">

                @datefield([
                    'name' => 'sample_date'
                ])@enddatefield

                @text([
                    'name'  => 'code',
                ])@endtext

                @text([
                    'name'  => 'name',
                ])@endtext

                @textarea([
                    'name' => 'remarks',
                    'placeholder' => 'Enter the remarks'
                ])@endtextarea

            </div>
        <button type="submit" class="btn btn-secondary mt-4 btn-user form-btn" name="status" value="save">
                Save
        </button>

        <button type="submit" class="btn btn-secondary mt-4 btn-user form-btn" name="status" value="post">
            Post
        </button>
        </form>
    </div>
    @errors
    @enderrors
</div>

@endsection