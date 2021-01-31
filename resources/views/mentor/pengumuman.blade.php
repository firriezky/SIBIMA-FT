@extends('layout.mentor')
@section('title')
    Pengumuman
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('mentor/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Pengumuman</a>
    </nav>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title"><span class="fa fa-bullhorn"></span> Pengumuman</h4>
                    <hr>
                    @foreach($list_pengumuman as $pengumuman)
                        <div class="article-clean">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="intro">
                                            <h5 class="text-xs-center">{{ $pengumuman->judul }}</h5>
                                            <p class="text-xs-center"><span class="by">by</span> <a style="color: #00aced">Admin Badan Mentoring </a><span class="date">| {{ $pengumuman->created_at }}</span></p>
                                            <div class="m-b-2">
                                                <p>{!! $pengumuman->detail !!}</p>
                                            </div>
                                            @if($pengumuman->file_url != null)
                                                <img class="mx-auto d-block img-fluid img-thumbnail img-responsive" src="{{ url($pengumuman->file_url)}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <hr>
                    @endforeach
                    {{ $list_pengumuman->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection('content')



