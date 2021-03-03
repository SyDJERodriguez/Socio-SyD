<div>
    <p>Hola {{$data['name'].' '.$data['last_name']}}</p>

    <p>Has solicitado restablecer tu cuenta en la plataforma SYD, has clic este <a href="{{url('account/activate/'.$data['client_number'])}}">enlace</a>  para continuar.</p>
</div>
