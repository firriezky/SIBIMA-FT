@extends('layout.admin')
@section('title')
    Detail Pengumuman
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/')}}">Dashboard</a>
        <a class="breadcrumb-item" href="{{ url('admin/pengumuman')}}">Pengumuman</a>
        <a class="breadcrumb-item">Detail Penggumuman</a>
    </nav>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title"><span class="fa fa-bullhorn"></span> Pengumuman</h4>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="intro">
                                <h4 class="text-xs-center">{{ $pengumuman->judul }}</h4>
                                <p class="text-xs-center"><span class="by">by</span>
                                    <a style="color: #00aced">BM Admin</a> |
                                    <span class="date">{{ $pengumuman->created_at }}</span>
                                </p>
                                <div class="text-justify">
                                    <p>{!! $pengumuman->detail !!}</p>
                                </div>
                                @if($pengumuman->file_url != null)
                                <img class="mx-auto d-block img-fluid img-thumbnail img-responsive"
                                     src="{{ url($pengumuman->file_url)}}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection('content')



