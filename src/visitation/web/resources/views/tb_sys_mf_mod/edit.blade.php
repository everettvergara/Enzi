@extends('layouts.app')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('dashboard')UPDATE MODULE @endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{route('mods.update', ['mod'=>  $mod->id])}}">
            @method("PUT")
            @csrf
            <div class="row">
                @text([
                    'name' => 'id',
                    'value' => $mod->id,
                    'disabled' => 1,
                ])@endtext

                @text([
                    'name' => 'code',
                    'placeholder' => 'Enter the code',
                    'value' => $mod->code
                ])@endtext

                @text([
                'name' => 'name',
                'placeholder' => 'Enter the name',
                'value' => $mod->name
                ])@endtext

                @text([
                    'name' => 'menu',
                    'placeholder' => 'Enter the menu',
                    'value' => $mod->menu
                ])@endtext

                @text([
                    'name' => 'url',
                    'placeholder' => 'Enter the url',
                    'value' => $mod->url
                ])@endtext

                @select([
                    'name' => 'mod_group_id',
                    'label' => 'MODULE GROUP',
                    'elements' => $mod_groups_dd,
                    'value' => $mod->mod_group_id
                ])@endselect

                <div class="col-lg-4 col-md-6 col-sm-12 mt-3">
                    @checkbox([
                        'name' => 'is_active',
                        'value' =>  $mod->is_active
                    ])@endcheckbox
                </div>
            </div>
            {{--  Mod Access Type  --}}
            <div class="card shadow mt-4 mb-4">
                <div class="card-header">
                    MOD ACCESS TYPE
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="table-light-blue">
                            <tr>
                                <td>NO.</td>
                                <td>ACCESS TYPE</td>
                                <td>ACTIONS</td>
                            </tr>
                        </thead>
                        <tbody id="mod_access_type_table">
                            @foreach ($mod_access_types as $key=>$mod_access_type)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <input type="hidden" name="detail_mod_access_type_id[]" id="detail_mod_access_type_id" class="form-control" value="{{ $mod_access_type->id }}" >
                                    <td>
                                        <select class="form-select detail_access_type_id"  name="detail_access_type_id[]" id="detail_access_type_id">
                                            @foreach ($detail_access_types_dd as $detail_access_type)
                                                <option value="{{ $detail_access_type->id }}" {{ $detail_access_type->id == $mod_access_type->access_type_id ? "selected":"" }}>{{ $detail_access_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><a href="#" class="btn btn-danger remove action-btn"><i class="fa-regular fa-trash-can"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="form d-inline">
                        <a href="javascript:void(0)" class="btn btn-secondary addRow_mat create-btn"><i class="fa-regular fa-plus"></i> New Record</a>
                    </div>
                </div>
            </div>
            {{--  Mod Approver Type  --}}
            <div class="card shadow mt-4 mb-4">
                <div class="card-header">
                    MOD APPROVAL HIERARCHY TYPE
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="table-light-blue">
                            <tr>
                                <td>NO.</td>
                                <td>APPROVAL TYPE</td>
                                <td>ACTIONS</td>
                            </tr>
                        </thead>
                        <tbody id="mod_apr_type_table">
                            @foreach ($mod_apr_types as $key=>$mod_apr_type)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <input type="hidden" name="detail_mod_apr_type_id[]" id="detail_mod_apr_type_id" class="form-control" value="{{ $mod_apr_type->id }}" >
                                    <td>
                                        <select class="form-select detail_apr_type_id"  name="detail_apr_type_id[]" id="detail_apr_type_id">
                                            @foreach ($detail_apr_type_dd as $detail_apr_type)
                                                <option value="{{ $detail_apr_type->id }}" {{ $detail_apr_type->id == $mod_apr_type->approval_type_id ? "selected":"" }}>{{ $detail_apr_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><a href="#" class="btn btn-danger remove action-btn"><i class="fa-regular fa-trash-can"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="form d-inline">
                        <a href="javascript:void(0)" class="btn btn-secondary addRow_aht create-btn"><i class="fa-regular fa-plus"></i> New Record</a>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-secondary btn-user form-btn">
                Submit
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $(document).on('click', '.addRow_mat', function() {
    addRow_mat();
});


function addRow_mat()          // ============================== ADDROW
{
    var tr = '<tr>' +
            '<td></td>' +
                '<td>' +
                    '<select class="form-select detail_access_type_id"  name="detail_access_type_id[]" id="detail_access_type_id">' +
                        '@foreach ($detail_access_types_dd as $detail_access_type)' + 
                            '<option value="{{ $detail_access_type->id }}">{{ $detail_access_type->name }}</option>' +
                        '@endforeach' +
                    '</select>' +
                '</td>' +
                '<td><a href="#" class="btn btn-danger remove action-btn"><i class="fa-regular fa-trash-can"></i></a></td>' +
            '</tr>';
    $('#mod_access_type_table').append(tr);
};

$(document).on('click', '.addRow_aht', function() {
    addRow_aht();
});

function addRow_aht()          // ============================== ADDROW
{
    var tr = '<tr>' +
            '<td></td>' +
                '<td>' +
                    '<select class="form-select detail_apr_type_id"  name="detail_apr_type_id[]" id="detail_apr_type_id">' +
                        '@foreach ($detail_apr_type_dd as $detail_apr_type)' + 
                            '<option value="{{ $detail_apr_type->id }}">{{ $detail_apr_type->name }}</option>' +
                        '@endforeach' +
                    '</select>' +
                '</td>' +
                '<td><a href="#" class="btn btn-danger remove action-btn"><i class="fa-regular fa-trash-can"></i></a></td>' +
            '</tr>';
    $('#mod_apr_type_table').append(tr);
};
$(document).on('click', '.remove', function() {         // =========================================== Delete Detail ROW
var last=$('tbody tr').length;
// if(last==1){
//     alert("Please enter atleast 1 row.");
// }
// else{
//         $(this).parent().parent().remove();
// }
$(this).parent().parent().remove();
});
</script>
@endsection