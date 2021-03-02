@extends('layout.mentor')

@section('title') Input Berita Mentoring @endsection

@section('css_addon')
    <link rel="stylesheet" href="{{ url('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" />
@endsection

@section('js_addon')
    <script src="{{ url("bower_components/moment/min/moment.min.js") }}"></script>
    <script src="{{ url("bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js") }}"></script>
    <script>
        $('.date-picker').datetimepicker({
            maxDate: new Date(),
            format: 'DD/MM/YYYY HH:mm',
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-calendar-check-o',
                clear: 'fa fa-trash-o',
                close: 'fa fa-close'
            }
        });
    </script>
@endsection

@section('content')

    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('mentor/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="{{ url('mentor/berita-mentoring')}}">Berita Mentoring</a>
        <a class="breadcrumb-item">Input Berita Mentoring</a>
    </nav>

    @include('layout.dashboard.alert_flash')

    @if($list_kelompok->count() == 0)

        {{-- ALERT TIDAK ADA KELOMPOK --}}
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger" role="alert">
                            <strong>Belum terdapat Kelompok Mentoring</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif($list_kelompok->count() == 1)

        {{-- TAMPILKAN SINGLE TABLE JIKA KELOMPOK 1 --}}
        @foreach($list_kelompok as $kelompok)
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ url('mentor/berita-mentoring/input') }}/{{ $agenda->id }}" method="post">
                        {{ csrf_field() }}
                        <div class="card card-block">
                            <h4 class="card-title">Input Berita Mentoring {{ $kelompok->kode }}</h4>
                            <hr>
                            @include('layout.dashboard.form_input_nilai_content', [
                                "kelompok" => $kelompok
                            ])
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

    @else
        {{-- TAMPILKAN SEBAGAI ACCORDION JIKA KELOMPOK LEBIH DARI 1--}}
        @foreach($list_kelompok as $kelompok)
            @if($agenda->isKelompokBeritaExist($kelompok->id))
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success" role="alert">
                                    Berita Mentoring Kelompok {{ $kelompok->kode }} <strong> sudah diinput</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ url('mentor/berita-mentoring/input') }}/{{ $agenda->id }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card card-default">
                                <div class="card-header card-header-inverse">
                                    <a data-toggle="collapse" href="#collapse{{ $kelompok->kode }}">
                                        <p class="title-collapse">Berita Mentoring -  Kelompok {{ $kelompok->kode }}</p>
                                    </a>

                                    <div class="card-actions">
                                        <a class="btn-minimize collapsed" data-toggle="collapse" href="#collapse{{ $kelompok->kode }}">
                                            <i class="fa fa-arrow-down"></i>
                                        </a>
                                    </div>
                                </div>
                                <div id="collapse{{ $kelompok->kode }}" class="collapse card-block">
                                    @include('layout.dashboard.form_input_nilai_content', [
                                        "kelompok" => $kelompok
                                    ])
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        @endforeach
    @endif

@endsection