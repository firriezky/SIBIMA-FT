@extends('layout.mentor')
@section('title') Quisioner @endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('mentor/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Kuesioner</a>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-block">
                <h4 class="card-title m-b-2">Daftar Kuesioner</h4>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th width="10px">#</th>
                            <th>Judul</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $skipped = ($list_questioner->currentPage() * $list_questioner->perPage())
                                - $list_questioner->perPage();?>
                        @foreach($list_questioner as $questioner)
                            <tr>
                                <td class="text-xs-center">{{ $skipped + $loop->iteration }}</td>
                                <td>{{$questioner->judul}}</td>
                                <td><a target="_blank" href="{{  $questioner->link }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-pencil-square"></i> Isi Kuesioner</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $list_questioner->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection