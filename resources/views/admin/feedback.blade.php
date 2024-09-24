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
                     <div class="d-flex justify-content-between align-items-center mb-4">
                        <form action="{{ route('feedback') }}" method="GET" class="form-inline">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request()->input('search') }}">
                                <button class="btn btn-primary" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered mt-2">
                            <tr>
                                <th>No</th>
                                <th>No Rawat</th>
                                <th>Nama Pasien</th>
                                <th>No. Peserta</th>
                                <th>Status Validasi</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th width="280px">Action</th>
                            </tr>
                            @foreach ($validasiVedika as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->no_rawat }}</td>
                                <td>{{ $item->regperiksa->pasien->nm_pasien ?? 'N/A' }}</td>
                                <td>{{ $item->regperiksa->pasien->no_peserta ?? 'N/A'}}</td>
                                <td>{{ $item->status_validasi_vedika }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->jam }}</td>
                                <td>
                                    <form id="delete-form-{{ $item->id_validasi_vedika }}" action="{{ route('feedback.destroy', $item->id_validasi_vedika) }}" method="POST">
                                        <a class="btn btn-primary" href="{{ route('feedback.edit', encrypt($item->no_rawat)) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $item->id_validasi_vedika }})"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <br>
                    <!-- Custom Pagination -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            Showing {{ $validasiVedika->firstItem() }} to {{ $validasiVedika->lastItem() }} of {{ $validasiVedika->total() }} entries
                        </div>
                         <nav aria-label="Page navigation">
                            <ul class="pagination mb-0 justify-content-end">
                                <!-- Previous Page Link -->
                                @if ($validasiVedika->onFirstPage())
                                    <li class="page-item disabled">
                                        <a class="page-link" href="javascript:void(0);">Previous</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $validasiVedika->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}">Previous</a>
                                    </li>
                                @endif
                        
                                <!-- Pagination Elements -->
                                @foreach ($validasiVedika->links()->elements[0] as $page => $url)
                                    @if ($page == $validasiVedika->currentPage())
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
                                @if ($validasiVedika->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $validasiVedika->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}">Next</a>
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
     document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#date", {
            defaultDate: new Date(),  // Set default date to today
            dateFormat: "Y-m-d",      // Format of the date
        });
    });
    
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Anda tidak dapat mengembalikannya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
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