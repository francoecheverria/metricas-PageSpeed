
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('css/welcome/index.css') }}" rel="stylesheet">

    <title>Metricas-PageSpeed</title>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="container text-center">
        <img class="img-fluid my-4 d-block mx-auto" src="{{ asset('image/img4.png') }}" alt="Metricas-PageSpeed">
        <div class="form-group">
            <a href="{{ url('/metrics') }}" class="btn btn-info text-white">Metrics</a>
        </div>
        <div class="form-group">
            <a href="{{ url('/about-metrics') }}" class="btn btn-info text-white">About Metrics</a>
        </div>
    </div>
</body>
</html>
