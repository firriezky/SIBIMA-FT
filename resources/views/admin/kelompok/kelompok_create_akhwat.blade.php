@extends('layout.admin')

@section('title')
    Buat Kelompok Akhwat
@endsection

@section('js_addon')
    <script src="{{ url('js/lib/jquery.chained.remote.js') }}"></script>
    <script>

        $("#select-kelas").remoteChained({
            parents : "#select-jurusan",
            url : "{{ url('admin/api/get-kelas') }}",
            loading : "Loading...",
            clear : false,
            removePlaceholder : false
        });

        $("#select-mentee").remoteChained({
            parents : "#select-kelas",
            url : "{{ url('admin/api/get-mentee-akhwat') }}",
            loading : "Loading Mentee...",
            clear : true,
            bima_mode : true,
            append : true
        });

        var last_valid_selection = null;
        $("#select-mentee").change(function () {
            if ($(this).val().length > 13) {
                $(this).val(last_valid_selection);
                alert("Maximal 13 Mentee")
            } else {
                last_valid_selection = $(this).val();
                $('#counter').text($(this).val().length);
            }

        });

    </script>
@endsection

@section('content')

    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Kelompok</a>
        <a class="breadcrumb-item">Buat Kelompok Akhwat</a>
    </nav>

    @include('layout.dashboard.alert_flash')

    <div class="card card-block">
        <h4 class="card-title">Buat Kelompok Akhwat</h4>
        <hr>
        <form class="form" action="{{ url('admin/kelompok/create-akhwat') }}" method="post"
              id="form-create-kelompok-akhwat">

            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Mentor</label>
                        <select class="form-control" name="mentor" required>
                            <option disabled selected>PILIH MENTOR</option>
                            @foreach($list_mentor as $mentor)
                                <option value="{{ $mentor->id }}">
                                    {{ $mentor->fakultas }} -
                                    {{ ucwords(strtolower($mentor->nama)) }} -
                                    M {{ $mentor->total }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Asisten Mentor</label>
                        <select class="form-control" name="asisten">
                            <option selected>--</option>
                            @foreach($list_asisten as $asisten)
                                <option value="{{ $asisten->id }}">
                                    {{ $asisten->fakultas }} -
                                    {{ ucwords(strtolower($asisten->nama)) }} -
                                    A {{ $asisten->total }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <h5 class="card-title">Pilih Anggota</h5>
            <hr>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Program Study </label>
                        <select class="form-control" id="select-jurusan" name="jurusan" data-variable="bar">
                            <option value="">--</option>
                            @foreach($jurusan as $jr)
                                <option value="{{ $jr->program_studi }}">{{ $jr->program_studi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kelas </label>
                        <select class="form-control" id="select-kelas" name="kelas">
                            <option value="">--</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Mentee - Counter : <strong><span id="counter">0</span></strong> (Max 13)</label>
                <select style="height: 200px" class="form-control" id="select-mentee" name="mentee[]" multiple required>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>

@endsection