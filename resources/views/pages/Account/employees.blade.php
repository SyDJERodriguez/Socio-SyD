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
            <h5>Agrega a tus beneficiarios para darle los beneficios del seguro</h5>
        </div>
    </div>
    <hr>
    <div>
        <div>
            <div style="margin-left: 10px !important;">
                <h5>Detalle de empleados</h5>

                @if (session()->has('activeAssociate'))
                    <script>
                        $(function() {
                            $('#dependentOwner').modal('show');
                        });
                    </script>
                @endif

                @if (session()->has('deactiveAssociate'))
                    <script>
                        $(function() {
                            $('#historicSuccess').modal('show');
                        });
                    </script>
                @endif

                @if(session()->has('isMechanic'))
                    <script>
                        $(function() {
                            $('#individualSuccess').modal('show');
                        });
                    </script>
                @endif

                @if(session()->has('isOwner'))
                    <script>
                        $(function() {
                            $('#ownerSuccess').modal('show');
                        });
                    </script>
                @endif

                @if(session()->has('isDependent'))
                    <script>
                        $(function() {
                            $('#dependentSuccess').modal('show');
                        });
                    </script>
                @endif

                @if(session()->has('phoneNoValid'))
                    <script>
                        $(function() {
                            $('#phoneNoValid').modal('show');
                        });
                    </script>
                @endif

                @if(session()->has('dnsNoValid'))
                <script>
                    $(function() {
                        $('#dnsNoValid').modal('show');
                    });
                </script>
            @endif

                @if(session()->has('success'))
                    <script>
                        $(function() {
                            $('#associateSuccess').modal('show');
                        });
                    </script>
                @endif

                @if ($validated === false)
                    <script>
                        $(function() {
                            $('#limitAccount').modal('show');
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
                                <a class="btn btn-outline-dark btn-sm btn-block delete"
                                        style="border: 0px"
                                        href="#"
                                        role="button" id="{{$as->id}}" 
                                        onclick="deleteEmployee('{{$as->id}}','{{$as->name .' '.$data->last_name.' '.$as->second_last_name}}')">
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
                        <h5 class="text-white">TU COLABORADOR HA SIDO DADO <br> DE ALTA CORRECTAMENTE</h5>
                        {{-- <p class="text-white">Se ha enviado un email a tu dependiente para crear su cuenta</p> --}}
                        <button data-dismiss="modal" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- phoneNoValid Modal -->
<div class="modal fade" id="phoneNoValid" tabindex="-1" role="dialog" aria-labelledby="phoneNoValid" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">

            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p><i class="fas fa-times" style="font-size: 28px;color: #00A1E3"></i></p>
                        <h5 class="text-white">¡NÚMERO TELEFÓNICO NO VÁLIDO!</h5>
                        <p class="text-white">No es posible registrar al asociado, número de teléfono no es válido</p>
                        <button data-dismiss="modal" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- dnsNoValid Modal -->
<div class="modal fade" id="dnsNoValid" tabindex="-1" role="dialog" aria-labelledby="dnsNoValid" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">

            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p><i class="fas fa-times" style="font-size: 28px;color: #00A1E3"></i></p>
                        <h5 class="text-white">¡CORREO ELECTRÓNICO NO VÁLIDO!</h5>
                        <p class="text-white">No es posible registrar al asociado, el email no es válido</p>
                        <button data-dismiss="modal" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Individual Account Modal -->
<div class="modal fade" id="individualSuccess" tabindex="-1" role="dialog" aria-labelledby="individualSuccess" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">

            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        {{-- <img src="{{asset('img/icon_check.png')}}"> --}}
                        <h5 class="text-white">¡HAS AGREGADO UN USUARIO CON CUENTA INDIVIDUAL!</h5>
                        <p class="text-white">El email y/o número de teléfono pertenecen a una cuenta individual</p>
                        <p class="text-white">Se ha enviado un email al usuario para aceptar tu invitación</p>
                        <p class="text-white">En cuanto acepte tu invitación formará parte de tus dependientes</p>
                        <button data-dismiss="modal" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Owner Account Modal -->
<div class="modal fade" id="ownerSuccess" tabindex="-1" role="dialog" aria-labelledby="ownerSuccess" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">

            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        {{-- <img src="{{asset('img/icon_check.png')}}"> --}}
                        <h5 class="text-white">¡HAS INTENTADO AGREGAR UN USUARIO CON CUENTA DE NEGOCIO!</h5>
                        <p class="text-white">No es posible registrar al asociado, el email y/o número de teléfono pertenecen a una cuenta de negocio</p>
                        <button data-dismiss="modal" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Owner Account Modal -->
<div class="modal fade" id="dependentSuccess" tabindex="-1" role="dialog" aria-labelledby="dependentSuccess" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">

            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        {{-- <img src="{{asset('img/icon_check.png')}}"> --}}
                        <h5 class="text-white">¡HAS INTENTADO AGREGAR UN USUARIO REGISTRADO!</h5>
                        <p class="text-white">No es posible registrar al asociado, el email y/o número de teléfono pertenecen a una cuenta registrada</p>
                        <button data-dismiss="modal" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Historic Dependent Account Modal -->
<div class="modal fade" id="historicSuccess" tabindex="-1" role="dialog" aria-labelledby="historicSuccess" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">

            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        {{-- <img src="{{asset('img/icon_check.png')}}"> --}}
                        <h5 class="text-white">¡EL DEPENDIENTE AGREGADO YA HA SIDO TU COLABORADOR!</h5>
                        <p class="text-white">El correo y/o número de teléfono ya ha sido dependiente de este negocio</p>
                        <p class="text-white">Se ha enviado un email para que active nuevamente su cuenta</p>
                        <button data-dismiss="modal" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dependent to other Owner Account Modal -->
<div class="modal fade" id="dependentOwner" tabindex="-1" role="dialog" aria-labelledby="dependentOwner" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">

            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        {{-- <img src="{{asset('img/icon_check.png')}}"> --}}
                        <h5 class="text-white">¡EL DEPENDIENTE AGREGADO YA ESTA ASOCIADO A OTRA CUENTA DE NEGOCIO!</h5>
                        <p class="text-white">El correo y/o número de teléfono ya es dependiente de un cuenta de negocio</p>
                        <button data-dismiss="modal" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Limit Account Modal -->
<div class="modal fade" id="limitAccount" tabindex="-1" role="dialog" aria-labelledby="limitAccount" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">

            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h5 class="text-white">{{strtoupper($data->name).' '.strtoupper($data->last_name).' '.strtoupper($data->second_last_name)}}</h5>
                        <p class="text-white">Has llegado al límite de usuarios dependientes</p>
                        <button data-dismiss="modal" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;" >CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delet Dependent Modal -->
<div class="modal fade" id="deleteDependent" tabindex="-1" role="dialog" aria-labelledby="deleteDependent" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div style="height: 34px;">

            </div>
            <div class="modal-body " style="background-color: #143153;">
                <div class="row">
                    <div class="col-12 text-center">
                        <h5 class="text-white">{{strtoupper($data->name).' '.strtoupper($data->last_name).' '.strtoupper($data->second_last_name)}}</h5>
                        <div class="row">
                            <div class="col-8 py-2 text-center">
                                <p class="text-white">El siguiente dependiente perderá los beneficios:</p>
                                <p class="text-white" id="nameDependient"></p>
                                <p class="text-white">Al eliminarlo perderá todos sus beneficios</p>
                            </div>
                            <div class="col-2 py2 text-center" style="padding: 30px 0 0 0;">
                                <input type="button" class="btn btn-light btn-sm" value="CANCELAR" data-dismiss="modal"
                                       style="padding-left: 35px;padding-right: 35px;background-color: white;color: #00A5E6;width: 138px;">
                                <br>
                                <a href="#"
                                   class="text-white btn btn bg-primary btn-sm my-2 confirmDeleteButton"
                                   style="padding-left: 40px;padding-right: 40px">
                                    ACEPTAR
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function deleteEmployee(id,name){
        //console.log(id+" "+name)
        //$('.confirmDeleteButton').attr('id', id);
        document.getElementById('nameDependient').innerText=name;
        let href_button = "{{ url('/customer/employees/{id}/delete') }}";
        href_button = href_button.replace('{id}', id)
        $('.confirmDeleteButton').attr('href', href_button)
        $('#deleteDependent').modal('show');
    }
    /*$('.delete').on('click', function(){
        let id = $(this).data('datos-id');
        console.log('hola');
        //rest.eliminarEjercicio(id);//Esto es lo que quiero hacer en el modal
        $('#deleteDependent').data('id_elemento',id);

        $('#deleteDependent').modal({backdrop: false});

    });*/

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
