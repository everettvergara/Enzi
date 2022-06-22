@extends('layouts.app')
@section('dashboard')EDIT {{ strtoupper($user->name) }}'S PASSWORD @endsection
@section('content')
<div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="{{route('users.update-pw', ['user'=> $user->id])}}">
                @csrf
                @method('PUT')

                <div class="row">             
                    @password([
                        'name' => 'new_password'
                    ])@endpassword

                    @password([
                        'name' => 'conf_new_password',
                        'label' => 'CONFIRM NEW PASSWORD'
                    ])@endpassword

                </div>
                <button type="submit" class="btn btn-secondary mt-4 form-btn">
                    Submit
                </button>
                   
            </form>
            @errors()
            @enderrors
        </div>
        
</div>
@endsection