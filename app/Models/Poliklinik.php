<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poliklinik extends Model
{
    protected $table = 'poliklinik';
    use HasFactory;

    protected $fillable = [
        'kd_poli', 'nm_poli', 'status'
    ];
    
}
