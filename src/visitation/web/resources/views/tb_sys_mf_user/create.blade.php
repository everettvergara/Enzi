@extends('layouts.app')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('dashboard')CREATE USER @endsection

@section('content')
<div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="{{route('users.store')}}" enctype="multipart/form-data">
                @csrf

                <div class="row mb-4">

                    @text([
                    'name' => 'name',
                    'placeholder' => 'Enter your name'
                    ])@endtext
                    
                    @uploader([
                        'name' => 'image'
                    ])@enduploader
                                    
                    @email([
                        'name' => 'email',
                        'placeholder' => 'johndoe@gmail.com'
                    ])@endemail

                    @password([
                        'name' => 'password'
                    ])@endpassword

                    @password([
                        'name' => 'confirm_password'
                    ])@endpassword

                    <div class="col-lg-4 col-md-6 col-sm-12 mt-3">
                        @checkbox([
                        'name' => 'is_admin',
                        ])@endcheckbox()
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12 mt-3">
                        @checkbox([
                            'name' => 'is_active',
                            'value' => 1
                        ])@endcheckbox()
                    </div>

                </div>

                <div class="row ">
                    <div class="col-lg-6 col-md-12">    {{--  User Access Type   --}}
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                USER ACCESS TYPE
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
                                    <tbody id="user_access_type_table">
                                    </tbody>
                                </table>
                                <div class="form d-inline">
                                    <a href="javascript:void(0)" class="btn btn-secondary addRow_uat create-btn"><i class="fa-regular fa-plus"></i> New Record</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">  
                        <div class="card shadow mb-4"> {{--  User Approval Type  --}}
                            <div class="card-header">
                                USER APPROVAL HIERARCHY TYPE
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
                                    <tbody id="user_approval_type_table">
                                    </tbody>
                                </table>
                                <div class="form d-inline">
                                    <a href="javascript:void(0)" class="btn btn-secondary addRow_uaht create-btn"><i class="fa-regular fa-plus"></i> New Record</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <button type="submit" class="btn btn-secondary mt-4 btn-user form-btn">
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
            '<th scope="row"></th>' +
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
                '<th scope="row"></th>'+
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