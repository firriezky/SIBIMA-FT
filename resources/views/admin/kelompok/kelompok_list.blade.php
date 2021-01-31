@extends('layout.admin')

@section('title')
	Kelompok
@endsection

@section('content')

    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Manage Kelompok</a>
    </nav>

	@include('layout.dashboard.alert_flash')

	<div class="row">

		<div class="col-md-12">
			<div class="card card-block">
				<h4 class="card-title">Daftar Kelompok</h4>
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
									   placeholder="Search by Kelompok / Mentor / Asisten"
									   name="search" value="{{ $search or "" }}">
							</div>
						</div>
					</div>
				</form>

				<div class="table-responsive">
					<table class="table table-striped table-sm">
						<thead>
						<tr>
							<th>No</th>
							<th>Kode</th>
							<th>Mentor</th>
							<th>Asisten</th>
							<th>Total Mentee</th>
							<th style="text-align: center">Aksi</th>
						</tr>
						</thead>
						<tbody>
						<?php $skipped = ($list_kelompok->currentPage() * $list_kelompok->perPage())
								- $list_kelompok->perPage();?>
							@foreach($list_kelompok as $kelompok)
							<tr>
								<td>{{ $skipped + $loop->iteration }}</td>
								<td>{{ $kelompok->kode }}</td>
								<td>{{ $kelompok->getMentor->nama }}</td>
								<td>{{ $kelompok->getAsisten->nama or "-"}}</td>
								<td>{{ count($kelompok->getMentee) }}</td>
								<td style="text-align: center">
									<a href="{{ url('admin/kelompok/') }}/{{ $kelompok->id }}" class="btn btn-primary btn-sm">Manage</a>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>

				{{ $list_kelompok->appends(["search" => $search, 'jk' => $jk])
				->links('vendor.pagination.bootstrap-4')}}

			</div>
		</div>

	</div>

@endsection