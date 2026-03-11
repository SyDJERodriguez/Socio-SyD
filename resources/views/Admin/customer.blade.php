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
			  	    <a href="#"
                                      style="margin-bottom: 0; font-size:13px;text-align:center;padding-top:5px"
                                      class="primary-color"
                                      data-toggle="modal"
                                      data-target="#modal-change-account"> [cambiar]
                                    </a>
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
                            <p>Email:
				<b>{{$customerData->email}}</b>
				<a  href="#"
                                    style="margin-bottom: 0; font-size:13px;text-align:center;padding-top:5px"
                                    class="primary-color"
                                    data-toggle="modal"
                                    data-target="#modal-change-email"> [cambiar]
                                </a>
			    </p>
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

            @if(Auth::user()->type_user == '1')
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <h4>Movimientos transaccionales</h4>
                        <table class="table table-striped table-bordered" id="tableTrans" style="width:100%">
                            <thead>
                            <tr>
                                <!-- <th scope="col">Pieza</th> -->
                                <th scope="col">Factura</th>
                                <th scope="col">Oficina de Venta</th>
                                <!-- <th scope="col">SKU</th> -->
                                <th scope="col">Método de pago</th>
                                {{-- <th scope="col">Cantidad</th> --}}
                                <th scope="col">Fecha</th>
                                <th scope="col">Monto</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($transactions as $trans)
                                <tr>
                                    <th> {{ $trans->invoce }}</th>
                                    <td> {{ $trans->sale_office }}</td>
                                    <td> {{ $trans->payment_method }}</td>
                                    <td> {{ date_format(date_create($trans->transaction_date),'d-m-Y') }}</td>
                                    <td>$ {{ $trans->amount }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="4" style="text-align:right">Total: </th>
                                <th>$ <b>{{ $totalAmount}}</b></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endif

            {{--@if($account->client_type === '1')--}}
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <h4>Dependientes</h4>
                        <table class="table table-striped table-bordered" id="tableEmployees" style="width:100%">
                            <thead>
                            <tr>
                                <td><b>Nombre </b></td>
                                <td><b>Correo electrónico</b></td>
                                <td><b>Teléfono </b></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($associates as $as)
                                <tr>
                                    <td>{{$as->name}} {{$as->last_name}} {{$as->second_last_name}}</td>
                                    <td>{{$as->email}}</td>
                                    <td>{{$as->mobile_number}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            {{--@endif--}}
        @endif
    </div>

@endsection


    <!-- Modal change email cuenta admin AGV - EPYA -->
    <div class="modal fade" id="modal-change-email" tabindex="-1" role="dialog" aria-labelledby="modal-change-email" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
		<div class="modal-header d-flex flex-row-reverse">
		    <span class="times" data-dismiss="modal" aria-label="Close">X</span>
		</div>
	    <div class="modal-body">
		<h5 class="text-uppercase">CAMBIAR E-MAIL</h5>
		<div>{{$customerData->email}}</div>
		<img src="{{asset('img/line.png')}}" alt="line">
                <h6 style="margin-top: -17px">Ingresa el nuevo correo electrónico</h6>
		<br>
		<form action="{{route('admin.updateEmployeEmail')}}" method="POST" id="sendUpdateEmail">
		    @method("PUT")
                    @csrf
                    <input type="hidden" name="client_number" value="{{ isset($client_number) ? $client_number : null }}">
                    <input type="hidden" name="client_current_email" value="{{$customerData->email}}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <input autocomplete="new-password" class="form-control-sm form-control" type="text" name="new_email"
                                       placeholder="NUEVO CORREO ELECTRÓNICO" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <br>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info" id="">Actualizar</button>
                            </div>
                        </div>
                    </div>
		</form>
	    </div>
	    </div>
	</div>
    </div


    <!-- Modal change account type AGV - EPYA -->
    <div class="modal fade" id="modal-change-account" tabindex="-1" role="dialog" aria-labelledby="modal-change-account" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width:65% !important; margin: auto;">
            <div class="modal-header d-flex flex-row-reverse">
                <span class="times" data-dismiss="modal" aria-label="Close">X</span>
            </div>
            <div class="modal-body">
                <h5 class="text-uppercase">CAMBIAR Tipo de CUENTA</h5>
                <p><strong>Cuenta actual:</strong>
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
                <br>

                <img src="{{asset('img/line.png')}}" alt="line">
                <h6 style="margin-top: -17px">Ingresa el nuevo tipo de cuenta</h6>
                <form action="{{route('admin.updateEmployeAccountType')}}" method="POST" id="updateEmployeAccountType">
                    @method("PUT")
                    @csrf
                    <input type="hidden" name="client_number" value="{{ isset($client_number) ? $client_number : null }}">
                    <input type="hidden" name="client_email" value="{{$customerData->email}}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <select name="account_type" id="account_type" style="width: 250px;height: 40px;background-color: aliceblue;">
                                    <!-- <option value="">Individual</option> -->
                                    <option value="0">Selecciona una opción</option>
                                    <option value="1">Cuenta con Colaboradores</option>
                                    <!-- <option value="">Dependiente</option> -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <br>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info" id="">Actualizar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
