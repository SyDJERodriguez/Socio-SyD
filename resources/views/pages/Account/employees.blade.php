@extends('layouts.application')
@section('content')
@include('includes.options', ['active' => 2])

<div style="padding-left: 3rem !important;
    padding-right: 3rem !important;">
    <hr>
    <div >
        <div style="padding-left: 10px !important;">
            <h6>Hola {{$data->name.' '.$data->last_name.' '.$data->second_last_name}}<br>
               No. de Cliente <span style="color:#009ce0">{{substr(Auth::user()->client_number, 2)}}</span>
            </h6>
            <hr>
         </div>
    </div>

    <div>
        <div>
            <div style="margin-left: 10px !important;">
                <h5>Detalle de empleados</h5>
                <table class="table table-striped table-bordered" id="tableEmployees" style="width:100%">
                    <thead>
                        <tr>
                            <td><b>Nombre </b></td>
                            <td><b>Correo electrónico</b></td>
                            <td><b>Teléfono </b></td>
                            <td><b>Editar </b></td>
                            <td><b>Eliminar </b></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($associates as $as)
                        <tr>
                            <td>{{$as->name}} {{$as->last_name}} {{$as->second_last_name}}</td>
                            <td>{{$as->email}}</td>
                            <td>{{$as->mobile_number}}</td>
                            <td>
                                <a class="btn btn-outline-light btn-sm btn-block" 
                                    href="{{ action('CustomerController@editEmployee',['user' => $as->number]) }}"
                                    id="edit-item" 
                                    role="button">
                                    <i class="fa fa-pencil text-info"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-outline-dark btn-sm btn-block" 
                                        style="border: 0px" 
                                        href="{{ action('CustomerController@deleteEmployee',['employee' => $as->number]) }}" 
                                        role="button">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-lg-12 text-justify text-primary leyenda">
                    <p style="font-size:10px">
                       <b>Desliza hacia la derecha con el scroll inferior, para ver la tabla completa.<b>
                    </p>
                 </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12 col-md-3 mx-auto">
                <button class="btn btn-block text-white btn-alta"     
                @if ($validated == 0)
                disabled
                @endif
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

<script>
    $('#tableEmployees').DataTable({
       dom: 'Bfrtip',
       info: false,
       searching:false,
       scrollX:true,
       language: {
          paginate: {
             previous: "Anterior",
             next: "Siguiente"
          }
       },
       buttons: [
          {
             extend: 'excel',
             text: 'Excel',
             className: 'excel',
             exportOptions: {
                 modifier: {
                     page: 'current'
                 }
             }
         },
         {
             extend: 'print',
             text: 'Imprimir',
             className: 'print',
             exportOptions: {
                 modifier: {
                     page: 'current'
                 }
             }
         }
        ],
        language: {
            emptyTable: "No hay registros para mostrar"
        }
    });
 </script>
@stop
