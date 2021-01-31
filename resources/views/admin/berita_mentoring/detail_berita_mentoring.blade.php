@extends('layout.admin')

@section('title')
    Berita Mentoring Detail
@endsection

@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="{{ url('admin/berita-mentoring') }}">Berita Mentoring</a>
        <a class="breadcrumb-item">Detail</a>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    <div class="card-title"><h4>Kelompok : {{ $berita_mentoring->getKelompok->kode }}</h4></div>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group form-group">
                                <span class="input-group-addon"><span></span> Agenda</span>
                                <div class="form-control form-head">
                                    {{ $berita_mentoring->getAgenda->judul }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group form-group">
                                <span class="input-group-addon"><span></span>Tempat</span>
                                <div class="form-control form-head">
                                    {{ $berita_mentoring->tempat }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group form-group">
                                <span class="input-group-addon"><span></span> Mentor</span>
                                <div class="form-control form-head">
                                    {{ $berita_mentoring->getKelompok->getMentor->nama }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group form-group">
                                <span class="input-group-addon"><span></span> Materi</span>
                                <div class="form-control form-head">
                                    {{ $berita_mentoring->materi }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group form-group">
                                <span class="input-group-addon"><span></span> Tanggal</span>
                                <div class="form-control form-head">
                                    {{ $berita_mentoring->tanggal }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group form-group">
                                <span class="input-group-addon"><span></span>Kultum</span>
                                <div class="form-control form-head">
                                    {{ $berita_mentoring->materi_kultum }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th width="15">Mentoring</th>
                                    <th width="80">Kultum</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($berita_mentoring->getNilaiMentee() as $nilai)
                                <tr>
                                    <input type="number" name="nilai_id[]"
                                           value="{{ $nilai->id }}" style="display: none">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $nilai->nim }}</td>
                                    <td>{{ $nilai->nama }}</td>
                                    <td>{{ $nilai->kelas }}</td>
                                    <td>{{ $nilai->kehadiran }}</td>
                                    <td>{{ $nilai->kultum }} </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection