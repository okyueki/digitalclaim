<?php

namespace App\Http\Controllers;

use App\Models\ValidasiVedika;
use App\Models\RegPeriksa;
use Illuminate\Support\Facades\Log;
use App\Models\Poliklinik;
use App\Models\DiagnosaPasien;
use App\Models\BerkasDigitalPerawatan;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the validasi vedika records.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        $title = 'Feedback BPJS';

        // Initialize query with relationships
        $query = ValidasiVedika::with(['regperiksa' => function ($query) {
            $query->with('pasien');
        }]);

        // Apply filters
        if ($request->has('no_rawat')) {
            $query->where('no_rawat', $request->input('no_rawat'));
        }

        if ($request->has('status_validasi_vedika')) {
            $query->where('status_validasi_vedika', $request->input('status_validasi_vedika'));
        }

        if ($request->has('tanggal')) {
            $query->whereDate('tanggal', $request->input('tanggal'));
        }

        if ($request->has('jam')) {
            $query->whereTime('jam', $request->input('jam'));
        }

        // Handle search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('no_rawat', 'like', "%{$search}%")
                  ->orWhereHas('regperiksa.pasien', function($q) use ($search) {
                      $q->where('nm_pasien', 'like', "%{$search}%")
                        ->orWhere('no_peserta', 'like', "%{$search}%");
                  });
            });
        }

        // Paginate results
        $validasiVedika = $query->paginate(10); // Adjust number per page as needed

        return view('admin.feedback', compact('validasiVedika', 'title'));
    
    }

    public function edit($encryptedNoRawat)
    {
        $title = 'Validasi BPJS';
        $no_rawat = decrypt($encryptedNoRawat);  // Dekripsi no_rawat dari rute terenkripsi

        // Build query
        $result = RegPeriksa::with(['dokter', 'poliklinik', 'penjab', 'pasien', 'berkasdigitalperawatan.masterberkasdigital'])
            ->where('no_rawat', $no_rawat)
            ->first();

        if ($result) {
            // Adding diagnoses to result
            $diagnoses = DiagnosaPasien::where('no_rawat', $result->no_rawat)
                ->where('prioritas', '1')
                ->where('status', $result->status_lanjut)
                ->with('penyakit')
                ->get()
                ->map(function ($diagnosa) {
                    return $diagnosa->kd_penyakit . ' ' . $diagnosa->penyakit->nm_penyakit;
                });
            $result->diagnoses = $diagnoses;
        }

          // Retrieve validation data if it exists
        $validasiVedika = ValidasiVedika::where('no_rawat', $no_rawat)->first();
        
        return view('admin.editfeedback', compact('result', 'title', 'validasiVedika'));
    }

   
    public function update(Request $request, $encryptedNoRawat)
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
                'tanggal' => now()->toDateString(),
                'jam' => now()->toTimeString(),
            ]
        );
        
        return redirect()->route('feedback')->with('success', 'Record updated successfully.');
    }

 
    public function destroy(ValidasiVedika $validasiVedika)
    {
        $validasiVedika->delete();

        return redirect()->route('feedback')->with('success', 'Record deleted successfully.');
    }
}