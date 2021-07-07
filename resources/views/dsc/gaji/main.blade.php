@extends('layout.outsider')
@section('title')
    View Data Mentor
@endsection
@section('js_addon')

    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4-4.1.1/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/r-2.2.7/sb-1.0.1/sp-1.2.2/datatables.min.js">
    </script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
    </script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js">
    </script>
    <script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">
    </script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js">
    </script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js">
    </script>

    <script>
        $('.btn-reset').on('click', function() {
            var mentor_id = $(this).attr('mentor');
            var mentor_name = $(this).attr('data-name');
            $('input[id="mentor_id"]').val(mentor_id);
            $('#mentor_name').val(mentor_name);
        });

        $('#dataTable').DataTable({
            searching: true,
            dom: 'Tf<"clear">lrtip<"bottom"B>',
            buttons: [{
                    extend: 'excelHtml5',
                    title: 'Data export'
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A1',
                    title: 'Data export'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Data export'
                },
            ],
        });

        var paginate = {{ request()->route('paginate') }}
        $('#selectPaginate').val(paginate);

    </script>

@endsection
@section('content')
    @include('layout.dashboard.alert_flash')

    <div class="card card-block">
        <h3 class="card-title">Laporan Penggajian</h3>
        <h6 class="text-muted">Data Mentor Belum Mentoring dapat dilihat <a href="{{ url('/dsc') }}">disini</a></h6>
        <hr>

        <h5>Laporan Mentoring </h5>
        <div class="table-responsive">
            <table id="dataTable" class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Mentor</th>
                        <th>NIM Mentor</th>
                        <th>Pembimbing</th>
                        <th>Materi</th>
                        <th>Link Gambar</th>
                        <th>Link Record</th>
                        <th>Gambar (Jika ada)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($myData as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="width: 200px">{{ $data->judul_agenda }}</td>
                            <td>{{ $data->kode }}</td>
                            <td>{{ $data->mentor_nim }}</td>
                            <td>{{ $data->mentor_nama }}</td>
                            <td>{{ $data->materi }}</td>
                            <td>
                                <a
                                    href="{{ url('/') . '/BERITA_MENTORING/' . $data->judul_agenda . '/' . $data->kode . '/' . $data->photo }}">
                                    {{ url('/') . '/BERITA_MENTORING/' . $data->judul_agenda . '/' . $data->kode . '/' . $data->photo }} </a>
                            </td>
                            <td>{{ $data->record_gmeet }}</td>
                            <td>
                                <img src="{{ url('/') . '/BERITA_MENTORING/' . $data->judul_agenda . '/' . $data->kode . '/' . $data->photo }}" alt=""
                                style="width: 300px; height=250px; border-radius:20px">

                            </td>

                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



    </div>



@endsection
