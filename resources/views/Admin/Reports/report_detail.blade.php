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
                                @if( "CHUBB" === $type_report )
                                    <td><b># </b></td>
                                    <td><b># Cliente</b></td>
                                    <td><b>Nombre</b></td>
                                    <td><b>Apellido Paterno</b></td>
                                    <td><b>Apellido Materno</b></td>
                                    <td colspan="2"><b>RFC </b></td>
                                    <td><b>Fecha Nacimiento</b></td>
                                    <td><b>Género</b></td>
                                    @if( '1' === $status || '2' === $status )
                                        <td><b>Opciones</b></td>
                                    @endif
                                @else
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
                                    @if( '1' === $status || '2' === $status )
                                        <td><b>Opciones</b></td>
                                    @endif
                                @endif

                            </tr>
                            </thead>
                            <tbody>
                            <?php $count = 1 ?>
                            @foreach ($beneficiaries as $beneficiary)
                                @if( "CHUBB" === $type_report )
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$beneficiary->client_number}}</td>
                                        <td>{{$beneficiary->name}}</td>
                                        <td>{{$beneficiary->last_name}}</td>
                                        <td>{{$beneficiary->second_last_name}}</td>
                                        <td colspan="2">{{$beneficiary->rfc}}</td>
                                        <td>{{$beneficiary->birthday}}</td>
                                        <td>{{$beneficiary->gender}}</td>
                                        @if( '1' === $status || '2' === $status )
                                            <td>
                                                <a href="#" data-toggle="modal"
                                                   data-target='#edit_register'
                                                   data-id="{{ $beneficiary->id }}"
                                                   data-name="{{$beneficiary->name}}"
                                                   data-last_name_r="{{$beneficiary->last_name}}"
                                                   data-second_last_name_r="{{$beneficiary->second_last_name}}"
                                                   data-rfc_r="{{$beneficiary->rfc}}"
                                                   data-birthday="{{$beneficiary->birthday}}"
                                                   data-gender="{{$beneficiary->gender}}"
                                                   data-client_number_r="{{$beneficiary->client_number}}"
                                                   data-report_id_r="{{$beneficiary->report_id}}"
                                                   id="edit_beneficiary" class="btn btn-warning btn-sm">Editar</a>
                                                <a href="{{url('admin/reports/delete_register/'.$beneficiary->id.'/'.$beneficiary->report_id)}}" class="btn btn-danger btn-sm">Eliminar</a>
                                            </td>
                                        @endif
                                    </tr>

                                @else
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
                                        @if( '1' === $status || '2' === $status )
                                            <td>
                                                <a href="#" data-toggle="modal"
                                                   data-target='#edit_register'
                                                   data-id="{{ $beneficiary->id }}"
                                                   data-name="{{$beneficiary->name}}"
                                                   data-last_name_r="{{$beneficiary->last_name}}"
                                                   data-second_last_name_r="{{$beneficiary->second_last_name}}"
                                                   data-email="{{$beneficiary->email}}"
                                                   data-birthday="{{$beneficiary->birthday}}"
                                                   data-phone="{{$beneficiary->phone}}"
                                                   data-gender="{{$beneficiary->gender}}"
                                                   data-benefit="{{$beneficiary->benefit}}"
                                                   data-client_number_r="{{$beneficiary->client_number}}"
                                                   data-report_id_r="{{$beneficiary->report_id}}"
                                                   id="edit_beneficiary" class="btn btn-warning btn-sm">Editar</a>
                                                <a href="{{url('admin/reports/delete_register/'.$beneficiary->id.'/'.$beneficiary->report_id)}}" class="btn btn-danger btn-sm">Eliminar</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endif

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="modal fade rounded-0" id="edit_register" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg rounded-0" role="document">
                        <div class="modal-content rounded-0">
                            <div class="modal-header border-0 rounded-0" style="background-color: #143153; padding: 0 !important;">
                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                <div class="modal-header d-flex flex-row-reverse">
                                    <span class="times" data-dismiss="modal" aria-label="Close">X</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-7 pt-2 pb-5">
                                        <h2>EDITAR REGISTRO</h2>
                                        <div class="line1">
                                            <img src="{{asset('img/line2.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-danger" id="form_alert_mec" role="alert" style="border-radius: 6px;" hidden>
                                </div>
                                <div class="alert alert-danger" id="form_alert_mec_email" role="alert" style="border-radius: 6px;" hidden>
                                </div>
                                <div class="alert alert-danger" id="form_alert_mec_mobile" role="alert" style="border-radius: 6px;" hidden>
                                </div>
                                <div class="alert alert-danger" id="form_alert_mec_pass" role="alert" style="border-radius: 6px;" hidden>
                                </div>
                                <div class="alert alert-danger" id="form_alert_phone_text_mec" role="alert" style="border-radius: 6px;" hidden>
                                </div>
                                <div class="alert alert-danger" id="form_alert_dns_mec" role="alert" style="border-radius: 6px;" hidden>
                                </div>
                                <div class="alert alert-success" id="alertSuccessCodeMec" role="alert" style="border-radius: 6px;" hidden>
                                    <button type="button" class="close alertClose" aria-hidden="true" >&times;</button>
                                    <p style="margin-bottom: 0;">Se ha enviado un código de verificación al telefóno celular indicado</p>
                                </div>
                                <div class="alert alert-danger" id="error_code" role="alert" style="border-radius: 6px;" hidden>
                                </div>
                                <form autocomplete="off" id="mechanicForm" method="POST" action="{{route('admin.reports.update.register')}}">
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6 py-2" style="display: flex">
                                            <input type="text" class="form-control btnBorder mobileInput" placeholder="NÚMERO DE CLIENTE"
                                                   id="client_number_r" name="client_number" required>
                                            <p style="color: red; margin: 0;">*</p>
                                        </div>
                                        <div class="col-lg-6 py-2" style="display: flex">
                                            <input type="text" class="form-control btnBorder nameInput" placeholder="NOMBRE" id="name_r"
                                                   name="name" required>
                                            <p style="color: red; margin: 0;">*</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 py-2" style="display: flex">
                                            <input type="text" class="form-control btnBorder mobileInput" placeholder="APELLIDO PATERNO"
                                                   id="last_name_r" name="last_name" required>
                                            <p style="color: red; margin: 0;">*</p>
                                        </div>
                                        <div class="col-lg-6 py-2" style="display: flex">
                                            <input type="text" class="form-control btnBorder nameInput" placeholder="APELLIDO MATERNO" id="second_last_name_r"
                                                   name="second_last_name" required>
                                            <p style="color: red; margin: 0;">*</p>
                                        </div>
                                    </div>
                                    @if( "CHUBB" === $type_report )
                                        <div class="row">
                                            <div class="col-lg-6 py-2" style="display: flex">
                                                <input type="text" class="form-control btnBorder mobileInput" placeholder="RFC"
                                                       id="rfc_r" name="rfc" required>
                                                <p style="color: red; margin: 0;">*</p>
                                            </div>
                                            <div class="col-lg-6 py-2" style="display: flex">
                                                <input type="text" class="form-control btnBorder nameInput" placeholder="FECHA NACIMIENTO" id="birthday_r"
                                                       name="birthday" required>
                                                <p style="color: red; margin: 0;">*</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if( "TELASIST" === $type_report )
                                        <div class="row">
                                            <div class="col-lg-6 py-2" style="display: flex">
                                                <input type="text" class="form-control btnBorder mobileInput" placeholder="EMAIL"
                                                       id="email_r" name="email" required>
                                                <p style="color: red; margin: 0;">*</p>
                                            </div>
                                            <div class="col-lg-6 py-2" style="display: flex">
                                                <input type="text" class="form-control btnBorder nameInput" placeholder="FECHA NACIMIENTO" id="birthday_r"
                                                       name="birthday" required>
                                                <p style="color: red; margin: 0;">*</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if( "CHUBB" === $type_report )
                                        <div class="row">
                                            <div class="col-lg-6 py-2" style="display: flex">
                                                <input type="text" class="form-control btnBorder nameInput" placeholder="GÉNERO" id="gender_r"
                                                       name="gender" required>
                                                <p style="color: red; margin: 0;">*</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if( "TELASIST" === $type_report )
                                        <div class="row">
                                            <div class="col-lg-6 py-2" style="display: flex">
                                                <input type="text" class="form-control btnBorder mobileInput" placeholder="TELÉFONO"
                                                       id="phone_r" name="phone" required>
                                                <p style="color: red; margin: 0;">*</p>
                                            </div>
                                            <div class="col-lg-6 py-2" style="display: flex">
                                                <input type="text" class="form-control btnBorder nameInput" placeholder="GÉNERO" id="gender_r"
                                                       name="gender" required>
                                                <p style="color: red; margin: 0;">*</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 py-2" style="display: flex">
                                                <input type="text" class="form-control btnBorder mobileInput" placeholder="BENEFICIO"
                                                       id="benefit_r" name="benefit" required>
                                                <p style="color: red; margin: 0;">*</p>
                                            </div>
                                        </div>
                                    @endif



                                    <input type="hidden" class="form-control btnBorder mobileInput"
                                           id="id_r" name="id">
                                    <input type="hidden" class="form-control btnBorder mobileInput"
                                           id="report_id_r" name="report_id">

                                    <input type="hidden" class="form-control btnBorder mobileInput"
                                           id="type_report_r" name="type_report" value="{{$type_report}}">

                                    <input type="hidden" id="client_type" name="client_type" value="2">
                                    <div class="modal-footer border-top-0">
                                        <input type="submit" class="btn btn" style="background-color: #00A1E3;color: white;"
                                               id="btnSend_mechanic"
                                               onclick="focusrfc('rfcMec')";
                                               value="Actualizar">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
