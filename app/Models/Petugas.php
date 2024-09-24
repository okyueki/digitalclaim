<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;
    protected $table = 'petugas';

    protected $fillable = [
        'nip', 'nama', 'jk', 'tmp_lahir', 'tgl_lahir', 'gol_darah', 'agama', 'stts_nikah', 'alamat', 'kd_jbtn', 'no_telp', 'status',
        // tambahkan kolom lainnya sesuai dengan kebutuhan
    ];
}
