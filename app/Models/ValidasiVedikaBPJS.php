<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidasiVedikaBPJS extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'validasi_vedika_bpjs';
    protected $primaryKey = 'id_validasi_vedika_bpjs';

    protected $fillable = [
        'no_rawat',
        'status_validasi_vedika_bpjs',
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
