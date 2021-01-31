@extends('layout.admin')

@section('title')
	Manage Event
@endsection

@section('js_addon')
	<script src="{{ url("bower_components/moment/min/moment.min.js") }}"></script>
	<script src="{{ url("bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js") }}"></script>
	<script>

	$('#date-picker-to').datetimepicker({
		format: 'DD/MM/YYYY HH:mm',
		icons: {
			time: 'fa fa-clock-o',
			date: 'fa fa-calendar',
			up: 'fa fa-chevron-up',
			down: 'fa fa-chevron-down',
			previous: 'fa fa-chevron-left',
			next: 'fa fa-chevron-right',
			today: 'fa fa-calendar-check-o',
			clear: 'fa fa-trash-o',
			close: 'fa fa-close'
		}
	});
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
				}
			);
	});
	</script>

@endsection

@section('css_addon')
	<link rel="stylesheet" href="{{ url('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" />
@endsection

@section('content')

	<nav class="breadcrumb">
		<a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
		<a class="breadcrumb-item" >Manage Event</a>
	</nav>

	@include('layout.dashboard.alert_flash')

	<div class="row">
		<div class="col-md-12">
			<div class="card card-block">
				<h4 class="card-title">Daftar Event</h4>
				<hr>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAdd">Add</button>
				<br>
				<br>
				<div class="table-responsive">
					<table class="table table-striped table-hover table-sm">
						<thead>
						<tr>
							<th class="text-xs-center">No</th>
							<th>Acara</th>
							<th>Tanggal</th>
							<th>Status</th>
							<th style="text-align: center">Action</th>
						</tr>
						</thead>
						<tbody>
						<?php $skipped = ($events->currentPage() * $events->perPage())- $events->perPage();?>
						@foreach($events as $event)
							<tr>
								<td class="text-xs-center">{{ $skipped + $loop->iteration }}</td>
								<td>{{ $event->title }}</td>
								<td>{{ Carbon\Carbon::parse($event->start)->format('d-m-Y H:i') }}</td>

								{{-- Status Akhir --}}
								@if( $event->isEnded() )
									<td><h6><span class="tag tag-pill tag-default">Lewat</span></h6></td>
								@else
									<td><h6><span class="tag tag-pill tag-primary">Belum</span></h6></td>
								@endif

								<td th style="text-align: center">
									<button url="{{ url('admin/kalender/event/delete') }}/{{ $event->id }}" class="btn btn-danger btn-delete">Delete</button>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
				{{ $events->links('vendor.pagination.bootstrap-4') }}
			</div>
		</div>

	</div>
	<!-- Modal Add Event-->
	<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
			        </button>
			        <h4 class="modal-title" id="modalAddLabel">Tambah Event</h4>
			    </div>
			<div class="modal-body">
				<form class="form" action="{{ url('admin/kalender/event') }}" method="post">
					{{ csrf_field() }}
			        <label>Nama Event</label>
			        <input class="form-group form-control" type="text" name="nama" required>
					<label>Tanggal Event</label>
	                <div class='form-group input-group date' id='date-picker-to'>
	                    <input type='text' class="form-control" name="tanggal" required>
	                    <span class="input-group-addon">
	                        <span class="fa fa-calendar"></span>
	                    </span>
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