@extends('layouts.app')

@section('content')

<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div class="my-auto">
        <h5 class="page-title fs-21 mb-1">Detail Pasien: {{ $patient->pasien->nm_pasien }}</h5>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page">Detail Pasien: {{ $patient->no_rawat }}</li>
            </ol>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="main-content-body-invoice">
            <div class="card card-invoice">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mt-2">
                            <tr>
                                <th>No. SEP</th>
                                <td>{{ $patient->bridgingSep->no_sep ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>No RM</th>
                                <td>{{ $patient->no_rkm_medis }}</td>
                            </tr>
                            <tr>
                                <th>No. Rawat</th>
                                <td>{{ $patient->no_rawat }}</td>
                            </tr>
                            <tr>
                                <th>Nama Pasien</th>
                                <td>{{ $patient->pasien->nm_pasien }}</td>
                            </tr>
                            <tr>
                                <th>Poliklinik</th>
                                <td>{{ $patient->poliklinik->nm_poli }}</td>
                            </tr>
                            <tr>
                                <th>Dokter</th>
                                <td>{{ $patient->dokter->nm_dokter }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Registrasi</th>
                                <td>{{ $patient->tgl_registrasi }}</td>
                            </tr>
                            <tr>
                                <th>Cara Bayar</th>
                                <td>{{ $patient->penjab->png_jawab }} , {{ $patient->biaya_reg }}</td>
                            </tr>
                            <tr>
                                <th>Diagnosa</th>
                                <td>
                                    @foreach($patient->diagnosaPasien as $diagnosa)
                                        <p>{{ $diagnosa->penyakit->nm_penyakit }} ({{ $diagnosa->kd_penyakit }})</p>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>Prosedur</th>
                                <td>
                                    @foreach($patient->prosedurPasien as $prosedur)
                                        <p>{{ $prosedur->kode }} {{ $prosedur->icd9->deskripsi_panjang }}</p>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>Diagnosa SEP</th>
                                <td>{{ $patient->bridgingSep->nmdiagnosaawal ?? 'N/A' }}</td>
                            </tr>
                            <!-- Add more details as needed -->
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card card-invoice">
                <div class="card-body">
                    <div class="table-responsive">
                        <h3 class="card-title">Riwayat Pasien</h3>
                        <table class="table table-bordered mt-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="wrap-text">Tanggal</th>
                                    <th class="wrap-text">Suhu(C)</th>
                                    <th class="wrap-text">Tensi(mmHg)</th>
                                    <th class="wrap-text">Nadi(/menit)</th>
                                    <th class="wrap-text">RR(/menit)</th>
                                    <th class="wrap-text">Tinggi(cm)</th>
                                    <th class="wrap-text">Berat(Kg)</th>
                                    <th class="wrap-text">GCS(E,V,M)</th>
                                    <th class="wrap-text">SPO2</th>
                                    <th class="wrap-text">Alergi</th>
                                    <th class="wrap-text">Instruksi & Evaluasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pemeriksaanRalan as $index => $pemeriksaan)
                                    <tr>
                                        <td rowspan="6">{{ $index + 1 }}</td>
                                        <td rowspan="6" class="wrap-text">
                                            Rawat Jalan<br>
                                            {{ $pemeriksaan->tgl_perawatan }}<br>
                                            {{ $pemeriksaan->jam_rawat }}<br>
                                            {{ $pemeriksaan->location }}
                                        </td>
                                        <td class="wrap-text">{{ $pemeriksaan->suhu_tubuh }}</td>
                                        <td class="wrap-text">{{ $pemeriksaan->tensi }}</td>
                                        <td class="wrap-text">{{ $pemeriksaan->nadi }}</td>
                                        <td class="wrap-text">{{ $pemeriksaan->respirasi }}</td>
                                        <td class="wrap-text">{{ $pemeriksaan->tinggi }}</td>
                                        <td class="wrap-text">{{ $pemeriksaan->berat }}</td>
                                        <td class="wrap-text">{{ $pemeriksaan->gcs }}</td>
                                        <td class="wrap-text">{{ $pemeriksaan->spo2 }}</td>
                                        <td class="wrap-text">{{ $pemeriksaan->alergi }}</td>
                                        <td rowspan="6" class="wrap-text">
                                            Instruksi: {{ $pemeriksaan->instruksi }}<br>
                                            Evaluasi: {{ $pemeriksaan->evaluasi }}<br>
                                            {{ $pemeriksaan->pegawai->nama }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="9" class="wrap-text">Kesadaran: {{ $pemeriksaan->kesadaran }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="9" class="wrap-text">Keluhan : {{ $pemeriksaan->keluhan }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="9" class="wrap-text">Subyektif: {{ $pemeriksaan->pemeriksaan }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="9" class="wrap-text">Obyektif: {{ $pemeriksaan->rtl }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="9" class="wrap-text">Assessment: {{ $pemeriksaan->pemeriksaan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card card-invoice">
                <div class="card-body">
                    <div class="table-responsive">
                        <h3 class="card-title">Pemberian Obat</h3>
                        @php
                            $groupedObat = $detailPemberianObat->groupBy('tgl_perawatan');
                            $accordionIndex = 1;
                            $totalObat = 0; // initialize total obat variable
                        @endphp
                        @foreach ($groupedObat as $tanggal => $items)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingObat-{{ $accordionIndex }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseObat-{{ $accordionIndex }}" aria-expanded="true" aria-controls="collapseObat-{{ $accordionIndex }}">
                                        Tanggal: {{ $tanggal }}
                                    </button>
                                </h2>
                                <div id="collapseObat-{{ $accordionIndex }}" class="accordion-collapse collapse @if($loop->first) show @endif" aria-labelledby="headingObat-{{ $accordionIndex }}" data-bs-parent="#accordionExampleObat">
                                    <div class="accordion-body">
                                        <div class="table-responsive">
                                            <table class="table card-table table-vcenter text-nowrap datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Jam</th>
                                                        <th>Nama Barang</th>
                                                        <th>Kode Barang</th>
                                                        <th>Jumlah</th>
                                                        <th>Aturan Pakai</th>
                                                        <th>Harga</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($items as $item)
                                                        <tr>
                                                            <td>{{ $item->jam }}</td>
                                                            <td>{{ $item->barang->nama_brng }}</td>
                                                            <td>{{ $item->barang->kode_brng }}</td>
                                                            <td>{{ $item->jml }}</td>
                                                            <td>
                                                                @foreach ($aturanPakai as $aturan)
                                                                    @if ($aturan->kode_brng == $item->barang->kode_brng)
                                                                        {{ $aturan->aturan }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                                        </tr>
                                                        @php
                                                            $totalObat += $item->total; // increment total obat
                                                        @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <p>Total Obat: {{ number_format($totalObat, 0) }}</p> <!-- display total obat -->
                                    </div>
                                </div>
                            </div>
                            @php
                                $accordionIndex++;
                            @endphp
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="card card-invoice">
                <div class="card-body">
                    <div class="table-responsive">
                        @unless($tindakanDr->isEmpty())
                            <h3 class="card-title">Tindakan Rawat Jalan Dokter</h3>
                            <table class="table table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th>Kode Jenis Perawatan</th>
                                        <th>Dokter</th>
                                        <th>Biaya Rawat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tindakanDr as $tindakan)
                                        <tr>
                                            <td>{{ $tindakan->jnsPerawatan->nm_perawatan }}</td>
                                            <td>{{ $tindakan->dokter->nm_dokter }}</td>
                                            <td>{{ number_format($tindakan->biaya_rawat, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Tidak ada tindakan Rawat Jalan Dokter.</p>
                        @endunless
            
                        @unless($tindakanDrPr->isEmpty() && $tindakanPr->isEmpty())
                            @if(!$tindakanDrPr->isEmpty())
                                <h5>Tindakan Rawat Jalan Dokter dan Perawat</h5>
                                <table class="table table-bordered mb-4">
                                    <thead>
                                        <tr>
                                            <th>Kode Jenis Perawatan</th>
                                            <th>Biaya Rawat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tindakanDrPr as $tindakan)
                                            <tr>
                                                <td>{{ $tindakan->jnsPerawatan->nm_perawatan }}</td>
                                                <td>{{ number_format($tindakan->biaya_rawat, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
            
                            @if(!$tindakanPr->isEmpty())
                                <h5>Tindakan Rawat Jalan Perawat</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Kode Jenis Perawatan</th>
                                            <th>Biaya Rawat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tindakanPr as $tindakan)
                                            <tr>
                                                <td>{{ $tindakan->jnsPerawatan->nm_perawatan }}</td>
                                                <td>{{ number_format($tindakan->biaya_rawat, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @endunless
                    </div>
                </div>
            </div>

            <div class="card card-invoice">
                <div class="card-body">
                    <div class="table-responsive">
                        <h3 class="card-title">Hasil Pemeriksaan Radiologi</h3>
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap datatable">
                                    <thead>
                                    <tr>
                                        
                                        <th>NIP</th>
                                        <th>Kd. Jenis Prw</th>
                                        <th>Tgl. Periksa</th>
                                        <th>Jam</th>
                                        <th>Dokter Perujuk</th>
                                        <th>Bagian RS</th>
                                        <th>Menejemen</th>
                                        <th>Biaya</th>
                                        <th>Kd. Dokter</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($periksaRadiologi as $result)
                                        <tr>
                                            <td>{{ $result->petugas->nama }}</td>
                                            <td>{{ $result->jnsPerawatanRadiologi->nm_perawatan }}</td>
                                            <td>{{ $result->tgl_periksa }}</td>
                                            <td>{{ $result->jam }}</td>
                                            <td>{{ $result->biaya }}</td>
                                            <td>{{ $result->kd_dokter }}</td>
                                            <td>{{ $result->status }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>

            <div class="card card-invoice">
                <div class="card-body">
                    <div class="table-responsive">
                        <h3 class="card-title">Hasil Bacaan Radiologi</h3>
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap datatable">
                                    <thead>
                                    <tr>
                                        <th>No. Rawat</th>
                                        <th>Tgl. Periksa</th>
                                        <th>Jam</th>
                                        <th>Hasil</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($hasilRadiologi as $result)
                                        <tr>
                                            <td>{{ $result->no_rawat }}</td>
                                            <td>{{ $result->tgl_periksa }}</td>
                                            <td>{{ $result->jam }}</td>
                                            <td>{{ $result->hasil }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-invoice">
                <div class="card-body">
                    <div class="table-responsive">
                        <h3 class="card-title">Hasil Pemeriksaan Laborat</h3>
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                <tr>
                                    <th>No. Rawat</th>
                                    <th>Kd. Jenis Prw</th>
                                    <th>Tgl. Periksa</th>
                                    <th>Jam</th>
                                    <th>ID Template</th>
                                    <th>Nilai</th>
                                    <th>Nilai Rujukan</th>
                                    <th>Keterangan</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($detailPeriksaLab as $result)
                                    <tr>
                                        <td>{{ $result->no_rawat }}</td>
                                        <td>{{ $result->kd_jenis_prw }}</td>
                                        <td>{{ $result->tgl_periksa }}</td>
                                        <td>{{ $result->jam }}</td>
                                        <td>{{ $result->templateLaboratorium->Pemeriksaan }}</td>
                                        <td>{{ $result->nilai }}</td>
                                        <td>{{ $result->nilai_rujukan }}</td>
                                        <td>{{ $result->keterangan }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>    
                
        </div>    
    </div>
</div>    
    <a href="{{ route('ralan.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
