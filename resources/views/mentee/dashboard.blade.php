@extends('layout.mentee')
@section('title') Dashboard @endsection

@section('css_addon')
    <link href="{{ url('bower_components/fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        h2 {
            font-size: 19px;
            margin-top: 15px !important;
        }

    </style>
@endsection

@section('js_addon')
    <script src="{{ url('bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ url('bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    <script>
        var data = JSON.parse('{!! $events->toJson() !!}');
        $('#calendar').fullCalendar({
            height: 415,
            events: data,
            eventColor: '#20a8d8',
            eventTextColor: 'white',
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'listWeek , month'
            },
            views: {
                listWeek: {
                    buttonText: 'weekly'
                }
            },
            defaultView: 'month',
            navLinks: true, // can click day/week names to navigate views
            eventLimit: true, // allow "more" link when too many events
            displayEventTime: false
        })

    </script>
@endsection

@section('content')

    @if ($kelompok == null)
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <strong>Maaf anda belum mempunyai Kelompok Mentoring, Harap hubungi Admin BM.</strong>
                </div>
            </div>
        </div>
    @endif

    @include('layout.dashboard.official_account')

    <div class="row">


        {{-- //Ramadhan Prada 2021  --}}
        <div class="col-md-12">
            <div class="card" style="width: 100%">
                <img class="" width="100%" src="{{ url('/img/sapa_pemuda.jpg') }}" alt="Card image cap">
                <div class="card-body" style="padding: 10px">
                </div>
            </div>
        </div>

        {{-- Penggumuman layout --}}
        <div class="col-md-7">
            <div class="card">
                <div class="card-block">
                    <h5><span class="fa fa-bullhorn"></span> Pengumuman</h5>
                    <hr>
                    @foreach ($pengumumans as $pengumuman)
                        <div class="article-clean">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="intro" style="margin-bottom: 20px">
                                            <h5 class="text-xs-center text-uppercase">{{ $pengumuman->judul }}</h5>
                                            <p class="text-xs-center"><span class="by">by</span> <a
                                                    style="color: #00aced">Badan Mentoring Admin</a> | <span class="date">
                                                    {{ $pengumuman->created_at }} </span></p>
                                            <div class="m-b-2">
                                                {!! $pengumuman->detail !!}
                                            </div>
                                            @if ($pengumuman->file_url != null)
                                                <img class="mx-auto d-block img-fluid img-thumbnail"
                                                    src="{{ url($pengumuman->file_url) }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    {{ $pengumumans->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>

        {{-- Kalender dan identitas --}}
        <div class="col-md-5">
            <div class="card">
                <div class="card-block p-a-1 clearfix">
                    <i class="icon-user bg-primary p-a-1 font-4xl m-r-1 pull-left"></i>
                    <h5 class="card-title">Identitas Mentor Anda</h5>
                    <hr>
                    <dl class="row">
                        <dt class="col-xs-4 font-weight-bold">Nama Mentor</dt>
                        <dd class="col-xs-8"> : {{ $kelompok->getMentor->nama or ' - ' }} </dd>

                        <dt class="col-xs-4">NIM</dt>
                        <dd class="col-xs-8"> : {{ $kelompok->getMentor->nim or ' - ' }}</dd>

                        <dt class="col-xs-4">Fakultas</dt>
                        <dd class="col-xs-8"> : {{ $kelompok->getMentor->fakultas or ' - ' }}</dd>

                        <dt class="col-xs-4 text-truncate">Nomor HP</dt>
                        <dd class="col-xs-8"> : {{ $kelompok->getMentor->no_telp or ' - ' }}</dd>

                        <dt class="col-xs-4 text-truncate">Link Group</dt>
                        <dd class="col-xs-8"> : {!! $kelompok->getMentor->line_id or ' - ' !!}</dd>
                    </dl>
                </div>
            </div>
            <div class="card">
                <div class="card-block p-a-1 clearfix">
                    <h5 class="card-title">Kalender ICB</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
