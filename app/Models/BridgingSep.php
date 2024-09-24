<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BridgingSep extends Model
{
    use HasFactory;
    
    protected $table = 'bridging_sep';

    protected $fillable = [
        'no_sep', 'no_rawat', 'tglsep'
    ];
    
    public function regperiksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }
}
