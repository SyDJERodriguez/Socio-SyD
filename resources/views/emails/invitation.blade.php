<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invitación a Socio SYD</title>
</head>
<body>
    <p>¡Bienvenido! {{$data['name'].' '.$data['last_name'].' '.$data['second_last_name']}}</p>

    <p>Has sido registrado en la plataforma de Socio SYD como asociado.</p>
    <p>Has click en este
        <a href="{{url('invitation/'.$data['client_number'].'/'.$data['mobile_number'] )}}">enlace</a> 
        para completar el registro.
    </p>
</body>
</html>
