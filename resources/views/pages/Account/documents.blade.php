@extends('layouts.application')
@section('content')
<!--BUTTONS AND PROGRESS ARROW-->
@include('includes.options', ['active' => 4])
<div class="container-fluid" style="padding-left: 3rem !important; padding-right: 3rem !important;">
    <div class="row">
        <div class="col-lg-12">
            <hr>
        </div>
        <div class="col-12">
            <div style="padding-left: 16px !important;">
                <h6>Hola {{$data->name.' '.$data->last_name.' '.$data->second_last_name}}<br>
                    No. de Cliente <span style="color:#009ce0">{{substr(Auth::user()->client_number, 2)}}</span><br>
                    @if ((int)Auth::user()->client_type == 1)
                    Cuenta: Negocios
                    @else
                    Cuenta: Individual
                    @endif
                </h6>
                <a href="#" class="btn btn btn-sm" style="background-color: #00A1E3;color: #FFF;" data-toggle="modal"
                    data-target="#survey">
                    <span style="font-size: 12px"> Nos interesa tu opinión</span>
                </a>
                
            </div>
           
        </div>

        <div class="col-3 py-2 divImgIzquierda">
            <div class="form-row text-center"
                style="padding: 0 0 0 20px;">
                <div>
                  <img src="{{asset('img/mecanico-3.png')}}" class="imgDocument" alt="meca3">
                </div>
              </div>
        </div>
          

        <div class="col-8 py-2 divImgDerecha">
            <form>
                <div class="form-row text-center"
                    style="border: 1px solid rgba(128, 128, 128, 0.664);padding: 40px;border-radius: 10px;">
                    <div class="col-lg-12" style="color: #143153;">
                        <h5 class="text-center"> <strong> DA CLICK EN CADA SECCIÓN PARA VER O EDITAR TUS
                                DOCUMENTOS</strong></h5>
                    </div>
                    <div class="col-lg-12 py-3 text-center">
                        <img src="{{asset('img/Asset9.png')}}" class="py-2"><br>
                        <a href="{{route('customer.pdf')}}" target="_blank" class="btn btn py-2  text-white "
                            style="background-color: #143153;">
                            CERTIFICADO DE PÓLIZA</a> </div>
                </div>
            </form>
        </div>

        <div class="col-12 py-2 divImgDerecha2">
          <form>
              <div class="form-row text-center"
                  style="border: 1px solid rgba(128, 128, 128, 0.664);padding: 40px;border-radius: 10px;">
                  <div class="col-lg-12" style="color: #143153;">
                      <h5 class="text-center"> <strong> DA CLICK EN CADA SECCIÓN PARA VER O EDITAR TUS
                              DOCUMENTOS</strong></h5>
                  </div>
                  <div class="col-lg-12 py-3 text-center">
                      <img src="{{asset('img/Asset9.png')}}" class="py-2"><br>
                      <a href="{{route('customer.pdf')}}" target="_blank" class="btn btn py-2  text-white "
                          style="background-color: #143153;">
                          CERTIFICADO DE PÓLIZA</a> </div>
              </div>
          </form>

      </div>

    </div>
</div>

@stop
