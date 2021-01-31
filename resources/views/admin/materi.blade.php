@extends('layout.admin')

@section('title')
	Materi
@endsection

@section('js_addon')
	<script>
		$('.btn-delete').on('click', function(){
			var url = $(this).attr('url');

			swal({
				title: "Are you sure?",
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
		<a class="breadcrumb-item" >Materi</a>
	</nav>

	@include('layout.dashboard.alert_flash')

	<div class="card card-block">
		<h4 class="card-title">Daftar Materi</h4>
		<hr>
		<div class="row">
			<div class="col-md-12">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Upload</button>
			</div>
		</div>
		<br>
		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
				<tr>
					<th class="text-xs-center">#</th>
					<th>Judul Materi</th>
                    <th>Tipe</th>
					<th>Aksi</th>
				</tr>
				</thead>
				<tbody>
				<?php $skipped = ($list_materi->currentPage() * $list_materi->perPage())
						- $list_materi->perPage();?>
				@foreach($list_materi as $materi)
					<tr>
						<td class="text-xs-center">{{ $skipped + $loop->iteration }}</td>
						<td>{{ $materi->nama }}</td>
                        <td>{{ $materi->getTipe() }}</td>
						<td>
							<a target="_blank" href="{{ url('/') }}/{{ $materi->file_url }}" class="btn btn-success">Download</a>
							<button url="{{ url('/admin/materi/delete') }}/{{ $materi->id }}" class="btn btn-danger btn-delete">Hapus</button>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
		{{ $list_materi->links('vendor.pagination.bootstrap-4') }}
	</div>

	<!-- Modal Upload Materi-->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form class="form" action="{{ url('admin/materi') }}" method="post" enctype="multipart/form-data">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Tambah Materi</h4>
					</div>
					<div class="modal-body">
						{{ csrf_field() }}
						<div class="form-group">
							<label>Judul Materi</label>
							<input class="form-control" type="text" name="judul" required>
						</div>

						<div class="form-group">
							<label>Materi Untuk</label>
							<select class="form-control" name="tipe" required>
								<option value="1">Mentor</option>
								<option value="2">Mentee</option>
							</select>
						</div>

						<div class="form-group">
							<label>Materi File</label>
							<input type="file" class="form-control-file" name="materi" required>
							<small class="form-text text-muted">Upload Materi (types : *.pdf | *.ppt |*.pptx | *.doc | *.docx)</small>
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