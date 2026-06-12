<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'address',
        'role', // 'admin' atau 'customer'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi: Satu user (customer) bisa punya banyak pesanan
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    // Fungsi pembantu untuk cek role (bisa dipakai di middleware/blade)
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}