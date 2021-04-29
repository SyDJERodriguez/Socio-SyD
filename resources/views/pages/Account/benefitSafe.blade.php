@extends('layouts.application')
@section('content')

<!--BUTTONS AND PROGRESS ARROW-->
@include('includes.options', ['active' => 1])

<div class="container-fluid" style="padding-left: 3rem !important;
    padding-right: 3rem !important;">
  <div class="row">
      @include('includes.Account.sidebarBenefits', ['active' => 1])
      <div class="col-lg-8 pb-5 pr-5 pl-5">

        <div class="row">
          <div class="col-5 text-center contenedorIcon">
            <img src="{{asset('img/iconno-1.png')}}" class="py-2 iconBene">
          </div>
          <div class="col-7 contenedorImg">
              <img src="{{asset('img/mecanico-1.png')}}" class="imgBene">
          </div>
        </div>
       <!-- <form>-->
          <div class="row" style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 30px;border-radius: 8px;">
          @if($level>0 || $is_cnt === 'true')
                <div class="col-lg-4 text-center py-3" style="cursor: pointer;" data-toggle="modal" data-target="#modal8" >
                    <h6 style="color: #143153;"><img class="py-2"   
                        style="width:150px; height:150px;" src="{{asset('img/perdida_organica.png')}}" 
                        ><br> <strong class="py-3"> PÉRDIDA ORGÁNICA  <br> <div class="pt-2"> Te apoyamos si pierdes una <br> o más extremidades </div> </strong></h6>
                </div>
                <div class="col-lg-4 py-3 text-center iconInvalid" style="cursor: pointer" data-toggle="modal" data-target="#modal8">
                    <h6 style="color: #143153;"> <img class="py-2"  
                        style="width:150px; height:150px;" src="{{asset('img/invalidez_total.png')}}">
                        <br><strong class="py-3"> INVALIDEZ TOTAL <br> Y PERMANENTE <br> 
                            <div class="pt-2"> Recibe apoyo si a causa <br> de algun accidente ya no  
                                <br> puedes realizar tu trabajo</div> </strong></h6>
                </div>
                <div class="col-lg-4 py-3 text-center" style="cursor: pointer;" data-toggle="modal" data-target="#modal8">
                    <h6 style="color: #143153;"><img class="py-2"  
                        style="width:150px; height:150px;" src="{{asset('img/muerte_accidental.png')}}">
                         <br><strong class="py-3"> MUERTE ACCIDENTAL   <br> 
                            <div class="pt-2"> Si llegas a faltar, protege a <br>los que más quieres</div> 
                        </strong></h6>
                </div>
                <div class="col-lg-4 text-center py-3" style="cursor: pointer;" data-toggle="modal" data-target="#modal8">
                    <h6 style="color: #143153;"><img class="py-2"  
                        style="width:150px; height:150px;" src="{{asset('img/reembolso.png')}}">
                        <br> <strong class="py-3">REEMBOLSO DE  <br> GASTOS MÉDICOS  <br>  
                            <div class="pt-2"> Cubrimos tus gastos que <br> deriven de algún accidente </div>
                    </strong></h6>
                </div>
                <div class="col-lg-4 py-3 text-center">
                </div>
                <div class="col-lg-4 py-3 text-center" style="cursor: pointer;" data-toggle="modal" data-target="#modal8">
                    <h6 style="color: #143153;"><img class="py-2"  
                        style="width:150px; height:150px;" src="{{asset('img/indemnización.png')}}"> <br>
                        <strong class="py-3"> INDEMNIZACIÓN DIARIA  <br>  <div class="pt-2"> Si necesitas hospitalización,  
                            <br> nosotros te ayudamos  </div> </strong></h6>
                </div>
          @else
                  <div class="modal-body " style="background-color: #143153;">
                      <div class="row">
                          <div class="col-lg-12 text-center">
                              <h5 class="text-white">¡AÚN NO TIENES DERECHO A LOS BENEFICIOS DEL SEGURO!</h5>
                              <p class="text-white"></p>
                          </div>
                      </div>
                  </div>
          @endif
          </div>
       <!-- </form>-->
      </div>
  </div>
</div>
@include('includes.termsAndConditions')


@stop
