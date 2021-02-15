@extends('layouts.application')
@section('content')
@include('includes.options', ['active' => 4])
<div class="container-fluid pr-5 pl-5 " >
    <h5 class="mt-3 text-center">PROGRESO DE REGISTRO</h5>
    <hr>
    <div class="row">
        <div class="col-4 pl-5">
            <h4>Hola EDUARDO Martínez Pozos<br>
                No. de Cliente <span style="color:#009ce0">000000</span></h4>
            <hr>


        </div>

    </div>

    <div class="container-fluid py-4" style="border: 2px solid #bfbfbf;overflow-y: scroll">
        <div class="row" >

            <div class="col-10 mx-auto " >
                <h4>Detalle de empleados</h4>
                <table class="table table-bordered ">
                    <tr class="p-0 m-0 font-weight-bold">
                        <td>Nombre <i class="fa fa-caret-right"></i></td>
                        <td>Correo electrónico</td>
                        <td>Teléfono</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="p-0 m-0">
                        <td>Lorem ipsum dolor sit</td>
                        <td>Lorem ipsum dolor sit</td>
                        <td>55 0000 0000</td>
                        <td><i class="fa fa-pencil text-info"></i></td>
                        <td><i class="fa fa-trash"></i></td>
                    </tr>
                    <tr class="p-0 m-0">
                        <td>Lorem ipsum dolor sit</td>
                        <td>Lorem ipsum dolor sit</td>
                        <td>55 0000 0000</td>
                        <td><i class="fa fa-pencil text-info"></i></td>
                        <td><i class="fa fa-trash"></i></td>
                    </tr>
                    <tr class="p-0 m-0">
                        <td>Lorem ipsum dolor sit</td>
                        <td>Lorem ipsum dolor sit</td>
                        <td>55 0000 0000</td>
                        <td><i class="fa fa-pencil text-info"></i></td>
                        <td><i class="fa fa-trash"></i></td>
                    </tr>
                    <tr class="p-0 m-0">
                        <td>Lorem ipsum dolor sit</td>
                        <td>Lorem ipsum dolor sit</td>
                        <td>55 0000 0000</td>
                        <td><i class="fa fa-pencil text-info"></i></td>
                        <td><i class="fa fa-trash"></i></td>
                    </tr>
                    <tr class="p-0 m-0">
                        <td>Lorem ipsum dolor sit</td>
                        <td>Lorem ipsum dolor sit</td>
                        <td>55 0000 0000</td>
                        <td><i class="fa fa-pencil text-info"></i></td>
                        <td><i class="fa fa-trash"></i></td>
                    </tr>
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
                <button class="btn btn-block text-white btn-alta" style="background-color: #143153;" >DAR DE ALTA</button>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12 text-right">
            <button class="btn text-white" style="background-color: #009CE0;">ELIMINAR MI CUENTA</button>

        </div>
    </div>


    <br><br><br><br>
</div>
@stop