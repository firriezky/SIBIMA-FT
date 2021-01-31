@extends('layout.admin')
@section('title')
    Perizinan
@endsection
@section('js_addon')
    <script>
        $('.btn-delete').on('click', function(){
            var url = $(this).attr('url');

            swal({
                title: "Are You Sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, hapus saja",
                closeOnConfirm: false
            },
            function(){
                window.location.href = url;
            });
        });
        $('.btn-detail').on('click', function(){
            var detail = $(this).attr('detail');

            swal("Detail Izin", detail);
        });
    </script>
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Perizinan</a>
    </nav>
    <div class="card card-block">
        <h4 class="card-title">Daftar Perizinan General</h4>
        <hr>

        {{-- Filter & Search Row --}}
        <form method="get" class="form">
            <div class="row">
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="row">
                        <div style="padding-right: 0px" class="col-xs-7">
                            <div class="form-group">
                                <select class="form-control" name="agenda">
                                    <option selected value="">Select Agenda</option>
                                    @foreach($agenda_general as $agenda)
                                        <option value="{{ $agenda->id }}"
                                                {{ $agenda->id == $current_agenda  ? "selected" : "" }}>
                                            {{ $agenda->judul }} - {{ $agenda->fakultas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Filter Data</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12 float-md-right float-sm-none">
                    <div class="form-group">
                        <input type="text"
                               class="form-control"
                               placeholder="Search by Nama, NIM, Fakultas"
                               name="search" value="{{ $query or "" }}">
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                <tr>
                    <th class="text-xs-center">No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Agenda</th>
                    <th>Fakultas</th>
                    <th>Kategori</th>
                    <th class="text-xs-center">Surat Izin</th>
                    <th class="text-xs-center">Aksi</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php $skipped = ($list_izin->currentPage() * $list_izin->perPage()) - $list_izin->perPage();?>
                    @foreach($list_izin as $izin)
                    <tr>
                        <td class="text-xs-center">{{ $skipped + $loop->iteration }}</td>
                        <td>{{ $izin->mentee_nim }}</td>
                        <td>{{ $izin->mentee_nama }}</td>
                        <td>{{ $izin->getAgenda->judul }}</td>
                        <td>{{ $izin->mentee_fakultas }}</td>
                        <td>{{ $izin->getKategori() }}</td>
                        <td class="text-xs-center">
                            <a class="btn btn-secondary btn-sm" target="_blank" href="{{ url($izin->surat_url) }}">
                                Download
                            </a>
                        </td>
                        <td class="text-xs-center">
                            <a href="{{ url('admin/presensi/perizinan/acc') }}/{{ $izin->id }}"
                                    class="btn btn-nilai btn-success btn-sm">Diterima</a>

                            <a href="{{ url('admin/presensi/perizinan/reject') }}/{{ $izin->id }}"
                                    class="btn btn-nilai btn-danger btn-sm">Ditolak</a>
                            <button class="btn btn-nilai btn-primary btn-sm btn-detail" detail="{{ $izin->detail }}">Detail</button>
                            <button url="{{ url('admin/presensi/perizinan/delete') }}/{{ $izin->id }}" class="btn btn-warning btn-sm btn-delete">Delete</button>
                        </td>
                        @if($izin->status == 0)
                            <td><h6 class="m-b-0"><span class="tag tag-pill tag-default">Belum Diproses</span></h6></td>
                        @elseif($izin->status == 1)
                            <td><h6 class="m-b-0"><span class="tag tag-pill tag-success">Diterima</span></h6></td>
                        @elseif($izin->status == 2)
                            <td><h6 class="m-b-0"><span class="tag tag-pill tag-danger">Ditolak</span></h6></td>
                        @endif

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $list_izin
            ->appends(['agenda' => $current_agenda, "search" => $query])
            ->links('vendor.pagination.bootstrap-4')
        }}

    </div>
@endsection