<!-- Question Model about client number-->
<div class="modal fade" id="modalQuestion" tabindex="-1" role="dialog" aria-labelledby="modalQuestion" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 500px;">
        <div class="modal-content border-0 rounded-0" style="background:transparent">
            <div class="modal-header" style="height: 35px; background-color: #fff !important;">
                <button type="button" class="close"
                        style="margin: 0rem 0rem -1rem auto;padding: 0.1rem 1rem 0.5rem;background-color: #00A5E6;"
                        data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body blue-dark">
                <div>
                    <div>
                        <h5 class="text-white"><b>¿YA CUENTAS CON NÚMERO DE CLIENTE?</b></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9 py-2 text-center">
                        <img src="{{asset('img/logo.png')}}" alt="logo" width="50%"></div>
                    <div class="col-lg-3 py2 text-center">
                        <a href="#" class="text-white btn btn bg-primary btn-sm my-2"
                           style="padding-left: 40px;padding-right: 40px;"
                           data-toggle="modal" data-target="#modalPositive" data-dismiss="modal">
                            SI
                        </a>
                        <br>
                        <input type="button" class="btn btn-light btn-sm" value="NO"
                               style="padding-left: 35px;padding-right: 35px;background-color: white;color: #00A5E6;"
                               data-toggle="modal" data-target="#modalNegative" data-dismiss="modal">
                        <form method="POST" action="{{route('customer.deactivate')}}" id="deleteForm"
                              style="display: none;">
                            @method("PUT")
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Negative response -->
<div class="modal fade" id="modalNegative" tabindex="-1" role="dialog" aria-labelledby="modalNegative" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 500px;">
        <div class="modal-content border-0 rounded-0" style="background:transparent">
            <div class="modal-header" style="height: 35px; background-color: #fff !important;">
                <button type="button" class="close"
                        style="margin: 0rem 0rem -1rem auto;padding: 0.1rem 1rem 0.5rem;background-color: #00A5E6;"
                        data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body blue-dark">
                <div>
                    <div>
                        <h5 class="text-white"><b>En caso de que no tengas o bien, no recuerdes tu número de cliente, comunícate al <b>800 SyD (793) 1010</b> y con gusto te apoyamos</b></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 py-2 text-center">
                        <img src="{{asset('img/logo.png')}}" alt="logo" width="50%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Positive response -->
<div class="modal fade rounded-0" id="modalPositive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg rounded-0" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header border-0 rounded-0" style="background-color: #143153;;">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <div class="modal-header d-flex flex-row-reverse">
                    <span class="times" data-dismiss="modal" aria-label="Close">X</span>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-7 pt-2 pb-5">
                        <h2>ACTUALIZACIÓN TIPO DE CUENTA </h2>
                        <div class="line1">
                            <img src="{{asset('img/line2.png')}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger" id="form_alert_employee" role="alert" style="border-radius: 6px;" hidden>
                </div>
                <form autocomplete="off" id="employeeForm" method="POST" action="{{route('customer.update.employee')}}">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 py-2" style="display: flex">
                            <input type="text" class="form-control btnBorder" placeholder="NÚMERO DE CLIENTE"
                                   id="client_number_employee" name="client_number" pattern="[0-9]{8}" maxlength="8"required>
                            <p style="color: red; margin: 0;">*</p>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <div class="form-check form-check-inline text-right">
                            <label class="form-check-label pr-2" for="inlineCheckbox1"
                                   style="color: grey;font-size: 12px;">
                                <strong>ACEPTAR</strong>

                                <br>
                                <a href="#" data-toggle="modal" data-target="#modalAviso">
                                    AVISO DE PRIVACIDAD</a>
                                <br>
                                <a href="#" data-toggle="modal" data-target="#modalGeneralTerms">
                                    TÉRMINOS Y CONDICIONES</a>
                            </label>
                            <input class="form-check-input " style="width: 30px;height: 30px;" type="checkbox" id="inlineCheckbox1" value="option1" required>
                        </div>
                        <input type="submit" class="btn btn" style="background-color: #00A1E3;color: white;"
                               id="btnSend" value="Enviar">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Modal SUCCESS-->
<div class="modal fade" id="modalSuccessEmployee" tabindex="-1" role="dialog" aria-labelledby="modalSuccess" aria-hidden="true">
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
                        <h5 class="text-white">ACTUALIZACIÓN EXITOSA</h5>
                        <p class="text-white">TU CUENTA HA SIDO ACTUALIZADA A CUENTA INDIVIDUAL DE MANERA CORRECTA</p>
                        <a href="{{route('customer.benefits')}}" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Error-->
<div class="modal fade" id="modalErrorEmployee" tabindex="-1" role="dialog" aria-labelledby="modalSuccess" aria-hidden="true">
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
                        <h5 class="text-white">ERROR AL GENERAR LA ACTUALIZACIÓN</h5>
                        <p class="text-white">¡HA OCURRIDO UN ERROR! POR FAVOR INTENTE DE NUEVO</p>
                        <a href="{{route('customer.benefits')}}" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
