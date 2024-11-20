<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'photo',
        'courses_sub',
        'courses_end',
        'roadmaps',
        'chat_allowed',
        'category',
        'projects'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
