<div class="row">
    <div class="col-md-4">
        <div class="input-group form-group">
            <span class="input-group-addon">Mentor</span>
            <div class="form-control form-head">
                {{ ucwords(strtolower($kelompok->getMentor->nama))}} ({{ $kelompok->getMentor->nim }})
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group form-group">
            <span class="input-group-addon"><span class="fa fa-phone"></span></span>
            <div class="form-control form-head">
                {{ $kelompok->getMentor->no_telp or "-" }}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group form-group">
            <span class="input-group-addon"><span class="fa fa-comment-o"></span>Group</span>
            <div class="form-control form-head">
                {{ $kelompok->getMentor->line_id or "-" }}
            </div>
        </div>
    </div>
</div>

<div class="row">
    @if($kelompok->getAsisten != null)
        <div class="col-md-4">
            <div class="input-group form-group">
                <span class="input-group-addon">Asisten</span>
                <div class="form-control form-head">
                    {{ $kelompok->getAsisten->nama }} ({{ $kelompok->getAsisten->nim }})
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group form-group">
                <span class="input-group-addon"><span class="fa fa-phone"></span></span>
                <div class="form-control form-head">
                    {{ $kelompok->getAsisten->no_telp or " - " }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group form-group">
                <span class="input-group-addon"><span class="fa fa-comment-o"></span> LINE</span>
                <div class="form-control form-head">
                    {{ $kelompok->getAsisten->line_id or " - " }}
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
    <table class="table table-hover table-sm table-striped">
        <thead>
        <tr>
            <th class="text-xs-center">No</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>No. HP</th>
            <th>ID Line</th>
            <th>Program Studi</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($kelompok->getMentee as $mentee)
            <tr>
                <td class="text-xs-center">{{ $i++ }}</td>
                <td>{{ $mentee->nim }}</td>
                <td>{{ ucwords(strtolower($mentee->nama)) }}</td>
                <td>{{ $mentee->kelas }}</td>
                <td>{{ $mentee->no_telp }}</td>
                <td>{{ $mentee->line_id or "-"}}</td>
                <td>{{ $mentee->program_studi }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
