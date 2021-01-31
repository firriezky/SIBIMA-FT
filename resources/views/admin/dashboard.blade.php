@extends('layout.admin')

@section('title') Dashboard @endsection

@section('css_addon')
@endsection

@section('js_addon')
    <script src="{{ url('bower_components/moment/min/moment.min.js') }}"  type="text/javascript"></script>
    <script src="{{ url('bower_components/chart.js/dist/Chart.min.js') }}"></script>
    <script>
        var data = {
            labels: {!! $label_agenda !!},
            datasets: [
                {
                    label: "Jumlah Mentor yang telah mengisi nilai",

                    // Red Chart
    //                backgroundColor: 'rgba(255, 99, 132, 0.2)',
    //                borderColor: 'rgba(255,99,132,1)',

                    // Blue Chart
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    data: {!! $data_total_berita_mentoring !!},
                }
            ]
        };

        var ctx = document.getElementById("main-chart");
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            max: {{ $kelompok_count }},
                            stepSize: 50
                        }
                    }]
                }
            }

        });

        var data_talaqi = {
            labels: {!! $label_agenda_talaqi !!},
            datasets: [
                {
                    label: "Mentor yang ikut Talaqi",
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255,99,132,1)',
                    borderWidth: 1,
                    data: {!! $data_total_talaqi !!},
                }
            ]
        };

        var ctx = document.getElementById("talaqi-chart");
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data_talaqi,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            max: {{ $fakultas_mentor[0]->count or 0 }},
                            stepSize: 25
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            callback : function(value){
                                return value.replace(/fakultas/i, "")
                            },
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 90
                        }
                    }]

                }
            }

        });

        var data_general = {
            labels: {!! $label_agenda_general !!},
            datasets: [
                {
                    label: "Mentee Yang Hadir",
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    data: {!! $data_total_general !!},
                }
            ]
        };

        var ctx = document.getElementById("general-chart");
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data_general,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            max: {{ $fakultas_mentee[0]->count or 0}},
                            stepSize: 200
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            callback : function(value){
                                return value.replace(/fakultas/i, "")
                            },
                            autoSkip: false,
                            mirror: true,
                            maxRotation: 90,
                            minRotation: 90
                        }
                    }]

                }
            }

        });

    </script>
@endsection

@section('content')

    {{-- Card Counter --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card card-inverse card-info">
                <div class="card-block">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="h4 m-b-0">{{ $mentee_count }}</div>
                            <h5 class="text-muted text-uppercase font-weight-bold">Mentee</h5>
                        </div>

                        <div class="col-xs-6">
                            <div class="h1 text-muted text-xs-right m-b-2">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-inverse card-success">
                <div class="card-block">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="h4 m-b-0">{{ $mentor_count }}</div>
                            <h5 class="text-muted text-uppercase font-weight-bold">Mentor</h5>
                        </div>

                        <div class="col-xs-6">
                            <div class="h1 text-muted text-xs-right m-b-2">
                                <i class="fa fa-user-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-inverse card-warning">
                <div class="card-block">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="h4 m-b-0">{{ $kelompok_count }}</div>
                            <h5 class="text-muted text-uppercase font-weight-bold">Kelompok</h5>
                        </div>

                        <div class="col-xs-6">
                            <div class="h1 text-muted text-xs-right m-b-2">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{--Chart Grafik Berita Mentoring--}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title">Grafik Pengisian Nilai</h4>
                            <div class="small text-muted" style="margin-top:-10px;">{{ \Carbon\Carbon::now() }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="chart-wrapper" style="padding: 20px">
                            <canvas id="main-chart" height="117"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Chart Grafik Talaqi Madah--}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title">Grafik Kehadiran Talaqi</h4>
                            <div class="small text-muted" style="margin-top:-10px;">{{ \Carbon\Carbon::now() }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="chart-wrapper" style="padding: 20px">
                            <canvas id="talaqi-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Chart Grafik General --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title">Grafik Kehadiran Agenda General</h4>
                            <div class="small text-muted" style="margin-top:-10px;">{{ \Carbon\Carbon::now() }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="chart-wrapper" style="padding: 20px">
                            <canvas id="general-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Table Statistik Mentor--}}
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title" style="margin-bottom: 20px">
                        <i class="fa fa-line-chart"></i> Mentor Statistik
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th>Fakultas</th>
                                <th class="text-md-center">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($fakultas_mentor as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucwords(strtolower($data->fakultas)) }}</td>
                                    <td class="text-md-center">{{ $data->count }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title" style="margin-bottom: 20px">
                        <i class="fa fa-line-chart"></i> Mentee Statistik
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th>Fakultas</th>
                                <th class="text-md-center">Total Mentee</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($fakultas_mentee as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucwords(strtolower($data->fakultas)) }}</td>
                                    <td class="text-md-center">{{ $data->count }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection