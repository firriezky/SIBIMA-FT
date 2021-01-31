<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export Berita Acara | SIBIMA</title>

    <!-- Main styles for this application -->
    <link href="{{ public_path('css/style-coreui.min.css') }}" rel="stylesheet">
    <style>
        .page-break {
            page-break-after: always;
        }

        body {
            font-size: 70%;
            background-color: #FFFFFF;
        }

        .m-b-0 {
            margin-bottom: 0 !important;
        }

    </style>
</head>

<body>
@foreach($list_kelompok as $kelompok)
    @if($kelompok->getBeritaMentoring($agenda_mentoring->id) != null)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="text-xs-center" style="margin-bottom: 10px">
                            <img src="{{ public_path('/img/bima/logo_badan_mentoring_sd.png') }}" style="height: 200px">
                        </div>

                        <h4 class="text-xs-center"> Berita Acara Mentoring Agama Islam<br></h4>

                            <div>
                                <h4 class="text-xs-center" style="height: 30px">Kelompok {{ $kelompok->kode }}</h4>
                                {{--<hr style="height: 10px">--}}                         <hr>

                                <div>
                                    <div class="col-xs-6">
                                        <div class="input-group form-group">
                                            <span class="input-group-addon">Agenda</span>
                                            <div class="form-control form-head">
                                                {{ $agenda_mentoring->judul }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="input-group form-group">
                                            <span class="input-group-addon"><span></span> Tanggal</span>
                                            <div class="form-control form-head">
                                                {{ $kelompok->getBeritaMentoring($agenda_mentoring->id)->tanggal }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="input-group form-group">
                                            <span class="input-group-addon"><span></span> Materi</span>
                                            <div class="form-control form-head">
                                                {{ $kelompok->getBeritaMentoring($agenda_mentoring->id)->materi }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="input-group form-group">
                                            <span class="input-group-addon"><span></span>Tempat</span>
                                            <div class="form-control form-head">
                                                {{ $kelompok->getBeritaMentoring($agenda_mentoring->id)->tempat }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-bordered table-sm">
                                    <thead>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th width="15">Mentoring</th>
                                    <th width="80">Kultum</th>
                                    </thead>
                                    <tbody>
                                    @foreach($kelompok->getBeritaMentoring($agenda_mentoring->id)->getNilaiMentee() as $nilai)
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

                                <div class="text-xs-right">
                                    <p style="margin-top: 20px"class="m-b-0">Bandung, {{\Carbon\Carbon::now()}}</p>
                                    <p style="margin-bottom: 80px">Mengetahui Mentor ICB</p>
                                    <p>{{ $kelompok->getMentor->nama }}</p>
                                </div>

                                <p class="text-xs-left"><em>Berita Acara Mentoring ini asli dan wajib di cetak untuk dibawa pada saat pengambilan gaji mentor</em></p>
                                <hr>
                                <p class="text-xs-left m-b-0">Berita Acara Mentoring dicetak pada tanggal {{\Carbon\Carbon::now()}} oleh-<strong> {{ $kelompok->getMentor->nama }}</strong></div>

                            </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Page Break Style--}}
        <div class="page-break"></div>
    @else
        <div class="alert alert-danger">
            <h3><strong>{{ $kelompok->kode }} Belum Input Berita Mentoring untuk Agenda Ini, harap hubungi Admin BM untuk Input #IniAmanahku</strong></h3>
        </div>
    @endif

@endforeach
</body>

</html>