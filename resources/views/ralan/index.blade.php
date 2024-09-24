@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div class="my-auto">
        <h5 class="page-title fs-21 mb-1">Monitoring Ralan</h5>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                <li class="breadcrumb-item active" aria-current="page">Monitoring Ralan</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->

<!-- Display Total Patients -->
<div class="alert alert-info">
Total Pasien: {{ $totalPatients }}</br>
Total Suhu Tubuh Lengkap: {{ $ttvLengkap }}</br>
Total Suhu Tubuh Tidak Lengkap: {{ $ttvTidakLengkap }}</br>
Total Tensi Lengkap: {{ $tensiLengkap }}</br>
Total Tensi Tidak Lengkap: {{ $tensiTidakLengkap }}</br>
Total Nadi Lengkap: {{ $nadiLengkap }}</br>
Total Nadi Tidak Lengkap: {{ $nadiTidakLengkap }}</br>
Total GCS Lengkap: {{ $gcsLengkap }}</br>
Total GCS Tidak Lengkap: {{ $gcsTidakLengkap }}</br>
Total Assesmen Lengkap: {{ $assesmenLengkap }}</br>
Total Assesmen Tidak Lengkap: {{ $assesmenTidakLengkap }}</br>
</div>

<!-- Start::row-1 -->
<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="main-content-body-invoice">
            <div class="card card-invoice">
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('ralan.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="start_date">Start Date:</label>
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date">End Date:</label>
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="poliklinik">Poliklinik:</label>
                                <select name="poliklinik" class="js-example-basic-single2">
                                    <option value="">-- All Poliklinik --</option>
                                    @foreach($polikliniks as $poliklinik)
                                        <option value="{{ $poliklinik->kd_poli }}" {{ request('poliklinik') == $poliklinik->kd_poli ? 'selected' : '' }}>
                                            {{ $poliklinik->nm_poli }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="dokter">Dokter:</label>
                                <select name="dokter" class="js-example-basic-single3">
                                    <option value="">-- All Dokter --</option>
                                    @foreach($dokters as $dokter)
                                        <option value="{{ $dokter->kd_dokter }}" {{ request('dokter') == $dokter->kd_dokter ? 'selected' : '' }}>
                                            {{ $dokter->nm_dokter }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 align-self-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('ralan.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered mt-2">
                            <thead>
                                <tr>
                                    <th>Data Registrasi</th>
                                    <th>Tanda Vital</th>
                                    <th>Asesmen</th>
                                    <th>Diagnosa Pasien</th>
                                    <th>Kesimpulan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patients as $patient)
                                <tr>
                                    <td style="word-wrap: break-word; white-space: normal;">
                                        <!-- <strong>No. Rawat:</strong> {{ $patient->no_rawat }}<br> -->
                                        <strong>Tanggal Registrasi:</strong> {{ $patient->tgl_registrasi }}<br>
                                        <strong>No. RM:</strong> {{ $patient->no_rkm_medis }}<br>
                                        <strong>Nama:</strong> {{ $patient->pasien->nm_pasien }}<br>
                                        <strong>Nama Dokter:</strong> {{ $patient->dokter->nm_dokter }}<br>
                                        <strong>Poliklinik:</strong> {{ $patient->poliklinik->nm_poli }}<br>
                                    </td>
                                    <td style="word-wrap: break-word; white-space: normal;">
                                        <strong>Temperature:</strong> {{ optional($patient->pemeriksaanRalan->first())->suhu_tubuh }}<br>
                                        <strong>Tensi:</strong> {{ optional($patient->pemeriksaanRalan->first())->tensi }}<br>
                                        <strong>Nadi:</strong> {{ optional($patient->pemeriksaanRalan->first())->nadi }}<br>
                                        <strong>GCS:</strong> {{ optional($patient->pemeriksaanRalan->first())->gcs }}<br>
                                    </td>
                                    <td style="word-wrap: break-word; white-space: normal;">
                                        <strong>Keluhan:</strong> {{ optional($patient->pemeriksaanRalan->first())->keluhan }}<br>
                                        <strong>Pemeriksaan:</strong> {{ optional($patient->pemeriksaanRalan->first())->pemeriksaan }}<br>
                                        <strong>Plan:</strong> {{ optional($patient->pemeriksaanRalan->first())->rtl }}<br>
                                        <strong>Penilaian:</strong> {{ optional($patient->pemeriksaanRalan->first())->penilaian }}<br>
                                        @if($patient->hasMultipleExaminations)
                                            <span class="badge bg-danger">Periksa Detail</span>
                                        @endif
                                    </td>
                                    <td style="word-wrap: break-word; white-space: normal;">
                                        @foreach($patient->diagnosaPasien as $diagnosa)
                                            <strong>ICD 10:</strong> {{ $diagnosa->kd_penyakit }}<br>
                                            <strong>Nama Penyakit:</strong> {{ $diagnosa->penyakit->nm_penyakit ?? 'Tidak Diketahui' }}<br>
                                        @endforeach
                                        @foreach($patient->prosedurPasien as $prosedur)
                                           <strong>ICD 9:</strong> {{ $prosedur->kode }}<br>
                                           <strong>Deskripsi:</strong> {{ $prosedur->ic9->deskripsi_panjang ?? 'Tidak ada deskripsi' }}<br>
                                       @endforeach
                                    </td>
                                    <td style="word-wrap: break-word; white-space: normal;">
                                        @php
                                            $ttvLengkap = false;
                                            $assesmenLengkap = false;
                                            $tensiLengkap = false;
                                            
                                            // Loop melalui semua pemeriksaan terkait
                                            foreach ($patient->pemeriksaanRalan as $pemeriksaan) {
                                                // Cek kelengkapan TTV
                                                if ($pemeriksaan->suhu_tubuh) {
                                                    $ttvLengkap = true;
                                                }
                                                if ($pemeriksaan->tensi) {
                                                    $tensiLengkap = true;
                                                }
                                                
                                                // Cek kelengkapan Assesmen
                                                if ($pemeriksaan->keluhan && $pemeriksaan->pemeriksaan && $pemeriksaan->rtl && $pemeriksaan->penilaian) {
                                                    $assesmenLengkap = true;
                                                }
                                            }
                                        
                                            $ttvStatus = $ttvLengkap ? 'TTV lengkap' : 'TTV tidak lengkap';
                                            $assesmenStatus = $assesmenLengkap ? 'Assesmen lengkap' : 'Assesmen tidak lengkap';
                                        @endphp
                                        
                                        <strong>Kesimpulan:</strong> {{ $ttvStatus }}, {{ $assesmenStatus }}<br>
                                        <strong>Nama</strong> {{ optional(optional($patient->pemeriksaanRalan->first())->pegawai)->nama }}<br>
                                        <a href="{{ route('ralan.show', preg_replace('/[\/-]/', '', $patient->no_rawat)) }}" class="btn btn-info">Detail</a>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Paginasi -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} entries
                        </div>
                        
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0 justify-content-end">
                                <!-- Previous Page Link -->
                                @if ($patients->onFirstPage())
                                    <li class="page-item disabled">
                                        <a class="page-link" href="javascript:void(0);">Previous</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $patients->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}">Previous</a>
                                    </li>
                                @endif
                        
                                <!-- Pagination Elements -->
                                @foreach ($patients->links()->elements[0] as $page => $url)
                                    @if ($page == $patients->currentPage())
                                        <li class="page-item active" aria-current="page">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url . '&' . http_build_query(request()->except('page')) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach
                        
                                <!-- Next Page Link -->
                                @if ($patients->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $patients->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <a class="page-link" href="javascript:void(0);">Next</a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
     $('.js-example-basic-single1,.js-example-basic-single2').select2();
     $('.js-example-basic-single1,.js-example-basic-single3').select2();
     document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#date", {
            dateFormat: "Y-m-d"  // Format of the date
        });
    });
</script>

@endsection



