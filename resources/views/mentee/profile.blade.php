@extends('layout.mentee')
@section('title')
    Edit Profile
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('mentee/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Profile</a>
    </nav>

    @include("layout.dashboard.alert_flash")

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="profile-header-container">
                    <div class="text-xs-center">
                        @if(strtolower(Auth::guard('mentee')->user()->jk) == 1)
                            <img src="{{ url('img/avatar/avatar-sibima01.png') }}" class="img-fluid profile-user" alt="Responsive image">
                        @else
                            <img src="{{ url('img/avatar/avatar-sibimi01.png') }}" class="img-fluid profile-user" alt="Responsive image">
                        @endif
                    </div>
                    <hr style="margin-bottom: 0px">
                    <div class="card-block">
                        <div class="text-xs-center">
                            <h5 class="card-title">{{ Auth::guard('mentee')->user()->nama }}</h5>
                            <h6 class="font-weight-bold">{{ Auth::guard('mentee')->user()->nim }}</h6>
                            <h6 class="font-weight-bold">{{ Auth::guard('mentee')->user()->kelas }}</h6>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-block">
                <form class="form" action="{{ url('mentee/profile') }}" method="post">
                {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label">Nama Lengkap </label>
                        <input type="text" placeholder="{{ Auth ::guard('mentee')->user()->nama }}" class="form-control" disabled> </div>

                    <div class="form-group">
                        <label class="control-label">Nomor HP</label>
                        <input name="no_telp" type="text" value="{{ Auth::guard('mentee')->user()->no_telp }}" class="form-control" ></div>
                    <div class="form-group">
                        <label class="control-label">ID Line</label>
                        <input name="line_id" type="text" value="{{ Auth::guard('mentee')->user()->line_id }}" class="form-control" ></div>
                    <div class="margiv-top-10">
                        <button class="btn btn-primary" type="submit"> Simpan Perubahan </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

@endsection