<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class AdminUser extends Authenticatable
{

    use HasFactory, Notifiable;
 // Pastikan sesuai dengan nama tabel di database
    protected $table = 'admin_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}


