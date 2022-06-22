@extends('layouts.app')

@section('dashboard')UPDATE STATUS @endsection
@section('content')
<div class="card shadow mb-4">
    
    <div class="card-body">
        <form method="POST" action="{{route('statuses.update', ['status'=>  $status->id])}}">
            @method("PUT")
            @csrf
            <div class="row">
                @text([
                        'name' => 'id',
                        'value' => $status->id,
                        'disabled' => 1,
                ])@endtext

                @text([
                    'name' => 'code',
                    'placeholder' => 'Enter the code',
                    'value' => $status->code
                ])@endtext

                @text([
                    'name' => 'name',
                    'placeholder' => 'Enter the name',
                    'value' => $status->name
                ])@endtext

                <div class="col-lg-4 col-md-6 col-sm-12 mt-3">
                    @checkbox([
                        'name' => 'is_for_posting',
                        'value' => $status->is_for_posting
                    ])@endcheckbox

                    @checkbox([
                        'name' => 'is_cancelled',
                        'value' => $status->is_cancelled
                    ])@endcheckbox

                    @checkbox([
                        'name' => 'is_posted',
                        'value' => $status->is_posted
                    ])@endcheckbox
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mt-3">
                    @checkbox([
                        'name' => 'is_active',
                        'value' => $status->is_active
                    ])@endcheckbox
                </div>
            </div>
            <button type="submit" class="btn btn-secondary mt-4 form-btn">
                Submit
            </button>
        </form>
    </div>
    @errors
    @enderrors
</div>

@endsection