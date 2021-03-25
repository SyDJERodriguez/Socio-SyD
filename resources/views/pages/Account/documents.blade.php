@extends('layouts.application')
@section('content')
<!--BUTTONS AND PROGRESS ARROW-->
@include('includes.options', ['active' => 4])
<div class="container-fluid" style="padding-left: 3rem !important; padding-right: 3rem !important;">
    <div class="row">
        <div class="col-lg-12">
            <hr>
        </div>
        <div class="col-lg-2">
          <div style="padding-left: 0px !important;">
            <h6>Hola {{$data->name.' '.$data->last_name.' '.$data->second_last_name}}<br>
               No. de Cliente <span style="color:#009ce0">{{substr(Auth::user()->client_number, 2)}}</span><br>
                @if ((int)Auth::user()->client_type == 1)
                Cuenta: Negocios
                @else
                    Cuenta: Individual
                @endif
            </h6>
            <hr>
         </div>
            <div>
              <img src="{{asset('img/mandoc.png')}}"  style="width: 90%;border-radius: 10px; margin-bottom: 50px" alt="">
            </div>
        </div>
        <div class="col-lg-10 py-5">

                <!--<div class="modal-body " style="background-color: #143153;">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <img src="{{asset('img/icon_check.png')}}">
                            <h5 class="text-white">¡NECESITAS GENERAR TU FIRMA Y REGISTAR A TUS BENEFICIARIOS<br> PARA PODER OBTENER TU PÓLIZA.!</h5>
                            <p class="text-white"></p>
                        </div>
                    </div>
                </div>-->

                <form>
                    <div class="form-row text-center" style="border: 1px solid rgba(128, 128, 128, 0.664);padding: 40px;border-radius: 10px;">
                        <div class="col-lg-12" style="color: #143153;">  <h5 class="text-center"> <strong> DA CLICK EN CADA SECCIÓN PARA VER O EDITAR TUS DOCUMENTOS</strong></h5>
                        </div>
                    <!--<div class="col-lg-6 py-3 text-center">
                      <img src="{{asset('img/Asset8.png')}}" class="py-2"><br>
                    <input type="button" class="btn btn py-2  text-white " style="background-color: #143153;" value="estudio socioeconómico">
                  </div>-->
                        <div class="col-lg-12 py-3 text-center">
                            <img src="{{asset('img/Asset9.png')}}" class="py-2"><br>
                            <a href="{{route('customer.pdf')}}" target="_blank" class="btn btn py-2  text-white " style="background-color: #143153;">CERTIFICADO DE PÓLIZA</a>               </div>
                    <!--<div class="col-lg-6 py-3 text-center">
                    <img src="{{asset('img/Asset10.png')}}" class="py-2"><br>
                    <input type="button" class="btn btn py-2  text-white " style="background-color: #143153;padding-left: 80px;padding-right: 80px;" value="INE">  </div>
                  <div class="col-lg-6 py-3 text-center">
                    <img src="{{asset('img/Asset11.png')}}" class="py-2"><br>
                    <input type="button" class="btn btn py-2  text-white " style="background-color: #143153;" value="comprobante de domicilio">
                  </div>-->


                    </div>
                </form>


            @include('includes.Account.deleteButton')
        </div>
    </div>
</div>

@stop
