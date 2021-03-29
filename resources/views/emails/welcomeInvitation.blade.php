<div>
    <p>¡Bienvenido! {{$data['name'].' '.$data['last_name'].' '.$data['second_last_name']}}</p>

    <p>Te has registrado en la plataforma de lealtad SYD, has clic en este
        <a href="{{url('account/verify/'.$data['email'])}}">enlace</a>
        para activar tu cuenta.</p>
</div>