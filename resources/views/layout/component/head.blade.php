<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
@include('layout.dashboard.meta_data')
<link rel="shortcut icon" href="{{ url('img/favicon.png') }}">

<title>@yield('title') | SIBIMA</title>


<!-- Datatables Styling -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/r-2.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/datatables.css" />



<!-- Icons -->
<link href="{{ url('bower_components/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ url('bower_components/sweetalert/dist/sweetalert.css') }}" rel="stylesheet">

<!-- Main styles for this application -->
<link href="{{ url('css/style-coreui.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bima.css') }}" rel="stylesheet">

@yield('css_addon')