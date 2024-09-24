<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidasiVedika extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'validasi_vedika';
    protected $primaryKey = 'id_validasi_vedika';

    protected $fillable = [
        'no_rawat',
        'status_validasi_vedika',
        'keterangan',
        'id_uservedika',
        'tanggal',
        'jam'
    ];

    public function regperiksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }
    
     public function uservedika()
    {
        return $this->belongsTo(UserVedika::class, 'id_uservedika', 'id_uservedika');
    }

}
