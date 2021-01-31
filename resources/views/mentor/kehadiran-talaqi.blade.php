@extends('layout.mentor')

@section('title')
    Kehadiran
@endsection

@section('content')

    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" >Kehadiran</a>
    </nav>

    <div class="card card-block">
        <h4 class="card-title m-b-2">Daftar Kehadiran</h4>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th width="10px">#</th>
                    <th>Agenda</th>
                    <th>Tanggal</th>
                    <th>Materi</th>
                    <th>Tempat</th>
                    <th>Keterangan</th>
                </tr>
                </thead>
                <tbody>
                @foreach($presensi_talaqi as $presensi)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $presensi['agenda']->judul }}</td>
                    <td>{{ $presensi['agenda']->tanggal_akhir }}</td>
                    <td>{{ $presensi['agenda']->materi }}</td>
                    <td>{{ $presensi['agenda']->tempat }}</td>

                    @if( $presensi['agenda']->isEnded() || $presensi['presensi'] != null)
                        @if( $presensi['presensi'] != null )
                            @if( !$presensi['presensi']->isTelat())
                                <td>
                                    <h6 class="m-b-0">
                                        <span class="tag tag-pill tag-success">Hadir</span>
                                    </h6>
                                <td>
                            @else
                                <td>
                                    <h6 class="m-b-0">
                                        <span class="tag tag-pill tag-warning">Hadir (Telat)</span>
                                    </h6>
                                <td>
                            @endif
                        @else
                        <td>
                            <h6 class="m-b-0">
                                <span class="tag tag-pill tag-danger">Tidak Hadir</span>
                            </h6>
                        <td>
                        @endif
                    @else
                        <td>
                            <h6 class="m-b-0">
                                <span class="tag tag-pill tag-default">Belum Dimulai</span>
                            </h6>
                        </td>
                    @endif

                </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection