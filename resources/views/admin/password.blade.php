@extends('layout.admin')
@section('title')
    Ganti Password
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Ganti Password</a>
    </nav>

    @include('layout.dashboard.alert_flash')

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">

                <div class="card-header">
                    <strong>Ganti Password</strong>
                </div>

                <div class="card-block">
                    <form action="{{ url('/admin/password') }}" method="post">
                    {{csrf_field()}}
                        <div class="form-group">
                            <label class="control-label">Password Lama</label>
                            <input name="password-lama" type="password" class="form-control" required /> </div>
                            <div class="form-group">
                                <label class="control-label">Password Baru</label>
                                <input name="password-baru" type="password" class="form-control" required /> </div>
                        <div class="form-group">
                            <label class="control-label">Ketik Ulang Password Baru</label>
                            <input name="re-enter" type="password" class="form-control" required /> </div>
                        <div class="margin-top-10">
                            <button type="submit" class="btn btn-primary"> Ganti Password </button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>

@endsection