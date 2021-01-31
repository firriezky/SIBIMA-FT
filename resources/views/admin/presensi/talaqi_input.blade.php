<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="{{ url('img/favicon.png') }}">

    <title>Input Presensi Talaqi | SIBIMA</title>

    <!-- Icons -->
    <link href="{{ url('bower_components/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="{{ url('css/style-coreui.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/bima.css') }}" rel="stylesheet">

    <link href="{{ url('bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <style>
        body { background-size: cover; }
        .title-agenda {
            padding-top: 40px;
        }
        h3.text-xs-center {
            padding-bottom: 20px;
        }
        table {
            margin-bottom: 0px !important;
        }
        .select2-selection, .select2-container .select2-selection--single, .select2-selection__arrow {
            height: 40px !important;
        }
        #select2-select-nim-container { line-height:  40px; }
        .row-input { padding-bottom: 30px; }
    </style>

</head>

<body>
    <div class="container">

        <div class="row title-agenda">
            <h3 class="text-xs-center">Presensi Talaqi - {{ $agenda->judul }} - {{ $agenda->fakultas }}</h3>
            <h3 class="text-xs-center">Batas Telat - {{ date('d F Y - h:i', strtotime($agenda->tanggal_akhir)) }}</h3>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form class="form form-inline" method="post" action="{{ url('admin/presensi/talaqi/input') }}/{{ $agenda->id }}">
                    {{ csrf_field() }}
                    <div class="row row-input">
                        <div class="col-md-6 offset-md-3 text-xs-center">
                            <div class="form-group" style="padding-right: 20px">
                                <span class="input-group" style="padding-right: 10px"><span class="fa fa-search"></span></span>
                                <select name="nim" class="form-control" id="select-nim" style="width: 400px;" required>
                                    <option disabled>Search berdasarkan NIM / Nama</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('layout.dashboard.alert_flash')

        <div class="row">
            <div class="col-md-12">
                <div class="card card-block">
                    <h4 class="card-title m-b-2 text-xs-center">Latest Presensi</h4>
                    <table class="table table-sm table-hover">
                        <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>NIM</th>
                            <th>JK</th>
                            <th>Fakultas</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($latest_presensi as $presensi)
                            <tr>
                                <td>{{ $presensi->mentor->nama }}</td>
                                <td>{{ $presensi->mentor->nim }}</td>
                                <td>{{ $presensi->mentor->getJK() }}</td>
                                <td>{{ $presensi->mentor->fakultas }}</td>
                                @if($presensi->isTelat())
                                    <td><h5><span class="tag tag-pill tag-warning">Telat</span></h5></td>
                                @else
                                    <td><h5><span class="tag tag-pill tag-success">Hadir</span></h5></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('layout.component.js_body')
    <script src="{{ url('bower_components/select2/dist/js/select2.min.js') }}"></script>
    <script>

        function formatMentee (mentor) {

            if (mentor.loading) return mentor.nama;

            var markup = "<div class='clearfix'>" +
                    "<div>" +
                    "<div>" + mentor.nama.toUpperCase() + "</div>";

            markup += "<div>" +
                    "<div>NIM : " + mentor.nim + " (" + mentor.fakultas + ")</div>" +
                    "</div>" +
                    "</div></div>";

            return markup;
        }

        function formatMenteeSelection(mentee) {
            if (typeof mentee.nama == "undefined"){
                return "Search by Nama / NIM"
            } else {
                return mentee.nama.toUpperCase() + " - " + mentee.nim;
            }

        }

        $("#select-nim").select2({
            ajax: {
                url: "{{ url('admin/api/presensi/get-mentor/') }}",
                dataType: "json",
                delay: 250,
                type: "GET",
                tags: true,
                multiple: true,
                tokenSeparators: [',', ' '],
                minimumInputLength: 2,
                data: function (params) {

                    var queryParameters = {
                        query: params.term,
                        fakultas: "{{ $agenda->fakultas }}"
                    };
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                nama: item.nama,
                                id: item.nim,
                                fakultas: item.fakultas,
                                nim: item.nim
                            }
                        })
                    };
                }
            },
            minimumInputLength: 1,
            escapeMarkup: function (markup) { return markup; },
            templateResult: formatMentee,
            templateSelection: formatMenteeSelection,

        });
    </script>
</body>
</html>

