@extends('layout.admin')
@section('title')
	View Data Admin
@endsection
@section('js_addon')
	<script>
		$('.btn-reset').on('click', function(){
			var admin_id = $(this).attr('admin');
			$('input[id="admin_id"]').val(admin_id);
		});
	</script>
@endsection
@section('content')
	<nav class="breadcrumb">
		<a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
		<a class="breadcrumb-item">Lihat Data Admin</a>
	</nav>

	@include('layout.dashboard.alert_flash')

	<div class="card card-block">
		<h4 class="card-title m-b-2">List Admin - [Manage Access via Artisan]</h4>
		<table class="table table-sm table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Username</th>
				</tr>
			</thead>
			<tbody>
			@foreach($list_admin as $admin)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $admin->username }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>


@endsection