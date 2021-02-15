@extends('layouts.application')
@section('content')

<!--BUTTONS AND PROGRESS ARROW-->
@include('includes.options', ['active' => 4])

<div class="container-fluid">
      <div class="row">
          <div class="col-lg-12">
              <h6 class="text-center">PROGRESO DE REGISTRO</h6>
              <hr style="background-color: #009CE0;">
          </div>
   <div class="col-lg-3">
     <h6>Hola EDUARDO Martínez Pozos</h6>
     <p>No. de Cliente <span style="color: #009CE0;"> 000000</span></p>
     <br>
     <button class="btn btn-lg text-white" style="background-color: #143153;font-size: 18px;width: 100%;" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
      <b>seguro de accidentes personales<i class="fas fa-caret-down pl-2"></i></b>
    </button>
  </p>
  <div class="collapse" id="collapseExample">
    <div class="card card-body border-0">
      <span>- Coberturas principales del seguro</span>
      <span>- Registro de beneficiarios</span>
      <span>- Estudio Socioeconómico</span>
      <span>- Subir documentos</span>
      <span>- Firma electrónica</span>
    </div>
  </div>
  <button class="btn btn-lg text-white px-5" style="background-color: #143153;font-size: 20px;width: 100%;" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">
    <b> ASISTENCIAS ACTIVAS<i class="fas fa-caret-down pl-2"></i></b>
  </button>
  </p>
  <div class="collapse" id="collapseExample2">
  <div class="card card-body border-0">
    <span>- Tipo de asistencia</span>
  
  </div>
  </div>
  <span style="color: #143153;font-size: 20px;"><strong>
    SOLICITAR ASISTENCIA
    
    <i class="fas fa-phone-alt" style="font-size: 30px;vertical-align: top;"></i></strong>
    <hr style="margin: 0; border: 1px solid #143153;width: 60%;"/>
    <br/>
  </span>
  <button class="btn btn-lg text-white px-5" style="background-color: #143153;width: 100%;" type="button" data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample">
    <b> RED DE DESCUENTOS<i class="fas fa-caret-down pl-2"></i></b>
  </button>
  </p>
  <div class="collapse" id="collapseExample3">
  <div class="card card-body border-0 text-center p-5">
   
   
  </div>
  
  </div>
  <button class="btn" style="color: #143153;border:8px solid #009CE0;border-radius: 10px;width: 100%;font-size: 20px;"><b>TUVE UN ACCIDENTE</b> </button>
  
   </div>
 <div class="col-lg-9 pb-5 pr-5 pl-5">

<div class="row">
  <div class="col-6  p-4">
    <h4 style="color: #143153;">CON TU MONTO MÍNIMO DE COMPRA,</h4>
    <h4 style="color: #143153;"><strong>OBTIENES BENEFICIOS ESPECIALES.</strong></h4>
  </div>
  <div class="col-6 p-0">
      <img src="assets/img/benefeciroimg.png" width="100%" alt="">
  </div>
</div>
  <form>
    <div class="row" class="" style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 30px;border-radius: 8px;">
    
        <div class="col-lg-4 text-center py-3">
            <h6 style="color: #143153;"><img class="py-2" src="{{asset('img/icon1.png')}}" ><br> <strong class="py-2"> orientación médica <br> telefónica </strong></h6>
        </div>
        <div class="col-lg-4 py-3 text-center">
            <h6 style="color: #143153;"> <img class="py-2" src="{{asset('img/icon2.png')}}"><br><strong class="py-2"> orientación emocional <br> telefónica </strong></h6>
        </div>
        <div class="col-lg-4 py-3 text-center">
            <h6 style="color: #143153;"><img class="py-2"src="{{asset('img/icon3.png')}}"> <br><strong class="py-2"> Ambulancia terrestre</strong></h6>
        </div>
        <div class="col-lg-3 text-center py-3">
            <h6 style="color: #143153;"><img class="py-2" src="{{asset('img/icon4.png')}}"><br> <strong class="py-2">orientación nutricional <br> telefónica
            </strong></h6>
        </div>
        <div class="col-lg-3 py-3 text-center">
            <h6 style="color: #143153;"> <img class="py-2" src="{{asset('img/icon5.png')}}"><br><strong class="py-2"> video consulta <br>
                por covid 19 </strong></h6>
        </div>
        <div class="col-lg-3 py-3 text-center">
            <h6 style="color: #143153;"><img class="py-2" src="{{asset('img/icon6.png')}}"> <br><strong class="py-2"> asistencia <br>
                funeraria 
                </strong></h6>
        </div>
        <div class="col-lg-3 py-3 text-center">
            <h6 style="color: #143153;"><img class="py-2"src="{{asset('img/icon7.png')}}"> <br><strong class="py-2"> Envío de grúa</strong></h6>
        </div>
    </div>
    <div class="row">
      <div class="col-lg-12 py-2 float-right">
        <button class="btn btn float-right text-white" style="background-color: #009CE0;">eliminar mi cuenta</button>
      </div>
    </div>
  </form>
 </div>
    </div>
</div>


@stop