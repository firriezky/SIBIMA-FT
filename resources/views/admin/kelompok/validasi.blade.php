@extends('layout.admin')

@section('title')
	Validasi
@endsection

@section('content')

    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Validasi</a>
    </nav>

	<div class="row">

		<div class="col-md-6">
			<div class="card card-block">
				<h4 class="card-title m-b-2">Mentor Belum Berkelompok</h4>
				<div class="table-responsive">
					<table class="table table-striped table-sm" >
						<thead>
						<tr>
							<th class="text-xs-center">No</th>
							<th>Nama</th>
							<th>Fakultas</th>
							<th>JK</th>
						</tr>
						</thead>
						<tbody>
						<?php $skipped = ($mentor_belum_berkelompok->currentPage()
										* $mentor_belum_berkelompok->perPage())
								- $mentor_belum_berkelompok->perPage();?>

						@foreach($mentor_belum_berkelompok as $mentor)
							<tr>
								<td class="text-xs-center">{{ $skipped + $loop->iteration }}</td>
								<td>{{ $mentor->nama }}</td>
								<td>{{ $mentor->fakultas }}</td>
								<td>{{ $mentor->jk == 1 ? "Ikhwan" : "Akhwat" }}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
				{{ $mentor_belum_berkelompok->links('vendor.pagination.bootstrap-4') }}

			</div>
		</div>
		<div class="col-md-6">
			<div class="card card-block">
				<h4 class="card-title m-b-2">Mentee Belum Berkelompok</h4>
				<table class="table table-striped table-sm">
					<thead>
					<tr>
						<th class="text-xs-center">No</th>
						<th>NIM</th>
						<th>Nama</th>
						<th>JK</th>
						<th>Kelas</th>
					</tr>
					</thead>
					<tbody>
					<?php $skipped = ($mentee_belum_berkelompok->currentPage()
									* $mentee_belum_berkelompok->perPage())
							- $mentee_belum_berkelompok->perPage();?>

					@foreach($mentee_belum_berkelompok as $mentee)
						<tr>
							<td class="text-xs-center">{{ $skipped + $loop->iteration }}</td>
							<td>{{ $mentee->nim }}</td>
							<td>{{ $mentee->nama }}</td>
							<td>{{ $mentee->getJK() }}</td>
							<td>{{ $mentee->kelas }}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
				{{ $mentee_belum_berkelompok->links('vendor.pagination.bootstrap-4') }}

			</div>
		</div>

	</div>

@endsection