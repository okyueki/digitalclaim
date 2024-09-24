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
                                        <th>Nama Dokumen</th>
                                        <th>Preview</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($berkas as $file)
                                        <tr class="isi8">
                                            <td>{{ $file->masterberkasdigital->nama }}</td>
                                            <td width="99%">
                                                <object data="{{ url('http://192.168.10.74/webapps2/berkasrawat/' . $file->lokasi_file) }}" type="application/pdf" width="100%" height="730px">
                                                    Tidak support PDF, Silahkan download <a href="{{ url('http://192.168.10.74/webapps2/berkasrawat/' . $file->lokasi_file) }}">Download PDF</a>
                                                </object>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2">Tidak ada berkas untuk ditampilkan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                    </div>
                    <br>
                    <br>
                    <form method="post" action="{{ route('listvedika.validasiverifikator', encrypt($no_rawat)) }}" enctype="multipart/form-data">
                        @csrf
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
                        <button class="btn btn-primary" type="submit">Kirim ke BPJS</button>
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