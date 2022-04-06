@extends('layouts.admin')

@section('content')
    <div class="container">
        @if(isset($errorn))
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h2>{{$error}}</h2>
                </div>
            </div>
        @else
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
                                <a href="{{route('beneficiary.index')}}"
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
                    <div class="col-md-4">
                        <p>Nombre: <b>{{$customerData->name.' '.$customerData->last_name.' '.$customerData->second_last_name}}</b></p>
                    </div>
                    @if(Auth::user()->type_user == '1' || Auth::user()->type_user == '2')
                        <div class="col-md-4">
                            <p>Email: <b>{{$customerData->email}}</b></p>
                        </div>
                        <div class="col-md-4">
                            <p>Número telefónico: <b>{{$customerData->mobile_number}}</b></p>
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

            @if(isset($error)) 
                             <div class="alert alert-danger" id="form_alert" role="alert" style="border-radius: 6px;" >
                                 <strong>{{$error}}</strong>
                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                             </div>
                         @endif
            <div>
                    <div class="row"
                    style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 20px;border-radius: 8px">

                    @if(isset($beneficiary))
                            <div class="modal-body " style="background-color: #143153;">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <img src="{{asset('img/icon_check.png')}}">
                                        <h5 class="text-white">¡Los beneficiarios ya han sido registrados!</h5>
                                        <br>
                                        <div class="text-white">
                                            @for ($i = 0; $i < count($beneficiary); $i++)
                                                <p>Beneficiario {{$i+1}}:
                                                    {{mb_strtoupper($beneficiary[$i]->name)}}
                                                    {{mb_strtoupper($beneficiary[$i]->last_name)}}
                                                    {{mb_strtoupper($beneficiary[$i]->second_last_name)}}</p>
                                            @endfor
                                        </div>
                                        <br>
                                        <h5 class="text-white">¡Recuerda agregar tu firma al certificado!</h5>
                                        <br>
                                        <a href="{{route('customer.myDocuments')}}" class="btn btn" style="background-color: #00A1E3;color: #FFF;">VER CERTIFICADO</a>
                                        <p class="text-white"></p>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- call modalBeneficiarySignUp --}}
                            <script>
                                $(function() {
                                    $('#modalBeneficiarySignUp').modal('show');
                                });
                            </script>
                            <form autocomplete="off" method="POST" action="{{route('beneficiary.add')}}">
                                @csrf
                                <div id="beneficiaryParent" >

                                    <div class="inputsBeneficiary" id="inputsBeneficiary">
                                        
                                            <h6>BENEFICIARIO 1</h6>
                                        <input type="hidden" id="branch_number1" name="branch_number[0]" value="{{$account->branch_number}}">
                                        <input type="hidden" id="id" name="id[0]" value="{{$account->id}}">
                                        <input type="hidden" id="email" name="email[0]" value="{{$customerData->email}}">
                                        <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control nameInput" name="name[]"  placeholder="NOMBRE"
                                                   pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
                                                   required maxlength="30" value="{{ isset($request) ? $request['name'][0] : null  }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control nameInput" name="lastname[]" placeholder="PRIMER APELLIDO"
                                                   pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
                                                   required maxlength="30" value="{{ isset($request) ? $request['lastname'][0] : null  }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control nameInput" name="second_lastname[]" placeholder="SEGUNDO APELLIDO"
                                                   pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
                                                   required maxlength="30" value="{{ isset($request) ? $request['second_lastname'][0] : null  }}">
                                        </div>
                                    </div>
                                    <br>
                                       <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control nameInput" name="parent[]" placeholder="PARENTESCO"
                                                   pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
                                                   required maxlength="30" value="{{ isset($request) ? $request['parent'][0] : null  }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                                <input type="text" class="form-control mobileInput" name="percent[]" placeholder="PORCENTAJE DESTINADO"
                                                       pattern="[0-9].{1,2}"
                                                       required maxlength="3" value="{{ isset($request) ? $request['percent'][0] : null  }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control mobileInput" name="phone[]" placeholder="No. TELEFÓNICO 10 DÍGITOS"
                                                   pattern="[0-9]{10}"
                                                   required  maxlength="10" value="{{ isset($request) ? $request['phone'][0] : null  }}">
                                        </div>
                                    </div>
                                    </div>
                                    
                                    <div class="inputsBeneficiary" id="inputsBeneficiary">
                                            <h6>BENEFICIARIO 2</h6>
                                        <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control nameInput" name="name[]"  placeholder="NOMBRE"
                                                   pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
                                                    maxlength="30" value="{{ isset($request) ? $request['name'][1] : null  }}">
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control nameInput" name="lastname[]" placeholder="PRIMER APELLIDO"
                                                   pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
                                                    maxlength="30" value="{{ isset($request) ? $request['lastname'][1] : null  }}">
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control nameInput" name="second_lastname[]" placeholder="SEGUNDO APELLIDO"
                                                   pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
                                                    maxlength="30" value="{{ isset($request) ? $request['second_lastname'][1] : null  }}">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control nameInput" name="parent[]" placeholder="PARENTESCO"
                                                   pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
                                                    maxlength="30" value="{{ isset($request) ? $request['parent'][1] : null  }}">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                                <input type="text" class="form-control mobileInput" name="percent[]" placeholder="PORCENTAJE DESTINADO"
                                                       pattern="[0-9].{1,2}"
                                                        maxlength="3" value="{{ isset($request) ? $request['percent'][1] : null  }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control mobileInput" name="phone[]" placeholder="No. TELEFÓNICO 10 DÍGITOS"
                                                   pattern="[0-9]{10}"
                                                     maxlength="10" value="{{ isset($request) ? $request['phone'][1] : null  }}">
                                        </div>
                                    </div>
                                 </div>

                                </div>

                               <br>
                                    <input type="submit" class="btn btn float-right text-white px-5"
                                           style="background-color: #009CE0;" value="CONFIRMAR">
                               
                            </form>

            

                    @endif
                    </div>

                </div>
        @endif
    </div>
@endsection
