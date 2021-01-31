@extends('layout.admin')
@section('title') Kalender Islamic Character Building @endsection

@section('css_addon')
    <link href="{{ url('bower_components/fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('js_addon')
    <script src="{{ url('bower_components/moment/min/moment.min.js') }}"  type="text/javascript"></script>
    <script src="{{ url('bower_components/fullcalendar/dist/fullcalendar.min.js') }}"  type="text/javascript"></script>
    <script>
        var data = JSON.parse('{!! $events->toJson() !!}');
        $('#calendar').fullCalendar({
            height: 410,
            events: data,
            eventColor: '#20a8d8',
            eventTextColor: 'white',
        })
    </script>
@endsection

@section('content')

    <div class="card card-block">
        <h5 class="card-title">Kalender Islamic Character Building</h5>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div id='calendar'></div>
            </div>
        </div>
    </div>


@endsection


