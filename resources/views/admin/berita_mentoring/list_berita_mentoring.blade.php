@extends('layout.admin')

@section('title')
    Berita Acara
@endsection

@section('js_addon')
    <script>
        $('.btn-delete').on('click', function () {
            var url = $(this).attr('data-url');
            swal({
                title: "Are you sure?",
                text: "Penghapusan Berita Mentoring, data Nilai Mentee terkait",
                type: "input",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, hapus saja",
                closeOnConfirm: false,
                inputPlaceholder: "Masukan Password Rahasia"
            },
            function(inputValue){
                if (inputValue === false)
                    return false;
                else if (inputValue == ""){
                    swal.showInputError("Jangan Kosong hiks / Masukkan Angka!");
                    return false
                } else {
                    window.location.href = url + "?password=" + inputValue;
                }

            }
            );
        });

    </script>
@endsection

@section('content')

<nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
    <a class="breadcrumb-item" >Berita Mentoring</a>
</nav>

@include('layout.dashboard.alert_flash')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block">

            {{--<a href="{{ url('admin/berita-mentoring/export/data?jk=akhwat') }}" class="btn btn-sm btn-primary pull-right">Export Akhwat <span class="fa fa-female"></span></a>--}}
            {{--<a style="margin-right: 10px" href="{{ url('admin/berita-mentoring/export/data?jk=ikhwan') }}" class="btn btn-sm btn-primary pull-right">Export Ikhwan <span class="fa fa-male"></span></a>--}}
            <h4 class="card-title">Daftar Berita Acara Mentor</h4>
            <hr>
            <button data-toggle="modal" data-target="#input-telat"
                    class="btn btn-danger">Input Berita Mentoring [Telat]
            </button>
            <hr>

            {{-- Filter & Search Row --}}
            <form method="get" class="form">
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="row">
                            <div style="padding-right: 0px" class="col-xs-7">
                                <div class="form-group">
                                    <select class="form-control" name="jk">
                                        <option selected value="">Select Filter</option>
                                        <option value="1" {{ $jk == 1 ? "selected" : "" }}>Ikhwan</option>
                                        <option value="2" {{ $jk == 2 ? "selected" : "" }}>Akhwat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-5">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 float-md-right float-sm-none">
                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   placeholder="Search by Kelompok / Mentor / Agenda"
                                   name="search" value="{{ $query or "" }}">
                        </div>
                    </div>
                </div>
            </form>

            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th class="text-xs-center">No</th>
                    <th class="text-xs-center">Kelompok</th>
                    <th>Mentor</th>
                    <th>Agenda</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php Date::setLocale('id'); ?>
                <?php $skipped = ($list_berita_mentoring->currentPage() * $list_berita_mentoring->perPage()) - $list_berita_mentoring->perPage(); ?>
                @foreach($list_berita_mentoring as $berita)
                    <tr>
                        <td class="text-xs-center">{{$skipped + $loop->iteration}}</td>
                        <td class="text-xs-center">{{ $berita->kode }}</td>
                        <td>{{ $berita->mentor_nama }}</td>
                        <td>{{ $berita->judul }}</td>
                        <td>{{ Jenssegers\Date\Date::parse($berita->tanggal)->format('l, j F Y - H:i') }}</td>
                        <td>
                            <a href="{{ url('admin/berita-mentoring') }}/{{ $berita->id }}" class="btn btn-sm btn-primary">Detail</a>
                            <a href="{{ url('admin/berita-mentoring/edit') }}/{{ $berita->id }}" class="btn btn-sm btn-warning">Edit</a>
                            <button data-url="{{ url('admin/berita-mentoring/delete') }}/{{ $berita->id }}" class="btn btn-sm btn-danger btn-delete">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $list_berita_mentoring->appends(["search" => $query, 'jk' => $jk])
                ->links('vendor.pagination.bootstrap-4')}}

        </div>
    </div>
</div>

{{-- Modal Input Berita Acara [TELAT]--}}
<div class="modal fade" id="input-telat">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form" action="{{ url('admin/berita-mentoring/input') }}" method="get">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Input Berita Acara [Telat]</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Pilih Agenda</label>
                    <select class="form-control" name="agenda_id" required>
                        @foreach($agenda_mentoring as $agenda)
                            <option value="{{ $agenda->id }}">{{ $agenda->judul }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>NIM Mentor</label>
                    <input class="form-control" name="mentor_nim" required
                           placeholder="NIM Mentor yang mau diinputkan Berita Acara">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Go</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection