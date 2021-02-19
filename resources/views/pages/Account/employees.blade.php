@extends('layouts.application')
@section('content')
@include('includes.options', ['active' => 2])
<div class="container-fluid pr-5 pl-5 " style="padding-left: 3rem !important;
    padding-right: 3rem !important;">
    <hr>
    <div class="row">
        <div class="col-4 pl-5">
            <h4>Hola {{$data->name.' '.$data->last_name.' '.$data->second_last_name}}<br>
                No. de Cliente <span style="color:#009ce0">{{Auth::user()->client_number}}</span></h4>
            <hr>
        </div>
    </div>

    <div class="container-fluid py-4" style="border: 2px solid #bfbfbf;overflow-y: scroll">
        <div class="row" >
            <div class="col-10 mx-auto " >
                <h4>Detalle de empleados</h4>
                <table class="table table-bordered ">
                    <thead>
                        <tr class="p-0 m-0 font-weight-bold">
                            <td>Nombre</td>
                            <td>Correo electrónico</td>
                            <td>Teléfono</td>
                            <td>Editar</td>
                            <td>Elimar</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($associates as $as)
                        <tr class="p-0 m-0">
                            <td>{{$as->name}} {{$as->last_name}} {{$as->second_last_name}}</td>
                            <td>{{$as->email}}</td>
                            <td>{{$as->mobile_number}}</td>
                            <td><i class="fa fa-pencil text-info"></i></td>
                            <td><i class="fa fa-trash"></i></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <div class="row text-center" style="margin-top: -35px">
            <div class="col-12">

                <i class="fa fa-caret-down fa-3x"></i>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-3 mx-auto">
                <button class="btn btn-block text-white btn-alta" 
                style="background-color: #143153;" 
                data-toggle="modal" data-target="#modalSignUpEmployee">DAR DE ALTA</button>
            </div>
        </div>
    </div>
    <br>
    @include('includes.Account.deleteButton')
    @include('includes.signUpEmployee')


    <br><br><br><br>
</div>
@stop
