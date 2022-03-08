@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div style="display: flex; justify-content: space-between;">
                    <div class="col-md-8">
                        <h2>Registros Socio SyD</h2>
                    </div>
                    <div class="col-md-4" style="display: flex; justify-content: flex-end;">
                        <a href="{{route('admin.customers.index')}}"
                           class="btn btn-lg"
                           style="background-color: rgb(0, 165, 230); color: rgb(255, 255, 255);">Regresar</a>
                    </div>
                </div>
                <hr>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h4>Total Registros</h4>
                <table class="table table-striped table-bordered" id="logsSessions" style="width:100%">
                    <thead>
                    <tr>
                        <th scope="col">No. Cliente</th>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefóno</th>
                        <th scope="col">Fecha Registro</th>
                        <th scope="col">Tipo Cuenta</th>
                        <th scope="col">Activación</th>
                        <th scope="col">Género</th>
                        <th scope="col">Cumpleaños</th>
                        <th scope="col">Consumo Mes Actual</th>
                        <th scope="col">Beneficios</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{$d->client_number}}</td>
                            <td>{{$d->name.' '.$d->last_name.' '.$d->second_last_name}}</td>
                            <td>{{$d->email}}</td>
                            <td>{{$d->phone}}</td>
                            <td>{{ $d->fecha_registro }}</td>
                            <td>{{$d->type_user}}</td>
                            <td>{{$d->active}}</td>
                            @if($d->gender === 'M')
                                <td>Masculino</td>
                            @elseif($d->gender === 'F')
                                <td>Femenino</td>
                            @else
                                <td>N/A</td>
                            @endif

                            <td>{{date_format(date_create($d->birthday),'d-m-Y')}}</td>
                            <td>{{'$ '.$d->amount}}</td>
                            @if($d->type_user === 'Dueño de Negocio' || $d->type_user === 'Empleado Dependiente' || $d->type_user === 'Cadenas' )
                            @if ($d->amount>2500 && $d->amount<=4500)
                            <td>Bronce</td>
                            @elseif($d->amount>4500 && $d->amount<=7000)
                            <td>Plata</td>
                            @elseif($d->amount>7000)
                            <td>Oro</td>
                            @elseif($d->amount<2500)
                            <td>Sin beneficios</td>
                            @endif
                            @elseif($d->type_user === 'Mecánico Individual' || $d->type_user === 'Publico en general')
                            @if ($d->amount>200 && $d->amount<=500)
                            <td>Bronce</td>
                            @elseif($d->amount>500 && $d->amount<=1300)
                            <td>Plata</td>
                            @elseif($d->amount>1300)
                            <td>Oro</td>
                            @elseif($d->amount<200)
                            <td>Sin beneficios</td>
                            @endif
                            @else
                            <td>N/A</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
