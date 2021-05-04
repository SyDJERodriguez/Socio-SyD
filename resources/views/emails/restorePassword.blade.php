<div>
    <p>Hola {{$data['name'].' '.$data['last_name']}}</p>

    <p>Has solicitado reestablecer tu contraseña de acceso a la plataforma SYD, has clic este <a href="{{url('password/edit/'.$data['client_number'])}}">enlace</a>  para continuar.</p>
</div>
