@extends('layout.admin')
@section('title')
    Edit Mentee
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="{{ url('admin/data/mentee')}}">Data Mentee</a>

        <a class="breadcrumb-item">Edit</a>
    </nav>

    @include('layout.dashboard.alert_flash')

    <div class="card card-block">
        <h4 class="card-title">Edit Data Mentee</h4>
        <hr>
        <form class="form" method="post" action="{{ url('admin/data/mentee/edit/') }}/{{ $mentee->id }}">
        {{csrf_field()}}
            <div class="row">
                <div class="col-sm-6">

                    <div class="form-group">
                        <label>NIM</label>
                        <input class="form-control" name="nim" value="{{ $mentee->nim }}" required>
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input class="form-control" name="nama" value="{{ $mentee->nama }}" required>
                    </div>

                    <div class="form-group">
                        <label>Fakultas</label>
                        <select class="form-control" name="fakultas" required>
                            @foreach($fakultas_all as $fakultas)
                                <option value="{{ $fakultas->fakultas }}" {{ $mentee->fakultas == $fakultas->fakultas ? "selected" : "" }}>{{ $fakultas->fakultas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label> Program Studi</label>
                        <select class="form-control" name="prodi" required>
                            @foreach($prodi_all as $prodi)
                                <option value="{{ $prodi->program_studi }}" {{ $mentee->program_studi == $prodi->program_studi ? "selected" : ""}}>{{ $prodi->program_studi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Line ID</label>
                        <input class="form-control" name="line_id" value="{{ $mentee->line_id }}">
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select class="form-control" name="jk" required>
                            <option value="1" {{ $mentee->jk == 1 ? "selected" : "" }}>Ikhwan</option>
                            <option value="2" {{ $mentee->jk == 2 ? "selected" : "" }}>Akhwat</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>No Telephone</label>
                        <input class="form-control" name="no_telp" value="{{ $mentee->no_telp }}">
                    </div>

                    <div class="form-group">
                        <label>Kelas</label>
                        <select class="form-control" name="kelas" required>
                        @foreach($kelas_all as $kelas)
                            <option value="{{ $kelas->kelas }}" {{ $mentee->kelas == $kelas->kelas ? "selected" : ""}}>{{ $kelas->kelas }}</option>
                        @endforeach
                        </select>
                </div>

            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

    </div>

@endsection
