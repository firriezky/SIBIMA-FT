@extends('layout.mentee')

@section('title')
    Quisioner
@endsection

@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('mentee/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Daftar Kuesioner</a>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title m-b-2">Daftar Kuesioner</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm table-striped">
                                <thead>
                                <tr>
                                    <th class="text-xs-center">#</th>
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
                                        <td><a target="_blank" href="{{  $questioner->link }}" class="btn btn-primary"><i class="fa fa-pencil-square"></i> Isi Kuesioner </a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                            {{ $list_questioner->links('vendor.pagination.bootstrap-4') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection