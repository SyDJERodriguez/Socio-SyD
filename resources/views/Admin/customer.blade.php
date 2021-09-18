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
                                    <b> Negocio </b>
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
                                    <b> Otro </b>
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
                                <b> Seguro de accidentes para 4 colaboradores </b>
                            @elseif($level === 1 && $account->client_type === "2")
                                <b> Seguro de accidentes </b>

                            @elseif($level === 2 && $account->client_type != "2")
                                <b> Seguro de accidentes y asistencias plata para 4 colaboradores </b>
                            @elseif($level === 2 && $account->client_type === "2")
                                <b> Seguro de accidentes y asistencias plata </b>

                            @elseif($level === 3 && $account->client_type != "2")
                                <b> Seguro de accidentes y asistencias oro para 8 colaboradores </b>
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

            @if($account->client_type === '1')
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
            @endif
        @endif
    </div>
@endsection
