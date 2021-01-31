<input style="display: none;" name="kelompok_id" value="{{ $kelompok->id }}" type="text">
<input style="display: none;" name="berita_mentoring_id" value="{{ $berita_mentoring->id }}" type="text">

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
                    <input class="form-control form-head" type="text" name="tempat"
                           value="{{ $berita_mentoring->tempat }}" required>
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
                    <input class="form-control form-head" value="{{ $berita_mentoring->materi }}"
                           type="text" name="materi" required>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6">
            <div class="form-group input-group">
                <span class="input-group-addon input-group-head">Hari / Tanggal </span>
                <input class="form-control form-head" type="text"
                       value="{{ \Carbon\Carbon::parse($berita_mentoring->tanggal)->format('d/m/Y H:i') }}" disabled>
                <span class="input-group-addon input-group-head" style="width: 20px">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon input-group-head">Kultum</span>
                    <input class="form-control form-head" type="text" name="materi_kultum"
                           value="{{ $berita_mentoring->materi_kultum }}" required>
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
                @foreach($berita_mentoring->getKelompok->getMentee as $mentee)
                    <?php $nilai = $mentee->getNilaiMentoringByAgenda($agenda_id) ?>
                    @if($nilai != null)
                    <tr>
                        <input type="number" name="nilai_id[]"
                               value="{{ $nilai->id }}" style="display: none">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $nilai->nim }}</td>
                        <td>{{ $nilai->nama }}</td>
                        <td>{{ $nilai->kelas }}</td>
                        <td>
                            <input class="form-control form-control-sm"
                                   type="number" required value="{{ $nilai->kehadiran }}" name="nilai[]" >
                        </td>
                        <td>
                            <input class="form-control form-control-sm"
                                   type="number" name="kultum[]" value="{{ $nilai->kultum }}" required>
                        </td>
                    </tr>
                    {{--@else TODO: Handling Jika Nilai Belum Diinput--}}
                    @endif
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
