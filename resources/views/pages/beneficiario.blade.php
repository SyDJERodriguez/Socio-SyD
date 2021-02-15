@extends('layouts.application')
@section('content')

<!--BUTTONS AND PROGRESS ARROW-->
@include('includes.options')

<div class="barra">
    <div class="row">
        <div class="col-lg-12">
            <hr style="background-color: #009CE0; height:2px; margin-left: 10px;margin-right: 10px ">
        </div>
        <div class="col-lg-3" style="margin-left: 10px">
            <h6 style="font-size: 18px">Hola EDUARDO Martínez Pozos</h6>
            <p style="font-size: 18px">No. de Cliente <span style="color: #009CE0;"> 000000</span></p>
            <br>
            <button class="btn btn-lg text-white" style="background-color: #143153;font-size: 18px;width: 100%;"
                type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false"
                aria-controls="collapseExample">
                <b>SEGURO DE ACCIDENTES PERSONALES<i class="fas fa-caret-down pl-2"></i></b>
            </button>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body border-0">
                    <span>- Coberturas principales del seguro</span>
                    <span><strong style="color: #143153;"> - Registro de beneficiarios</strong></span>
                    <span>- Estudio Socioeconómico</span>
                    <span>- Subir documentos</span>
                    <span>- Firma electrónica</span>
                </div>
            </div>
            <button class="btn btn-lg text-white px-5" style="background-color: #143153;font-size: 20px;width: 100%;"
                type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false"
                aria-controls="collapseExample">
                <b> ASISTENCIAS ACTIVAS<i class="fas fa-caret-down pl-2"></i></b>
            </button>
            </p>
            <div class="collapse" id="collapseExample2">
                <div class="card card-body border-0">
                    <span>- Tipo de asistencia</span>

                </div>
            </div>
            <span style="color: grey;font-size: 20px;"><strong>
                    SOLICITAR ASISTENCIA

                    <i class="fas fa-phone-alt" style="font-size: 30px;vertical-align: top;"></i></strong>
                <hr style="margin: 0; border: 1px solid grey;width: 60%;" />
                <br />
            </span>
            <button class="btn btn-lg text-white px-5" style="background-color: #143153;width: 100%;" type="button"
                data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false"
                aria-controls="collapseExample">
                <b> RED DE DESCUENTOS<i class="fas fa-caret-down pl-2"></i></b>
            </button>
            </p>
            <div class="collapse" id="collapseExample3">
                <div class="card card-body border-0 text-center p-5">


                </div>

            </div>
            <button class="btn"
                style="color: #143153;border:8px solid #009CE0;border-radius: 10px;width: 100%;font-size: 20px;"><b>TUVE
                    UN ACCIDENTE</b> </button>

        </div>

        <div class="col-lg-8 pt-0 pl-5 pr-5 pb-5">
            <div class="row">
                <div class="col-6 text-center p-4">
                    <img src="{{asset('img/Asset8.png')}}" height="80px" alt="">
                </div>
                <div class="col-6 p-0">
                    <img src="{{asset('img/benefeciroimg.png')}}" width="100%" alt="">
                </div>
            </div>
            <form>
                <div class="row" style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 30px;border-radius: 8px;">
                    <div class="col-lg-12">
                        <h6>BENEFICIARIO 1</h6>
                    </div>

                    <div class="col-lg-6 py-2">
                        <input type="text" class="form-control" placeholder="NOMBRE">
                    </div>
                    <div class="col-lg-6 py-2">
                        <input type="text" class="form-control" placeholder="APELLIDOS">
                    </div>
                    <div class="col-lg-6 py-2">
                        <input type="text" class="form-control" placeholder="PARENTESCO">
                    </div>
                    <div class="col-lg-6 py-2">
                        <input type="text" class="form-control" placeholder="PORCENTAJE DESTINADO">
                    </div>
                    <div class="col-lg-6 py-2">
                        <input type="text" class="form-control" placeholder="No. TELEFÓNICO 10 DÍGITOS">
                    </div>
                    <div class="col-lg-6 py-2">
                        <input type="button" class="btn btn float-right text-white px-5"
                            style="background-color: #009CE0;" value="Confirmar">
                    </div>
                    <div class="col-lg-12">
                        <h6>BENEFICIARIO 2</h6>
                    </div>
                    <div class="col-lg-6 py-2">
                        <input type="text" class="form-control" placeholder="NOMBRE">
                    </div>
                    <div class="col-lg-6 py-2">
                        <input type="text" class="form-control" placeholder="APELLIDOS">
                    </div>
                    <div class="col-lg-6 py-2">
                        <input type="text" class="form-control" placeholder="PARENTESO">
                    </div>
                    <div class="col-lg-6 py-2">
                        <input type="text" class="form-control" placeholder="PORCENTAJE DESTINADO">
                    </div>
                    <div class="col-lg-6 py-2">
                        <input type="text" class="form-control" placeholder="No. TELEFÓNICO 10 DÍGITOS">
                        <div class="col-lg-6 py-2">
                            <input type="button" class="btn btn float-right text-white px-5"
                                style="background-color: #009CE0;" value="Confirmar">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 py-2 float-right">
                            <button class="btn btn float-right text-white" style="background-color: #009CE0;">eliminar
                                mi cuenta</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
    <br />

    @stop
