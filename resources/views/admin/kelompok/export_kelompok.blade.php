@extends('layout.admin')

@section('title')
    Export Kelompok
@endsection

@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" >Export Kelompok</a>
    </nav>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-block">
                <h4 class="card-title">Export Kelompok Fakultas</h4>
                <hr>
                <div class="col-md-12">
                    <form method="get" action="{{ url('admin/kelompok/export/data') }}">
                        <div class="form-group">
                            <label>Fakultas</label>
                            <select class="form-control" name="fakultas" required>
                                <option selected disabled>Pilih Fakultas</option>
                                @foreach($list_fakultas as $fakultas)
                                    <option value="{{ $fakultas->fakultas }}">{{ $fakultas->fakultas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelompok (Ikhwan/Akhwat)</label>
                            <select class="form-control" name="jk" required>
                                <option selected disabled>Select Filter</option>
                                <option value="1">Ikhwan</option>
                                <option value="2">Akhwat</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Download</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-block">
                <h4 class="card-title">Export Kelompok Jurusan</h4>
                <hr>
                <div class="col-md-12">
                    <form method="get" action="{{ url('admin/kelompok/export/data') }}">
                        <div class="form-group">
                            <label>Program Study</label>
                            <select class="form-control" name="prodi" required>
                                <option selected disabled>Pilih Program Studi</option>
                                @foreach($list_prodi as $jr)
                                    <option value="{{ $jr->program_studi }}">{{ $jr->program_studi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelompok(Ikhwan/Akhwat)</label>
                            <select class="form-control" name="jk" required>
                                <option selected disabled>Select Filter</option>
                                <option value="1">Ikhwan</option>
                                <option value="2">Akhwat</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Download</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection