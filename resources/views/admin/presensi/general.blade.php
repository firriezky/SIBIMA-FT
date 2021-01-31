@extends('layout.admin')
@section('title')
    Presensi
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Presensi</a>
    </nav>

    @include('layout.dashboard.alert_flash')

    <div class="card card-block">
        <h4 class="card-title m-b-2">Presensi General</h4>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm">
                <thead>
                <tr>
                    <th class="text-xs-center">No.</th>
                    <th>Agenda</th>
                    <th>Fakultas</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Materi</th>
                    <th>Tempat</th>
                    <th style="width: 200px">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php $skipped = ($general_agenda->currentPage() * $general_agenda->perPage())
                        - $general_agenda->perPage();?>
                @foreach($general_agenda as $agenda)
                    <tr>
                        <td class="text-xs-center">{{ $skipped + $loop->iteration }}</td>
                        <td>{{ $agenda->judul }}</td>
                        <td>{{ $agenda->fakultas }}</td>
                        <td>{{ $agenda->tanggal_akhir }}</td>
                        @if( $agenda->isEnded() )
                            <td><h6 class="m-b-0"><span class="tag tag-pill tag-default">Selesai</span></h6></td>
                        @else
                            <td><h6 class="m-b-0"><span class="tag tag-pill tag-primary">Berjalan</span></h6></td>
                        @endif
                        <td>{{ $agenda->materi or "-" }}</td>
                        <td>{{ $agenda->tempat or "-" }}</td>
                        <td>
                            <a class="btn btn-success btn-sm" target="_blank" href="{{ url('admin/presensi/general/input')}}/{{ $agenda->id }}">Input</a>
                            <a class="btn btn-primary btn-sm" target="_blank" href="{{ url('admin/presensi/general/detail')}}/{{ $agenda->id }}">Detail Presensi</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $general_agenda->links('vendor.pagination.bootstrap-4') }}

    </div>
@endsection