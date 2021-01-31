@extends('layout.mentor')

@section('title') Berita Mentoring @endsection

@section('content')

	<nav class="breadcrumb">
		<a class="breadcrumb-item" href="{{ url('mentor/dashboard')}}">Dashboard</a>
		<a class="breadcrumb-item" >Berita Mentoring</a>
	</nav>

	@include('layout.dashboard.alert_flash')

	@if(Auth::guard('mentor')->user()->getKelompok->count() == 0)

		{{-- ALERT TIDAK ADA KELOMPOK --}}
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-danger" role="alert">
							Belum terdapat Kelompok Mentoring, <strong> harap hubungi Admin BM</strong>
						</div>
					</div>
				</div>
			</div>
		</div>
	@else
		<div class="row">
		<div class="col-md-12">
			<div class="card card-block">
				<a href="{{ url('mentor/berita-mentoring/rekap') }}"
				   class="btn btn-sm btn-primary pull-right">View Rekap Nilai</a>
				<h4 class="card-title m-b-2">List Berita Mentoring</h4>
				<div class="table-responsive">
					<table class="table table-hover table-striped">
						<thead>
						<tr>
							<th width="10px">#</th>
							<th>Berita Mentoring</th>
							<th>Tanggal Akhir</th>
							<th class="text-md-center">Status</th>
							<th class="text-xs-center">Aksi</th>
						</tr>
						</thead>
						<tbody>

						<? $count = 1 ?>
						<? Date::setLocale('id'); ?>
						@foreach($agendas as $agenda)
							<tr>
								<td scope="row">{{  $loop->iteration }}</td>
								<td>{{ $agenda->judul }}</td>
								<td>{{ Jenssegers\Date\Date::parse($agenda->tanggal_akhir)->format('l, j F Y - H:i') }}</td>
								@if( $agenda->isEnded() )
									<td class="text-xs-center"><h6 class="m-b-0"><span class="tag tag-pill tag-default">Selesai</span></h6></td>
									<td class="text-xs-center">
										<a href="{{url('/mentor/berita-mentoring/export')}}/{{$agenda->id}}"  class="btn btn-sm btn-secondary">Download</a>
									</td>
								@elseif( $agenda->isAlreadyInput(Auth::guard('mentor')->user()->id) )
									<td class="text-xs-center"><h6 class="m-b-0"><span class="tag tag-pill tag-success">Sudah Input</span></h6></td>
									<td class="text-xs-center">
										<a href="{{ url('mentor/berita-mentoring/edit') }}/{{ $agenda->id }}" class="btn btn-sm btn-info" >Edit Nilai</a>
									</td>
								@else
									<td class="text-xs-center"><h6 class="m-b-0"><span class="tag tag-pill tag-primary">Berlangsung</span></h6></td>
									<td class="text-xs-center">
										<a href="{{ url('mentor/berita-mentoring/input') }}/{{ $agenda->id }}" class="btn btn-sm btn-primary" >Input Nilai</a>
									</td>
								@endif

							</tr>
							<? $count++ ?>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	@endif
@endsection