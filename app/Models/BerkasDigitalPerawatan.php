<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasDigitalPerawatan extends Model
{
    use HasFactory;
    protected $table = 'berkas_digital_perawatan'; // Sesuaikan dengan nama tabel Anda

    public function regperiksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }
    public function masterberkasdigital()
    {
        return $this->belongsTo(MasterBerkasDigital::class, 'kode', 'kode');
    }

}
