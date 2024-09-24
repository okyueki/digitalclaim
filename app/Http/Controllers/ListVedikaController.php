<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\RegPeriksa;
use App\Models\Poliklinik;
use App\Models\DiagnosaPasien;
use App\Models\BerkasDigitalPerawatan;
use App\Models\MasterBerkasDigital;
use App\Models\ValidasiVedika;
use App\Models\ValidasiVedikaBPJS;

class ListVedikaController extends Controller
{
    public function index(Request $request)
    {
         $title = 'List Vedika';
    $tanggal_mulai = $request->input('tanggal_mulai') ?: date('Y-m-d');
        $tanggal_berakhir = $request->input('tanggal_berakhir') ?: date('Y-m-d');
    $keyword = $request->input('keyword', '');
    $poli = $request->input('poli', '');

    // Check if there is any search input
    $isSearching = $tanggal_mulai || $tanggal_berakhir || $keyword || $poli;

    // Set default date range to today if no search is performed
    if (!$isSearching) {
        $tanggal_mulai = date('Y-m-d');
        $tanggal_berakhir = date('Y-m-d');
    }

    // Build the query
    $query = RegPeriksa::with(['dokter', 'poliklinik', 'penjab', 'pasien', 'berkasdigitalperawatan.masterberkasdigital', 'diagnosapasien.penyakit', 'bridgingsep', 'validasivedika', 'validasivedikabpjs'])
        ->where('status_lanjut', 'like', 'Ralan')
        ->where('kd_pj', 'like', 'BPJ')
        ->whereBetween('tgl_registrasi', [$tanggal_mulai, $tanggal_berakhir]);

    // Apply filters if searching
    if ($isSearching) {
        $query->where(function ($q) use ($keyword, $poli) {
            if ($poli) {
                $q->whereHas('poliklinik', function ($q) use ($poli) {
                    $q->where('kd_poli', $poli);
                });
            }
            if ($keyword) {
                $q->where('no_reg', 'like', "%$keyword%")
                    ->orWhere('no_rawat', 'like', "%$keyword%")
                    ->orWhere('tgl_registrasi', 'like', "%$keyword%")
                    ->orWhereHas('dokter', function ($q) use ($keyword) {
                        $q->where('nm_dokter', 'like', "%$keyword%");
                    })
                    ->orWhereHas('pasien', function ($q) use ($keyword) {
                        $q->where('no_rkm_medis', 'like', "%$keyword%")
                            ->orWhere('nm_pasien', 'like', "%$keyword%");
                    });
            }
        });
    }

    $results = $query->orderBy('tgl_registrasi', 'desc')
        ->orderBy('jam_reg', 'desc')
        ->paginate(10);

    // Adding diagnoses to results
    $results->each(function ($result) {
        if ($result->pasien) {
            $diagnoses = $result->diagnosapasien
                ->where('prioritas', '1')
                ->where('status', $result->status_lanjut)
                ->map(function ($diagnosa) {
                    return $diagnosa->kd_penyakit . ' ' . optional($diagnosa->penyakit)->nm_penyakit;
                });
            $result->diagnoses = $diagnoses;
        } else {
            Log::warning('Patient not found for no_rawat: ' . $result->no_rawat);
            $result->diagnoses = collect();
        }
    });

    // Retrieve polikliniks with status = 1
    $polikliniks = Poliklinik::where('status', '1')->get();

    return view('admin.listvedika', compact('results', 'polikliniks', 'poli', 'title','tanggal_mulai', 'tanggal_berakhir', 'keyword'));
    }

    public function showValidasiverifikatorForm($encryptedNoRawat)
    {
        $title = 'Validasi Verifikator';
        $no_rawat = decrypt($encryptedNoRawat);  // Dekripsi no_rawat dari rute terenkripsi

        // Build query
        $berkas = BerkasDigitalPerawatan::with('masterberkasdigital')
        ->where('no_rawat', $no_rawat)
        ->join('master_berkas_digital', 'berkas_digital_perawatan.kode', '=', 'master_berkas_digital.kode')
        ->orderBy('master_berkas_digital.nama', 'asc')
        ->get();


          // Retrieve validation data if it exists
        $validasiVedika = ValidasiVedika::where('no_rawat', $no_rawat)->first();
        
        return view('admin.validasiverifikator', compact('berkas', 'no_rawat', 'title', 'validasiVedika'));
        
    }

    public function validasiverifikator(Request $request, $encryptedNoRawat)
    {
        $no_rawat = decrypt($encryptedNoRawat);

        // Validate input
        $validated = $request->validate([
            'status_validasi_vedika' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        // Update or create the record in the database
        ValidasiVedika::updateOrCreate(
            ['no_rawat' => $no_rawat], // Attributes to match
            [
                'status_validasi_vedika' => $validated['status_validasi_vedika'],
                'keterangan' => $validated['keterangan'],
                'id_uservedika' => Auth::user()->id_uservedika,
                'tanggal' => now()->toDateString(),
                'jam' => now()->toTimeString(),
            ]
        );
        
          // Check if the status is 'Sesuai' and then create or update the validasi_vedika_bpjs table
        if ($validated['status_validasi_vedika'] === 'Sesuai') {
            ValidasiVedikaBPJS::updateOrCreate(
                ['no_rawat' => $no_rawat], // Attributes to match
                [
                    'status_validasi_vedika_bpjs' => 'Belum Sesuai',
                ]
            );
        }elseif ($validated['status_validasi_vedika'] === 'Belum Sesuai') {
            // Delete the validasi_vedika_bpjs record if it exists
            ValidasiVedikaBPJS::where('no_rawat', $no_rawat)->delete();
        }

        return redirect()->route('listvedika', encrypt($no_rawat))->with('success', 'Validasi BPJS berhasil disimpan.');
    }
    
    public function gabungberkas($encryptedNoRawat)
    {
        $no_rawat = decrypt($encryptedNoRawat);

    // Fetch digital files for the provided no_rawat with correct join
    $berkas = BerkasDigitalPerawatan::with('masterberkasdigital')
        ->where('no_rawat', $no_rawat)
        ->join('master_berkas_digital', 'berkas_digital_perawatan.kode', '=', 'master_berkas_digital.kode')
        ->orderBy('master_berkas_digital.nama', 'asc')
        ->get();

    return view('admin.gabungberkas', compact('berkas', 'no_rawat'));
    }
}
