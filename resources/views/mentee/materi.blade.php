@extends('layout.mentee')
@section('title')
    Materi
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('mentee/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Daftar Materi</a>
    </nav>
    <div class="card card-block">
        <h4 class="card-title m-b-2">Daftar Materi</h4>
        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover">
                <thead>
                <tr>
                    <th class="text-xs-center">#</th>
                    <th>Judul Materi</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php $skipped = ($list_materi->currentPage() * $list_materi->perPage())
                        - $list_materi->perPage();?>
                @foreach($list_materi as $materi)
                    <tr>
                        <td class="text-xs-center">{{ $skipped + $loop->iteration }}</td>
                        <td>{{$materi->nama}}</td>
                        <td><a target="_blank" href="{{ url('/') }}/{{ $materi->file_url }}" class="btn btn-primary"><span class="fa fa-download"></span> Unduh</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $list_materi->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection