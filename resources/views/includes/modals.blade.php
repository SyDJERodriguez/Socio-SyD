<!-- Modal Forgot My Password-->
<div class="modal fade" id="modal4" tabindex="-1" role="dialog" aria-labelledby="modal4" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex flex-row-reverse">
                <span class="times" data-dismiss="modal" aria-label="Close">X</span>
            </div>
            <div class="modal-body">
                <h5 class="text-uppercase">OLVIDÉ MI CONTRASEÑA</h5>
                <img src="{{asset('img/line.png')}}" alt="line">
                <h6 style="margin-top: -17px">Ingresa tu correo electrónico registrado</h6>
                <br>
                <form action="#">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <input class="form-control-sm form-control" type="text"
                                       placeholder="CORREO ELECTRÓNICO">

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <br>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info">ENVIAR</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal SUCCESS-->
<div class="modal fade" id="modalSuccess" tabindex="-1" role="dialog" aria-labelledby="modalSuccess" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">
                <button type="button" class="close" style="padding: 0.1rem 1rem 0.5rem;background-color: #00A5E6;"  data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <img src="{{'img/icon_check.png'}}">
                        <h5 class="text-white">REGISTRO EXITOSO</h5>
                        <p class="text-white" id="clientName"></p>
                        <p class="text-white" id="clientNumber"></p>
                        <a href="{{route('home')}}" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >ENTRAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Error-->
<div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="modalSuccess" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">
                <button type="button" class="close" style="padding: 0.1rem 1rem 0.5rem;background-color: #00A5E6;"  data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <img src="{{'img/icon_check.png'}}">
                        <h5 class="text-white">ERROR AL GENERAR EL REGISTRO</h5>
                        <p class="text-white">¡HA OCURRIDO UN ERROR, POR FAVOR INTENTE DE NUEVO!</p>
                        <a href="{{route('home')}}" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Error SERVER-->
<div class="modal fade" id="modalErrorServer" tabindex="-1" role="dialog" aria-labelledby="modalSuccess" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">
                <button type="button" class="close" style="padding: 0.1rem 1rem 0.5rem;background-color: #00A5E6;"  data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <img src="{{'img/icon_check.png'}}">
                        <h5 class="text-white">ERROR EN EL SERVIDOR</h5>
                        <p class="text-white">¡HA OCURRIDO UN ERROR EN EL SERVIDOR, POR FAVOR INTENTE MÁS TARDE!</p>
                        <a href="{{route('home')}}" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal NOTIFICATIONS-->
<div class="modal fade" id="modalNotifications" tabindex="-1" role="dialog" aria-labelledby="modalNotifications"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="toast-header text-white blue-dark p-0" >
                <strong class="mr-auto ml-4">Notificaciones</strong>
                <button type="button" class="ml-2  close text-white p-2"
                        data-dismiss="modal" aria-label="Close" style="background-color:#00A5E6">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><span class="float-left" style="font-size: 14px;">¡Ya tienes derecho a tu
                                seguro<bR> de accidentes personales</span><span class="float-right"><i style="color: #00A5E6;"
                                                                                                       class="fas fa-circle"></i></span></li>
                    <li class="list-group-item"><span class="float-left" style="font-size: 14px;">Lorem ipsum dolor sit
                                amet, consectetuer<br> adipiscing elit, sed diam </span><span class="float-right"><i
                                style="color: #00A5E6;" class="far fa-check"></i></span></li>
                    <li class="list-group-item"><span class="float-left" style="font-size: 14px;">Lorem ipsum dolor sit
                                amet, consectetuer<br> adipiscing elit, sed diam </span><span class="float-right"><i
                                style="color: #00A5E6;" class="far fa-check"></i></span></li>
                    <li class="list-group-item"><span class="float-left" style="font-size: 14px;">Lorem ipsum dolor sit
                                amet, consectetuer<br> adipiscing elit, sed diam </span><span class="float-right"><i
                                style="color: #00A5E6;" class="far fa-check"></i></span></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<!-- Modal CONTACTO FORMULARIO-->
<div class="modal fade" id="contactModalSuccess" tabindex="-1" role="dialog" aria-labelledby="modalSuccess" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">
                
            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <img src="{{'img/icon_check.png'}}">
                        <h5 class="text-white">Correo enviado exitosamente</h5>
                        <p class="text-white" id="clientName"></p>
                        <p class="text-white" id="clientNumber"></p>
                        <a href="." class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >Aceptar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
