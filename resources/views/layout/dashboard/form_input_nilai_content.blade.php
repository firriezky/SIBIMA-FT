<input style="display: none;" name="kelompok_id" value="{{ $kelompok->id }}" type="text">

<div class="input-header">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon input-group-head">Agenda</span>
                    <input class="form-control form-head" type="text" disabled value="{{ $agenda->judul }}">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon input-group-head">Tempat</span>
                    <input class="form-control form-head" type="text" name="tempat" required>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon input-group-head">Mentor</span>
                    <input class="form-control form-head" type="text" disabled value="{{ $kelompok->getMentor->nama }}">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon input-group-head">Materi</span>
                    <input class="form-control form-head" type="text" name="materi" required>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6">
            <div class="form-group input-group date date-picker">
                <span class="input-group-addon input-group-head">Hari / Tanggal</span>
                <input class="form-control form-head" type="text" name="tanggal" required>
                <span class="input-group-addon input-group-head" style="width: 20px">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon input-group-head">Kultum</span>
                    <input class="form-control form-head" type="text" name="materi_kultum" required>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon input-group-head">Foto Mentoring</span>
                    <input class="form-control form-head" type="file" name="photo" accept="image/*" required>
                </div>
            </div>
        </div>

      



    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-sm table-hover table-striped">
                <thead>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th width="15">Mentoring</th>
                    <th width="80">Kultum</th>
                </thead>
                <tbody>
                    @foreach($kelompok->getMentee as $mentee)
                    {{-- TODO CEK APABILA MENTEE TELAH INPUT NILAI PADA AGENDA TERKAIT --}}
                    {{-- KEMUNGKINAN TERJADI APABILA PINDAH KELOMPOK --}}
                    <tr>
                        <input type="number" name="mentee_id[]" value="{{ $mentee->id }}" style="display: none">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mentee->nim }}</td>
                        <td>{{ $mentee->nama }}</td>
                        <td>{{ $mentee->kelas }}</td>
                        <td>
                            <input class="form-control form-control-sm" type="number" name="nilai[]" required>
                        </td>
                        <td>
                            <input class="form-control form-control-sm" type="number" name="kultum[]" value="0" required>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<hr>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg float-md-right">Submit</button>
        </div>
    </div>
</div>