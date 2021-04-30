@extends('layouts.application')
@section('content')

<!--BUTTONS AND PROGRESS ARROW-->
@include('includes.options', ['active' => 1])

<div class="container-fluid" style="padding-left: 3rem !important;
    padding-right: 3rem !important;">
      <div class="row">
          @include('includes.Account.sidebarBenefits', ['active' => 4])
 <div class="col-lg-8 pb-5 pr-5 pl-5">

<div class="row displayXL">
    <div class="col-6" >
        <p class="textBene">
            CON TU MONTO MÍNIMO DE COMPRA, <br>
            <strong>OBTIENES BENEFICIOS ESPECIALES</strong>
        </p>
      </div>
      <div class="col-6 contenedorImg">
          <img src="{{asset('img/mecanico-2.png')}}" class="imgBene2">
      </div>
</div>

<div class="row displaySL">
    <div class="col-12" >
        <p class="textBene">
            CON TU MONTO MÍNIMO DE COMPRA, <br>
            <strong>OBTIENES BENEFICIOS ESPECIALES</strong>
        </p>
      </div>
      <div class="col-12 contenedorImg">
          <img src="{{asset('img/mecanico-2.png')}}" class="imgBene2">
      </div>
</div>

  <form>
    <div class="row" class="" style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 30px;border-radius: 8px;">
        @if($level === 'oro' || $level === 'plata')

        <div class="row">
                @if ($level === 'oro')
                <div class="col-12 text-center">
                    <h5>Nivel de asistencias actual: <b>Oro</b></h5>
                </div>
                @else
                <div class="col-lg-12 text-center">
                    <h5>Nivel de asistencias actual: <b>Plata</b></h5>
                </div>
                @endif
        </div>

        <div class="row">
            <div class="col-lg-4 text-center py-3" style="cursor: pointer;" data-toggle="modal" data-target="#modalTerms">
                <h6 style="color: #143153;"><img class="py-2" src="{{asset('img/icon1.png')}}" ><br> <strong class="py-2"> ORIENTACIÓN MÉDICA  <br> TELEFÓNICA</strong></h6>
            </div>
            <div class="col-lg-4 py-3 text-center" style="cursor: pointer;" data-toggle="modal" data-target="#modalTerms">
                <h6 style="color: #143153;"> <img class="py-2" src="{{asset('img/icon2.png')}}"><br><strong class="py-2"> ORIENTACIÓN EMOCIONAL <br> TELEFÓNICA </strong></h6>
            </div>
            <div class="col-lg-4 py-3 text-center" style="cursor: pointer;" data-toggle="modal" data-target="#modalTerms">
                <h6 style="color: #143153;"><img class="py-2"src="{{asset('img/icon3.png')}}"> <br><strong class="py-2"> AMBULANCIA TERRESTRE</strong></h6>
            </div>
            <div class="col-lg-3 text-center py-3" style="cursor: pointer;" data-toggle="modal" data-target="#modalTerms">
                <h6 style="color: #143153;"><img class="py-2" src="{{asset('img/icon4.png')}}"><br> <strong class="py-2">ORIENTACIÓN NUTRICIONAL <br> TELEFÓNICA
                </strong></h6>
            </div>
            <div class="col-lg-3 py-3 text-center" style="cursor: pointer;" data-toggle="modal" data-target="#modalTerms">
                <h6 style="color: #143153;"> <img class="py-2" src="{{asset('img/icon5.png')}}"><br><strong class="py-2"> VIDEO CONSULTA <br>
                    POR COVID 19 </strong></h6>
            </div>
            <div class="col-lg-3 py-3 text-center" style="cursor: pointer;" data-toggle="modal" data-target="#modalTerms">
                <h6 style="padding-top: 15px;color: #143153;"><img class="py-2" src="{{asset('img/icon6.png')}}"> <br><strong class="py-2"> ASISTENCIA  <br>
                    FUNERARIA
                    </strong></h6>
            </div>
                @if($level === 'oro')
                    <div class="col-lg-3 py-3 text-center" style="cursor: pointer;" data-toggle="modal" data-target="#modalTerms">
                        <h6 style="padding-top: 13px;color: #143153;"><img class="py-2"src="{{asset('img/icon7.png')}}"> <br><strong class="py-2"> ENVÍO DE GRÚA</strong></h6>
                    </div>
                @else
                    <div class="col-lg-3 py-3 text-center" style="filter: grayscale(50%); opacity: 0.4;">
                        <h6 style="padding-top: 13px;color: #c4c4c4;"><img class="py-2"src="{{asset('img/icon7.png')}}"> <br><strong class="py-2"> ENVÍO DE GRÚA</strong></h6>
                    </div>
                @endif

        </div>

        @else
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h5 class="text-white">¡AÚN NO TIENES DERECHO A LOS BENEFICIOS DE ASISTENCIA!</h5>
                        <p class="text-white"></p>
                    </div>
                </div>
            </div>
        @endif
    </div>
  </form>

 </div>
    </div>
</div>
@stop
