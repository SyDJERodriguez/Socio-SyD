@extends('layouts.admin')

@section('content')
    <div class="container" style="max-width: 100%">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div style="display: flex; justify-content: space-between;">
                    <div class="col-md-4">
                        <h2>Detalle de reporte</h2>
                    </div>
                    <div class="col-md-6" style="display: flex; justify-content: flex-end;">
                        <!--<div class="col-md-4" style="max-width: 20%">
                            <a href="{{route('admin.reports.index')}}" class="btn btn-lg btn-success">Descargar</a>
                        </div>-->
                        <div class="col-md-4" style="max-width: 20%">
                            <a href="{{route('admin.reports.index')}}"
                               class="btn btn-lg"
                               style="background-color: rgb(0, 165, 230); color: rgb(255, 255, 255);">Regresar</a>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <h4></h4>
                        <table class="table table-striped table-bordered" style="table-layout: fixed; width:100%;">
                            <thead>
                            <tr>
                                <td><b># </b></td>
                                <td><b># Cliente</b></td>
                                <td><b>Nombre</b></td>
                                <td><b>Apellido Paterno</b></td>
                                <td><b>Apellido Materno</b></td>
                                <td colspan="2"><b>Email </b></td>
                                <td><b>Fecha Nacimiento</b></td>
                                <td><b>Teléfono</b></td>
                                <td><b>Género</b></td>
                                <td><b>Beneficio</b></td>
                                <td><b>Opciones</b></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $count = 1 ?>
                            @foreach ($beneficiaries as $beneficiary)
                                <tr>
                                    <td>{{$count++}}</td>
                                    <td>{{$beneficiary->client_number}}</td>
                                    <td>{{$beneficiary->name}}</td>
                                    <td>{{$beneficiary->last_name}}</td>
                                    <td>{{$beneficiary->second_last_name}}</td>
                                    <td colspan="2">{{$beneficiary->email}}</td>
                                    <td>{{$beneficiary->birthday}}</td>
                                    <td>{{$beneficiary->phone}}</td>
                                    <td>{{$beneficiary->gender}}</td>
                                    <td>{{$beneficiary->benefit}}</td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="#" class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
