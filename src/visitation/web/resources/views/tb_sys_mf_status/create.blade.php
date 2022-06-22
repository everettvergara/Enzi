@extends('layouts.app')
@section('dashboard')CREATE STATUS @endsection
@section('content')
<div class="card shadow mb-4">

    <div class="card-body">
        <form method="POST" action="{{route('statuses.store')}}">
            @csrf
            <div class="row">
                    @text([
                        'name' => 'code',
                        'placeholder' => 'Enter the code'
                    ])@endtext
    
                    @text([
                        'name' => 'name',
                        'placeholder' => 'Enter the name'
                    ])@endtext
    
                <div class="col-lg-4 col-md-6 col-sm-12 mt-3">
                    @checkbox([
                        'name' => 'is_for_posting',
                    ])@endcheckbox()
    
                    @checkbox([
                        'name' => 'is_cancelled',
                    ])@endcheckbox()
    
                    @checkbox([
                        'name' => 'is_posted',
                    ])@endcheckbox()
                </div>   
                <div class="col-lg-4 col-md-6 col-sm-12 mt-3">
                    @checkbox([
                        'name' => 'is_active',
                        'value' => 1
                    ])@endcheckbox()
                </div>
            </div>

            <button type="submit" class="btn btn-secondary mt-4 btn-user form-btn">
                Submit
            </button>
        </form>
    </div>
    @errors
    @enderrors
</div>

@endsection