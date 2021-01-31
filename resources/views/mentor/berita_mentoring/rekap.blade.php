@extends('layout.mentor')

@section('title') Rekap @endsection

@section('content')

	<nav class="breadcrumb">
		<a class="breadcrumb-item" href="{{ url('mentor/')}}">Dashboard</a>
		<a class="breadcrumb-item" href="{{ url('mentor/berita-mentoring')}}">Berita Mentoring</a>
		<a class="breadcrumb-item">Rekap</a>
	</nav>

	@include('layout.dashboard.alert_flash')

	@if($list_kelompok->count() == 0)

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

	@elseif($list_kelompok->count() == 1)

		{{-- TAMPILKAN SINGLE TABLE JIKA KELOMPOK 1 --}}
		@foreach($list_kelompok as $kelompok)
			<div class="row">
				<div class="col-md-12">
					<div class="card card-block">
						<h4 class="card-title m-b-2">Rekap Kelompok {{ $kelompok->kode }}</h4>

						{{-- Table & Head Data Kelompok Dipisah --}}
						@include('layout.dashboard.rekap_table', [
                            "kelompok" => $kelompok,
							"agenda_mentoring" => $agenda_mentoring
                        ])

					</div>
				</div>
			</div>
		@endforeach

	@else
		{{-- TAMPILKAN SEBAGAI ACCORDION JIKA KELOMPOK LEBIH DARI 1--}}
		@foreach($list_kelompok as $kelompok)
			<div class="row">
				<div class="col-md-12">
					<div class="card card-default">
						<div class="card-header card-header-inverse">
							<a data-toggle="collapse" href="#collapse{{ $kelompok->kode }}">
								<p class="title-collapse">Rekap Kelompok {{ $kelompok->kode }}</p>
							</a>
							<div class="card-actions">
								<a class="btn-minimize collapsed" data-toggle="collapse" href="#collapse{{ $kelompok->kode }}">
									<i class="fa fa-arrow-down"></i>
								</a>
							</div>
						</div>

						<div id="collapse{{ $kelompok->kode }}" class="collapse card-block">

							{{-- Table & Head Data Kelompok Dipisah --}}
							@include('layout.dashboard.rekap_table', [
                            ])

						</div>
					</div>
				</div>
			</div>
		@endforeach
	@endif


@endsection