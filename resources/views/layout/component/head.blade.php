<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
@include('layout.dashboard.meta_data')
<link rel="shortcut icon" href="{{ url('img/favicon.png') }}">

<title>@yield('title') | SIBIMA</title>

<!-- Icons -->
<link href="{{ url('bower_components/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ url('bower_components/sweetalert/dist/sweetalert.css') }}" rel="stylesheet">

<!-- Main styles for this application -->
<link href="{{ url('css/style-coreui.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bima.css') }}" rel="stylesheet">

@yield('css_addon')
