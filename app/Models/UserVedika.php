<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class UserVedika extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nonaktifkan timestamps jika tidak ada created_at dan updated_at
    public $timestamps = false;

    // Tentukan nama tabel jika berbeda dari konvensi Laravel
    protected $table = 'uservedika'; 
    
    // Tentukan primary key jika tidak menggunakan id (default)
    protected $primaryKey = 'id_uservedika';

    // Tentukan tipe primary key jika menggunakan tipe selain integer
    protected $keyType = 'int';

    // Tentukan kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'nama', 'username', 'password', 'level'
    ];

    // Tentukan kolom yang harus disembunyikan dari array/model serialization
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Atur agar tidak ada auto-increment
    public $incrementing = true;
}