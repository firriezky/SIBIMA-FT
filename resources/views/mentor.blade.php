<!--
 * CoreUI - Open Source Bootstrap Admin Template
 * @version v1.0.0-alpha.2
 * @link http://coreui.io
 * Copyright (c) 2016 creativeLabs Łukasz Holeczek
 * @license MIT
 -->
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
            /*background-image: url('https://image.freepik.com/free-vector/mandala-illustration_53876-81805.jpg')  ;*/
            background-image: url('https://png.pngtree.com/thumb_back/fw800/background/20200408/pngtree-islamic-background-in-flat-style-image_333578.jpg')  ;
            /*background-image: url('https://');*/
            margin: 0;
            background-repeat: no-repeat;
            position: fixed;
            left: 0 !important;
            right: 0 !important;
            z-index: 0;
            width:100% !important;
            height:100% !important;
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

        .login-card{
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
                        </div>
                        <h1 class="text-xs-center mt-3 mb-2" style="color: #464646; font-family:'gloss'; ">Dept Mentor</h1>
                        <h5 class="text-xs-center" style="color: #464646; font-family:'Quicksand'; margin-bottom:20px;">
                            Departemen Mentor Pusat Badan Mentoring</h5>
                        <div class="row">
                            <p style="font-family: Quicksand; color: black" class="" ><strong>Fakultas Asal Mentor : </strong></p>
                        </div>
                        <a href="{{url('/mentor-2021/teknik')}}"><button  style="font-family: Quicksand"  class="btn btn-primary btn-block px-2">Fakultas Teknik (FT-FRI-FIF)</button></a>
                        <a href="{{url('/mentor-2021/FIK')}}"><button  style="font-family: Quicksand"  class="btn btn-primary btn-block mt-1 px-2">Fakultas Industri Kreatif (FIK)</button></a>
                        <a href="{{url('/mentor-2021/FIT')}}"><button  style="font-family: Quicksand"  class="btn btn-primary btn-block mt-1 px-2">Fakultas Ilmu Terapan (FIT)</button></a>
                        <a href="{{url('/mentor-2021/FKEB')}}"><button  style="font-family: Quicksand"  class="btn btn-primary btn-block mt-1 px-2">FKEB</button></a>

                        <form class="form" action="{{ url('/login') }}" method="post">
                            {{ csrf_field() }}

                            @include('layout.dashboard.alert_flash')


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