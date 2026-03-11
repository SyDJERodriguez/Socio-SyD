@extends('layouts.admin')

@section('content')
    <div class="container">
        @if(isset($error))
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h2>{{$error}}</h2>
                </div>
            </div>
        @else
        @if ($account->client_type == 1 || $account->client_type == 4 )
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(isset($client_number))
                    <div style="display: flex; justify-content: space-between;">
                        <div class="col-md-8">
                            <h3>Datos del usuario con
                                @if ($account->client_type === '4')
                                número de destinatario
                                @else
                                número de cliente
                                @endif
                                {{$client_number}}</h3>
                        </div>
                        <div class="col-md-4" style="display: flex; justify-content: flex-end;">
                            <a href="{{route('admin.customers.index')}}"
                               class="btn btn-lg"
                               style="background-color: rgb(0, 165, 230); color: rgb(255, 255, 255);">Regresar</a>
                        </div>
                    </div>
                    <hr>
                @elseif(isset($email))
                    <h2>Datos del cliente con email {{$email}}</h2>
                    <p>Es del form 2</p>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12" style="display: flex;">
                <div class="col-md-4">
                    <p>Tipo de cuenta:
                        @switch($account->client_type)
                            @case(1)
                                <b> Cuenta con colaboradores </b>
                                @break
                            @case(2)
                                <b> Individual </b>
                                @break
                            @case(3)
                                <b> Dependiente </b>
                                @break
                            @case(4)
                                <b> Sucursal </b>
                                @break
                            @default
                                <b> Público en general </b>
                        @endswitch
                    </p>
                </div>
                <div class="col-md-4">
                    <p>Estatus de cuenta:
                        @if($account->active === 1)
                            <b> Activa </b>
                        @elseif($account->active === 0)
                            <b> Desactivada </b>
                        @endif
                    </p>
                </div>
                <div class="col-md-4">
                    <p>Nivel de beneficios:
                        @if($level === 0)
                            <b> Aún no cuenta con beneficios </b>
                        @elseif($level === 1 && $account->client_type != "2")
                            <b> Seguro de accidentes para 3 colaboradores </b>
                        @elseif($level === 1 && $account->client_type === "2")
                            <b> Seguro de accidentes </b>

                        @elseif($level === 2 && $account->client_type != "2")
                            <b> Seguro de accidentes y asistencias plata para 3 colaboradores </b>
                        @elseif($level === 2 && $account->client_type === "2")
                            <b> Seguro de accidentes y asistencias plata </b>

                        @elseif($level === 3 && $account->client_type != "2")
                            <b> Seguro de accidentes y asistencias oro para 7 colaboradores </b>
                        @elseif($level === 3 && $account->client_type === "2")
                            <b> Seguro de accidentes y asistencias oro </b>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12" style="display: flex;">
                <div class="col-sm-4">
                    <p>Nombre: <b>{{$customerData->name.' '.$customerData->last_name.' '.$customerData->second_last_name}}</b></p>
                </div>
                @if(Auth::user()->type_user == '1' || Auth::user()->type_user == '2')
                    <div class="col-sm-4">
                        <p>Email: <b>{{$customerData->email}}</b></p>
                    </div>
                    <div class="col-sm-4">
                        <p>Telefónico: <b>{{$customerData->mobile_number}}</b></p>
                    </div>
                @endif
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12" style="display: flex;">
                <div class="col-md-4">
                    <p>Género:
                        <b>
                            @if($customerData->gender === 'M')
                                Masculino
                            @elseif($customerData->gender === 'F')
                                Femenino
                            @endif
                        </b>
                    </p>
                </div>
                <div class="col-md-4">
                    <p>Fecha de Nacimiento: <b>{{$customerData->birthday}}</b></p>
                </div>
                <div class="col-md-4">
                    <p>RFC: <b>{{$customerData->rfc}}</b></p>
                </div>
            </div>
        </div>

        @if($account->client_type === '1')
            <div class="row justify-content-center">
                <div class="col-md-12" style="display: flex;">
                    <div class="col-md-4">
                        <p>Nombre de negocio: <b>{{$customerData->company}}</b></p>
                    </div>
                    <div class="col-md-4">
                        <p>RFC Negocio: <b>{{$customerData->RFC_Company}}</b></p>
                    </div>
                    <div class="col-md-4">
                        <p>Tipo de negocio:
                            <b>
                                @if($customerData->work === '1')
                                    Taller general
                                @elseif($customerData->work === '2')
                                    Taller suspensionista
                                @elseif($customerData->work === '3')
                                    Mecánico independiente
                                @elseif($customerData->work === '4')
                                    Refaccionaria
                                @elseif($customerData->work === '5')
                                    Mayorista
                                @endif
                            </b>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-12">
            <p>Beneficios del mes anterior:
                @if($level_before === 0)
                    <b> Ninguno </b>
                @elseif($level_before === 1 && $account->client_type != "2")
                    <b> Seguro de accidentes para 3 colaboradores </b>
                @elseif($level_before === 1 && $account->client_type === "2")
                    <b> Seguro de accidentes </b>

                @elseif($level_before === 2 && $account->client_type != "2")
                    <b> Seguro de accidentes y asistencias plata para 3 colaboradores </b>
                @elseif($level_before === 2 && $account->client_type === "2")
                    <b> Seguro de accidentes y asistencias plata </b>

                @elseif($level_before === 3 && $account->client_type != "2")
                    <b> Seguro de accidentes y asistencias oro para 7 colaboradores </b>
                @elseif($level_before === 3 && $account->client_type === "2")
                    <b> Seguro de accidentes y asistencias oro </b>
                @endif
            </p>
        </div>
         <!-- Content Start -->
    <div class="container-fluid" style="display: flex; justify-content: center; padding: 50px 0;">
      @if ($numberEmployees <8)
         <div class="container">
           <h5 class="text-uppercase" id="title">ALTA EMPLEADO</h5>
           <div class="alert alert-danger" id="form_alert_phone_text_search" role="alert" style="border-radius: 6px;" hidden>
           </div>
           <div class="alert alert-danger" id="form_alert_dns_search" role="alert" style="border-radius: 6px;" hidden>
           </div>
           <div class="alert alert-danger" id="error_code_br" role="alert" style="border-radius: 6px;" hidden></div>
           <br>
         <form autocomplete="off" id="addEmployesearch" method="POST" action="{{route('admin.addEmployesearch')}}">
              @method("PUT")
              @csrf
              <input type="hidden" name="client_number" value="{{ isset($client_number) ? $client_number : null }}"> 
              <input type="hidden" name="email_auth" value="{{$customerData->email}}"> 
              <input type="hidden" name="client_type" value="{{$account->client_type}}">
              <input id="mobileuser" type="hidden" name="mobile_auth" value="{{$customerData->mobile_number}}">
              <input type="hidden" name="customer_id" value="{{$customerData->id}}">
              <input type="hidden" name="nameClient" value="{{$customerData->name}}">
              <input type="hidden" name="lastNameClient" value="{{$customerData->last_name}}">
              <input type="hidden" name="branch_number" value="{{ isset($client_number) ? $client_number : null }}">
              <div class="form-group">
                 <div class="row">
                     <div class="col-6">
                          <input class="form-control-sm form-control nameInput" type="text"
                                name="name"
                                placeholder="NOMBRE(S)"
                                pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*"
                                required maxlength="30" style="border: 1px solid black">
                     </div>
                      <div class="col-6">
                          <input class="form-control-sm form-control nameInput" type="text"
                                name="last_name"
                                placeholder="APELLIDO PATERNO"
                                pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*"
                                required maxlength="30" style="border: 1px solid black">
                      </div>
                 </div>
             </div>
             <div class="form-group">
                  <div class="row">
                      <div class="col-6">
                          <input class="form-control-sm form-control nameInput" type="text"
                                name="second_last_name"
                                placeholder="APELLIDO MATERNO"
                                pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*"
                                required  maxlength="30" style="border: 1px solid black">
                     </div>
                     <div class="col-6">
                         <div class="input-group input-group-sm mb-3">
                             <div class="input-group-prepend">
                                 <div style="border: 1px solid black" class="input-group-text">+52</div>
                             </div>
                              <input type="text" class="form-control-sm form-control btnBorder mobileInput"
                               placeholder="NO. TELEFÓNICO 10 DIG"
                               name="mobile_number"
                               maxlength="10"
                               pattern="[0-9]{10}"
                               required style="border: 1px solid black">
                               <div class="input-group-append" id="form_alert_phone_AEF" hidden>
                               </div>
                         </div>
                     </div>
                 </div>
                 <div class="row">
                        <div class="col-6">
                          <label class="text-muted sml p-0 m-0" style="font-size: 10px">FECHA DE NACIMIENTO</label>
                           <input class="form-control-sm form-control btnBorder" type="date"
                                        name="bday"
                                        placeholder="FECHA DE NACIMIENTO"
                                        required style="border: 1px solid black">
                      </div>
                       <div class="col-6">
                            <br>
                            <input class="form-control-sm form-control btnBorder"
                                type="email"
                                autocomplete="new-password"
                                name="email"
                                placeholder="CORREO ELECTRÓNICO"
                                pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9._%+-]+@[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9.-]+\.[a-zA-ZñÑ]{2,}$"
                                style="border: 1px solid black">
                       </div>
                  </div>
             </div>
               <div class="col-sm-3">  
                </div>
                <div class="row" style="justify-content: center">
			<button type="submit" id="Sendbtn" class="btn btn-info" style="width: 180px; background-color: #00A1E3; border-color: #00a1e3; color:white; cursor:pointer">Agregar</button>
                        <!--<input class="btn btn-info" style="background-color: #00A1E3; border-color: #00a1e3; color:white; cursor:pointer "  id="buttonconf" data-toggle="modal" data-target="#modalClientType" value="Agregar" readonly> -->
                </div>
             <!-- Modal Confirm-->
             <div class="modal fade" id="modalClientType" tabindex="-1" role="dialog" aria-labelledby="modalClientType"
                  aria-hidden="true" >
                  <div class="modal-dialog modal-sm" role="document" >
                     <div class="modal-content" >
                        <div class="modal-header d-flex flex-row-reverse" style="padding: -0px">
                          <span class="times" data-dismiss="modal" aria-label="Close">X</span>
                        </div>
                     <div class="container" style="display: flex; flex-direction: column; align-items: center;">
                       <div class="row mt-4 mx-2">
                          <div class="col-12">
                           <h5 class="md2-heading" style="color: #143153;"><b>Código de confirmación</b></h5>
                          </div>
                       </div>
                     <div class="form-group" style="justify-content: center;">
                        <br>
                      <div class="input-group mb-3" style="margin-top: 1rem">
                         <input type="hidden" class="form-control btnBorder" placeholder="CÓDIGO DE 6 DIGITOS"
                             id="codes" name="verification_code" maxlength="6" pattern="[0-9]{6}" style="border-radius: .25rem;">
                         <input type="hidden" class="form-control btnBorder" placeholder="CÓDIGO DE 6 DIGITOS"
                             id="codesConfirm" name="confirm_code" maxlength="6" pattern="[0-9]{6}" required style="border-radius: .25rem;">
                         <p style="color: red; margin: 0;" hidden id="requiredSignal">*</p>
                       </div> 
                       <button type="submit" class="btn btn-info" id="Sendbtn"
                       style="width: 180px; font-size: 12px; ">Aceptar</button>          
                        <br>
                     </div>
                   </div>
                  </div>
                 </div>
             </div>
             <!--modal end -->
        </form>
 </div>
     @else 
    <div class="modal-body " style="background-color: #143153;">
        <div class="row">
            <div class="col-lg-12 text-center">
                <img src="{{asset('img/icon_check.png')}}">
                <br>
                <br>
                <h5 class="text-white">¡Llegaste al límite de usuarios!</h5>
                <br>
                <p class="text-white"></p>
            </div>
        </div>
    </div>
    @endif
</div>
<!-- Content End -->

            
        @else
        <h2>Esta cuenta no puede registrar colaboradores porque es individual</h2>  
        @endif

           

        @endif
        

@endsection
