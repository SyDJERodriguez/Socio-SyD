<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nuevo Registro de Club Dar</title>
</head>
<body>
    <h3>Una persona quiere contactarlos.</h3>

    <p><b>Nombre:</b> <span class="text-uppercase">{{$data['name']}} {{$data['lastName']}}</span>.</p>
    <p><b>Mensaje:</b></p>
    <p>{{$data['comment']}}</p>
    <br>
    <p><b>Email:</b> {{$data['email']}} - <b>Número de teléfono:</b> {{$data['mobile']}}.</p>

    
</body>
</html>