<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invitación a cuenta dependiente Socio SYD</title>
</head>
<body>
<p>¡Hola! {{$data['name'].' '.$data['last_name'].' '.$data['second_last_name']}}</p>

<p>Has sido invitado por {{$data['owner']}} para formar parte de sus dependientes.</p>
<p>Has click en este
    <a href="{{ route('update.mechanic.dependent',$data) }}">enlace</a>
    para convertir tu cuenta individual en cuenta dependiente de {{$data['owner']}}.
</p>
</body>
</html>
