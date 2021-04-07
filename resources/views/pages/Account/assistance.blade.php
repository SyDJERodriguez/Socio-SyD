@extends('layouts.application')
@section('content')

<!--BUTTONS AND PROGRESS ARROW-->
@include('includes.options', ['active' => 1])

<div class="container-fluid" style="padding-left: 3rem !important;
    padding-right: 3rem !important;">
      <div class="row">
          @include('includes.Account.sidebarBenefits', ['active' => 4])
 <div class="col-lg-8 pb-5 pr-5 pl-5">

<div class="row">
  <div class="col-6  p-4">
    <h4 style="color: #143153;">CON TU MONTO MÍNIMO DE COMPRA,</h4>
    <h4 style="color: #143153;"><strong>OBTIENES BENEFICIOS ESPECIALES.</strong></h4>
  </div>
  <div class="col-6 p-0">
      <img  src="{{asset('img/benefeciroimg.png')}}" width="100%" alt="">
  </div>
</div>
  <form>
    <div class="row" class="" style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 30px;border-radius: 8px;">
        @if($level === 'oro' || $level === 'plata')
            <div class="col-lg-4 text-center py-3" style="cursor: pointer;">
                <h6 style="color: #143153;"><img data-toggle="modal" data-target="#modalTerms" class="py-2" src="{{asset('img/icon1.png')}}" ><br> <strong class="py-2"> ORIENTACIÓN MÉDICA  <br> TELEFÓNICA </strong></h6>
            </div>
            <div class="col-lg-4 py-3 text-center" style="cursor: pointer;">
                <h6 style="color: #143153;"> <img data-toggle="modal" data-target="#modalTerms" class="py-2" src="{{asset('img/icon2.png')}}"><br><strong class="py-2"> ORIENTACIÓN EMOCIONAL <br> TELEFÓNICA </strong></h6>
            </div>
            <div class="col-lg-4 py-3 text-center" style="cursor: pointer;">
                <h6 style="color: #143153;"><img data-toggle="modal" data-target="#modalTerms" class="py-2"src="{{asset('img/icon3.png')}}"> <br><strong class="py-2"> AMBULANCIA TERRESTRE</strong></h6>
            </div>
            <div class="col-lg-3 text-center py-3" style="cursor: pointer;">
                <h6 style="color: #143153;"><img data-toggle="modal" data-target="#modalTerms" class="py-2" src="{{asset('img/icon4.png')}}"><br> <strong class="py-2">ORIENTACIÓN NUTRICIONAL <br> TELEFÓNICA
                </strong></h6>
            </div>
            <div class="col-lg-3 py-3 text-center" style="cursor: pointer;">
                <h6 style="color: #143153;"> <img data-toggle="modal" data-target="#modalTerms" class="py-2" src="{{asset('img/icon5.png')}}"><br><strong class="py-2"> VIDEO CONSULTA <br>
                    POR COVID 19 </strong></h6>
            </div>
            <div class="col-lg-3 py-3 text-center" style="cursor: pointer;">
                <h6 style="color: #143153;"><img data-toggle="modal" data-target="#modalTerms" class="py-2" src="{{asset('img/icon6.png')}}"> <br><strong class="py-2"> ASISTENCIA  <br>
                    FUNERARIA
                    </strong></h6>
            </div>
                @if($level === 'oro')
                    <div class="col-lg-3 py-3 text-center" style="cursor: pointer;">
                        <h6 style="color: #143153;"><img data-toggle="modal" data-target="#modalTerms" class="py-2"src="{{asset('img/icon7.png')}}"> <br><strong class="py-2"> ENVÍO DE GRÚA</strong></h6>
                    </div>
                @elseif($level === 'plata')
                    <div class="col-lg-3 py-3 text-center" style="filter: grayscale(50%); opacity: 0.4;">
                        <h6 style="color: #c4c4c4;"><img class="py-2"src="{{asset('img/icon7.png')}}"> <br><strong class="py-2"> ENVÍO DE GRÚA</strong></h6>
                    </div>
                @endif
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
