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
                <img class="" width="100%" src="{{ url('/sembako_igracias.jpg') }}" alt="Card image cap">
                <div class="card-body" style="padding: 10px">
                    <h4 class="card-title">Hadiahkan Paket Sembako Ramadhan</h4>
                    <br>
                    <h5 class="card-text">
                        1 Minggu lagi Tamu Istimewa akan datang
                        Ramadhan akan membawa hadiah dan keberkahan untuk kita semua
                        Pastikan bahagia dan telah menyiapkan diri untuk perbanyak amalan
                        Mari hadiahkan 1.000 Paket Sembako untuk warga yang membutuhkan
                        karna setiap kebaikan di Bulan Ramadhan akan dilipatgandakan pahalanya
                        <br><br>
                        <strong> 1 paket hanya Rp. 75,000 saja </strong>
                        Yuk tunggu apalagi
                        <br><br>
                        www.lazissu.com <br>
                        @lazissu <br>
                        wa.me/6281314918127
                        <br><br>
                        Raih Kelengkapan Berkah di Bulan Ramadhan dengan Bersedekah <br><br>
                        <br>
                        Alhamdulillah... <br>
                        Hingga 6 April 2021 (H-7 Ramadhan) telah terkumpul : <br>
                        🥪 2.233 Paket Berbagi Buka (Setiap paketnya senilai Rp 20.000), di Targetkan 30.000 Paket Sekotak
                        Nasi disalurkan hingga 30 Ramadhan <br>
                        🎁 152 Paket Berbagi Sembako (Setiap paketnya senilai Rp 75.000), di Targetkan 1.000 Paket Berbagi
                        Sembako <br>
                        <br>
                        📬 Penyaluran bantuan untuk warga dhuafa di 8 Desa Sekitar Kampus Telkom, Kabupaten Bandung
                        <br> <br> <br>

                        Amankan Peluang anda dengan SEGERA BOOKING dan TRANSFER Donasi ke...  <br>
                        Rekening LAZIS Syamsul Ulum <br>
                        Rekening Bank Syariah Mandiri <br>
                        (kode bank 451) <br>
                        7137664447 <br>
                        a.n. LAZIS SYAMSUL ULUM <br>
                        <br>
                        Rekening Bank Mandiri
                        (kode bank 008)
                        131-00-1546633-9
                        a.n. LEMBAGA AMIL ZAKAT (LAZIS) SYAMSUL ULUM
                        <br>
                        Kirim bukti transfer klik aja wa.me/6281314918127 (admin Lazissu) 
                        <br>
                        “Siapa memberi makan orang yang berpuasa, maka baginya pahala seperti orang yang berpuasa tersebut,
                        tanpa mengurangi pahala orang yang berpuasa itu sedikit pun juga.”
                        <br>
                        #DKMSyamsululum
                        #LDKAlfath
                        #BMUniversitasTelkom
                        #MQMSU
                        #PRISMA
                        #LAZISSU
                    </h5>
                
                </div>
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