@extends('layouts.application')
@section('content')
@include('includes.options', ['active' => 2])

<div style="padding-left: 3rem !important;
    padding-right: 3rem !important;">
    <hr>
    <div class="col-md-12" style="display: flex;">
        <div style="padding-left: 10px !important;" class="col-md-3">
            <h6>Hola {{$data->name.' '.$data->last_name.' '.$data->second_last_name}}<br>
               No. de Cliente <span style="color:#009ce0">{{substr(Auth::user()->client_number, 2)}}</span><br>
                @if ((int)Auth::user()->client_type == 1)
                    Cuenta: Negocios
                @else
                    Cuenta: Individual
                @endif
            </h6>
            <a href="#" class="btn btn" data-toggle="modal" data-target="#survey" style="background-color: #00A1E3;color: #FFF;">Nos interesa tu opinión</a>
         </div>
        <div class="col-md-6" style="display: flex; justify-content: center; align-items: center">
            <h5>Agrega a tus beneficiarios para darle los beneficios del seguro.</h5>
        </div>
    </div>
    <hr>
    <div>
        <div>
            <div style="margin-left: 10px !important;">
                <h5>Detalle de empleados</h5>

                @if (session()->has('activeAssociate'))
                     <div class="col-lg-12 text-justify text-primary">
                        <h6 style="color:red;text-align:center">
                           El correo y/o número de teléfono ya es dependiente de un cuenta de negocio
                        </h6>
                     </div>
                @endif

                @if (session()->has('deactiveAssociate'))
                    <div class="col-lg-12 text-justify text-primary">
                        <h6 style="color:red;text-align:center">
                            El correo y/o número de teléfono ya ha sido dependiente de este negocio<br>
                            Se ha enviado un email para que active nuevamente su cuenta
                        </h6>
                    </div>
                @endif

                @if(session()->has('isMechanic'))
                    <div class="col-lg-12 text-justify text-primary">
                        <h6 style="color:red;text-align:center">
                            El email y/o número de teléfono pertenecen a una cuenta individual <br>
                            Se ha enviado un email al usuario para aceptar tu invitación <br>
                            En cuanto acepte tu invitación formará parte de tus dependientes
                        </h6>
                    </div>
                @endif

                @if(session()->has('isOwner'))
                    <div class="col-lg-12 text-justify text-primary">
                        <h6 style="color:red;text-align:center">
                            No es posible registrar al asociado, el email y/o número de teléfono pertenecen a una cuenta de negocio
                        </h6>
                    </div>
                @endif

                @if(session()->has('success'))
                    <script>
                        $(function() {
                            $('#associateSuccess').modal('show');
                        });
                    </script>
                @endif

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
                                    href="{{ action('CustomerController@editEmployee',['user' => $as->id]) }}"
                                    id="edit-item"
                                    role="button">
                                    <i class="fa fa-pencil text-info"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-outline-dark btn-sm btn-block"
                                        style="border: 0px"
                                        href="{{ action('CustomerController@deleteEmployee',['employee' => $as->id]) }}"
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
                @if ($validated === false)
                disabled
                @endif
                style="background-color: #143153;"
                data-toggle="modal" data-target="#modalSignUpEmployee">Agregar Dependiente</button>
            </div>
        </div>
    </div>
    <br>

    @include('includes.signUpEmployee')

    <br><br><br><br>
</div>

<!-- Success Modal -->
<div class="modal fade" id="associateSuccess" tabindex="-1" role="dialog" aria-labelledby="associateSuccess" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">

            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <img src="{{asset('img/icon_check.png')}}">
                        <h5 class="text-white">¡HAS AGREGADO CORRECTAMENTE A TU DEPENDIENTE!</h5>
                        <p class="text-white">Se ha enviado un email a tu dependiente para crear su cuenta</p>
                        <p class="text-white" id="clientNumber"></p>
                        <button data-dismiss="modal" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $.noConflict();
    jQuery(document).ready(function($){
        $('#tableEmployees').DataTable({
       dom: 'Bfrtip',
       info: false,
       searching:false,
       scrollX:true,
       oLanguage: {
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
    });
 </script>
@stop
