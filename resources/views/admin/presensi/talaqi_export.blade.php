@extends('layout.admin')

@section('title')
    Export Talaqi
@endsection

@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" >Talaqi Export</a>
    </nav>

    @include('layout.dashboard.alert_flash')

    <div class="row">
        <div class="col-md-6">
            <div class="card card-block">
                <h4 class="card-title">Export Presensi Talaqi Fakultas</h4>
                <hr>
                <div class="col-md-12">
                    <form type="get">
                        <div class="form-group">
                            <label>Fakultas</label>
                            <select class="form-control" name="fakultas" required>
                                <option selected disabled>Pilih Fakultas</option>
                                @foreach($list_fakultas as $fakultas)
                                    <option value="{{ $fakultas->fakultas }}">{{ $fakultas->fakultas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                        <button type="submit" class="btn btn-primary">Download</button>
                            </div>
                    </form>
            </div>
        </div>
    </div>

    </div>
@endsection