@extends('layout.admin')

@section('title')
    Manage Kelompok
@endsection

@section('js_addon')
	<script>
		$('.btn-delete').on('click', function () {
			var url = $(this).attr('url');

			swal({
				title: "Are you sure?",
//				text: ", Presensi, dan Nilai Mentee",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Ya, hapus saja",
				closeOnConfirm: false
				},
				function(){
					window.location.replace(url);
				}
			);
		});

		$('.btn-remove').on('click', function () {
			var url = $(this).attr('url');

			swal({
						title: "Are you sure?",
//				text: ", Presensi, dan Nilai Mentee",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "Ya, hapus saja",
						closeOnConfirm: false
					},
					function(){
						window.location.replace(url);
					}
			);
		});

		$('#btn-ganti-mentor').on('click', function () {
			// show Modal
			var url = $('#data-mentor').text();

			$('#input-mentor-lama').val(url);

			$('#ganti-mentor').modal('show');
		})

		$('#btn-ganti-asisten').on('click', function () {
			// show Modal
			var url = $('#data-asisten').text();

			$('#input-asisten-lama').val(url);

			$('#ganti-asisten').modal('show');
		})

	</script>
@endsection

@section('content')

	<nav class="breadcrumb">
		<a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
		<a class="breadcrumb-item" href="{{ url('admin/kelompok')}}">Manage Kelompok</a>
		<a class="breadcrumb-item" >Kelompok {{ $kelompok->kode }}</a>
	</nav>

	@include('layout.dashboard.alert_flash')

	<div class="row">
		<div class="col-md-12">
			<div class="card card-block">
				<h4 class="card-title">Kelompok {{ $kelompok->kode }}</h4>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<button id="btn-ganti-mentor" class="btn btn-primary" type="button">Ganti Mentor</button>
						<button id="btn-ganti-asisten" class="btn btn-primary" type="button">Ganti Asisten</button>
						<button class="btn btn-primary" data-toggle="modal" data-target="#tambah-mentee">Tambah Mentee</button>
						<button url="{{ url('admin/kelompok/delete') }}/{{$kelompok->id}}"
								class="btn btn-danger pull-right btn-delete">Delete Kelompok
						</button>
					</div>
				</div>
				<hr>

				<div class="row">
					<div class="col-md-4">
						<div class="input-group form-group">
							<span class="input-group-addon">Mentor</span>
							<div class="form-control form-head" id="data-mentor">{{ $kelompok->getMentor->nama }} ({{ $kelompok->getMentor->nim }})</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="input-group form-group">
							<span class="input-group-addon"><span class="fa fa-phone"></span></span>
							<div class="form-control form-head">
								{{ $kelompok->getMentor->no_telp or "-" }}
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="input-group form-group">
							<span class="input-group-addon"><span class="fa fa-comment-o"></span> LINE</span>
							<div class="form-control form-head">
								{{ $kelompok->getMentor->line_id or "-" }}
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					@if($kelompok->getAsisten != null)
						<div class="col-md-4">
							<div class="input-group form-group">
								<span class="input-group-addon">Asisten</span>
								<div class="form-control form-head" id="data-asisten">{{ $kelompok->getAsisten->nama }} ({{ $kelompok->getAsisten->nim }})</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon"><span class="fa fa-phone"></span></span>
								<div class="form-control form-head">
									{{ $kelompok->getAsisten->no_telp or " - " }}
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="input-group form-group">
								<span class="input-group-addon"><span class="fa fa-comment-o"></span> LINE</span>
								<div class="form-control form-head">
									{{ $kelompok->getAsisten->line_id or " - " }}
								</div>
							</div>
						</div>
					@else
						<div class="col-md-4">
							<div class="input-group form-group">
								<span class="input-group-addon">Asisten</span>
								<div class="form-control form-head">
									-
								</div>
							</div>
						</div>

					@endif

				</div>

				<div class="table-responsive">
					<table class="table table-hover table-sm">
						<thead>
						<tr>
							<th>No</th>
							<th>NIM</th>
							<th>Nama</th>
							<th>Kelas</th>
							<th>No. HP</th>
							<th>Program Studi</th>
							<th>Aksi</th>
						</tr>
						</thead>
						<tbody>
						<?php $i = 1 ?>
						@foreach($kelompok->getMentee as $mentee)
							<tr>
								<td scope="row">{{ $i++ }}</td>
								<td>{{ $mentee->nim }}</td>
								<td>{{ $mentee->nama }}</td>
								<td>{{ $mentee->kelas }}</td>
								<td>{{ $mentee->no_telp }}</td>
								<td>{{ $mentee->program_studi }}</td>
								<td><button type="button" url="{{ url('admin/kelompok/remove') }}/{{ $mentee->id }}"
											class="btn btn-danger btn-sm btn-remove">Remove</button>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	{{-- Modal Tambah Mentee --}}
	<div class="modal fade" id="tambah-mentee" >
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Tambah Mentee</h4>
				</div>
				<form method="post" action="{{ url('admin/kelompok/add-mentee') }}/{{ $kelompok->id }}">
					{{ csrf_field() }}
					<div class="modal-body">
						<div class="form-group">
							<label>NIM</label>
							<input class="form-control" name="nim" placeholder="Masukkan NIM Mentee yang akan ditambahkan ke Kelompok Ini">
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>

	{{-- Modal Ganti Mentor --}}
	<div class="modal fade" id="ganti-mentor" >
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Ganti Mentor Kelompok</h4>
				</div>
				<form method="post" action="{{ url('admin/kelompok/change') }}/{{ $kelompok->id }}">
					{{ csrf_field() }}
					<div class="modal-body">
						<div class="form-group">
							<label>Mentor Lama</label>
							<input id="input-mentor-lama" class="form-control" value="" disabled>
						</div>
						<div class="form-group">
							<label>NIM Mentor Baru</label>
							<input class="form-control" name="mentor_nim" placeholder="Inputkan NIM Mentor Baru">
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>

	{{-- Modal Ganti Asisten --}}
	<div class="modal fade" id="ganti-asisten" >
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Ganti Asisten Kelompok</h4>
				</div>
				<form method="post" action="{{ url('admin/kelompok/change') }}/{{ $kelompok->id }}">
					{{ csrf_field() }}
					<div class="modal-body">
						<div class="form-group">
							<label>Asisten Lama</label>
							<input id="input-asisten-lama" class="form-control" value="" disabled>
						</div>
						<div class="form-group">
							<label>NIM Asisten Baru</label>
							<input class="form-control" name="asisten_nim" placeholder="Inputkan NIM Asisten Baru">
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>


@endsection