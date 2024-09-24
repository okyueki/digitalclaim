@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div class="my-auto">
        <h5 class="page-title fs-21 mb-1">{{ $title }}</h5>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>

    <div class="d-flex my-xl-auto right-content align-items-center">
        <div class="pe-1 mb-xl-0">
            <button type="button" class="btn btn-info btn-icon me-2 btn-b"><i class="mdi mdi-filter-variant"></i></button>
        </div>
        <div class="pe-1 mb-xl-0">
            <button type="button" class="btn btn-danger btn-icon me-2"><i class="mdi mdi-star"></i></button>
        </div>
        <div class="pe-1 mb-xl-0">
            <button type="button" class="btn btn-warning  btn-icon me-2"><i class="mdi mdi-refresh"></i></button>
        </div>
        <div class="mb-xl-0">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuDate" data-bs-toggle="dropdown" aria-expanded="false">
                    14 Aug 2019
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuDate">
                  <li><a class="dropdown-item" href="javascript:void(0);">2015</a></li>
                  <li><a class="dropdown-item" href="javascript:void(0);">2016</a></li>
                  <li><a class="dropdown-item" href="javascript:void(0);">2017</a></li>
                  <li><a class="dropdown-item" href="javascript:void(0);">2018</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Page Header Close -->
<!-- Start::row-1 -->
<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class=" main-content-body-invoice">
            <div class="card card-invoice">
                <div class="card-body">
                   <form name="frm_aturadmin" method="get" action="{{ route('listvedikabpjs') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="container-fluid mb-4">
                            <!-- Form fields -->
                            <div class="row mb-3">
                                <div class="col-md-12 mb-3">
                                    <label for="periode" class="form-label">Periode</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </span>
                                                <input type="text" class="form-control" id="date" name="tanggal_mulai" placeholder="Start Date" value="{{ $tanggal_mulai ?? date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </span>
                                                <input type="text" class="form-control" id="date" name="tanggal_berakhir" placeholder="End Date" value="{{ $tanggal_berakhir ?? date('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="col-md-3">-->
                                <!--    <label for="status" class="form-label">Status</label>-->
                                <!--    <select id="status_lanjut" name="status_lanjut" class="js-example-basic-single1">-->
                                <!--        <option value="">-- Pilih Status --</option>-->
                                <!--        <option value="">Semua</option>-->
                                <!--        <option value="Ralan">Ralan</option>-->
                                <!--        <option value="Ranap">Ranap</option>-->
                                <!--    </select>-->
                                <!--</div>-->
                                <!-- Other form fields remain unchanged -->
                                <div class="col-md-4">
                                    <label for="keyword" class="form-label">Keyword</label>
                                    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Masukkan Keyword" value="{{ $keyword }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="poli" class="form-label">Poliklinik</label>
                                    <select id="poli" name="poli" class="js-example-basic-single2">
                                        <option value="">-- Pilih Poliklinik --</option>
                                        @foreach($polikliniks as $poliklinik)
                                            <option value="{{ $poliklinik->kd_poli }}" {{ $poli == $poliklinik->kd_poli ? 'selected' : '' }}>
                                                {{ $poliklinik->nm_poli }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-center mt-4">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class=" main-content-body-invoice">
            <div class="card card-invoice">
                <div class="card-body">
                @if($results->count())
                        <div class="table-responsive">
                        <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Proses</th>
                                        <th scope="col">Data Pasien</th>
                                        <th scope="col">Registrasi</th>
                                        <th scope="col">Kunjungan</th>
                                        <th scope="col">Berkas Digital</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $result)
                                        <tr>
                                            <td class="text-center" width="100px">
                                            <div class="btn-list d-flex align-items-center flex-wrap">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Dropdown Action
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                        <li><a class="dropdown-item" target="_blank" href="{{ route('listvedika.gabungberkas',encrypt($result->no_rawat)) }}">Gabung Berkas</a></li>
                                                        <li><a class="dropdown-item" href="{{ route('listvedikabpjs.validasibpjs',encrypt($result->no_rawat)) }}">Validasi BPJS</a></li>
                                                        <!--<li><a class="dropdown-item" href="javascript:void(0);">Validasi Koders</a></li>-->
                                                    </ul>
                                                </div>
                                            </div>
                                            </td>
                                            <td width="500px">
                                                <table class="table table-borderless table-sm">
                                                    <tr>
                                                        <td>No.Rawat</td><td>: {{ $result->no_rawat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>No.RM</td><td>: {{ $result->no_rkm_medis }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama Pasien</td><td>: {{ optional($result->pasien)->nm_pasien ?? 'Tidak tersedia' }}, 
                                                        {{ $result->umurdaftar }} {{ $result->sttsumur }}, 
                                                        {{ optional($result->pasien)->jk == 'L' ? 'Laki-Laki' : 'Perempuan' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alamat Pasien</td><td>: {{ $result->almt_pj }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Diagnosa</td><td>: {{ $result->diagnoses->join(', ') }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table class="table table-borderless table-sm">
                                                    <tr>
                                                        <td>Tgl.Registrasi</td><td>: {{ $result->tgl_registrasi }} {{ $result->jam_reg }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Poliklinik</td><td>: {{ $result->poliklinik->nm_poli }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dokter</td><td>: {{ $result->dokter->nm_dokter ?? 'Tidak Tersedia' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jenis Bayar</td><td>: {{ $result->status_lanjut }} ({{ $result->penjab->png_jawab }})</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table class="table table-borderless table-sm">
                                                    <tr>
                                                        <td>No.Kunjungan</td><td>: {{ $result->bridgingsep->no_sep ?? 'Tidak tersedia' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>No.Kartu</td><td>: {{ optional($result->pasien)->no_peserta ?? 'Tidak tersedia' }}</td>
                                                    </tr>
                                                    <tr>
                                                    <td>D.U.</td><td>:  @if ($result->diagnosapasien->isNotEmpty())
                                                        @foreach ($result->diagnosapasien as $diagnosa)
                                                            {{ $diagnosa->kd_penyakit }} {{ optional($diagnosa->penyakit)->nm_penyakit }}<br>
                                                        @endforeach
                                                    @else
                                                        Tidak tersedia
                                                    @endif
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status Verifikator</td><td>: 
                                                        
                                                       @if ($result->validasivedika->isNotEmpty())
                                                            @php
                                                                $firstValidasi = $result->validasivedika->first();
                                                            @endphp
                                                            @if ($firstValidasi->status_validasi_vedika == 'Sesuai')
                                                                <span class="badge bg-success">Tervalidasi</span>
                                                            @else
                                                                <span class="badge bg-danger">Belum Tervalidasi</span>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-danger">Belum Tervalidasi</span>
                                                        @endif
                                                        </td>
                                                        
                                                    </tr>
                                                   <tr>
                                                        <td>Status BPJS</td><td>: 
                                                        
                                                       @if ($result->validasivedikabpjs->isNotEmpty())
                                                            @php
                                                                $firstValidasi = $result->validasivedikabpjs->first();
                                                            @endphp
                                                            @if ($firstValidasi->status_validasi_vedika_bpjs == 'Sesuai')
                                                                <span class="badge bg-success">Tervalidasi</span>
                                                            @else
                                                                <span class="badge bg-danger">Belum Tervalidasi</span>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-danger">Belum Tervalidasi</span>
                                                        @endif
                                                        </td>
                                                        
                                                    </tr>
                                                    
                                                </table>
                                            </td>
                                            <td>
                                                <ul class="list-group list-group-flush">
                                                @if($result->berkasdigitalperawatan->isNotEmpty())
                                                    @foreach($result->berkasdigitalperawatan as $berkas)
                                                        <li class="list-group-item"><a href="{{ url('http://192.168.10.74/webapps2/berkasrawat/' . $berkas->lokasi_file) }}" target="_blank">
                                                            {{ $berkas->masterberkasdigital->nama ?? 'Nama Tidak Ada' }}
                                                        </a></li>
                                                    @endforeach
                                                @else
                                                    Tidak ada berkas digital
                                                @endif

                                                </ul>
                                           
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                         <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                Showing {{ $results->firstItem() }} to {{ $results->lastItem() }} of {{ $results->total() }} entries
                            </div>
                            <nav aria-label="Page navigation">
                                <ul class="pagination mb-0 justify-content-end">
                                    <!-- Previous Page Link -->
                                    @if ($results->onFirstPage())
                                        <li class="page-item disabled">
                                            <a class="page-link" href="javascript:void(0);">Previous</a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $results->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}">Previous</a>
                                        </li>
                                    @endif
                            
                                    <!-- Pagination Elements -->
                                    @foreach ($results->links()->elements[0] as $page => $url)
                                        @if ($page == $results->currentPage())
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
                                    @if ($results->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $results->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}">Next</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <a class="page-link" href="javascript:void(0);">Next</a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @else
                        <div class="alert alert-warning text-center" role="alert">
                            Data pasien tidak ditemukan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
     $('.js-example-basic-single1,.js-example-basic-single2').select2();
      document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#date", {
            dateFormat: "Y-m-d"  // Format of the date
        });
    });
    
// Fungsi untuk menghapus tanggal yang disimpan jika diperlukan (misalnya, ketika pencarian baru dimulai)
function clearStoredDate() {
    sessionStorage.removeItem('selectedDate');
}
     @if (session('success'))
    Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'OK'
    })
    @endif

    @if (session('error'))
    Swal.fire({
        title: 'Error!',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonText: 'OK'
    })
    @endif
</script>
<!-- row closed -->
@endsection
