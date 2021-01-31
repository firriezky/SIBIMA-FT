@extends('layout.mentee')
@section('title')
    Tugas Besar
@endsection

@section('content')

    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('mentee/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Tugas Besar</a>
    </nav>

    {{-- Belum Punya Kelompok Handler --}}
    @if($kelompok == null)
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <strong>Maaf anda belum mempunyai Kelompok Mentoring, Harap hubungi Admin BM</strong>
                </div>
            </div>
        </div>

    {{-- Handler buat Agenda Tubes, apakah sudah dibuka atau belumz --}}
    @elseif($agenda_tubes == null)
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    <strong>Agenda Tugas Besar belum dibuka.</strong>
                </div>
            </div>
        </div>

    @else

        <div class="row">
        {{-- Handler Kelompok telah submit tugas besar --}}
        {{-- Dan Tampilkan data yang telah disubmit--}}
        @if($kelompok->isAlreadySubmitTugasBesar())
            <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                    <strong>Kelompok Anda telah submit Tugas Besar.</strong>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Nilai Shining Team</h4>
                        <hr>
                        <div>
                            <div class="col-xs-12">
                                <div class="input-group form-group">
                                    <span class="input-group-addon input-group-head ">Judul</span>
                                    <div class="form-control form-head">
                                        {{ $kelompok->getTugasBesar->judul }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="input-group form-group">
                                    <span class="input-group-addon input-group-head ">Deskirpsi</span>
                                    <div class="form-control form-head">
                                        {{ $kelompok->getTugasBesar->deskripsi }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="input-group form-group">
                                    <span class="input-group-addon input-group-head ">Link Tubes</span>
                                    <div class="form-control form-head">
                                        {{ $kelompok->getTugasBesar->video_link}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="input-group form-group">
                                    <span class="input-group-addon input-group-head ">Fakultas</span>
                                    <div class="form-control form-head">
                                        {{ $kelompok->getTugasBesar->fakultas}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="input-group form-group">
                                    <span class="input-group-addon input-group-head ">Nilai</span>
                                    <div class="form-control form-head">
                                        {{ $kelompok->getTugasBesar->nilai or "BELUM DIPROSES" }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else

            @if($agenda_tubes->isEnded())
                <div class="col-md-12">
                    <div class="alert alert-danger" role="alert">
                        <strong>Agenda Tugas Besar telah ditutup.</strong> <br>
                        {{--<strong>Mohon Hubungi Admin BM untuk Telat Input!.</strong>--}}
                    </div>
                </div>
            @else
                {{-- Tampilkan Form Submit Tugas Besar--}}
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Tugas Besar Shining Team</h4>
                            <hr>
                            <form class="form" action="{{ url('mentee/tugas-besar') }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="control-label">Judul Tugas Besar</label>
                                    <input type="text" class="form-control" required name="judul"/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Link Tugas Besar Video/Poster/Karya Lain</label>
                                    <input type="text" class="form-control" placeholder="ex : https://www.youtube.com/watch?v=ulr0muQKjk0" required name="video_link"/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Deskripsi Singkat</label>
                                    <textarea type="text" class="form-control" required name="deskripsi" ></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Fakultas</label>
                                    <select class="form-control" name="fakultas" required>
                                        <option selected disabled>Pilih Fakultas</option>
                                        @foreach($list_fakultas_mentee as $fakultas)
                                            <option value="{{ $fakultas->fakultas }}">{{ $fakultas->fakultas }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div>
                                    <small class="form-text text-danger">Note : Sebelum mengklik submit pastikan Link Video dan Data anda benar,<br> karena jika anda sudah mengsubmit maka anda tidak bisa mengsubmit ulang lagi </small>
                                    <br>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit"> Kirim </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        {{-- Handler Tampilkan Latest submit jika agenda sudah dibuka--}}
            <div class="col-md-5">
                <div class="card card-block">
                    <h4 class="card-title text-xs-center m-b-1">Terakhir Submit</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <tbody>
                            @foreach($latest_tugas_besar as $tubes)
                                <tr>
                                    <td style="text-align: center">
                                        <a href="{{ $tubes->video_link }}" target="_blank">
                                            {{ $tubes->getKelompok->kode }} - {{ $tubes->judul }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    @endif

@endsection