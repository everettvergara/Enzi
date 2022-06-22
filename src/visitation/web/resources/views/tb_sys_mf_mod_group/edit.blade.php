@extends('layouts.app')

@section('dashboard')UPDATE MODULE GROUP @endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{route('mod-groups.update', ['mod_group'=>  $mod_group->id])}}">
            @method("PUT")
            @csrf
            <div class="row">
                @text([
                        'name' => 'id',
                        'value' => $mod_group->id,
                        'disabled' => 1,
                ])@endtext

                @text([
                    'name' => 'code',
                    'placeholder' => 'Enter the code',
                    'value' => $mod_group->code
                ])@endtext

                @text([
                    'name' => 'name',
                    'placeholder' => 'Enter the name',
                    'value' => $mod_group->name
                ])@endtext

                @text([
                    'name' => 'menu',
                    'placeholder' => 'Enter the menu',
                    'value' => $mod_group->menu
                ])@endtext

        
                @select([
                    'name' => 'ref_mod_id',
                    'label' => 'Reference Module Group',
                    'elements' => $mod_groups_dd,
                    'value' => $mod_group->ref_mod_id
                ])

                @endselect

                @text([
                    'name' => 'seq',
                    'placeholder' => 'Enter the code',
                    'value' => $mod_group->seq
                ])@endtext

                <div class="col-lg-4 col-md-6 col-sm-12 mt-3">
                    @checkbox([
                        'name' => 'is_active',
                        'value' => $mod_group->is_active
                    ])@endcheckbox()
                </div>

            </div>
            
            <button type="submit" class="btn btn-secondary mt-4 form-btn">
                Submit
            </button>
        </form>
    </div>
</div>

@endsection