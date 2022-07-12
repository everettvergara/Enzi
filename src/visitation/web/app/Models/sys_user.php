<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class sys_user extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'sys_user';

    protected $primaryKey = "user_id";

    protected $fillable = [
        'user_code',
        'email_address',
        'password',
        'first_name',
        'middle_name',
        'last_name',
        'super',
        'active',
        'last_login',
        'failed_attempts',
        'last_pass_changed',
        'email_address',
        'session',
        'login_status_id',
        'last_status_update',
        'user_level_id',
        'require_password_change'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];
}
