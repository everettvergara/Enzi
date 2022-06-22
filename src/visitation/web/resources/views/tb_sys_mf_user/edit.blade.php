@extends('layouts.app')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('dashboard')
    UPDATE USER
@endsection
@section('content')
<div class="card shadow mb-4">
        
        <div class="card-body">
            <form method="POST" action="{{route('users.update', ['user'=> $user->id])}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-4 ">
                    <div class="col-lg-12 d-lg-none mt-4">
                        <img src="{{ asset('images/profiles/' . $user->image_path) }}" class="img-fluid img-thumbnail rounded mx-auto d-block shadow" style="width:150px; height:150px;">
                    </div>
                    <div class="row col-lg-10 col-md-12 mr-0">
                        @text([
                            'name' => 'id',
                            'value' => $user->id,
                            'disabled' => 1,
                        ])@endtext

                        @text([
                            'name' => 'name',
                            'value' => $user->name
                        ])@endtext

                        @uploader([
                            'name' => 'image'
                        ])@enduploader
                        
                        @email([
                            'name' => 'email',
                            'value' => $user->email
                        ])@endemail

                        <div class="mt-3 col-lg-4 col-md-6 col-sm-12">
                            @checkbox([
                            'name' => 'is_admin',
                            'value' => $user->is_admin
                            ])@endcheckbox()
                        </div>

                        <div class="mt-3 col-lg-4 col-md-6 col-sm-12">
                            @checkbox([
                                'name' => 'is_active',
                                'value' => $user->is_active
                            ])@endcheckbox()
                        </div>
                    </div>
                    <div class="col-lg-2 d-none d-lg-block mt-4 ">
                        <img src="{{ asset('images/profiles/' . $user->image_path) }}" class="img-fluid img-thumbnail rounded mx-auto d-block shadow" style="width:150px; height:150px;">
                    </div>
                </div>
                @can('route_users')
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                USER ACCESS TYPE
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead class="table-light-blue">
                                        <tr>
                                            <td>NO.</th>
                                            <td>ACCESS TYPE</th>
                                            <td>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody id="user_access_type_table">
                                        @foreach ($user_access_types as $key=>$user_access_type)
                                            <tr>
                                                <td scope="row">{{ ++$key }}</th>
                                                <input type="hidden" name="detail_user_access_type_id[]" id="detail_user_access_type_id" class="form-control" value="{{ $user_access_type->id }}" >
                                                <td>
                                                    <select class="form-select detail_access_type_id"  name="detail_access_type_id[]" id="detail_access_type_id">
                                                        @foreach ($detail_access_types_dd as $detail_access_type)
                                                            <option value="{{ $detail_access_type->id }}" {{ $detail_access_type->id == $user_access_type->access_type_id ? "selected":"" }}>{{ $detail_access_type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><a href="#" class="btn btn-danger remove action-btn"><i class="fa-regular fa-trash-can"></i></a>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="form d-inline">
                                    <a href="javascript:void(0)" class="btn btn-secondary addRow_uat create-btn"><i class="fa-regular fa-plus"></i> New Record</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                USER APPROVAL HIERARCHY TYPE
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead class="table-light-blue">
                                        <tr>
                                            <td scope="col">NO.</th>
                                            <td scope="col">APPROVAL TYPE</th>
                                            <td>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody id="user_approval_type_table">
                                        @foreach ($user_apr_types as $key=>$user_apr_type)
                                            <tr>
                                                <td scope="row">{{ ++$key }}</th>
                                                <input type="hidden" name="detail_user_approval_type_id[]" id="detail_user_approval_type_id" class="form-control" value="{{ $user_apr_type->id }}" >
                                                <td>
                                                    <select class="form-select detail_approval_type_id"  name="detail_approval_type_id[]" id="detail_approval_type_id">
                                                        @foreach ($detail_apr_type_dd as $detail_apr_type)
                                                            <option value="{{ $detail_apr_type->id }}" {{ $detail_apr_type->id == $user_apr_type->approval_type_id ? "selected":"" }}>{{ $detail_apr_type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><a href="#" class="btn btn-danger remove action-btn"><i class="fa-regular fa-trash-can"></i></a>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="form d-inline">
                                    <a href="javascript:void(0)" class="btn btn-secondary addRow_uaht create-btn"><i class="fa-regular fa-plus"></i> New Record</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @endcan
                    
                <button type="submit" class="btn btn-secondary mt-4 form-btn">
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
                    //========================================== User Access Type
$(document).on('click', '.addRow_uat', function() {
        addRow_uat();
});
    
function addRow_uat()          // ============================== ADDROW
{
    var tr = '<tr>' +
            '<td scope="row"></th>' +
                '<td>' +
                    '<select class="form-select detail_access_type_id"  name="detail_access_type_id[]" id="detail_access_type_id">' +
                        '@foreach ($detail_access_types_dd as $detail_access_type)' + 
                            '<option value="{{ $detail_access_type->id }}">{{ $detail_access_type->name }}</option>' +
                        '@endforeach' +
                    '</select>' +
                '</td>' +
                '<td><a href="#" class="btn btn-danger remove action-btn"><i class="fa-regular fa-trash-can"></i></a></td>' +
            '</tr>';
    $('#user_access_type_table').append(tr);
};
                            // =================================== User Approval Hierarchy Type
                            $(document).on('click', '.addRow_uaht', function() {
        addRow_uaht();
});
    
function addRow_uaht()          // ============================== ADDROW
{
    var tr = '<tr>'+
                '<td scope="row"></th>'+
                '<td>'+
                    '<select class="form-select detail_approval_type_id"  name="detail_approval_type_id[]" id="detail_approval_type_id">'+
                        '@foreach ($detail_apr_type_dd as $detail_apr_type)'+
                            '<option value="{{ $detail_apr_type->id }}">{{ $detail_apr_type->name }}</option>'+
                        '@endforeach'+
                    '</select>'+
                '</td>'+
                '<td><a href="#" class="btn btn-danger remove action-btn"><i class="fa-regular fa-trash-can"></i></a></td>'+
            '</tr>';
    $('#user_approval_type_table').append(tr);
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