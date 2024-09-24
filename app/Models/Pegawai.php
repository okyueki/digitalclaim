<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';
    
    protected $fillabel = ['id', 'nik', 'nama', 'jk', 'jbtn', 'jnj_jabatan', 'kode_kelompok', 'kode_resiko', 'kode_emergency', 'departemen', 'bidang', 'stts_wp', 'stts_kerja', 'npwp', 'pendidikan', 'gapok', 'tmp_lahir', 'tgl_lahir', 'alamat', 'kota', 'mulai_kerja', 'ms_kerja', 'indexins', 'bpd', 'rekening', 'stts_aktif', 'wajibmasuk', 'pengurang', 'indek', 'mulai_kontrak', 'cuti_diambil', 'dankes', 'photo', 'no_ktp'];
    // Definisi relasi dengan model Dokter
    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'kd_dokter', 'nik');
    }
}
