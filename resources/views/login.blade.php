<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" maximum-scale=1,
          user-scalable=no'>
    @include('layout.dashboard.meta_data')
    <link rel="shortcut icon" href="{{ url('img/favicon.png') }}">
    <title>Login | SIBIMA Badan Mentoring</title>
    <link href="{{ url('bower_components/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ url('bower_components/sweetalert/dist/sweetalert.css') }}" rel="stylesheet">
    <!-- Main styles for this application -->
    <link href="{{ url('css/style-coreui.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/bima.css') }}" rel="stylesheet">
    <style>
        body {
            background-size: cover;
        }

        .background-image {
            /*background-image: url('https://images.pexels.com/photos/6462611/pexels-photo-6462611.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260');*/
            background-image: url('https://image.freepik.com/free-vector/mandala-illustration_53876-81805.jpg');
            /*background-image: url('https://');*/
            margin: 0;
            background-repeat: no-repeat;
            position: fixed;
            left: 0 !important;
            right: 0 !important;
            z-index: 0;
            width: 100% !important;
            height: 100% !important;
            display: block;
            /* Center and scale the image nicely */
            background-position: center;
            background-size: cover;
            -webkit-filter: blur(2px);
            -moz-filter: blur(2px);
            -o-filter: blur(2px);
            -ms-filter: blur(2px);
            filter: blur(2px);
        }

        .login-card {
            border: 2px solid #1C6EA4;
            border-radius: 25px;
        }

        .bg-text {
            background-color: #FFFFFf; /* Fallback color */
            background-color: rgba(255, 255, 255, 0.4); /* Black w/opacity/see-through */
            color: white !important;
            font-weight: bold;
            border: 1px solid #f1f1f1;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            width: 100%;
            text-align: center;
        }

        footer {
            background-color: transparent !important;
            border: none !important;
        }
    </style>
    {!! Analytics::render() !!}
</head>
<body>
<div class="background-image"></div>
<div id="particles-js"></div>
<div class="container">
    <div class="row">
        <div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-xs-10 offset-xs-1 vamiddle">
            <div class="login-card bg-text">
                <div class="card-block">
                    <div class="form-box" id="login-box">
                        <div id="bima-look">
                            <div id="head-look"></div>
                            <div id="hand-look"></div>
                        </div>
                        <h1 class="text-xs-center mt-3 mb-2" style="color: #464646; font-family:'gloss'; ">
                            Sibima
                            @if(str_contains(url('/'), 'fkeb'))
                                FKEB
                            @endif
                            @if(str_contains(url('/'), 'fit'))
                                FIT
                            @endif
                            @if(str_contains(url('/'), 'fik'))
                                FIK
                            @endif
                            @if(str_contains(url('/'), 'ft'))
                                FT
                            @endif
                        </h1>
                        <h5 class="text-xs-center" style="color: #464646; font-family:'Quicksand'; margin-bottom:20px;">
                            Sistem Informasi Badan Mentoring<br/>Telkom University
                            <br>
                            @if(str_contains(url('/'), 'fkeb'))
                                Fakultas Ekonomi, Komunikasi dan Bisnis.
                            @endif
                            @if(str_contains(url('/'), 'fit'))
                                Fakultas Ilmu Terapan
                            @endif
                            @if(str_contains(url('/'), 'fik'))
                                Fakultas Industri Kreatif
                            @endif
                            @if(str_contains(url('/'), 'ft'))
                                Fakultas Teknik
                            @endif

                        </h5>
                        <form class="form" action="{{ url('/login') }}" method="post">
                            {{ csrf_field() }}
                            @include('layout.dashboard.alert_flash')
                            <div class="input-group mb-1">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" style="font-family: Quicksand" name="nim"
                                       placeholder="NIM" required>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" style="font-family: Quicksand"
                                       name="password" placeholder="Password"
                                       required>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <button style="font-family: Quicksand" type="submit" class="btn btn-primary  px-2">
                                        Login
                                    </button>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 ">
                                    <button style="font-family: Quicksand" type="button"
                                            onclick="swal('Hubungi OA Badan Mentoring Fakultas Teknik')"
                                            class="btn btn-link px-0 float-md-right">Forgot password?
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <br>
{{--                                <p style="font-family: Quicksand; color: black" class=""><strong>SIBIMA tersedia dalam--}}
{{--                                        versi Android <br> (beta version)</strong></p>--}}
{{--                                <a style="font-family: Quicksand" href="https://feylaboratory.xyz/sibima/">Download--}}
{{--                                    SIBIMA MOBILE</a>--}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
            <span class="text-left m-r-1">
            Badan Mentoring MPAI Tel-U © {{ \Carbon\Carbon::now()->year }}
            </span>
        {{--<span class="text-right">--}}
        {{--<a class="m-r-1" href="">About</a>--}}
        {{--<a class="m-r-1" href="">Terms</a>--}}
        {{--<a class="m-r-1" href="">Privacy</a>--}}
        {{--</span>--}}
    </footer>
</div>
<script src="{{ url("bower_components/jquery/dist/jquery.min.js")}}"></script>
<script>
    function verticalAlignMiddle() {
        var bodyHeight = $(window).height();
        var formHeight = $('.vamiddle').height();
        var marginTop = (bodyHeight / 2) - (formHeight / 2);
        if (marginTop > 0) {
            $('.vamiddle').css('margin-top', marginTop);
        }
    }

    verticalAlignMiddle();
    $(window).bind('resize', verticalAlignMiddle);
</script>
<script src="{{ url("bower_components/bootstrap/dist/js/bootstrap.min.js")}}"></script>
<script src="{{ url("bower_components/pace/pace.min.js")}}"></script>
<script src="{{ url("bower_components/particles.js/particles.min.js") }}"></script>
<script src="{{ url("bower_components/sweetalert/dist/sweetalert.min.js") }}"></script>
<script>
    particlesJS.load('particles-js', '{{ url('config/particlesjs-config.json') }}', function () {
        console.log('callback - particles.js config loaded');
    });
</script>
</body>
</html>

