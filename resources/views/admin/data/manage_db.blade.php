@extends('layout.admin')
@section('title')
    Manage DB
@endsection
@section('js_addon')
    <script>
        $('.btn-remigrate').on('click', function(){
            var url = $(this).attr('url');
            var message = "Remigrate akan mereset kembali <strong style='font-weight: bold'>semua database</strong> seperti semula, termasuk " +
                            "<strong style='font-weight: bold'>backup, file materi, izin dll</strong>" +
                            "<br>kecuali data user admin<br><br>" +
                    "Fitur Ini Dikhususkan untuk pergantian semester <br><br>" +
                    "Note : SIBIMA akan berhenti (busy) dalam beberapa saat (2-5 Menit)";
            swal({
                title: "Are you sure?",
                text: message,
                html: true,
                type: "input",
                inputPlaceholder: "Masukan Password Rahasia",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "OK!",
                closeOnConfirm: false,
                inputPlaceHolder: "Masukkan Password Rahasia",
            },
            function(inputValue){
                if(inputValue === false) return false;
                else if(inputValue == "") {
                    swal.showInputError('Mohon isi password');
                    return false;
                } else{
                    window.location.href = url + "?password=" + inputValue;
                }
            });
        });
    </script>
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Upload Data</a>
    </nav>

    @include('layout.dashboard.alert_flash')


    <div class="card card-block">
            <h4 class="card-title">Manage Database - [Free Space {{ round(disk_free_space(base_path()) / (1000 * 1000), 2) }} MB]</h4>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <button url="{{ url('admin/data/manage-db/remigrate') }}" class="btn btn-danger btn-remigrate">Remigrate DB (SUPER DANGER)</button>
                <a href="{{ url('admin/data/manage-db/backup-now') }}" class="btn btn-primary">Backup Now</a>

            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama File</th>
                        <th>Size</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($backup_collection as $backup)
                @if($backup != "." && $backup != "..")
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $backup }}</td>
                    <td>
                        {{ round(filesize(base_path('storage/app/sibima-backup') . '/' . $backup) / (1000 * 1000), 2)}} MB
                    </td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ url('admin/data/manage-db/download') }}?file_name={{$backup}}">Download</a>
                    </td>
                </tr>
                @endif
                @endforeach

                </tbody>
            </table>
        </div>


    </div>

@endsection
