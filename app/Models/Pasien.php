<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';
    
    protected $fillable = [
        'no_rkm_medis', 'nm_pasien', 'no_peserta','jk', 'umur'
    ];
   
}
