@extends('layout.admin')

@section('title')
    Generate Kelompok
@endsection

@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" >Generate Kelompok</a>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-block">
                <h4 class="card-title">Generate Kelompok by Fakultas</h4>
                <p class="card-title">Note : SIBIMA akan busy (sibuk) selama 2 - 3 menit</p>
                <hr>
                <div class="col-md-12">
                    <form type="get" action="{{ url('admin/kelompok/generate') }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fakultas Mentee</label>
                                    <select class="form-control" name="fakultas_mentee" required>
                                        <option selected disabled>Pilih Fakultas Mentee</option>
                                        @foreach($list_fakultas_mentee as $fakultas)
                                            <option value="{{ $fakultas->fakultas }}">{{ $fakultas->fakultas }} - {{ $fakultas->count }} Orang</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fakultas Mentor</label>
                                    <select class="form-control" name="fakultas_mentor" required>
                                        <option selected disabled>Pilih Fakultas Mentor</option>
                                        @foreach($list_fakultas_mentor as $fakultas)
                                            <option value="{{ $fakultas->fakultas }}">{{ $fakultas->fakultas }} - {{ $fakultas->count }} Orang</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select class="form-control" name="jk" required>
                                        <option selected disabled>Select Filter</option>
                                        <option value="1">Ikhwan</option>
                                        <option value="2">Akhwat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Batas Anggota PerKelompok</label>
                                    <input class="form-control" name="batas" type="number" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Generate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection