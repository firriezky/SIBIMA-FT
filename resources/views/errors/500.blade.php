<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>500 Server Error</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ url('img/favicon.png') }}">
    <link href="{{ url('css/style-coreui.min.css') }}" rel="stylesheet">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      
</head>
<body>

<div class="container d-table">
    <div class="d-100vh-va-middle  d-flex justify-content-center mb-3 ">
        <div class="container d-table ">
            <div class="d-100vh-va-middle">
                <div class="d-flex justify-content-center">
                    <lottie-player style="max-width: 50%" src="https://assets4.lottiefiles.com/packages/lf20_28vrmff4.json"  background="transparent"  speed="1"  class="img-fluid"  loop  autoplay></lottie-player>
                </div>
            <div class="justify-content-center" style="text-align: center"><h2> <strong> 500 Internal Server Error</strong></h2><br> <h4>Kembali ke <a href="{{url('/')}}">SIBIMA</a><br>atau Hubungi <a href=""> SIBIMA IT-Helpdesk </a>jika gangguan terus berlanjut <br>
            <br><small>Error Description : {{$exception->getMessage()}}</small> </h4><br><br>
            </div>
        </div>
    </div>
</div>
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

     <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
</body>
</html>
