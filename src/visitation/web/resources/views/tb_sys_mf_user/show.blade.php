@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
        <div class="card-header">
            User Profile
        </div>
        <div class="card-body">

                <div class="row">
                    @text([
                        'name' => 'name',
                        'value' => $user->name,
                        'disabled' => '1'
                    ])@endtext
                    
                    @email([
                        'name' => 'email',
                        'value' => $user->email,
                        'disabled' => '1'
                    ])@endemail

                    <div class="col-lg-4 col-md-6 col-sm-12 mt-3">
                        @checkbox([
                            'name' => 'is_admin',
                            'value' => $user->is_admin,
                            'disabled' => '1'
                        ])@endcheckbox()
    
                        @checkbox([
                            'name' => 'is_active',
                            'value' => $user->is_active,
                            'disabled' => '1'
                        ])@endcheckbox()
                    </div>

                </div>
                <div class="card shadow mt-4 mb-4">
                    <div class="card-header">
                        User Access Type
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Access Type</th>
                                </tr>
                            </thead>
                            <tbody id="user_access_type_table">
                                @foreach ($user_access_types as $key=>$user_access_type)
                                    <tr>
                                        <th scope="row">{{ ++$key }}</th>
                                        <input type="hidden" name="detail_user_access_type_id[]" id="detail_user_access_type_id" class="form-control" value="{{ $user_access_type->id }}" >
                                        <td>
                                            <select class="form-select detail_access_type_id"  name="detail_access_type_id[]" id="detail_access_type_id" disabled>
                                                @foreach ($detail_access_types_dd as $detail_access_type)
                                                    <option value="{{ $detail_access_type->id }}" {{ $detail_access_type->id == $user_access_type->access_type_id ? "selected":"" }}>{{ $detail_access_type->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card shadow mt-4 mb-4">
                    <div class="card-header">
                        User Approval Hierarchy Type
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Access Type</th>
                                </tr>
                            </thead>
                            <tbody id="user_approval_type_table">
                                @foreach ($user_apr_types as $key=>$user_apr_type)
                                    <tr>
                                        <th scope="row">{{ ++$key }}</th>
                                        <input type="hidden" name="detail_user_approval_type_id[]" id="detail_user_approval_type_id" class="form-control" value="{{ $user_apr_type->id }}" disabled>
                                        <td>
                                            <select class="form-select detail_approval_type_id"  name="detail_approval_type_id[]" id="detail_approval_type_id">
                                                @foreach ($detail_apr_type_dd as $detail_apr_type)
                                                    <option value="{{ $detail_apr_type->id }}" {{ $detail_apr_type->id == $user_apr_type->approval_type_id ? "selected":"" }}>{{ $detail_apr_type->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @errors()
            @enderrors
        </div>
</div>
@endsection