@extends('layouts.app')
@section('dashboard')UPDATE CONFIGURATION @endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{route('configs.update', ['config'=>  $config->id])}}">
            @method("PUT")
            @csrf
            <div class="row">
                    @text([
                        'name' => 'id',
                        'value' => $config->id,
                        'disabled' => 1,
                    ])@endtext

                    @text([
                        'name' => 'code',
                        'placeholder' => 'Enter the code',
                        'value' => $config->code
                    ])@endtext

                    @text([
                        'name' => 'name',
                        'placeholder' => 'Enter the name',
                        'value' => $config->name
                    ])@endtext

                    @textarea([
                        'name' => 'value',
                        'placeholder' => 'Enter the value',
                        'value' => $config->value
                    ])@endtextarea

                    @textarea([
                        'name' => 'description',
                        'placeholder' => 'Enter the description',
                        'value' => $config->description
                    ])@endtextarea

                    <div class="col-lg-4 col-md-6 col-sm-12 mt-3">    
                        @checkbox([
                            'name' => 'is_active',
                            'value' => $config->is_active
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