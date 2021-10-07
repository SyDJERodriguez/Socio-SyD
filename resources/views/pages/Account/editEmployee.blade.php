@extends('layouts.application')
@section('content')
@include('includes.options', ['active' => 2])

<div style="padding-left: 3rem !important;
    padding-right: 3rem !important;">
    <hr>
    <div>
        <div>
            <div style="margin-left: 15px !important;">
                <h4>Editar empleado</h4>
                <br>
                <div class="alert alert-danger" id="form_alert_phone_text_EEF" role="alert" style="border-radius: 6px;" hidden>
                </div>
                <div class="alert alert-danger" id="form_alert_dns_EEF" role="alert" style="border-radius: 6px;" hidden>
                </div>
                <br>
                <form autocomplete="off" id="editEmployeeForm" method="POST" action="{{route('customer.updateEmployee')}}">
                    @method("POST")
                    @csrf
                    <input type="hidden" name="client_number" value="{{Auth::user()->client_number}}">
                    <input type="hidden" name="customer_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="id" value="{{$id}}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <input class="form-control-sm form-control nameInput" type="text"
                                        name="name"   
                                        value="{{$employee->name}}"
                                        pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{3,}"
                                        required maxlength="30">

                            </div>
                            <div class="col-6">
                                <input class="form-control-sm form-control nameInput" type="text"
                                        name="last_name"       
                                        placeholder="APELLIDO PATERNO"
                                        value="{{$employee->last_name}}"
                                        pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{3,}"
                                        required maxlength="30">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <input class="form-control-sm form-control nameInput" type="text"
                                        name="second_last_name"
                                        placeholder="APELLIDO MATERNO"
                                        value="{{$employee->second_last_name}}"
                                        pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{3,}"
                                        required  maxlength="30">
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <div style="border: 1px solid black" class="input-group-text">+52</div>
                                    </div>
                                    <input type="text" class="form-control-sm form-control btnBorder mobileInput" 
                                    placeholder="NO. TELEFÓNICO 10 DIG"
                                    name="mobile_number" 
                                    maxlength="10"
                                    pattern="[0-9]{10}"
                                    value="{{(int)$employee->mobile_number}}"
                                    required>
                                    <div class="input-group-append" id="form_alert_phone_EEF" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <label class="text-muted sml p-0 m-0">FECHA DE NACIMIENTO</label><br>
                            </div>
                            <div class="col-6">
                                <input class="form-control-sm form-control btnBorder" 
                                        type="email"
                                        autocomplete="new-password"
                                        name="email"
                                        value="{{$employee->email}}"
                                        pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9._%+-]+@[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9.-]+\.[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,}$"
                                        required>

                            </div>
                            <div class="col-6">
                                <div>
                                    <div>
                                        <input class="form-control-sm form-control btnBorder" type="date"
                                                name="bday"        
                                                value="{{$employee->birthday}}"
                                                required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn" id="btnSendEditEmployee" style="background-color: #009CE0;border:0px;color: #FFF">ACEPTAR</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>

    </div>
    <br>

    <br><br><br><br>
</div>
@stop