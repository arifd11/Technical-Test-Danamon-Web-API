<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 't_user';

    protected $fillable = [
        'username',
        'email',
        'name',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];
}
