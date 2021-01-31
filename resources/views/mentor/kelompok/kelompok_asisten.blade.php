@extends('layout.mentor')

@section('title') Asisten Kelompok @endsection

@section('content')

	<nav class="breadcrumb">
		<a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
		<a class="breadcrumb-item" >Asisten Kelompok</a>
	</nav>

@if($list_kelompok->count() == 0)

	{{-- ALERT TIDAK ADA KELOMPOK --}}
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-info" role="alert">
						Anda tidak meng-asisteni kelompok.
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
					<h4 class="card-title">Kelompok {{ $kelompok->kode }}</h4>
					<hr>

					{{-- Table & Head Data Kelompok Dipisah --}}
					@include('layout.dashboard.kelompok_content', [
						"kelompok" => $kelompok
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
							<p class="title-collapse">Kelompok {{ $kelompok->kode }}</p>
						</a>
					<div class="card-actions">
						<a class="btn-minimize collapsed" data-toggle="collapse" href="#collapse{{ $kelompok->kode }}">
							<i class="fa fa-arrow-down"></i>
						</a>
					</div>
					</div>

					<div id="collapse{{ $kelompok->kode }}" class="collapse card-block">

						{{-- Table & Head Data Kelompok Dipisah --}}
						@include('layout.dashboard.kelompok_content', [
                            "kelompok" => $kelompok
                        ])

					</div>
				</div>
			</div>
		</div>
	@endforeach
@endif

@endsection
