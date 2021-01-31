@extends('layout.mentee')


@section('title') Nilai @endsection
@section('js_addon')
    <script src="{{ url('bower_components/chart.js/dist/Chart.min.js') }}"></script>
    <script>

        var data = {
            labels: {!!  $label_nilai !!},
            datasets: [
                {
                    label: "Nilai Mentoring",
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    data: {!!  $data_nilai !!}
                },
                {
                    label: "Nilai Kultum",
                    backgroundColor: 'rgba(255,99,132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    data: {!! $data_kultum !!}
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
                            max:100
                        }
                    }]
                },
                responsive: true,
                maintainAspectRatio: false
            },
        });

    </script>

@endsection

@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('admin/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Nilai</a>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    <div class="row">
                        <div class="col-xs-5">
                            <h4 class="card-title">Grafik Nilai Mentoring</h4>
                            <div class="small text-muted" style="margin-top:-10px;">{{ \Carbon\Carbon::now() }}</div>
                        </div>
                        {{--<div class="col-xs-7">--}}
                            {{--<div class="btn-toolbar pull-right">--}}
                                {{--<div class="btn-group hidden-sm-down">--}}
                                    {{--<button type="button" class="btn btn-primary"><i class="fa fa-download"></i></button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="main-chart" style="padding: 20px; height: 350px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="card card-block">
                <h4 class="card-title m-b-2">Nilai Mentoring</h4>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Agenda</th>
                        <th>Kehadiran</th>
                        <th>Kultum</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($nilai_mentoring as $nilai)
                        <tr>
                            <td>{{ $nilai->getBeritaMentoring->getAgenda->judul }}</td>
                            <td>{{ $nilai->kehadiran }}</td>
                            <td>{{ $nilai->kultum != 0 ? $nilai->kultum : '-'}}</td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-block">
                <h4 class="card-title m-b-2">Nilai Mentoring General</h4>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Acara General</th>
                        <th>Nilai</th>
                    </tr>
                    </thead>
                    @foreach($nilai_general as $nilai)
                    <tr>
                        <td>{{ $nilai['agenda'] }}</td>
                        <td>{{ $nilai['nilai'] }}</td>
                    @endforeach
                    @if($nilai_tugas_besar != null)
                    <tr>
                        <td>Tugas Besar</td>
                        <td>{{$nilai_tugas_besar->nilai }}</td>
                    </tr>
                    @endif


                </table>
            </div>
        </div>
    </div>

@endsection
