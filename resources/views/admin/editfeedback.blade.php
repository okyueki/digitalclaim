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
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Data Pasien</th>
                                    <th scope="col">Registrasi</th>
                                    <th scope="col">Kunjungan</th>
                                    <th scope="col">Berkas Digital</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($result)
                            <tr>
                                <td width="500px">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td>No.Rawat</td><td>: {{ $result->no_rawat }}</td>
                                        </tr>
                                        <tr>
                                            <td>No.RM</td><td>: {{ $result->no_rkm_medis }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama Pasien</td><td>: {{ $result->pasien->nm_pasien }}, {{ $result->umurdaftar }} {{ $result->sttsumur }}, {{ $result->pasien->jk == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
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
                                            <td>Dokter</td><td>: {{ $result->dokter->nm_dokter }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td><td>: {{ $result->status_lanjut }} ({{ $result->penjab->png_jawab }})</td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td>No.Kunjungan</td><td>: {{ $result->kamarinap->no_sep ?? 'Tidak tersedia' }}</td>
                                        </tr>
                                        <tr>
                                            <td>No.Kartu</td><td>: {{ $result->pasien->no_peserta }}</td>
                                        </tr>
                                        <tr>
                                            <td>D.U.</td><td>:
                                            @if ($result->diagnosapasien->isNotEmpty())
                                                        @foreach ($result->diagnosapasien as $diagnosa)
                                                            {{ $diagnosa->kd_penyakit }} {{ optional($diagnosa->penyakit)->nm_penyakit }}<br>
                                                        @endforeach
                                                    @else
                                                        Tidak tersedia
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
                            @else
                            <tr>
                                <td colspan="5">Tidak ada data yang ditemukan untuk No. Rawat: {{ $no_rawat }}</td>
                            </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <br>
                    <form method="post" action="{{ route('feedback.update', encrypt($result->no_rawat)) }}" enctype="multipart/form-data">
                        @csrf
                         @method('PUT')
                        <div class="mb-3">
                            <label for="form-text" class="form-label fs-14 text-dark">Status Validasi</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_validasi_vedika" id="gridRadios1" value="Sesuai" {{ isset($validasiVedika) && $validasiVedika->status_validasi_vedika == 'Sesuai' ? 'checked' : '' }}>
                                <label class="form-check-label" for="gridRadios1">Sesuai</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_validasi_vedika" id="gridRadios2" value="Belum Sesuai" {{ isset($validasiVedika) && $validasiVedika->status_validasi_vedika == 'Belum Sesuai' ? 'checked' : '' }}>
                                <label class="form-check-label" for="gridRadios2">Belum Sesuai</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="form-password" class="form-label fs-14 text-dark">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="text-area" rows="3">{{ isset($validasiVedika) ? $validasiVedika->keterangan : '' }}</textarea>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
     $('.js-example-basic-single1,.js-example-basic-single2').select2();
     document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#date", {
            defaultDate: new Date(),  // Set default date to today
            dateFormat: "Y-m-d",      // Format of the date
        });
    });
</script>
<!-- row closed -->
@endsection