@extends('layout.mentor')

@section('title') Kelompok @endsection


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
                    document.getElementById("vgaji_sender").innerText = data.pentransfer;
                    document.getElementById("vgaji_total").innerText = data.jumlah_gaji;
                    document.getElementById("vgaji_kelompok_id").value = data.id;

                    const imgURL = window.location.origin + data.path_transfer;
                    document.getElementById("vgaji_img_bukti").src = imgURL;

                    let isGaji = data.status_gaji;
					document.getElementById("vgaji_status").innerText = "Loading";
                    if (isGaji == null || isGaji=="") {
                        document.getElementById("vgaji_status").innerText = "Dalam Proses Antrian Transfer";
                    } else {
                        document.getElementById("vgaji_status").innerText = isGaji;
                    }

					if (data.pentransfer==null || data.pentransfer=="" ) {
						document.getElementById("vgaji_sender").innerText = "Belum Ditransfer";
					}
					if (data.jumlah_gaji==null || data.jumlah_gaji=="" ) {
						document.getElementById("vgaji_total").innerText = "Belum Ada Data";
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
        <a class="breadcrumb-item">Kelompok</a>
    </nav>

    @if ($list_kelompok->count() == 0)

        {{-- ALERT TIDAK ADA KELOMPOK --}}
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger" role="alert">
                            Belum terdapat Kelompok Mentoring, <strong> harap hubungi Admin BM</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif($list_kelompok->count() == 1)

        {{-- TAMPILKAN SINGLE TABLE JIKA KELOMPOK 1 --}}
        @foreach ($list_kelompok as $kelompok)
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-block">
                        <h4 class="card-title">Kelompok {{ $kelompok->kode }}</h4>
                        <hr>

                        {{-- Table & Head Data Kelompok Dipisah --}}
                        @include('layout.dashboard.kelompok_content', [
                        "kelompok" => $kelompok
                        ])

                    </div>
                </div>
            </div>
        @endforeach

    @else
        {{-- TAMPILKAN SEBAGAI ACCORDION JIKA KELOMPOK LEBIH DARI 1 --}}
        @foreach ($list_kelompok as $kelompok)
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header card-header-inverse">
                            <a data-toggle="collapse" href="#collapse{{ $kelompok->kode }}">
                                <p class="title-collapse">Kelompok {{ $kelompok->kode }}</p>
                            </a>
                            <div class="card-actions">
                                <a class="btn-minimize collapsed" data-toggle="collapse"
                                    href="#collapse{{ $kelompok->kode }}">
                                    <i class="fa fa-arrow-down"></i>
                                </a>
                            </div>
                        </div>

                        <div id="collapse{{ $kelompok->kode }}" class="collapse card-block">

                            {{-- Table & Head Data Kelompok Dipisah --}}
                            @include('layout.dashboard.kelompok_content', [
                            "kelompok" => $kelompok
                            ])

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif



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
                                <label for="">Status Gaji : </label>
                                <h4 id="vgaji_status"></h4>
                            </div>

                            <div class="form-group">
                                <label for="">Nama Pihak Yang Mentransfer</label>
                                <h4 id="vgaji_sender"></h4>
                                <small id="helpId" class="form-text text-muted">Nama Pengurus Yang Mengirim Gaji</small>
                            </div>

                            <div class="form-group">
                                <label for="">Jumlah Gaji</label>
                                <h4 id="vgaji_total"></h4>
                                <small id="helpId" class="form-text text-muted">Jumlah Gaji Yang Dikirim</small>
                            </div>

                            <hr>
                            <h3>Bukti Gaji </h3>
                            <h6>(Jika sudah ditransfer akan muncul disini)</h6>

                            <img id="vgaji_img_bukti" class="card-img-top img-fluid" style=" border-radius:20px !important"
                                src="" alt="Card image cap"
                                onerror="this.src='http://www.pallenz.co.nz/assets/camaleon_cms/image-not-found-4a963b95bf081c3ea02923dceaeb3f8085e1a654fc54840aac61a57a60903fef.png'">

                        </div>

                    </form>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div>



@endsection
