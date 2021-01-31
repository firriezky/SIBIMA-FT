@extends('layout.admin')
@section('title')
    Edit Mentor
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="{{ url('admin/data/mentor')}}">Data Mentor</a>

        <a class="breadcrumb-item">Edit</a>
    </nav>

    @include('layout.dashboard.alert_flash')

    <div class="card card-block">
        <h4 class="card-title">Edit Data Mentor</h4>
        <hr>
        <form class="form" action="{{ url('admin/data/mentor/edit/') }}/{{ $mentor->id }}" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-6">

                    <div class="form-group">
                        <label>NIM</label>
                        <input class="form-control" name="nim" value="{{ $mentor->nim }}" required>
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input class="form-control" name="nama" value="{{ $mentor->nama }}" required>
                    </div>

                    <div class="form-group">
                        <label>Fakultas</label>
                        <select class="form-control" name="fakultas" required>
                            @foreach($list_fakultas as $fakultas)
                                <option value="{{ $fakultas->fakultas }}" {{ $mentor->fakultas == $fakultas->fakultas ? "selected" : "" }}
                                >{{ $fakultas->fakultas }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Line ID</label>
                        <input class="form-control" name="line_id" value="{{ $mentor->line_id }}">
                    </div>

                    <div class="form-group">
                        <label>JK</label>
                        <select class="form-control" name="jk" required>
                            <option value="1" {{ 1 == $mentor->jk ? "selected" : ""}}>Ikhwan</option>
                            <option value="2" {{ 2 == $mentor->jk ? "selected" : ""}}>Akhwat</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>No Telephone</label>
                        <input class="form-control" name="no_telp" value="{{ $mentor->no_telp }}">
                    </div>

                </div>

            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

    </div>

@endsection
