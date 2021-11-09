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
                <form action="{{route('send.restore.password')}}" method="GET" id="sendRestorePassword">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <input autocomplete="new-password" class="form-control-sm form-control" type="text" name="email"
                                       placeholder="CORREO ELECTRÓNICO" required>

                            </div>
                            <div class="col-12">
                                <p style="font-size:12px;padding-top:4px" class="primary-color">
                                    *Si no visualizas el correo en tu bandeja de entrada, revisa en correo no deseado
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <br>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info" id="sendEmailRestore">ENVIAR</button>
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
                        <img src="{{asset('img/icon_check.png')}}">
                        <h5 class="text-white">REGISTRO EXITOSO</h5>
                        <p class="text-white" id="clientName"></p>
                        <p class="text-white" id="clientNumber"></p>
                        <p class="text-white" id="clientMessage"></p>
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
                        <p><i class="fas fa-times" style="font-size: 28px;color: #00A1E3"></i></p>
                        <h5 class="text-white">ERROR AL GENERAR EL REGISTRO</h5>
                        <p class="text-white">Ha ocurrido un error. <br>Por favor revíselo e inténtelo nuevamente</p>
                        <a href="{{route('home')}}" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal modalSignUpInCadenas --}}
<div class="modal fade" id="modalSignUpInCadenas" tabindex="-1" role="dialog" aria-labelledby="modalSignUpInCadenas" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;background-color: #143153;">
                <button type="button" class="close" style="padding: 0.1rem 1rem 0.5rem;background-color: #00A5E6;"  data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h5 class="text-white">Por favor, regístrate en el  formulario de Cadenas</h5>
                        <a href="javascript:void(0)" onclick="abrirModalCadenas()" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >ACEPTAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function abrirModalCadenas() {
        $('.modal').modal('hide');
        $('#modalCadenas').modal('show');
    }
</script>

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
                        <img src="{{asset('img/icon_check.png')}}">
                        <h5 class="text-white">ERROR EN EL SERVIDOR</h5>
                        <p class="text-white">¡Ha ocurrido un error en el servidor! Por favor intente más tarde</p>
                        <a href="{{route('home')}}" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</a>
                    </div>
                </div>
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
                        <img src="{{asset('img/icon_check.png')}}">
                        <h5 class="text-white">NOTIFICACIÓN ENVIADA A TU CORREO CORRECTAMENTE</h5>
                        <p class="text-white">En breve nos ponemos en contacto contigo</p>
                        <p class="text-white" id="clientNumber"></p>
                        <a href="." class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal RESTORE PASSWORD-->
<div class="modal fade" id="restorePasswordSuccess" tabindex="-1" role="dialog" aria-labelledby="modalSuccess" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">

            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <img src="{{asset('img/icon_check.png')}}">
                        <h5 class="text-white">SU CONTRASEÑA HA SIDO RESTABLECIDA CORRECTAMENTE</h5>
                        <p class="text-white">Por favor ingresa a nuestra página <b>sociosyd.com</b> con tu nueva contraseña</p>
                        <p class="text-white" id="clientNumber"></p>
                        <a href="{{route('home')}}" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal SEND EMAIL RESTORE PASSWORD-->
<div class="modal fade" id="sendRestoreEmail" tabindex="-1" role="dialog" aria-labelledby="modalSuccess" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">

            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <img src="{{asset('img/icon_check.png')}}">
                        <h5 class="text-white">SE HA ENVIADO UN MENSAJE A TU CORREO O TELÉFONO PARA QUE PUEDAS <br>RESTABLECER TU CONTRASEÑA</h5>
                        <p class="text-white">En un momento recibirás un correo <br>con los pasos para que puedas restablecer tu contraseña</p>
                        <p class="text-white"></p>
                        <a href="{{route('home')}}" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >ACEPTAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal forgot client number-->
<div class="modal fade" id="modalForgotNum" tabindex="-1" role="dialog" aria-labelledby="modalForgotNum" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px; background-color: #143153;">
                <button type="button" class="close" style="padding: 0.1rem 1rem 0.5rem;background-color: #00A5E6;"  data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="border: 1px solid black;">
                <div class="row">
                    <div class="col-lg-8 pt-2 pb-5">
                        <h4>RECUPERAR NÚMERO DE CLIENTE</h4>
                        <div class="line1">
                            <img src="{{asset('img/line2.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <p style="padding-left: 1px">Ingresa tu correo electrónico registrado <br>
                        o tu número de teléfonico de 10 dígitos</p>
                    </div>
                </div>

                <form autocomplete="off" action="{{route('customer.forgotClientNumber')}}" method="POST" id="sendForgotClientNumberForm">
                    @method('POST')
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <input style="border: 1px solid black"
                                autocomplete="new-password" class="form-control-sm form-control"
                                type="email" name="email"
                                placeholder="CORREO ELECTRÓNICO"
                                pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9._%+-]+@[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9.-]+\.[a-zA-ZñÑ]{2,}$">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 py-1">
                                <input autocomplete="new-password" class="form-control-sm form-control"
                                type="text" name="mobile_number"
                                placeholder="NO. TELEFÓNICO 10 DIG"
                                maxlength="10" pattern="[0-9]{10}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3 offset-lg-9 text-center">
                                <button type="submit"
                                style="background-color: #00A5E6;"
                                class="text-white btn btn-sm px-4"
                                id="sendForgotClientNumber">
                                ENVIAR</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal ACTIVATE ACCOUNT-->
<div class="modal fade" id="modalActivate" tabindex="-1" role="dialog" aria-labelledby="modalSuccess" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex flex-row-reverse">
                <span class="times" data-dismiss="modal" aria-label="Close">X</span>
            </div>
            <div class="modal-body">
                <h5 class="text-uppercase">ACTIVAR MI CUENTA</h5>
                <img src="{{asset('img/line.png')}}" alt="line">
                <h6 style="margin-top: -17px">Ingresa tu correo electrónico registrado</h6>
                <br>
                <form action="{{route('send.activate.account')}}" method="GET" id="sendRestoreAccount">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <input autocomplete="new-password" class="form-control-sm form-control" type="text" name="email"
                                       placeholder="CORREO ELECTRÓNICO" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <br>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info" id="sendEmailRestore">ENVIAR</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal SEND EMAIL RESTORE ACCOUNT-->
<div class="modal fade" id="sendRestoreAccountSuccess" tabindex="-1" role="dialog" aria-labelledby="modalSuccess" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">

            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <img src="{{asset('img/icon_check.png')}}">
                        <h5 class="text-white">SE HA ENVIADO UN MAIL PARA QUE PUEDAS RESTABLECER TU CUENTA</h5>
                        <p class="text-white">En un momento recibirás un correo con los pasos<br> para que puedas restablecer tu contraseña</p>
                        <p class="text-white">Si no visualizas el correo, por favor revisa tu correo en la carpeta de no deseado o SPAM</p>
                        <a href="{{route('home')}}" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >ACEPTAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal RESTORE ACCOUNT SUCCESS-->
<div class="modal fade" id="restoreAccountSuccess" tabindex="-1" role="dialog" aria-labelledby="modalSuccess" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">

            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <img src="{{asset('img/icon_check.png')}}">
                        <h5 class="text-white">SU CUENTA HA SIDO RESTABLECIDA CORRECTAMENTE</h5>
                        <p class="text-white">Ya puedes ingresar a nuestra página <b>sociosyd.com</b> <br>con tu nueva cuenta</p>
                        <p class="text-white" id="clientNumber"></p>
                        <a href="{{route('home')}}" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Asistencias -->
<div class="modal fade" id="modalAsistencias" tabindex="-1" role="dialog" aria-labelledby="modalAsistencias" aria-hidden="true">
    <div class="modal-dialog modal-xl  " role="document">
        <div class="modal-content  mb-0 pb-0">
            <div class="modal-header d-flex flex-row-reverse">
                <span class="times" data-dismiss="modal" aria-label="Close">X</span>
            </div>
            <div class="modal-body mb-0 pb-0">
                <h5 class="text-uppercase">
                    SERVICIOS DE ASISTENCIA
                </h5>
                <div class="line1">
                    <img src="{{asset('img/line2.png')}}" alt="">
                </div>
                <br>

            </div>

            <div class="row" class="" style="padding: 30px;border-radius: 8px;">

                <div class="col-lg-4 text-center py-3">
                    <h6 style="color: #143153;"><img class="py-2" src="{{asset('img/icon1.png')}}" ><br> <strong class="py-2"> ORIENTACIÓN MÉDICA  <br> TELEFÓNICA </strong></h6>
                </div>
                <div class="col-lg-4 py-3 text-center">
                    <h6 style="color: #143153;"> <img class="py-2" src="{{asset('img/icon2.png')}}"><br><strong class="py-2"> ORIENTACIÓN EMOCIONAL <br> TELEFÓNICA </strong></h6>
                </div>
                <div class="col-lg-4 py-3 text-center">
                    <h6 style="color: #143153;"><img class="py-2"src="{{asset('img/icon3.png')}}"> <br><strong class="py-2"> AMBULANCIA TERRESTRE <br> POR ACCIDENTE</strong></h6>
                </div>
                <div class="col-lg-3 text-center py-3">
                    <h6 style="color: #143153;"><img class="py-2" src="{{asset('img/icon4.png')}}"><br> <strong class="py-2">ORIENTACIÓN NUTRICIONAL <br> TELEFÓNICA
                    </strong></h6>
                </div>
                <div class="col-lg-3 py-3 text-center">
                    <h6 style="color: #143153;"> <img class="py-2" src="{{asset('img/icon5.png')}}"><br><strong class="py-2"> VIDEO CONSULTA <br>
                        POR COVID-19 </strong></h6>
                </div>
                <div class="col-lg-3 py-3 text-center">
                    <h6 style="color: #143153;"><img class="py-2" src="{{asset('img/icon6.png')}}"> <br><strong class="py-2"> ASISTENCIA  <br>
                        FUNERARIA
                        </strong></h6>
                </div>
                <div class="col-lg-3 py-3 text-center">
                    <h6 style="color: #143153;"><img class="py-2"src="{{asset('img/icon7.png')}}"> <br><strong class="py-2"> 
                        ENVÍO DE GRÚA <br> POR ACCIDENTE <br> (NIVEL ORO)</strong></h6>
                </div>

                <div class="col-lg-12 text-center playHomeVideo" onclick="playHomeVideo('usoDeGrua',1)">
                    <button class="btn btn-lg" style="background-color: #143153">
                        VER VIDEO
                    </button>
                </div>

            </div>

            <div style="width: 100%;padding: 10px;">
                <p style="color: #143153;">*Consulta términos y condiciones</p>
                <button class="btn btn-lg btn-block" data-dismiss="modal">
                  CERRAR
                </button>
              </div>

            <div class="container-fluid">
                <div style="background: #143153" class="p-3">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal VIDEO HOME-->
<div class="modal fade" id="modalVideo" tabindex="-1" role="dialog" aria-labelledby="modalVideo" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div class="modal-header d-flex flex-row-reverse" style="background-color: #ffffff;">
                <span class="times" data-dismiss="modal" aria-label="Close">X</span>
            </div>
            <div class="modal-body " style="background-color: #143153;padding-top: 0px;padding-bottom: 0px;">
                <div class="row">
                    <div class="div">
                        <video id="videoSocioSYD" class="videoInsert" controls>
                            {{-- <source src="{{asset('video/socioSYD_video.mp4')}}" type="video/mp4"> --}}
                          Your browser does not support the video tag.
                          </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal SEGUROS -->
<div class="modal fade" id="modalSeguros" tabindex="-1" role="dialog" aria-labelledby="modalSeguros" aria-hidden="true">
    <div class="modal-dialog modal-xl  " role="document">
        <div class="modal-content  mb-0 pb-0">
            <div class="modal-header d-flex flex-row-reverse">
                <span class="times" data-dismiss="modal" aria-label="Close">X</span>
            </div>
            <div class="modal-body mb-0 pb-0">
                <h5 class="text-uppercase">
                    SEGURO DE ACCIDENTES PERSONALES
                </h5>
                <div class="line1">
                    <img src="{{asset('img/line2.png')}}" alt="">
                </div>
                <br>

            </div>

            <div class="row" class="" style="padding: 30px;border-radius: 8px;">

                <div class="col-lg-4 text-center py-3" style="cursor: pointer;">
                    <h6 style="color: #143153;"><img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/perdida_organica.png')}}"
                        ><br> <strong class="py-3"> PÉRDIDA ORGÁNICA POR ACCIDENTE  <br>
                            <div class="pt-2"> Te apoyamos si pierdes una <br> o más extremidades. </div>
                        </strong></h6>
                        <a class="btn btn-outline-light btn-sm playBenefits"
                         style="background-color: #143153"
                         id="showVideoButton1"
                         href="#modalSeguros"
                         onclick="playVideoBenefit('perdidaOrganica')"
                        >Ver video</a>
                </div>
                <div class="col-lg-4 py-3 text-center" style="cursor: pointer;">
                    <h6 style="color: #143153;"> <img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/invalidez_total.png')}}">
                        <br><strong class="py-3"> INVALIDEZ TOTAL <br> Y PERMANENTE <br>
                            <div class="pt-2"> Recibe apoyo si a causa <br> de algun accidente ya no
                                <br> puedes realizar tu trabajo. </div> </strong></h6>
                        <a class="btn btn-outline-light btn-sm playBenefits"
                            style="background-color: #143153"
                            id="showVideoButton2"
                            href="#modalSeguros"
                            onclick="playVideoBenefit('invalidezTotal')"
                            >Ver video</a>
                </div>
                <div class="col-lg-4 py-3 text-center" style="cursor: pointer;">
                    <h6 style="color: #143153;"><img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/muerte_accidental.png')}}">
                         <br><strong class="py-3"> MUERTE ACCIDENTAL   <br>
                            <div class="pt-2"> Si llegas a faltar, protege a <br>los que más quieres. </div>
                        </strong></h6>
                        <a class="btn btn-outline-light btn-sm playBenefits"
                             style="background-color: #143153"
                             id="showVideoButton1"
                             href="#modalSeguros"
                             onclick="playVideoBenefit('muerteAccidental')"
                            >Ver video</a>
                </div>
                <div class="col-lg-4 text-center py-3" style="cursor: pointer;">
                    <h6 style="color: #143153;"><img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/reembolso.png')}}">
                        <br> <strong class="py-3">REEMBOLSO DE  <br> GASTOS MÉDICOS  <br>
                            <div class="pt-2"> Cubrimos tus gastos que <br> deriven de algún accidente. </div>
                    </strong></h6>
                    <a class="btn btn-outline-light btn-sm playBenefits"
                         style="background-color: #143153"
                         id="showVideoButton1"
                         href="#modalSeguros"
                         onclick="playVideoBenefit('gastosMedicos')"
                        >Ver video</a>
                </div>
                <div class="col-lg-4 py-3 text-center">
                </div>
                <div class="col-lg-4 py-3 text-center" style="cursor: pointer;">
                    <h6 style="color: #143153;"><img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/indemnización.png')}}"> <br>
                        <strong class="py-3"> INDEMNIZACIÓN DIARIA  <br>  <div class="pt-2"> Si necesitas hospitalización,
                            <br> nosotros te ayudamos.  </div> </strong></h6>
                </div>

            </div>

            <div style="width: 100%;padding: 10px;">
                <p style="color: #143153;">*Consulta términos y condiciones</p>
                <button class="btn btn-lg btn-block" data-dismiss="modal">
                  CERRAR
                </button>
              </div>

            <div class="container-fluid">
                <div style="background: #143153" class="p-3">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal VIDEO HOME-->
<div class="modal fade" id="modalVideoBenefits" tabindex="-1" role="dialog" aria-labelledby="modalVideoBenefits" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div class="modal-header d-flex flex-row-reverse" style="background-color: #ffffff;">
                <span class="times" data-dismiss="modal" aria-label="Close">X</span>
            </div>
            <div class="modal-body " style="background-color: #143153;padding-top: 0px;padding-bottom: 0px;">
                <div class="row">
                    <div class="div">
                        <video id="videoBenefits" class="videoInsert" controls>

                          Your browser does not support the video tag.
                          </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
