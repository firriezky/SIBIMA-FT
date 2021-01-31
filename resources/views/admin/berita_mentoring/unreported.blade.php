@extends('layout.admin')

@section('title')
    Unreported
@endsection

@section('content')

<nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
    <a class="breadcrumb-item" >Unreported Berita Mentoring</a>

</nav>

@include('layout.dashboard.alert_flash')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block">

            <h4 class="card-title">Unreported Berita Acara Mentor</h4>
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
                                        @foreach($agenda_mentoring as $agenda)
                                        <option value="{{ $agenda->id }}"
                                                {{ $agenda->id == $current_agenda  ? "selected" : "" }}>
                                            {{ $agenda->judul }}</option>
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
                                   placeholder="Search by Kode / Mentor Only"
                                   name="search" value="{{ $query or "" }}">
                        </div>
                    </div>
                </div>
            </form>

            @if($list_unreported != null)
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th class="text-xs-center">No</th>
                    <th class="text-xs-center">Kelompok</th>
                    <th>Mentor</th>
                    <th>Fakultas (Mentee)</th>
                    <th>Agenda</th>
                    {{--<th>Tanggal</th>--}}
                    {{--<th>Aksi</th>--}}
                </tr>
                </thead>
                <tbody>
                <?php Date::setLocale('id'); ?>
                <?php $skipped = ($list_unreported->currentPage() * $list_unreported->perPage()) - $list_unreported->perPage(); ?>

                @foreach($list_unreported as $unreported)
                    <tr>
                        <td class="text-xs-center">{{$skipped + $loop->iteration}}</td>
                        <td class="text-xs-center">{{ $unreported->kode }}</td>
                        <td >{{ $unreported->getMentor->nama }}</td>
                        <td >{{ $unreported->getMentee[0]->fakultas }}</td>

                        <td >{{ $unreported->judul }}</td>
                        {{--<td>{{ $berita->getKelompok->getMentor->nama }}</td>--}}
                        {{--<td>{{ $berita->getAgenda->judul }}</td>--}}
                        {{--<td>{{ Jenssegers\Date\Date::parse($berita->tanggal)->format('l, j F Y - H:i') }}</td>--}}
                        {{--<td>--}}
                            {{--<a href="{{ url('admin/berita-mentoring') }}/{{ $berita->id }}" class="btn btn-sm btn-primary">Detail</a>--}}
                            {{--<a href="{{ url('admin/berita-mentoring/edit') }}/{{ $berita->id }}" class="btn btn-sm btn-warning">Edit</a>--}}
                        {{--</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $list_unreported
                ->appends(['agenda' => $current_agenda, "search" => $query])
                ->links('vendor.pagination.bootstrap-4')
            }}

            @endif
        </div>
    </div>
</div>


@endsection