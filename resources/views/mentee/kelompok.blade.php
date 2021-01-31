@extends('layout.mentee')

@section('title')
    Kelompok
@endsection

@section('content')

    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('mentee/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Kelompok</a>
    </nav>

    @if($kelompok == null)
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <strong>Maaf anda belum mempunyai Kelompok Mentoring, Harap hubungi Admin BM</strong>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title"> Data Kelompok {{ $kelompok->kode }}</h4>
                        <hr>

                        {{-- Table & Head Data Kelompok Dipisah --}}
                        @include('layout.dashboard.kelompok_content', [
                            "kelompok" => $kelompok
                        ])

                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection