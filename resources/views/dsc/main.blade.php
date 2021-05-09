@extends('layout.outsider')
@section('title')
View Data Mentor
@endsection
@section('js_addon')

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/r-2.2.7/sb-1.0.1/sp-1.2.2/datatables.min.js">
</script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>


<script>
    $('.btn-reset').on('click', function() {
        var mentor_id = $(this).attr('mentor');
        var mentor_name = $(this).attr('data-name');
        $('input[id="mentor_id"]').val(mentor_id);
        $('#mentor_name').val(mentor_name);
    });

    $('#dataTable').DataTable({
        dom: 'Bfrtip',
        "ordering": false,
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ]
    });

    var paginate = {{request()->route('paginate')}}
    $('#selectPaginate').val(paginate);
</script>

@endsection
@section('content')
@include('layout.dashboard.alert_flash')

<div class="card card-block">
    <h4 class="card-title">Data Mentor Belum Mentoring</h4>
    <h6 class="text-muted">Butuh Bantuan Teknis ? Hubungi Helpdesk IT Support SIBIMA <a href="">Disini</a></h6>
    <hr>

    <div class="form-group">
      <label for="">Pilih Agenda Mentoring Yang Akan Dicek</label>
      <select class="form-control"  onchange="location = this.value;" id="">
        @forelse ($acara as $item)
            <option value="{{url('/dsc').'/'.$item->id}}">{{$item->judul}}</option>
        @empty
            
        @endforelse
      </select>
    </div>

    <h5>Daftar Mentor Belum Mentoring Sama Sekali</h5>
    <div class="table-responsive">
        <table id="dataTable" class="table table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode Kelompok</th>
                    <th>NIM Mentor</th>
                    <th>Nama Mentor</th>
                    <th>Line Mentor</th>
                    <th>Kontak Mentor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($myData as $data)
                <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$data->kode}}</td>
                <td>{{$data->nim}}</td>
                <td>{{$data->nama}}</td>
                <td>{{$data->line_id}}</td>
                <td>{{$data->no_telp}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


  
</div>



@endsection