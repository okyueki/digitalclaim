<?php

namespace App\Models;

use App\Models\Poliklinik;
use App\Models\Dokter;
use App\Models\Penjab;
use App\Models\KamarInap;
use App\Models\PemeriksaanRalan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegPeriksa extends Model
{
    protected $table = 'reg_periksa'; // Sesuaikan dengan nama tabel Anda
    // Tambahan properti lainnya jika diperlukan
    // Definisikan relasi dengan model Dokter
    protected $fillable = ['no_reg','no_rawat','tgl_registrasi','jam_reg','kd_dokter','no_rkm_medis','status_lanjut','umurdaftar','sttsumur','p_jawab','almt_pj','hubunganpj','biaya_reg','stts_daftar'];
    
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }
    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class, 'kd_poli', 'kd_poli');
    }
    public function penjab()
    {
        return $this->belongsTo(Penjab::class, 'kd_pj', 'kd_pj');
    }
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'no_rkm_medis', 'no_rkm_medis');
    }
    public function kamarinap()
    {
        return $this->belongsTo(KamarInap::class, 'no_rawat', 'no_rawat');
    }
    public function berkasdigitalperawatan()
    {
    return $this->hasMany(BerkasDigitalPerawatan::class, 'no_rawat', 'no_rawat');
    }
    public function diagnosapasien()
    {
        return $this->hasMany(DiagnosaPasien::class, 'no_rawat', 'no_rawat');
    }
    public function bridgingsep()
    {
        return $this->belongsTo(BridgingSep::class, 'no_rawat', 'no_rawat');
    }
    public function validasivedika()
    {
    return $this->hasMany(ValidasiVedika::class, 'no_rawat', 'no_rawat');
    }
    public function pemeriksaanRalan()
    {
        return $this->hasMany(PemeriksaanRalan::class, 'no_rawat', 'no_rawat');
    }
    public function prosedurPasien()
    {
        return $this->hasMany(ProsedurPasien::class, 'no_rawat', 'no_rawat');
    }
    public function validasivedikabpjs()
    {
        return $this->hasMany(ValidasiVedikaBPJS::class, 'no_rawat', 'no_rawat');
    }
}
