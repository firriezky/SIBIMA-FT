@extends('layout.admin')

@section('title')
    Manage Pengumuman
@endsection

@section('js_addon')
    <script>

        $('.btn-delete').on('click', function () {
            var url = $(this).attr('data-url');

            swal({
                    title: "Are you sure?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya, hapus saja",
                    closeOnConfirm: false
                },
                function(){
                    window.location.replace(url);
                }
            );
        });

    </script>
@endsection

@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Lihat Pengumuman</a>
    </nav>

    @include('layout.dashboard.alert_flash')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Daftar Pengumuman</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input-pengumuman">Tambah Pengumuman</button>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th class="text-xs-center">No</th>
                                <th>Judul</th>
                                <th>Tipe</th>
                                <th>Created</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $skipped = ($list_pengumuman->currentPage() * $list_pengumuman->perPage())
                                    - $list_pengumuman->perPage();?>
                            @foreach ($list_pengumuman as $pengumuman)
                                <tr>
                                    <td class="text-xs-center">{{ $skipped + $loop->iteration }}</td>
                                    <td>{{ $pengumuman->judul }}</td>
                                    <td>{{ $pengumuman->getTipe() }}</td>
                                    <td>{{ $pengumuman->created_at }}</td>
                                    <td>
                                        <a href="{{ url('admin/pengumuman') }}/{{ $pengumuman->id }}" class="btn btn-primary ">Detail</a>
                                        <button data-url="{{ url('admin/pengumuman/delete') }}/{{ $pengumuman->id }}"
                                                type="button"
                                                class="btn btn-delete btn-danger ">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $list_pengumuman->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Edit Agenda-->
    <div class="modal fade" id="input-pengumuman" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah Pengumuman</h4>
                </div>
                <div class="modal-body">
                    <form class="form" method="post" action="{{ url('admin/pengumuman') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Judul Pengumuman</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleTextarea">Detail Pengumuman</label>
                            <textarea class="form-control" id="detail" rows="5" name="detail"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Tipe</label>
                            <select class="form-control" name="tipe" required>
                                <option value="1">MENTOR</option>
                                <option value="2">MENTEE</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Upload Dokumen</label>
                            <input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp" name="dokumen">
                            <small id="fileHelp" class="form-text text-muted">Upload Dokumen (types : *.png | *.jpg )</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection