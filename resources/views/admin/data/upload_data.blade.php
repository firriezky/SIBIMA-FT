@extends('layout.admin')
@section('title')
    Upload Data
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Upload Data</a>
    </nav>

    <div class="row">

        <div class="col-md-6">
            <div class="card card-block">
                <h4 class="card-title">Upload Data Mentee</h4><hr>
                <p class="card-text"></p>
                <form class="form" action="{{ url('admin/data/upload') }}" method="post" enctype="multipart/form-data">

                    {{ csrf_field() }}

                    <div class="form-group">
                        <label>File input (.csv)</label>
                        <input type="file" class="form-control-file" name="csv_mentee">
                        <small class="form-text text-muted">Baca keterangan sample file excel <a href="#">berikut</a></small>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-block">
                <h4 class="card-title">Upload Data Mentor</h4><hr>
                <p class="card-text"></p>
                <form class="form" action="{{ url('admin/data/upload') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>File input (.csv)</label>
                        <input type="file" class="form-control-file" name="csv_mentor">
                        <small class="form-text text-muted">Baca keterangan sample file excel <a href="#">berikut</a></small>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    {{-- Table Format Information --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card  card-accent-primary">
                <div class="card-header card-header-inverse">
                    <p class="card-title title-collapse">Format File CSV Mentee</p>
                    <p class="card-text" style="color:#1c2d3f">Akan menolak tambahan attribut (Bold == Wajib Ada)</p>
                </div>
                <div class="card-block">
                    <div style="padding: 10px;" class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Header</th>
                                    <th>Input</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>1</td>
                                    <td><strong>NIM</strong></td>
                                    <td>Angka</td>
                                    <td>Contoh : 1301140171</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><strong>Nama</strong></td>
                                    <td>Huruf</td>
                                    <td>Contoh : Bambang Ari Wahyudi</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><strong>Kelas</strong></td>
                                    <td>Kode Kelas</td>
                                    <td>Contoh : IF-38-01</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><strong>Program_Studi</strong></td>
                                    <td>String - Nama Prodi</td>
                                    <td>Contoh : S1 Teknik Informatika</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td><strong>Fakultas</strong></td>
                                    <td>String - Nama Fakultas</td>
                                    <td>Contoh : INFORMATIKA</td>
                                </tr>

                                <tr>
                                    <td>6</td>
                                    <td><strong>JK</strong></td>
                                    <td>"Pria"/"Laki-laki" atau "Wanita"/"Perempuan"</td>
                                    <td>Format Header harus JK !, selain format diatas ditolak</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>No_Telp</td>
                                    <td>String</td>
                                    <td>Contoh : 081320380666</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Line_id</td>
                                    <td>String</td>
                                    <td>Contoh : bambang_wahyudi</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Table Format Information --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card  card-accent-primary">
                <div class="card-header card-header-inverse">
                    <p class="card-title title-collapse">Format File CSV Mentor</p>
                    <p class="card-text" style="color:#1c2d3f">Akan menolak tambahan attribut (Bold == Wajib Ada)</p>
                </div>
                <div class="card-block">
                    <div style="padding: 10px;" class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Header</th>
                                <th>Input</th>
                                <th>Keterangan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td>1</td>
                                <td><strong>NIM</strong></td>
                                <td>Angka</td>
                                <td>Contoh : 1301140171</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><strong>Nama</strong></td>
                                <td>Huruf</td>
                                <td>Contoh : Bambang Ari Wahyudi</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><strong>Fakultas</strong></td>
                                <td>String - Nama Fakultas</td>
                                <td>Contoh : INFORMATIKA</td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td><strong>JK</strong></td>
                                <td>"Pria"/"Laki-laki" atau "Wanita"/"Perempuan"</td>
                                <td>Format Header harus JK !, selain format diatas ditolak</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>No_Telp</td>
                                <td>String</td>
                                <td>Contoh : 081320380666</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Line_id</td>
                                <td>String</td>
                                <td>Contoh : bambang_wahyudi</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
