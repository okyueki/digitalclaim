<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegPeriksa;
use App\Models\ValidasiVedika;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = 'Dashboard';
        
        $today = Carbon::today();

        // Get data for the last 10 days
        $data = RegPeriksa::selectRaw('DATE(tgl_registrasi) as date, COUNT(*) as count')
            ->where('status_lanjut', 'like', "Ralan")
            ->whereBetween('tgl_registrasi', [$today->copy()->subDays(30), $today])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('count', 'date');
            
        $dates = $data->keys()->toArray();
        $counts = $data->values()->toArray();
        
       
        $startOfYear = $today->copy()->startOfYear();
        $endOfYear = $today->copy()->endOfYear();
    
            // Get count of "Sesuai" and "Belum Sesuai" per month for the current year
        $validasiData = ValidasiVedika::selectRaw('
                DATE_FORMAT(tanggal, "%Y-%m") as month,
                SUM(CASE WHEN status_validasi_vedika = "Sesuai" THEN 1 ELSE 0 END) as sesuai,
                SUM(CASE WHEN status_validasi_vedika = "Belum Sesuai" THEN 1 ELSE 0 END) as belum_sesuai
            ')
            ->whereBetween('tanggal', [$startOfYear, $endOfYear])
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    
        // Get all RegPeriksa data for the year
        $regPeriksaData = RegPeriksa::selectRaw('
                DATE_FORMAT(tgl_registrasi, "%Y-%m") as month
            ')
            ->whereBetween('tgl_registrasi', [$startOfYear, $endOfYear])
            ->where('status_lanjut', 'like', "Ralan")
            ->groupBy('month')
            ->pluck('month')
            ->toArray();
    
        // Generate months for the year to ensure all months are included in the chart
        $months = [];
        $sesuaiCounts = [];
        $belumSesuaiCounts = [];
    
        foreach (range(1, 12) as $month) {
            $formattedMonth = $startOfYear->copy()->month($month)->format('Y-m');
            $months[] = $formattedMonth;
            $validasiForMonth = $validasiData->where('month', $formattedMonth)->first();
            $totalForMonth = RegPeriksa::where('status_lanjut', 'like', "Ralan")
                ->whereBetween('tgl_registrasi', [$startOfYear->copy()->month($month)->startOfMonth(), $startOfYear->copy()->month($month)->endOfMonth()])
                ->count();
    
            $sesuaiCounts[] = $validasiForMonth ? $validasiForMonth->sesuai : 0;
            $belumSesuaiCounts[] = $totalForMonth - ($validasiForMonth ? $validasiForMonth->sesuai : 0);
        }
        
        return view('admin.dashboard',compact('title','dates', 'counts', 'months', 'sesuaiCounts', 'belumSesuaiCounts'));
    }
}
