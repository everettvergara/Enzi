@extends('layouts.app')
@section('dashboard')UPDATE APPROVAL HIERARCHY TYPE @endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{route('apr-types.update', ['apr_type'=>  $apr_type->id])}}">
            @method("PUT")
            @csrf
            <div class="row">
                @text([
                    'name' => 'id',
                    'value' => $apr_type->id,
                    'disabled' => 1,
                ])@endtext

                @text([
                    'name' => 'code',
                    'placeholder' => 'Enter the code',
                    'value' => $apr_type->code
                ])@endtext

                @text([
                    'name' => 'name',
                    'placeholder' => 'Enter the name',
                    'value' => $apr_type->name
                ])@endtext

                @textarea([
                    'name' => 'description',
                    'placeholder' => 'Enter the description',
                    'value' => $apr_type->description
                ])@endtextarea

                <div class="col-lg-4 col-md-6 col-sm-12 mt-3">
                    @checkbox([
                        'name' => 'is_active',
                        'value' => $apr_type->is_active
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