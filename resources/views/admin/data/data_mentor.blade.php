@extends('layout.admin')
@section('title')
	View Data Mentor
@endsection
@section('js_addon')
	<script>
		$('.btn-reset').on('click', function(){
			var mentor_id = $(this).attr('mentor');
			var mentor_name = $(this).attr('data-name');
			$('input[id="mentor_id"]').val(mentor_id);
			$('#mentor_name').val(mentor_name);
		});

		$('.btn-delete').on('click', function(){
			var url = $(this).attr('data-url');
			swal({
				title: "Are you sure?",
				text: "Penghapusan Mentor, dapat menghilangkan semua data mentor terkait (presensi, nilai, etc)",
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

	</script>
@endsection
@section('content')

	<nav class="breadcrumb">
		<a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
		<a class="breadcrumb-item">Lihat Data</a>
	</nav>

	@include('layout.dashboard.alert_flash')

	<div class="card card-block">
		<h4 class="card-title">Daftar Mentor Islamic Character Building</h4>
		<hr>
		<form method="get">
			<div class="row">
				<div class="col-md-9 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-xs-3">
							<div class="form-group">
								<button type="button" class="btn btn-primary form-control" data-toggle="modal" data-target="#modalAdd">Tambah Mentor</button>
							</div>
						</div>
						<div class="col-xs-4">
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
				<div class="col-md-3 col-sm-12 col-xs-12 float-md-right float-sm-none">
					<div class="form-group">
						<input type="text"
							   class="search form-control"
							   placeholder="Search by NIM/Nama/Fakultas"
							   name="search" value="{{ $search or "" }}" >
					</div>
				</div>
			</div>
		</form>

		<div class="table-responsive">
			<table class="table table-sm">
				<thead>
				<tr>
					<th>#</th>
					<th>NIM</th>
					<th>Nama</th>
					<th>JK</th>
					<th>Fakultas</th>
					<th>As Mentor</th>
					<th>As Asisten</th>
					<th>Aksi</th>
				</tr>
				</thead>
				<tbody>
				<?php $skipped = ($list_mentor->currentPage() * $list_mentor->perPage())
						- $list_mentor->perPage();?>
				@foreach($list_mentor as $mentor)
					<tr>
						<td>{{ $skipped + $loop->iteration }}</td>
						<td>{{ $mentor->nim }}</td>
						<td>{{ $mentor->nama }}</td>
						<td>{{ $mentor->getJK() }}</td>
						<td>{{ $mentor->fakultas }}</td>
						<td class="text-xs-center">{{ $mentor->getKelompok->count() }}</td>
						<td class="text-xs-center">{{ $mentor->getKelompokAsisten->count() }}</td>

						<td>
							<a href="{{ url('admin/data/mentor')}}/{{ $mentor->id }}" class="btn btn-sm btn-success">Detail</a>
							<a href="{{ url('admin/data/mentor/edit')}}/{{ $mentor->id }}" class="btn btn-sm btn-primary">Edit</a>
							<button data-url="{{ url('admin/data/mentor/delete') }}/{{ $mentor->id }}"
									class="btn btn-sm btn-danger btn-delete">Hapus</button>
							<a href="#modalReset" class="btn btn-sm btn-warning btn-reset" mentor="{{ $mentor->id }}"
							   data-toggle="modal" data-name="{{ $mentor->nama }}">Reset</a>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>

		<hr>
		@if($jk != 0)
			{{ $list_mentor
				->appends(['search' => $search, 'jk' => $jk])
				->links('vendor.pagination.bootstrap-4')
			}}
		@else
			{{ $list_mentor
				->appends(['search' => $search])
				->links('vendor.pagination.bootstrap-4')
			}}
		@endif

	</div>

	<!-- Modal Reset Password Mentor-->
	<div class="modal fade" id="modalReset" tabindex="-1">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	        <h4 class="modal-title">Reset</h4>
	      </div>
	      <div class="modal-body">
	      	<form class="form" action="{{ url('admin/data/mentor/reset') }}" method="post">
	      	{{ csrf_field() }}
	      		<input id="mentor_id" style="display: none" name="mentor_id">

				<label>Name</label>
				<input id="mentor_name" class="form-group form-control" type="text" value="" disabled>

				<label>Reset Password</label>
		      	<input class="form-group form-control" type="text" name="password" required>

				<div class="modal-footer">
		      		<button type="submit" class="btn btn-primary">Submit</button>
		      	</div>
		    </form>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal Add Mentor-->
	<div class="modal fade" id="modalAdd" tabindex="-1">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="modalAddLabel">Tambah Data Mentor</h4>
				</div>
				<div class="modal-body">
					<form class="form" action="{{ url('admin/data/mentor') }}" method="post">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-sm-6">

								<div class="form-group">
									<label>NIM</label>
									<input class="form-control" name="nim" required>
								</div>

								<div class="form-group">
									<label>Nama</label>
									<input class="form-control" name="nama" required>
								</div>

								<div class="form-group">
									<label>Fakultas</label>
									<select class="form-control" name="fakultas" required>
										<option selected disabled>PILIH FAKULTAS</option>
										@foreach($list_fakultas as $fakultas)
											<option value="{{ $fakultas->fakultas }}"
											>{{ $fakultas->fakultas }}</option>
										@endforeach
									</select>
								</div>

							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label>Line ID</label>
									<input class="form-control" name="line_id" placeholder="Optional">
								</div>

								<div class="form-group">
									<label>JK</label>
									<select class="form-control" name="jk" required>
										<option selected disabled>PILIH JK</option>
										<option value="1">Ikhwan</option>
										<option value="2">Akhwat</option>
									</select>
								</div>

								<div class="form-group">
									<label>No Telephone</label>
									<input class="form-control" name="no_telp" placeholder="Optional">
								</div>

							</div>

						</div>

						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


@endsection