<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;
    protected $table = 'dokter';

    public function regperiksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'kd_dokter', 'kd_dokter');
    }
}
