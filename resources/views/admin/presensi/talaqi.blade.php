@extends('layout.admin')
@section('title')
    Talaqi Madah
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Talaqi</a>
    </nav>

    @include('layout.dashboard.alert_flash')

    <div class="card card-block">
        <h4 class="card-title m-b-2">Talaqi Maddah</h4>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm">
                <thead>
                <tr>
                    <th class="text-xs-center">No.</th>
                    <th>Agenda</th>
                    <th>Fakultas</th>
                    <th>Tanggal</th>
                    <th>Materi</th>
                    <th>Tempat</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php $skipped = ($talaqi_agenda->currentPage() * $talaqi_agenda->perPage())
                        - $talaqi_agenda->perPage();?>
                @foreach($talaqi_agenda as $agenda)
                    <tr>
                        <td class="text-xs-center">{{ $skipped + $loop->iteration }}</td>
                        <td>{{ $agenda->judul }}</td>
                        <td>{{ $agenda->fakultas }}</td>
                        <td>{{ $agenda->tanggal_akhir }}</td>
                        <td>{{ $agenda->materi }}</td>
                        <td>{{ $agenda->tempat }}</td>
                        <td>
                            <a class="btn btn-success btn-sm" target="_blank"
                               href="{{ url('admin/presensi/talaqi/input')}}/{{ $agenda->id }}">Input</a>
                            <a class="btn btn-primary btn-sm" target="_blank"
                               href="{{ url('admin/presensi/talaqi/detail')}}/{{ $agenda->id }}">Detail Presensi</a>
                        </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $talaqi_agenda->links('vendor.pagination.bootstrap-4') }}

    </div>
@endsection