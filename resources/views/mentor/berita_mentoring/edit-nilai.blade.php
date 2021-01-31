@extends('layout.mentor')

@section('title') Edit Berita Mentoring @endsection

@section('content')

    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('mentor/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="{{ url('mentor/berita-mentoring')}}">Berita Mentoring</a>
        <a class="breadcrumb-item">Edit Berita Mentoring</a>
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
                    <form action="{{ url('mentor/berita-mentoring/edit') }}/{{ $agenda->id }}" method="post">
                        {{ csrf_field() }}
                        <div class="card card-block">
                            <h4 class="card-title">Edit Berita Mentoring {{ $kelompok->kode }}</h4>
                            <hr>
                            @include('layout.dashboard.form_edit_nilai_content', [
                                "kelompok" => $kelompok,
                                "berita_mentoring"  => $kelompok->getBeritaMentoring($agenda->id),
                                "agenda_id" => $agenda->id,
                            ])
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

    @else
        {{-- TAMPILKAN SEBAGAI ACCORDION JIKA KELOMPOK LEBIH DARI 1--}}
        @foreach($list_kelompok as $kelompok)
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ url('mentor/berita-mentoring/edit') }}/{{ $agenda->id }}" method="post">
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
                                @include('layout.dashboard.form_edit_nilai_content', [
                                    "kelompok" => $kelompok,
                                    "berita_mentoring"  => $kelompok->getBeritaMentoring($agenda->id),
                                    "agenda_id" => $agenda->id,
                                ])
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif

@endsection