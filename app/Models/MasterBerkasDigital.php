<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBerkasDigital extends Model
{
    use HasFactory;
    protected $table = 'master_berkas_digital'; // Sesuaikan dengan nama tabel Anda
    protected $fillable = [
        'kode',
        'nama',
    ];
    
}
