@extends('layouts.application')
@section('content')
<!-- aqui-->
<div class="container-fluid mt-3 pr-5 pl-5">
    <div class="row inside_nav someimpor">
        <div class="col-lg-2 py-2 border-right border-primary offset-lg-1">
            <a href="#" class="btn btn-lg btn-block boton active" style="background-color: #009CE0;">Beneficios obtenidos</a>
        </div>
        <div class="col-lg-2 py-2 border-right border-primary">
            <a href="#" class="btn btn-lg btn-block boton">agrEgar dependientes</a>
        </div>
        <div class="col-lg-2 py-2 border-right border-primary">
            <a href="#" class="btn btn-lg btn-block boton">estado de cuenta</a>
        </div>
        <div class="col-lg-2 py-2 border-right border-primary">
            <a href="#" class="btn btn-lg btn-block boton">mis documentos</a>
        </div>
        <div class="col-lg-2 py-2">
            <a href="#" class="btn btn-lg btn-block boton">referir amigos</a>
        </div>
    </div>
</div>
<div class="container-fluid mt-1 font-weight-bold" style="font-size: 14px;">
    <div class="row">
        <div class="col-lg-3 text-right pl-5">
            <span>REGISTRO DE BENEFICIARIOS
            </span>
        </div>
        <div class="col-lg-3 text-center pl-5"> <span>ESTUDIO SOCIOECONÓMICO</span></div>
        <div class="col-lg-3 text-center pr-5"> <span>SUBIR DOCUMENTOS</span></div>
        <div class="col-lg-3 text-left pl-5"> <span>FIRMA ELECTRÓNICA</span></div>
    </div>
</div>
</div>
<div class="container-fluid">
    <div class="d-flex justify-content-center mt-1">
        <div class="arrow-steps clearfix">
            <div class="row">
                <div class="col-lg-3 py-2 px-0">
                    <div class="step current"> <span class="float-right"> 25%</span> </div>
                </div>
                <div class="col-lg-3 py-2 px-0">
                    <div class="step"> <span class="float-right">50%</span> </div>
                </div>
                <div class="col-lg-3 py-2 px-0">
                    <div class="step" style="background-color: #009CE0;"> <span class="float-right"> 75%</span> </div>
                </div>
                <div class="col-lg-3 py-2 px-0">
                    <div class="step" style="background-color: #009CE0;"> <span class="float-right">100%</span> </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="barra">
    <div class="row">
        <div class="col-lg-12">
            <h6 class="text-center">PROGRESO DE REGISTRO</h6>
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
