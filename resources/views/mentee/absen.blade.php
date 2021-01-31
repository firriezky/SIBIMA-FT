@extends('layout.mentee')

@section('title')
    Kelompok
@endsection

@section('js_addon')
@endsection

@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('mentee/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">QR Code</a>
    </nav>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title"> Absensi QR Code Big Class / TM / Webinar </h4>
                        <hr>
                        <h5>Silakan SCAN QR Code yang ditampilkan operator di layar Zoom/Google Meet</h5>
                        <hr>
                        <div id="reader" class="p-5" width="50%"></div>
                        {{-- Table & Head Data Kelompok Dipisah --}}
                        <script src="{{ url("library\html5-qrcode\minified\html5-qrcode.min.js")}}"></script>

                        <script>
                            function onScanSuccess(qrMessage) {
                                // handle the scanned code as you like
                                console.log(`QR matched = ${qrMessage}`);
                            }

                            function onScanFailure(error) {
                                // handle scan failure, usually better to ignore and keep scanning
                                console.warn(`QR error = ${error}`);
                            }

                            let html5QrcodeScanner = new Html5QrcodeScanner(
                                "reader", { fps: 10, qrbox: 250 }, /* verbose= */ true);
                            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                        </script>

                    </div>
                </div>
            </div>


        </div>

@endsection