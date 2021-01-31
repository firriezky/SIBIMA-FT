@extends('layout.admin')
@section('title')
	Quisioner
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
		})
	</script>
@endsection
@section('content')
	<nav class="breadcrumb">
		<a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
		<a class="breadcrumb-item">Kuesioner</a>
	</nav>

	@include('layout.dashboard.alert_flash')

	<div class="card card-block">
		<h4 class="card-title">Daftar Kuesioner</h4>
		<hr>
		<div class="row">
			<div class="col-md-12">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah</button>
			</div>
		</div>
		<br>
		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
				<tr>
					<th class="text-xs-center">#</th>
					<th>Judul</th>
					<th>Koresponden</th>
					<th>Aksi</th>
				</tr>
				</thead>
				<tbody>
				<?php $skipped = ($list_questioner->currentPage() * $list_questioner->perPage())
						- $list_questioner->perPage();?>
				@foreach($list_questioner as $questioner)
					<tr>
						<td class="text-xs-center">{{ $skipped + $loop->iteration }}</td>
						<td>{{$questioner->judul}}</td>
						@if($questioner->koresponden ==  1)
							<td>Mentor</td>
						@elseif($questioner->koresponden ==  2)
							<td>Mentee</td>
						@endif
						<td><a target="_blank" href="{{$questioner->link}}" class="btn btn-success">Isi</a>
							{{--<a href="{{ url('admin/questioner/edit') }}" class="btn btn-primary">Ubah</a>--}}
							<button url="{{ url('admin/questioner/delete') }}/{{ $questioner->id }}" class="btn btn-danger btn-delete">Hapus</button>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
		{{ $list_questioner->links('vendor.pagination.bootstrap-4') }}

	</div>

	<!-- Modal Tambah Questioner-->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
			        </button>
			        <h4 class="modal-title" id="myModalLabel">Tambah Questioner</h4>
			    </div>
			<div class="modal-body">
				<form class="form" action="{{ url('admin/questioner') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
				        <label>Judul Questioner</label>
				        <input class="form-control" type="text" name="judul" required>
				    </div>
				    <div class="form-group">
				        <label>Link Questioner</label>
				        <input class="form-control" type="text" name="link"
							   required placeholder="Mohon ditambahkan http:// atau https://">
				    </div>
			        <div class="form-group">
			        	<label>Koresponden</label>
					    <select required class="form-control" id="selectKelompok" name="koresponden">
					      <option value="1">Mentor</option>
					      <option value="2">Mentee</option>
					    </select>
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