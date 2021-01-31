@extends('layout.admin')

@section('title')
    Berita Mentoring Detail
@endsection

@section('content')

    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="{{ url('admin/berita-mentoring') }}">Berita Mentoring</a>
        <a class="breadcrumb-item">Edit</a>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <form action="{{ url('admin/berita-mentoring/edit') }}/{{ $agenda->id }}" method="post">
                {{ csrf_field() }}
                <div class="card card-block">
                    <h4 class="card-title">Edit Berita Mentoring {{ $kelompok->kode }}</h4>
                    <hr>
                    @include('layout.dashboard.form_edit_nilai_content', [
                        "kelompok" => $kelompok,
                        "berita_mentoring"  => $berita_mentoring,
                        "agenda_id" => $agenda->id,
                    ])
                </div>
            </form>
        </div>
    </div>

@endsection