<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead>
        <tr>
            <th scope="row">No</th>
            <th>NIM</th>
            <th>Nama</th>
            @foreach($agenda_mentoring as $agenda)
                <th class="text-xs-center">{{ str_replace_first("Mentoring ", "M", $agenda->judul) }}</th>
                <th class="text-xs-center">K-{{ str_replace_first("Mentoring ", "M", $agenda->judul) }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($kelompok->getMentee as $mentee)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $mentee->nim }}</td>
                <td>{{ ucwords(strtolower($mentee->nama)) }}</td>
                @foreach($mentee->getNilaiMentoringSeries() as $nilai_mentoring)

                    @if($nilai_mentoring['nilai'] == null)
                        <td class="text-xs-center">-</td>
                        <td class="text-xs-center">-</td>
                    @else
                        <td class="text-xs-center">{{ $nilai_mentoring['nilai'] }}</td>
                        <td class="text-xs-center">{{ $nilai_mentoring['kultum'] }}</td>
                    @endif

                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
