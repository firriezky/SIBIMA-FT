@extends('layout.mentee')

@section('title') Perizinan @endsection

@section('js_addon')
    <script>

        $('#btn-submit').on('click', function () {
            if (!$('#confirm').prop('checked')){
                swal("Please check the confirmation")
            } else {
                $('#form-izin').find('[type="submit"]').trigger('click');
            }
        });
    </script>
@endsection

@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('mentee/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Perizinan</a>
    </nav>

    @include('layout.dashboard.alert_flash')

    @if( count($izins) != 0)
    <div class="card card-block">
        <h4 class="card-title m-b-2">Data Izin</h4>
        <div class="table-responsive">
            <table class="table table-hover table-sm table-striped">
                <thead>
                <tr>
                    <th class="text-xs-center">#</th>
                    <th>Agenda</th>
                    <th>Kategori</th>
                    <th>Surat</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($izins as $izin)
                    <tr>
                        <td class="text-xs-center">{{ $loop->iteration }}</td>
                        <td>{{ $izin->getAgenda->judul }} - {{ $izin->getAgenda->fakultas }}</td>
                        <td>{{ $izin->getKategori() }}</td>
                        <td><a target="_blank" href="{{ url('/') }}/{{ $izin->surat_url }}"
                               class="btn btn-primary btn-sm">Unduh</a></td>
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
    </div>
    @endif

    @if( count($agendas_general) != 0)
    <div class="card card-block">
        <h4 class="card-title">Form Perizinan General</h4>
        <hr>
        <form action="{{ url('mentee/perizinan') }}" method="post" enctype="multipart/form-data" id="form-izin">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Agenda</label>
                        <select class="form-control" type="number" name="agenda" required>
                            @foreach($agendas_general as $agenda)
                                @if(! $agenda->isMenteeProposeIzinGeneral($mentee_id))
                                    <option value="{{ $agenda->id }}">{{ $agenda->judul }} - {{ $agenda->fakultas }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kategori Izin</label>
                        <select class="form-control" type="number" name="kategori" required>
                            <option value="1">Sakit</option>
                            <option value="2">Urusan Keluarga</option>
                            <option value="3">Kegiatan Akademik (Bukan UKM)</option>
                            <option value="4">Berita Duka</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Jelaskan Secara Detail Izin Anda</label>
                <textarea class="form-control" rows="3" name="detail" required></textarea>
            </div>
            <div class="form-group">
                <label>Upload Surat Izin Anda</label>
                <input type="file" class="form-control-file" name="file_surat" required>
                <small class="form-text text-danger">Surat izin harus asli bertanda tangan, apabila sakit dari dokter / Akademik dari BK Kemahasiswaan / kepentingan keluarga harus asli tanda tangan orangtua</small>
                <small class="form-text text-danger">Accepted format File .jpg / .png / .pdf | Maximum Upload file 2MB</small>
            </div>

            <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                <input type="checkbox" class="custom-control-input" id="confirm">
                <span class="custom-control-indicator"></span>
                <p class="custom-control-description">Dengan ini data yang saya masukan adalah benar karena Allah SWT, serta siap menerima tugas tambahan mentoring dengan maksimal nilai 70.</p>
            </label>

            <div class="form-group">
                <button type="button" id="btn-submit" class="btn btn-primary">Kirim</button>
                <button type="submit" style="display: none"></button>
            </div>

        </form>
    </div>
    @else
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info" role="alert">
                <strong>Tidak Ada Agenda General yang dapat izin / dibuka.</strong>
            </div>
        </div>
    </div>
    @endif
@endsection