<?php

namespace App\Models;
use App\Models\KamarInap;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';

    protected $fillable = [
        'kd_kamar',
        'kd_bangsal',
        'status',
        'kelas'
    ];
    
    public function bangsal()
    {
        return $this->belongsTo(Bangsal::class, 'kd_bangsal', 'kd_bangsal');
    }
    public function kamarInap()
    {
        return $this->belongsTo(KamarInap::class, 'kd_kamar', 'kd_kamar');
    }
}

