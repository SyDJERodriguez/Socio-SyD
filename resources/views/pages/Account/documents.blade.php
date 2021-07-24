@extends('layouts.application')
@section('content')
<!--BUTTONS AND PROGRESS ARROW-->
@include('includes.options', ['active' => 4])
<div class="container-fluid" style="padding-left: 3rem !important; padding-right: 3rem !important;">
    <div class="row">
        <div class="col-lg-12" >
            <hr>
        </div>
        <div class="col-12" >
            <div style="padding-left: 16px !important;" >
                
                @include('includes.accountData')

                <a href="#" class="btn btn btn-sm" style="background-color: #00A1E3;color: #FFF;" data-toggle="modal"
                    data-target="#survey">
                    <span style="font-size: 12px"> Nos interesa tu opinión</span>
                </a>

            </div>

        </div>

        <div class="col-3 py-2 divImgIzquierda" >
            <div class="form-row text-center"
                style="padding: 0 0 0 20px;">
                <div>
                  <img src="{{asset('img/mecanico-3.png')}}" class="imgDocument" alt="meca3">
                </div>
              </div>
        </div>

        @if(count($beneficiaries) > 0)
            <div class="col-8 py-2 divImgDerecha">
                 <form>
                    <div class="form-row text-center box_documents"
                        style="border: 1px solid rgba(128, 128, 128, 0.664);padding: 30px;border-radius: 8px;">
                       
                        <div class="col-lg-12" style="color: #143153;">
                            <h5 class="text-center"> <strong> DA CLICK EN CADA SECCIÓN PARA VER O EDITAR TUS
                                    DOCUMENTOS</strong></h5>
                        </div>
                        <div class="col-lg-12 py-3 text-center">
                            <img src="{{asset('img/Asset9.png')}}" class="py-2"><br>
                            <a href="#" data-toggle="modal" data-target="#modalRemember" target="_blank" class="btn btn py-2  text-white "
                                style="background-color: #143153;">
                                CERTIFICADO DE PÓLIZA</a> </div>
                     
                        <div class="col-lg-12" style="color: #143153;">
                            <h5 class="text-center"> <strong> DA CLICK PARA SABER QUE HACER EN CASO DE NECESITAR <br> UNA RECLAMACIÓN POR 
                                COBERTURA DEL SEGURO
                            </strong></h5>
                        </div>
                        <div class="col-lg-4 text-center py-3" style="cursor: pointer;" data-toggle="modal" data-target="#modal9" >
                    <h6 style="color: #143153;"><img class="py-2"   
                        style="width:150px; height:150px;" src="{{asset('img/perdida_organica.png')}}" 
                        ><br> <strong class="py-3"> PÉRDIDA ORGÁNICA
                         </strong></h6>
                        </div>
                <div class="col-lg-4 py-3 text-center iconInvalid" style="cursor: pointer" data-toggle="modal" data-target="#modal10">
                    <h6 style="color: #143153;"> <img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/invalidez_total.png')}}">
                        <br><strong class="py-3"> INVALIDEZ TOTAL <br> Y PERMANENTE <br> 
                            </strong></h6>
                </div>
                <div class="col-lg-4 py-3 text-center" style="cursor: pointer;" data-toggle="modal" data-target="#modal11">
                    <h6 style="color: #143153;"><img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/muerte_accidental.png')}}">
                         <br><strong class="py-3"> MUERTE ACCIDENTAL
                        </strong></h6>
                </div>
                <div class="col-lg-4 text-center py-3" style="cursor: pointer;" data-toggle="modal" data-target="#modal12">
                    <h6 style="color: #143153;"><img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/reembolso.png')}}">
                        <br> <strong class="py-3">REEMBOLSO DE  <br> GASTOS MÉDICOS  <br>  
                    </strong></h6>
                </div>
                <div class="col-lg-4 py-3 text-center">
                </div>
                <div class="col-lg-4 py-3 text-center" style="cursor: pointer;" data-toggle="modal" data-target="#modal13">
                    <h6 style="color: #143153;"><img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/indemnización.png')}}"> <br>
                        <strong class="py-3"> INDEMNIZACIÓN POR ACCIDENTE  
                        </strong></h6>
                </div>
                <div class="col-lg-4 py-3 text-center">
                </div>
                <div class="col-lg-4 py-3 text-center">
                <a href="#" data-toggle="modal" data-target="#modal14" 
                                target="_blank" class="btn btn py-2  text-white "
                                style="background-color: #143153;">
                                LISTADO DE DOCUMENTOS</a>  
                </div>
                <div class="col-lg-4 py-3 text-center">
                </div>
                <p style="color: #143153;font-size: 13px;margin-bottom: 0px;">
                    *Consulta términos y condiciones
                </p>
                    </div>
                </form>
            </div>
            <div class="col-12 py-2 divImgDerecha2" >
            <form>
                    <div class="form-row text-center box_documents"
                        style="border: 1px solid rgba(128, 128, 128, 0.664);padding: 30px;border-radius: 8px;">
                         
                        <div class="col-lg-12" style="color: #143153;">
                            <h5 class="text-center"> <strong> DA CLICK EN CADA SECCIÓN PARA VER O EDITAR TUS
                                    DOCUMENTOS</strong></h5>
                        </div>
                        <div class="col-lg-12 py-3 text-center">
                            <img src="{{asset('img/Asset9.png')}}" class="py-2"><br>
                            <a href="#" data-toggle="modal" data-target="#modalRemember" 
                                target="_blank" class="btn btn py-2  text-white "
                                style="background-color: #143153;">
                                CERTIFICADO DE PÓLIZA</a> </div>
                                 
               
                        <div class="col-lg-12" style="color: #143153;">
                            <h5 class="text-center"> <strong> DA CLICK PARA SABER QUE HACER EN CASO DE NECESITAR UNA RECLAMACIÓN POR 
                                POR COBERTURA DEL SEGURO
                            </strong></h5>
                            <div class="col-lg-4 text-center py-3" style="cursor: pointer;" data-toggle="modal" data-target="#modal9" >
                    <h6 style="color: #143153;"><img class="py-2"   
                        style="width:150px; height:150px;" src="{{asset('img/perdida_organica.png')}}" 
                        ><br> <strong class="py-3"> PÉRDIDA ORGÁNICA
                         </strong></h6>
                </div>
                <div class="col-lg-4 py-3 text-center iconInvalid" style="cursor: pointer" data-toggle="modal" data-target="#modal10">
                    <h6 style="color: #143153;"> <img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/invalidez_total.png')}}">
                        <br><strong class="py-3"> INVALIDEZ TOTAL <br> Y PERMANENTE <br> 
                            </strong></h6>
                </div>
                <div class="col-lg-4 py-3 text-center" style="cursor: pointer;" data-toggle="modal" data-target="#modal11">
                    <h6 style="color: #143153;"><img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/muerte_accidental.png')}}">
                         <br><strong class="py-3"> MUERTE ACCIDENTAL
                        </strong></h6>
                </div>
                <div class="col-lg-4 text-center py-3" style="cursor: pointer;" data-toggle="modal" data-target="#modal12">
                    <h6 style="color: #143153;"><img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/reembolso.png')}}">
                        <br> <strong class="py-3">REEMBOLSO DE  <br> GASTOS MÉDICOS  <br>  
                    </strong></h6>
                </div>
                <div class="col-lg-4 py-3 text-center">
                </div>
                <div class="col-lg-4 py-3 text-center" style="cursor: pointer;" data-toggle="modal" data-target="#modal13">
                    <h6 style="color: #143153;"><img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/indemnización.png')}}"> <br>
                        <strong class="py-3"> INDEMNIZACIÓN POR ACCIDENTE  
                        </strong></h6>
                </div>
                <p style="color: #143153;font-size: 13px;margin-bottom: 0px;">
                    *Consulta términos y condiciones
                </p>
                        </div>
                        <div class="col-lg-4 text-center py-3" style="cursor: pointer;" data-toggle="modal" data-target="#modal9" >
                    <h6 style="color: #143153;"><img class="py-2"   
                        style="width:150px; height:150px;" src="{{asset('img/perdida_organica.png')}}" 
                        ><br> <strong class="py-3"> PÉRDIDA ORGÁNICA
                         </strong></h6>
                </div>
                <div class="col-lg-4 py-3 text-center iconInvalid" style="cursor: pointer" data-toggle="modal" data-target="#modal10">
                    <h6 style="color: #143153;"> <img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/invalidez_total.png')}}">
                        <br><strong class="py-3"> INVALIDEZ TOTAL <br> Y PERMANENTE <br> 
                            </strong></h6>
                </div>
                <div class="col-lg-4 py-3 text-center" style="cursor: pointer;" data-toggle="modal" data-target="#modal11">
                    <h6 style="color: #143153;"><img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/muerte_accidental.png')}}">
                         <br><strong class="py-3"> MUERTE ACCIDENTAL
                        </strong></h6>
                </div>
                <div class="col-lg-4 text-center py-3" style="cursor: pointer;" data-toggle="modal" data-target="#modal12">
                    <h6 style="color: #143153;"><img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/reembolso.png')}}">
                        <br> <strong class="py-3">REEMBOLSO DE  <br> GASTOS MÉDICOS  <br>  
                    </strong></h6>
                </div>
                <div class="col-lg-4 py-3 text-center">
                </div>
                <div class="col-lg-4 py-3 text-center" style="cursor: pointer;" data-toggle="modal" data-target="#modal13">
                    <h6 style="color: #143153;"><img class="py-2"
                        style="width:150px; height:150px;" src="{{asset('img/indemnización.png')}}"> <br>
                        <strong class="py-3"> INDEMNIZACIÓN POR ACCIDENTE  
                        </strong></h6>
                </div>
                <div class="col-lg-4 py-3 text-center">
                </div>
                <div class="col-lg-4 py-3 text-center">
                <a href="#" data-toggle="modal" data-target="#modal14" 
                                target="_blank" class="btn btn py-2  text-white "
                                style="background-color: #143153;">
                                LISTADO DE DOCUMENTOS</a>  
                </div>
                <div class="col-lg-4 py-3 text-center">
                </div>
                 
                <p style="color: #143153;font-size: 13px;margin-bottom: 0px;">
                    *Consulta términos y condiciones
                </p>
                    </div>
                </form>
            </div>
        @else
            <div class="col-8 py-2 divImgDerecha" >
                <div class="form-row text-center box_documents"
                     style="border: 1px solid rgba(128, 128, 128, 0.664);padding: 40px;border-radius: 10px;">
                    <div class="modal-body " style="background-color: #143153; height: 30%">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <p><i class="fas fa-times" style="font-size: 28px;color: #00A1E3"></i></p>
                                <h5 class="text-white">¡Tus beneficiarios aún no han sido registrados!</h5>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8 py-2 divImgDerecha2" >
                <div class="form-row text-center box_documents"
                     style="border: 1px solid rgba(128, 128, 128, 0.664);padding: 40px;border-radius: 10px;">
                    <div class="modal-body " style="background-color: #143153; height: 30%">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <p><i class="fas fa-times" style="font-size: 28px;color: #00A1E3"></i></p>
                                <h5 class="text-white">¡Tus beneficiarios aún no han sido registrados!</h5>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(Auth::user()->client_type === "3")
            <div class="col-md-11 col-sm-6" style="display: flex; justify-content: flex-end; padding: 10px 10px;">
                <button class="btn btn-primary" style="background-color: #009CE0;" data-toggle="modal" data-target="#modalQuestion">Quiero ser independiente</button>
            </div>
        @endif

    </div>
</div>
@include('includes.Account.unsuscribeEmployee')

<!-- Modal remember-->
<div class="modal fade" id="modalRemember" tabindex="-1" role="dialog" aria-labelledby="modalRemember" aria-hidden="true">
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
                        <h5 class="text-white">{{strtoupper($data->name).' '.strtoupper($data->last_name).' '.strtoupper($data->second_last_name)}}</h5>
                        <p class="text-white">Recuerda imprimir y guardar tu certificado para cuando lo requieras</p>
                        <a href="{{route('customer.pdf')}}" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;">
                            CERRAR
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.modalsMyDocuments')
@stop
