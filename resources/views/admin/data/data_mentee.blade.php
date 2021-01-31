@extends('layout.admin')
@section('title')
	View Data Mentee
@endsection
@section('js_addon')
	<script>
		$('.btn-reset').on('click', function(){
			var mentee_id = $(this).attr('mentee');
			$('input[id="mentee_id"]').val(mentee_id);
		});
		$('.btn-delete').on('click', function(){
			var url = $(this).attr('url');
			swal({
				title: "Are you sure?",
				text: "Penghapusan Mentee, dapat menghilangkan semua data mentee terkait (presensi, nilai, etc)",
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
		<h4 class="card-title">Daftar Mentee</h4>
		<hr>
		<form method="get">
			<div class="row">
				<div class="col-md-9 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-xs-3">
							<div class="form-group">
								<button type="button" class="btn btn-primary form-control" data-toggle="modal" data-target="#modalAdd">Tambah Mentee</button>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<select class="form-control" name="jk">
									<option selected value="">Select Filteer</option>
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
					    		placeholder="Search by NIM/Nama/Program Studi" 
					    		name="search" 
					    		value="{{ $search or "" }}">
					</div>
				</div>
			</div>
		</form>
		<table class="table table-sm">
			<thead>
				<tr>
					<th>#</th>
					<th>NIM</th>
					<th>Nama</th>
					<th>Jenis Kelamin</th>
					<th>Program Studi</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
			<?php $skipped = ($list_mentee->currentPage() * $list_mentee->perPage()) - $list_mentee->perPage(); ?>
			@foreach($list_mentee as $mentee)
				<tr>
					<td>{{ $skipped + $loop->iteration }}</td>
					<td>{{ $mentee->nim }}</td>
					<td>{{ $mentee->nama }}</td>
					<td>{{ $mentee->getJK() }}</td>
					<td>{{ $mentee->program_studi }}</td>
					<td>
						<a href="{{ url('admin/data/mentee')}}/{{ $mentee->id }}" class="btn btn-sm btn-success">Detail</a>
						<a href="{{ url('admin/data/mentee/edit') }}/{{ $mentee->id }}" class="btn btn-sm btn-primary">Edit</a>
						<button url="{{ url('admin/data/mentee/delete') }}/{{ $mentee->id }}" class="btn btn-sm btn-danger btn-delete">Hapus</button>
						<a href="#modalReset" class="btn btn-sm btn-warning btn-reset" data-toggle="modal" mentee="{{ $mentee->id }}">Reset</a>
					</td>

				</tr>
			@endforeach
			</tbody>
		</table>

		<hr>
		@if($jk != 0)
			{{ $list_mentee
				->appends(['search' => $search, 'jk' => $jk])
				->links('vendor.pagination.bootstrap-4')
			}}
		@else
			{{ $list_mentee
				->appends(['search' => $search])
				->links('vendor.pagination.bootstrap-4')
			}}
		@endif

	</div>

<!-- Modal Reset Password Mentee-->
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
	      	<form class="form" action="{{ url('admin/data/mentee/reset') }}" method="post">
	      	{{ csrf_field() }}
	      		<input id="mentee_id" style="display: none" name="mentee_id">
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
			<form class="form" method="post" action="{{ url('admin/data/mentee/')}}">
				<div class="modal-body">
						{{csrf_field()}}
						<div class="row">
							<div class="col-sm-6">

								<div class="form-group">
									<label>NIM</label>
									<input class="form-control" name="nim" required>
								</div>

								<div class="form-group">
									<label>Nama</label>
									<input class="form-control" name="nama"  required>
								</div>

								<div class="form-group">
									<label>Fakultas</label>
									<select class="form-control" name="fakultas" required>
										@foreach($fakultas_all as $fakultas)
											<option value="{{ $fakultas->fakultas }}">{{ $fakultas->fakultas }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<label> Program Studi</label>
									<select class="form-control" name="prodi" required>
										@foreach($prodi_all as $prodi)
											<option value="{{ $prodi->program_studi }}">{{ $prodi->program_studi }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label>Line ID</label>
									<input class="form-control" name="line_id" value="{{ $mentee->line_id }}">
								</div>

								<div class="form-group">
									<label>Jenis Kelamin</label>
									<select class="form-control" name="jk" required>
										<option selected disabled>Pilih JK</option>
										<option value="1" >Ikhwan</option>
										<option value="2" >Akhwat</option>
									</select>
								</div>

								<div class="form-group">
									<label>No Telephone</label>
									<input class="form-control" name="no_telp">
								</div>

								<div class="form-group">
									<label>Kelas</label>
									<select class="form-control" name="kelas" required>
										@foreach($kelas_all as $kelas)
											<option value="{{ $kelas->kelas }}">{{ $kelas->kelas }}</option>
										@endforeach
									</select>
								</div>

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

@endsection