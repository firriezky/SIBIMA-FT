@extends('layout.mentor')
@section('title')
    Edit Profile
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('mentor/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Profile Settings</a>
    </nav>

    @include('layout.dashboard.alert_flash')

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="profile-header-container">
                <div class="text-xs-center">
                    @if(strtolower(Auth::guard('mentor')->user()->jk) == 1)
                        <img src="{{ url('img/avatar/avatar-sibima03.png') }}" class="img-fluid profile-user"  alt="Responsive image">
                    @else
                        <img src="{{ url('img/avatar/avatar-sibima02.png') }}" class="img-fluid profile-user" alt="Responsive image">
                    @endif  
                </div>
                    <hr class="m-b-0">
                    <div class="card-block">
                        <div class="text-xs-center">
                        <h5 class="card-title">{{ Auth::guard('mentor')->user()->nama }}</h5>
                        <p class="font-weight-bold m-b-0">{{ Auth::guard('mentor')->user()->nim }}</p>
                        <p class="font-weight-bold">{{ Auth::guard('mentor')->user()->fakultas }}</p>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="col-sm-8">
        <div class="card">
            <div class="card-block">
                <form action="{{ url('mentor/profile') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label">Nama Lengkap </label>
                        <input type="text" placeholder="{{ Auth::guard('mentor')->user()->nama }}" class="form-control" disabled/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Nomor HP</label>
                        <input name="nomor_hp" type="text" value="{{ Auth::guard('mentor')->user()->no_telp }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Group Kelompok</label>
                        <input name="id_line" type="text" value="{{ Auth::guard('mentor')->user()->line_id }}" class="form-control" placeholder="Masukkan Link Group Anda" />
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Submit Perubahan</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>

@endsection