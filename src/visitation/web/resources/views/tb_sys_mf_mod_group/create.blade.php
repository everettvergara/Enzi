@extends('layouts.app')

@section('dashboard')CREATE MODULE GROUP @endsection
@section('content')
<div class="card shadow mb-4">
    
    <div class="card-body">
        <form method="POST" action="{{route('mod-groups.store')}}">
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

                @text([
                    'name' => 'menu',
                    'placeholder' => 'Enter the name'
                ])@endtext

                @select([
                    'name' => 'ref_mod_id',
                    'label' => 'Reference Module Group',
                    'elements' => $mod_groups_dd
                ])@endselect

                @text([
                    'name' => 'seq',
                    'placeholder' => 'Enter the Sequence Number'
                ])@endtext

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
</div>

@endsection