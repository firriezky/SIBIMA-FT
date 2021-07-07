@extends('layout.admin')

@section('title')
    Manage Kelompok
@endsection

@section('js_addon')
    <script>
        $('.btn-delete').on('click', function() {
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
                function() {
                    window.location.replace(url);
                }
            );
        });

        $('.btn-remove').on('click', function() {
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
                function() {
                    window.location.replace(url);
                }
            );
        });

        $('#btn-ganti-mentor').on('click', function() {
            // show Modal
            var url = $('#data-mentor').text();
            $('#input-mentor-lama').val(url);
            $('#ganti-mentor').modal('show');
        })

        $('#btn-ganti-asisten').on('click', function() {
            // show Modal
            var url = $('#data-asisten').text();
            $('#input-asisten-lama').val(url);
            $('#ganti-asisten').modal('show');
        })

        $(document).on('click', '.btn-gaji-mentor', function() {
            let idGroup = $(this).attr("id");

            $('#modal-gaji-mentor').modal('show');
            document.getElementById("vgaji_idgroup").innerText = idGroup;


            let csrf = $('meta[name="csrf-token"]').attr('content');

            document.getElementById('formUploadGaji').action = window.location.origin + '/kelompok/' + idGroup +
                '/updateGaji';
            $.ajax({
                url: window.location.origin + '/kelompok/' + idGroup + '/detailajax',
                method: "GET",
                data: {
                    id: idGroup,
                    '_token': csrf
                },
                beforeSend: function() {
                    $('#loader').show();
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(ts) {
                    alert("error bos");
                    console.log(ts.responseText);
                }, // or console.log(ts.responseText)
                success: function(data) {
                    console.log("responsez : ");
                    console.log(data);
                    let mType = data.ticket_type;
                    let mAccountType = data.account_type;
                    let ticketType = "Unknown Ticket Type";
                    let accountType = "Unknown Account Type";

                    var nim = data.nid;

                    let mStatus = data.status;
                    let statusAppend = "";

                    document.getElementById('vgaji_nama_mentor').innerText = data.nama;
                    document.getElementById("vgaji_rekening_mentor").innerText = data.no_rekening;
                    document.getElementById("vgaji_kodegroup").innerText = data.kode;
                    document.getElementById("vgaji_sender").value = data.pentransfer;
                    document.getElementById("vgaji_total").value = data.jumlah_gaji;
                    document.getElementById("vgaji_kelompok_id").value = data.id;

					const imgURL = window.location.origin +data.path_transfer;
					document.getElementById("vgaji_img_bukti").src = imgURL;

                    let isGaji = data.status_gaji;
                    switch (isGaji) {
                        case "Sudah Digaji":
                            document.getElementById("vgaji_status").options.selectedIndex = 0;
                            break;
                        case "Belum Digaji":
                            document.getElementById("vgaji_status").options.selectedIndex = 1;
                            break;
                        case "Pending":
                            document.getElementById("vgaji_status").options.selectedIndex = 2;
                            break;

                        default:
                            break;
                    }

                    if (data.no_rekening == null) {
                        document.getElementById("vgaji_rekening_mentor").innerText =
                            "Mentor Belum Mengisi No Rekening";
                    }
                }
            });
        });
    </script>
@endsection

@section('content')

    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard') }}">Dashboard</a>
        <a class="breadcrumb-item" href="{{ url('admin/kelompok') }}">Manage Kelompok</a>
        <a class="breadcrumb-item">Kelompok {{ $kelompok->kode }}</a>
    </nav>

    @include('layout.dashboard.alert_flash')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-block">
                <h4 class="card-title">Kelompok {{ $kelompok->kode }}</h4>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <button id="{{ $kelompok->id }}" class="btn btn-success btn-gaji-mentor" type="button">Upload/Edit
                            Gaji Mentor</button>
                        <button id="btn-ganti-mentor" class="btn btn-primary" type="button">Ganti Mentor</button>
                        <button id="btn-ganti-asisten" class="btn btn-primary" type="button">Ganti Asisten</button>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambah-mentee">Tambah
                            Mentee</button>
                        <button url="{{ url('admin/kelompok/delete') }}/{{ $kelompok->id }}"
                            class="btn btn-danger pull-right btn-delete">Delete Kelompok
                        </button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>( Kelompok Ini Belum Digaji )</h5>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group form-group">
                            <span class="input-group-addon">Mentor</span>
                            <div class="form-control form-head" id="data-mentor">{{ $kelompok->getMentor->nama }}
                                ({{ $kelompok->getMentor->nim }})</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group form-group">
                            <span class="input-group-addon"><span class="fa fa-phone"></span></span>
                            <div class="form-control form-head">
                                {{ $kelompok->getMentor->no_telp or '-' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group form-group">
                            <span class="input-group-addon"><span class="fa fa-comment-o"></span> LINE</span>
                            <div class="form-control form-head">
                                {{ $kelompok->getMentor->line_id or '-' }}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    @if ($kelompok->getAsisten != null)
                        <div class="col-md-4">
                            <div class="input-group form-group">
                                <span class="input-group-addon">Asisten</span>
                                <div class="form-control form-head" id="data-asisten">{{ $kelompok->getAsisten->nama }}
                                    ({{ $kelompok->getAsisten->nim }})</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-phone"></span></span>
                                <div class="form-control form-head">
                                    {{ $kelompok->getAsisten->no_telp or ' - ' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group form-group">
                                <span class="input-group-addon"><span class="fa fa-comment-o"></span> LINE</span>
                                <div class="form-control form-head">
                                    {{ $kelompok->getAsisten->line_id or ' - ' }}
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
                            <?php $i = 1; ?>
                            @foreach ($kelompok->getMentee as $mentee)
                                <tr>
                                    <td scope="row">{{ $i++ }}</td>
                                    <td>{{ $mentee->nim }}</td>
                                    <td>{{ $mentee->nama }}</td>
                                    <td>{{ $mentee->kelas }}</td>
                                    <td>{{ $mentee->no_telp }}</td>
                                    <td>{{ $mentee->program_studi }}</td>
                                    <td><button type="button"
                                            url="{{ url('admin/kelompok/remove') }}/{{ $mentee->id }}"
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
    < {{-- Modal Tambah Mentee --}} <div class="modal fade" id="tambah-mentee">
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
                            <input class="form-control" name="nim"
                                placeholder="Masukkan NIM Mentee yang akan ditambahkan ke Kelompok Ini">
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
        <div class="modal fade" id="ganti-mentor">
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


        {{-- Modal Gaji Mentor --}}
        <div class="modal fade" id="modal-gaji-mentor">
            <div class="modal-dialog" role="document">
                <form id="formUploadGaji" action="" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Gaji Mentor Kelompok</h4>
                            <h5>Kode Kelompok : <span id="vgaji_kodegroup"></span></h5>
                            <h5>ID Kelompok : <span id="vgaji_idgroup"></span></h5>
                        </div>
                        <form method="post" action="{{ url('admin/kelompok/change') }}/{{ $kelompok->id }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <input type="hidden" id="vgaji_kelompok_id" name="id">
                                <div class="form-group">
                                    <label>Nama Mentor</label>
                                    <h5 id="vgaji_nama_mentor"></h5>
                                </div>

                                <div class="form-group">
                                    <label>Nomor Rekening Mentor</label>
                                    <h5 id="vgaji_rekening_mentor"></h5>
                                </div>


                                <div class="form-group">
                                    <label for="">Status Gaji</label>
                                    <select class="form-control" name="vgaji_status" required id="vgaji_status">
                                        <option value="Sudah Digaji">Sudah Digaji</option>
                                        <option value="Belum Digaji">Belum Digaji</option>
                                        <option value="Pending">Pending</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Nama Pihak Yang Mentransfer</label>
                                    <input type="text" class="form-control" name="vgaji_sender" id="vgaji_sender"
                                        aria-describedby="helpId" placeholder="Pengirim Gaji">
                                    <small id="helpId" class="form-text text-muted">Nama Pengurus Yang Mengirim Gaji</small>
                                </div>

                                <div class="form-group">
                                    <label for="">Jumlah Gaji</label>
                                    <input type="text" class="form-control" name="vgaji_total" id="vgaji_total"
                                        aria-describedby="helpId" placeholder="Jumlah Gaji">
                                    <small id="helpId" class="form-text text-muted">Jumlah Gaji Yang Dikirim</small>
                                </div>

                                <div class="form-group">
                                    <label for="">Upload/Edit Bukti Pembayaran</label>
                                    <input type="file" accept="image/*" class="form-control-file" name="vgaji_bukti"
                                        id="vgaji_bukti" placeholder="" aria-describedby="fileHelpId">
                                    <small id="fileHelpId" class="form-text text-muted">Bukti Pembayaran</small>
                                </div>

                                <hr>
                                <h3>Bukti Gaji </h3>
                                <h6>(Jika sudah ditransfer akan muncul disini)</h6>
							
								<img id="vgaji_img_bukti" class="card-img-top img-fluid" style=" border-radius:20px !important" src=""
                                alt="Card image cap"
                                onerror="this.src='http://www.pallenz.co.nz/assets/camaleon_cms/image-not-found-4a963b95bf081c3ea02923dceaeb3f8085e1a654fc54840aac61a57a60903fef.png'">

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update Bukti Pembayaran</button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </form>
            </div><!-- /.modal-dialog -->
        </div>

        {{-- Modal Ganti Asisten --}}
        <div class="modal fade" id="ganti-asisten">
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
