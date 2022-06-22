@extends('layouts.app')

@section('dashboard')UPDATE ACCESS TYPE @endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{route('access-types.update', ['access_type'=>  $access_type->id])}}">
            @method("PUT")
            @csrf
            <div class="row">
                @text([
                    'name' => 'id',
                    'value' => $access_type->id,
                    'disabled' => 1,
                ])@endtext

                @text([
                'name' => 'name',
                'placeholder' => 'Enter the name',
                'value' => $access_type->name
                ])@endtext

                @text([
                    'name' => 'code',
                    'placeholder' => 'Enter the code',
                    'value' => $access_type->code
                ])@endtext

                <div class="col-lg-4 col-md-6 col-sm-12 mt-3">
                    @checkbox([
                        'name' => 'is_active',
                        'value' => $access_type->is_active
                    ])@endcheckbox()
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