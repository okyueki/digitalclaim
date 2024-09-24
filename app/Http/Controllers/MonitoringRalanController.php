<?php

namespace App\Http\Controllers;

use App\Models\RegPeriksa;
use App\Models\Poliklinik;
use App\Models\Dokter;
use App\Models\PemeriksaanRalan;
use App\Models\AturanPakai;
use App\Models\DetailPemberianObat;
use App\Models\DetailPeriksaLab;
use App\Models\PeriksaRadiologi;
use App\Models\JnsPerawatanRadiologi;
use App\Models\HasilRadiologi;
use App\Models\RawatJlDr;
use App\Models\RawatJlDrpr;
use App\Models\RawatJlPr;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MonitoringRalanController extends Controller
{
public function index(Request $request)
{
    $query = RegPeriksa::query();

    // Filter tanggal
    if (!$request->filled('start_date') && !$request->filled('end_date')) {
        $today = Carbon::today()->format('Y-m-d');
        $query->whereDate('tgl_registrasi', $today);
    } elseif ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('tgl_registrasi', [$request->start_date, $request->end_date]);
    }

    // Filter berdasarkan poliklinik
    if ($request->filled('poliklinik')) {
        $query->where('kd_poli', $request->poliklinik);
    }
    // Filter berdasarkan dokter
    if ($request->filled('dokter')) {
        $query->where('kd_dokter', $request->dokter);
    }
    // Filter berdasarkan status
    $allowedStatuses = ['Sudah', 'Dirawat'];
    $query->whereIn('stts', $allowedStatuses);

    // Hitung total pasien
    $totalPatients = $query->count();

    // Penghitungan TTV dan Assesmen lengkap/tidak lengkap untuk seluruh data
    $allPatients = $query->with('pemeriksaanRalan')->get();

    $ttvLengkap = $ttvTidakLengkap = 0;
    $assesmenLengkap = $assesmenTidakLengkap = 0;
    $tensiLengkap = $tensiTidakLengkap = 0; // Corrected initialization for $tensiTidakLengkap
    $nadiLengkap = $nadiTidakLengkap = 0;
    $gcsLengkap = $gcsTidakLengkap = 0;
    
    foreach ($allPatients as $patient) {
        $pemeriksaan = $patient->pemeriksaanRalan->last();
    
        if ($pemeriksaan) {
            // Cek kelengkapan TTV
            if ($pemeriksaan->suhu_tubuh) {
                $ttvLengkap++;
            } else {
                $ttvTidakLengkap++;
            }
    
            if ($pemeriksaan->tensi) {
                $tensiLengkap++; 
            } else {
                $tensiTidakLengkap++; 
            }
            
            if ($pemeriksaan->nadi) {
                $nadiLengkap++; 
            } else {
                $nadiTidakLengkap++; 
            }
            
            if ($pemeriksaan->gcs) {
                $gcsLengkap++; 
            } else {
                $gcsTidakLengkap++; 
            }
    
            // Cek kelengkapan Assesmen
            if ($pemeriksaan->keluhan && $pemeriksaan->pemeriksaan && $pemeriksaan->rtl && $pemeriksaan->penilaian) {
                $assesmenLengkap++;
            } else {
                $assesmenTidakLengkap++;
            }
        } else {
            // Jika tidak ada pemeriksaan, anggap TTV dan Assesmen sebagai tidak lengkap
            $ttvTidakLengkap++;
            $assesmenTidakLengkap++;
            $tensiTidakLengkap++; 
            $nadiTidakLengkap++;
            $gcsTidakLengkap++;
        }
    }


    // Ambil data pasien dengan relasi ke pemeriksaan_ralan dan paginasi
    $patients = $query->with('pemeriksaanRalan', 'pasien', 'dokter', 'poliklinik')
        ->paginate(30); // Menyesuaikan dengan jumlah data per halaman

    // Update data pasien untuk menambahkan flag multiple examinations
    $patients->getCollection()->transform(function ($patient) {
        $patient->hasMultipleExaminations = $patient->pemeriksaanRalan->count() > 1;
        return $patient;
    });

    // Ambil data poliklinik untuk dropdown
    $polikliniks = Poliklinik::all();
    // Ambil data dokter untuk dropdown
    $dokters = Dokter::all();

    return view('ralan.index', compact('patients', 'polikliniks','dokters','totalPatients','ttvLengkap', 'ttvTidakLengkap', 'assesmenLengkap', 'assesmenTidakLengkap','tensiLengkap','tensiTidakLengkap','nadiLengkap','nadiTidakLengkap','gcsLengkap','gcsTidakLengkap'));
}


    public function show($no_rawat)
    {
        // Convert dashes back to slashes for the database query
        $clean_no_rawat = str_replace('-', '/', $no_rawat);
    
        // Format the no_rawat back to the original format
        $no_rawat = substr($clean_no_rawat, 0, 4) . '/' . substr($clean_no_rawat, 4, 2) . '/' . substr($clean_no_rawat, 6, 2) . '/' . substr($clean_no_rawat, 8);
    
        // Fetch the patient data based on no_rawat
        $patient = RegPeriksa::with([
            'pasien', 
            'dokter', 
            'poliklinik', 
            'diagnosaPasien',
            'prosedurPasien.icd9',
            'bridgingSep'
        ])->where('no_rawat', $no_rawat)->first();
        
        // Ambil data pemeriksaan rawat jalan berdasarkan no_rawat
        $pemeriksaanRalan = PemeriksaanRalan::where('no_rawat', $no_rawat)->get();
        
        // Ambil data pemberian obat berdasarkan no_rawat
        $detailPemberianObat = DetailPemberianObat::with(['barang'])
            ->where('no_rawat', $no_rawat)
            ->get();
    
        // Ambil data aturan pakai berdasarkan no_rawat
        $aturanPakai = AturanPakai::where('no_rawat', $no_rawat)
            ->get();
    
            // Ambil data pemeriksaan laboratorium berdasarkan no_rawat
        $detailPeriksaLab = DetailPeriksaLab::with('templateLaboratorium')->where('no_rawat', $no_rawat)->get();
        
        $periksaRadiologi = Periksaradiologi::where('no_rawat', $no_rawat)->with('jnsPerawatanRadiologi','petugas')->get();
        
        $hasilRadiologi = HasilRadiologi::where('no_rawat', $no_rawat)->get();
    
        // Ambil data tindakan Rawat Jalan Dokter, Dokter & Perawat, Perawat berdasarkan no_rawat
        $tindakanDr = RawatJlDr::where('no_rawat', $no_rawat)->get();
        $tindakanDrPr = RawatJlDrpr::where('no_rawat', $no_rawat)->get();
        $tindakanPr = RawatJlPr::where('no_rawat', $no_rawat)->get();
        // Handle not found case
        if (!$patient) {
            abort(404, 'Riwayat pasien tidak ditemukan');
        }
    
        return view('ralan.show', compact('patient','pemeriksaanRalan','detailPemberianObat', 'aturanPakai','detailPeriksaLab', 'periksaRadiologi', 'hasilRadiologi', 'tindakanDr', 'tindakanDrPr', 'tindakanPr'));
    }


}
