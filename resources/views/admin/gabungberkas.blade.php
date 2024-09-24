<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Valex - Bootstrap 5 Premium Admin & Dashboard Template </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
	<meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="{{ asset('assets/js/authentication-main.js') }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" >

    <!-- Style Css -->
    <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet" >

    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" >


</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class=" main-content-body-invoice">
                    <div class="card card-invoice">
                        <div class="card-body">
                            <h1>Dokumen Digital untuk No. Rawat: {{ $no_rawat }}</h1>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>