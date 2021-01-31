@extends('layout.admin')
@section('title')
    Detail Presensi
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/')}}" >Dashboard</a>
        <a class="breadcrumb-item" href="{{ url('admin/presensi/talaqi')}}" >Presensi</a>
        <a class="breadcrumb-item">Talaqi Detail</a>
    </nav>

    <div class="card card-block">
        <h4 class="card-title">Presensi Talaqi Detail [{{ $agenda->judul }} - {{ $agenda->fakultas }}]</h4>
        <hr>

        {{-- Filter & Search Row --}}
        <form method="get" class="form">
            <div class="row">
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <input type="text"
                               class="form-control"
                               placeholder="Search by Nama / NIM"
                               name="search" value="{{ $query or "" }}">
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>JK</th>
                    <th>Fakultas</th>
                    <th>Waktu Hadir</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php $skipped = ($list_data->currentPage() * $list_data->perPage())
                    - $list_data->perPage();?>
                @foreach($list_data as $data)
                    <tr>
                        <td scope="row">{{ $skipped + $loop->iteration }}</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->nim }}</td>
                        <td>{{ $data->getJK() }}</td>
                        <td>{{ $data->fakultas }}</td>

                        {{-- Save it To Variable --}}
                        {{-- Agar tidak terjadi query setiap saat --}}
                        <?php $presensi = $data->getPresensiTalaqi($agenda->id) ?>

                        @if($presensi != null)
                            <td>{{ $presensi->waktu_hadir }}</td>
                        @else
                            <td>{{ "-" }}</td>
                        @endif

                        @if( $presensi != null )

                            @if($presensi->isTelat())
                                <td><span class="tag tag-pill tag-warning">Telat</span></td>
                            @else
                                <td><span class="tag tag-pill tag-success">Hadir</span></td>
                            @endif

                        @else
                            <td><span class="tag tag-pill tag-danger">Tidak Hadir</span></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        {{ $list_data
            ->appends(["search" => $query])
            ->links('vendor.pagination.bootstrap-4') }}

    </div>
@endsection