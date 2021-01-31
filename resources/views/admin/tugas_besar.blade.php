@extends('layout.admin')
@section('title')
	Tugas Besar
@endsection
@section('js_addon')
	<script>
		$(document).ready(function () {
			$('.btn-nilai').on('click', function(){

				var kelompok_id = $(this).attr('kelompok');
				var kode = $(this).attr('kode');
				var current_nilai = $('#nilai-' + kelompok_id).text();
				if(current_nilai == "-"){
					current_nilai = null;
				}

				swal({
					title: "Input Nilai Tugas Besar",
					text: "Masukkan Nilai Tugas Besar untuk <strong style='font-weight: bold'>Kelompok " + kode + "</strong>",
					type: "input",
					showCancelButton: true,
					closeOnConfirm: false,
//					animation: "slide-from-top",
					inputPlaceholder: "1 - 100",
					showLoaderOnConfirm: true,
					html: true,
					inputValue : current_nilai
				}, function(inputValue){
					// Exit Handler
					if (inputValue === false) return false;

					// Handler Input Nothing
					var isnum = /^\d+$/.test(inputValue);
					if (!isnum) {
						swal.showInputError("Jangan Kosong hiks / Masukkan Angka!");
						return false
					} else if (inputValue > 100 || inputValue < 1){
						swal.showInputError("Masukan Nilai sesuai range yang telah ditentukan");
						return false
					}

					// Input Nilai Handler (Ajax)
					$.ajax({
						url: '{{ url('admin/api/tugas-besar/submit') }}',

						data: {
							kelompok_id : kelompok_id,
							nilai : inputValue
						},
						error: function(xhr){
							swal("Error!", "Cek Koneksi Internet!!" ,"error");
						},
						success: function(result){
							swal("Success!", "Nilai berhasil di Input", "success");
							// Change DOM Nilai
							$('#nilai-' + kelompok_id).text(inputValue);
						}
					});
				});
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
				});
			});

			$('.btn-detail').on('click', function () {
				var deskripsi = $(this).attr('data-detail');
				var url = $(this).attr('data-url');
				swal({
					title: "Detail Tubes",
					text : "Deskripsi : " + deskripsi + "<br><br>Link Tubes : " +
					"<a href='" + url + "'>" + url + "</a>",
					html : true
				});
			});

		});
	</script>
@endsection
@section('content')
	<nav class="breadcrumb">
		<a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
		<a class="breadcrumb-item">Tugas Besar</a>
	</nav>

	@include('layout.dashboard.alert_flash')

	<div class="card card-block">
		<h4 class="card-title">Daftar Tugas Besar</h4>
		<hr>
		<form method="get">
			<div class="row">
				<div class="col-md-4 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-xs-12">
							<button data-toggle="modal" data-target="#input-telat" type="button"
									class="btn btn-danger">Input Tugas Besar [Telat]</button>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-12 col-xs-12 float-md-right float-sm-none">
					<div class="form-group">
					    <input type="text" 
					    		class="search form-control" 
					    		placeholder="Search by Mentor/Fakultas"
					    		name="search" value="{{ $search or "" }}">
					</div>
				</div>
			</div>
		</form>
		<div class="table-responsive">
			<table class="table table-hover table-sm">
			<thead>
				<tr>
					<th class="text-xs-center">#</th>
					<th>Kelompok</th>
					<th>Mentor</th>
					<th>Fakultas</th>
					<th>Judul</th>
					{{--<th>Link Tugas</th>--}}
					<th>Nilai</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
			<?php $skipped = ($list_tugas_besar->currentPage() * $list_tugas_besar->perPage())
					- $list_tugas_besar->perPage();?>

				@foreach($list_tugas_besar as $tubes)
				<tr>
					<td class="text-xs-center">{{ $skipped + $loop->iteration }}</td>
					<td>{{ $tubes->getKelompok->kode }}</td>
					<td>{{ $tubes->getKelompok->getMentor->nama }}</td>
					<td>{{ $tubes->fakultas  }}</td>
					<td>{{ $tubes->judul }}</td>
{{--					<td><a target="_blank" href="{{ $tubes->video_link }}">Download / View</a></td>--}}
					<td id="nilai-{{$tubes->kelompok_id}}">{{ $tubes->nilai or "-" }}</td>
					<td>
						<button data-detail="{{$tubes->deskripsi}}" data-url="{{ $tubes->video_link }}"
								class="btn btn-success btn-sm btn-detail">Detail</button>
						<button kelompok="{{$tubes->kelompok_id}}"
								kode="{{$tubes->getKelompok->kode }}"
								class="btn btn-nilai btn-primary btn-sm">Penilaian
						</button>
						<button url="{{ url('admin/tugas-besar/delete') }}/{{ $tubes->kelompok_id }}" class="btn btn-danger btn-sm btn-delete">Delete</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		</div>
		{{ $list_tugas_besar->appends(['search' => $search])
							->links('vendor.pagination.bootstrap-4') }}
	</div>

	<div class="modal fade" id="input-telat">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Input Tugas Besar [Telat]</h4>
				</div>
				<form method="post" action="{{ url('admin/tugas-besar') }}">
					<div class="modal-body">
						{{ csrf_field() }}
						<div class="form-group">
							<label>NIM Perwakilan Kelompok</label>
							<input type="text" class="form-control" name="nim" required>
						</div>
						<div class="form-group">
							<label>Fakultas</label>
							<select class="form-control" name="fakultas" required>
								<option disabled selected>Pilih Fakultas</option>
								@foreach($list_fakultas as $fakultas)
									<option>{{ $fakultas->fakultas }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">Judul Tugas Besar</label>
							<input type="text" class="form-control" required name="judul"/>
						</div>
						<div class="form-group">
							<label class="control-label">Link Tugas Besar Video/Poster/Karya Lain</label>
							<input type="text" class="form-control" placeholder="ex : https://www.youtube.com/watch?v=ulr0muQKjk0" required name="video_link"/>
						</div>
						<div class="form-group">
							<label class="control-label">Deskripsi Singkat</label>
							<textarea type="text" class="form-control" required name="deskripsi" ></textarea>
						</div>
						<div class="form-group">
							<label class="control-label">Nilai (Langsung Isi untuk yang telat)</label>
							<input type="number" class="form-control" required name="nilai" placeholder="0-100"/>
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