@extends('layout.mentor')

@section('title')
    Dashboard
@endsection

@section('css_addon')
    <link href="{{ url('bower_components/fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('css/timeline.css') }}" rel="stylesheet" type="text/css" />
    <style>
        h2 {
            font-size: 16px;
            margin-top: 15px !important;
        }
    </style>
@endsection

@section('js_addon')
    <script src="{{ url('bower_components/moment/min/moment.min.js') }}"  type="text/javascript"></script>
    <script src="{{ url('bower_components/fullcalendar/dist/fullcalendar.min.js') }}"  type="text/javascript"></script>
    <script>
        var data = JSON.parse('{!! $events->toJson() !!}');
        $('#calendar').fullCalendar({
            height: 450,
            events: data,
            eventColor: '#20a8d8',
            eventTextColor: 'white',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'listWeek , month'
            },
            views: {
                listWeek: { buttonText: 'weekly' }
            },
            defaultView: 'month',
            navLinks: true, // can click day/week names to navigate views
            eventLimit: true, // allow "more" link when too many events
            displayEventTime : false
        })
    </script>
@endsection

@section('content')

    @include('layout.dashboard.official_account')

    <div class="row">
          {{-- //Ramadhan Prada 2021  --}}
          <div class="col-md-12">
            <div class="card" style="width: 100%">
                <img class="" width="100%" src="{{ url('/img/sapa_pemuda.jpg') }}" alt="Card image cap">
            </div>
        </div>
    	<div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    {{-- Card Activity --}}
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Aktifitas Terbaru</h4>
                            <hr>
                            <div class="qa-message-list">
                                @foreach($latest_berita_mentoring as $berita)
                                <div class="message-item">
                                    <div class="message-inner">
                                        <div class="message-head clearfix">
                                            <div class="user-detail">
                                                <h7 class="message-title">{{ $berita->getKelompok->getMentor->nama }} | {{ $berita->getKelompok->getMentor->fakultas }}</h7>
                                                <div class="qa-message-content">
                                                    telah mengisi Berita {{ $berita->getAgenda->judul }}, Kelompok {{ $berita->getKelompok->kode }}
                                                </div>
                                                <div class="post-meta">
                                                    <div class="asker-meta">
                                                        <span class="qa-message-what"></span>
                                                        <span class="qa-message-when">
                                                            <span class="qa-message-when-data">{{ $berita->created_at }}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
        	<div class="card card-block">
		        <h4 class="card-title">Kalender ICB</h4>
		        <hr>
		        <div class="row">
		            <div class="col-md-12">
		                <div id='calendar'></div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>

@endsection