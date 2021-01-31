<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ url('img/favicon.png') }}">
    <link href="{{ url('css/style-coreui.min.css') }}" rel="stylesheet">

</head>
<body>

    <div class="container d-table">
        <div class="d-100vh-va-middle">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="clearfix">
                        <h1 class="float-xs-left display-3 mr-2">404</h1>
                        <h4 class="pt-1">Anda Tersesat.</h4>
                        <p class="text-muted">Mohon Maaf Halaman Yang Anda Cari Tidak Ditemukan</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="col-md-2 offset-md-5">
                <a href="{{ url('/') }}" class="btn btn-primary btn-block content-group">
                    <i class="icon-circle-left2 position-left"></i> Go Back</a>
            </div>
        </div>
    </div>

</body>
</html>
