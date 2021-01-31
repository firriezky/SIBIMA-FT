@extends('layout.admin')

@section('title')
	Agenda
@endsection

@section('js_addon')
	<script src="{{ url("bower_components/moment/min/moment.min.js") }}"></script>
	<script src="{{ url("bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js") }}"></script>
	<script>
		$('.date-picker-to').datetimepicker({
			format: 'DD/MM/YYYY HH:mm',
			minDate: new Date(),
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

		$('#selectKelompok').change(function () {
			var tipe = $(this).val();

			// General Handler
			if( tipe==1 ){
				$("input[name='judul']").val('').prop('readonly', false);
				$('#materi-tempat').css('display', 'none');
				$('#select-fakultas-talaqi').css('display', 'none');
				$('#select-fakultas-general').css('display', 'none');


			// General Handler
			} else if(tipe == 2) {
				$("input[name='judul']").val('').prop('readonly', false);

				// Add Materi & Tempat
				$('#materi-tempat').css('display', 'inline');
				$('#select-fakultas-talaqi').css('display', 'none');
				$('#select-fakultas-general').css('display', 'inline');


			// Talaqi Handler
			} else if(tipe == 3) {
				$("input[name='judul']").val('').prop('readonly', false);

				// Add Materi & Tempat
				$('#materi-tempat').css('display', 'inline');
				$('#select-fakultas-talaqi').css('display', 'inline');
				$('#select-fakultas-general').css('display', 'none');


			//Shining Handler
			} else if(tipe == 4) {
				$("input[name='judul']").val('Shining Team').prop('readonly', true);
				$('#materi-tempat').css('display', 'none');
				$('#select-fakultas-talaqi').css('display', 'none');
				$('#select-fakultas-general').css('display', 'none');

			}
		});

		$('.btn-edit').on('click', function(){
			var agenda_id = $(this).attr('agenda');
			var judul = $(this).attr('judul');

			$('input[id="agenda_id"]').val(agenda_id);
			$('input[id="judul_edit"]').val(judul);

		});

		$('.btn-delete').on('click', function () {
			var url = $(this).attr('url');

			swal({
					title: "Are you sure?",
					text: "Penghapusan Agenda, dapat menghilangkan data Berita Mentoring, Presensi, dan Nilai Mentee",
					type: "input",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Ya, hapus saja",
					closeOnConfirm: false,
					inputPlaceholder: "Masukan Password Rahasia"
				},
				function(inputValue){
					if (inputValue === false)
						return false;
					else if (inputValue == ""){
						swal.showInputError("Jangan Kosong hiks / Masukkan Angka!");
						return false
					} else {
						window.location.href = url + "?password=" + inputValue;
					}

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
		<a class="breadcrumb-item">Agenda</a>
	</nav>

	@include('layout.dashboard.alert_flash')

	<div class="row">
		<div class="col-md-12">
			<div class="card card-block">
				<h4 class="card-title">Daftar Agenda</h4>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAdd">Tambah Agenda</button>
					</div>
				</div>
				<br>
				<div class="table-responsive">
					<table class="table table-hover table-sm table-striped">
						<thead>
						<tr>
							<th class="text-xs-center">No</th>
							<th>Judul</th>
							<th>Tipe</th>
							<th>Fakultas</th>
							<th>Tanggal Akhir</th>
							<th>Status</th>
							<th style="text-align: center">Action</th>
						</tr>
						</thead>
						<tbody>
						<?php $skipped = ($agendas->currentPage() * $agendas->perPage())- $agendas->perPage();?>
						<?php Date::setLocale('id'); ?>
						@foreach($agendas as $agenda)
							<tr>
								<td class="text-xs-center">{{ $skipped + $loop->iteration }}</td>
								<td>{{ $agenda->judul }}</td>
								<td>{{ $agenda->getTipe() }}</td>
								<td>{{ $agenda->fakultas or "-" }}</td>

								<td>{{ Jenssegers\Date\Date::parse($agenda->tanggal_akhir)->format('l, j F Y - H:i') }}</td>

								{{-- Status Akhir --}}
								@if( $agenda->isEnded() )
									<td><h6 class="m-b-0"><span class="tag tag-pill tag-default">Selesai</span></h6></td>
								@else
									<td><h6 class="m-b-0"><span class="tag tag-pill tag-primary">Berlangsung</span></h6></td>
								@endif

								<td th style="text-align: center">
									<button type="button" class="btn btn-info btn-sm btn-edit"
											data-toggle="modal" agenda="{{ $agenda->id }}"
											judul="{{ $agenda->judul }}"
											data-target="#modalEdit">Edit
									</button>
									<button url="{{ url('admin/agenda/delete') }}/{{ $agenda->id }}"
									   class="btn btn-danger btn-sm btn-delete">Delete
									</button>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
				{{ $agendas->links('vendor.pagination.bootstrap-4') }}
			</div>
		</div>
	</div>

	<!-- Modal Add Agenda-->
	<div class="modal fade" id="modalAdd" tabindex="-1">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
			        </button>
			        <h4 class="modal-title" id="modalAddLabel">Tambah Agenda Mentoring</h4>
			    </div>
				<div class="modal-body">
					<form class="form" action="{{ url('admin/agenda/') }}" method="post">
						{{ csrf_field() }}

						<label>Judul Agenda</label>
						<input class="form-group form-control" type="text" name="judul" required>

						<label>Tipe Agenda</label>
						<div class="form-group">
							<select class="form-control" id="selectKelompok" name="tipe">
								<option value="1">Mentoring</option>
								<option value="2">General</option>
								<option value="3">Talaqi</option>
								<option value="4">Tugas Besar</option>
							</select>
						</div>

						<label>Tanggal Berakhir</label>
						<div class='form-group input-group date date-picker-to'>
							<input type='text' class="form-control" name="tanggal_akhir" required>
							<span class="input-group-addon">
								<span class="fa fa-calendar"></span>
							</span>
						</div>

						<div id="materi-tempat" style="display: none">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Tempat</label>
										<input class="form-control" type="text" name="tempat">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Materi</label>
										<input class="form-control" type="text" name="materi">
									</div>
								</div>
							</div>

						</div>

						<div id="select-fakultas-talaqi" style="display: none">
							<label>Fakultas</label>
							<div class="form-group">
								<select class="form-control" name="fakultas-talaqi">
									@foreach($list_fakultas_mentor as $fakultas)
										<option value="{{ $fakultas->fakultas }}">{{ $fakultas->fakultas }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div id="select-fakultas-general" style="display: none">
							<label>Fakultas</label>
							<div class="form-group">
								<select class="form-control" name="fakultas-general">
									@foreach($list_fakultas_mentee as $fakultas)
										<option value="{{ $fakultas->fakultas }}">{{ $fakultas->fakultas }}</option>
									@endforeach
								</select>
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

	<!-- Modal Edit Agenda-->
	<div class="modal fade" id="modalEdit" tabindex="-1">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Edit Agenda Mentoring</h4>
				</div>
				<div class="modal-body">
					<form class="form" action="{{ url('admin/agenda/edit') }}" method="post">
						{{ csrf_field() }}
						<input id="agenda_id" style="display: none" name="agenda_id">

						<label>Judul Agenda</label>
						<input class="form-group form-control" type="text" id="judul_edit" readonly>

						<label>Tanggal Akhir Baru</label>
						<div class='form-group input-group date date-picker-to'>
							<input type='text' class="form-control" name="tanggal_akhir_baru" required>
							<span class="input-group-addon">
								<span class="fa fa-calendar"></span>
							</span>
						</div>

						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Edit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection