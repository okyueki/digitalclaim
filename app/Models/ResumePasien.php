<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumePasien extends Model
{
    use HasFactory;
    protected $table = 'resume_pasien';
    protected $fillabel = ['no_rawat', 'kd_dokter', 'keluhan_utama', 'jalannya_penyakit', 'pemeriksaan_penunjang', 'hasil_laborat', 'diagnosa_utama', 'kd_diagnosa_utama', 'diagnosa_sekunder', 'kd_diagnosa_sekunder', 'diagnosa_sekunder2', 'kd_diagnosa_sekunder2', 'diagnosa_sekunder3', 'kd_diagnosa_sekunder3', 'diagnosa_sekunder4', 'kd_diagnosa_sekunder4', 'prosedur_utama', 'kd_prosedur_utama', 'prosedur_sekunder', 'kd_prosedur_sekunder', 'prosedur_sekunder2', 'kd_prosedur_sekunder2', 'prosedur_sekunder3', 'kd_prosedur_sekunder3', 'kondisi_pulang', 'obat_pulang'];
}
