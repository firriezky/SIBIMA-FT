@extends('layout.admin')
@section('title')
    Detail Mentee
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="{{ url('admin/data/mentee')}}">Data Mentee</a>
        <a class="breadcrumb-item">Detail</a>
    </nav>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-block">
                <div class="profile-header-container">
                    <div class="text-xs-center">
                        @if($mentee->jk == 1)
                            <img src="{{ url('img/avatar/avatar-sibima01.png') }}" class=" img-fluid profile-user"  alt="Responsive image">
                        @else
                            <img src="{{ url('img/avatar/avatar-sibimi01.png') }}" class=" img-fluid profile-user"  alt="Responsive image">
                        @endif
                        <p><strong>{{ $mentee->nama }}</strong></p>
                        <h5>{{ $mentee->fakultas }}</h5>
                        <h5>{{ $mentee->program_studi }}</h5>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-block p-a-1">
                    <h5 class="card-title text-xs-center">IDENTITAS MENTEE</h5>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group form-group">
                                <span class="input-group-addon"><span class="fa fa-vcard-o"></span> Nama</span>
                                <div class="form-control form-head">
                                    {{ $mentee->nama }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group form-group">
                                <span class="input-group-addon"><span class="fa fa-vcard-o"></span> NIM</span>
                                <div class="form-control form-head">
                                    {{ $mentee->nim }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group form-group">
                                <span class="input-group-addon"><span class="fa fa-vcard-o"></span> Jenis Kelamin</span>
                                <div class="form-control form-head">
                                    {{ $mentee->getJK() }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group form-group">
                                <span class="input-group-addon"><span class="fa fa-vcard-o"></span> Tahun Masuk</span>
                                <div class="form-control form-head">
                                    {{ $mentee->getTahunMasuk() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group form-group">
                                <span class="input-group-addon"><span class="fa fa-mobile-phone"></span> Nomer HP</span>
                                <div class="form-control form-head">
                                    {{ $mentee->no_telp or "-" }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group form-group">
                                <span class="input-group-addon"><span class="fa fa-comment-o"></span> ID Line</span>
                                <div class="form-control form-head">
                                    {{ $mentee->line_id or "-" }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group form-group">
                                <span class="input-group-addon"><span class="fa fa-vcard-o"></span> Kelompok</span>
                                <div class="form-control form-head">
                                    {{ $mentee->getKelompok->kode or "BELUM ADA KELOMPOK" }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group form-group">
                                <span class="input-group-addon"><span class="fa fa-vcard-o"></span> Kelas</span>
                                <div class="form-control form-head">
                                    {{ $mentee->kelas }}
                                </div>
                            </div>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection