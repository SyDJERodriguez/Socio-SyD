@extends('layouts.application')
@section('content')

<div style="padding-left: 3rem !important;
    padding-right: 3rem !important;">
    <hr>
    <div>
        <div>
            <div style="margin-left: 15px !important;">
                <h4>Registro asociado</h4>
                <br>
                @if (\Session::has('msg'))
                 <div class="col-lg-12 text-justify text-primary">
                    <p style="font-size:11px;color:red;text-align:center">
                       {{Session::get('msg')}}
                    </p>
                 </div>
                 @endif
                <form id="mechanicForm" method="POST" action="{{route('signUpInvitation')}}">
                    @method('POST')
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 py-2" style="display: flex">
                            <input type="text" class="form-control" value="{{$client_number}}" 
                            id="client_number_mec" name="client_number" pattern="[0-9]{8}" readonly required>
                            <p style="color: red; margin: 0;">*</p>
                        </div>
                        <div class="col-lg-6 py-2" style="display: flex">
                            <input type="text" class="form-control nameInput" placeholder="NOMBRE" id="nameMec" 
                            name="name" pattern="[a-zA-Z]{3,}" required>
                            <p style="color: red; margin: 0;">*</p>
                        </div>
                        <div class="col-lg-6 py-2" style="display: flex">
                            <input type="text" class="form-control nameInput" placeholder="PRIMER APELLIDO" 
                            id="lastNameMec" name="last_name" pattern="[a-zA-Z]{3,}" required>
                            <p style="color: red; margin: 0;">*</p>
                        </div>
                        <div class="col-lg-6 py-2" style="display: flex">
                            <input type="text" class="form-control nameInput" placeholder="SEGUNDO APELLIDO" 
                            id="secondLastNameMec" name="second_last_name" pattern="[a-zA-Z]{3,}" required>
                            <p style="color: red; margin: 0;">*</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 py-2" id="mobile" style="display: flex">
                            <input type="text" class="form-control mobileInput" placeholder="NO. TELEFÓNICO 10 DIG" 
                            id="mobileMec" name="mobile" maxlength="10" pattern="[0-9]{10}" required>
                            <p style="color: red; margin: 0;">*</p>
                        </div>
                        <div class="col-lg-6 py-2" style="display: flex">
                            <label for="" class="labelgre py-1">FECHA DE NACIMIENTO</label>
                            <input class="form-control" type="date" id="birthday" 
                                name="birthday" value="<?php echo date('Y-m-d');?>" required>
                            <p style="color: red; margin: 0;">*</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 py-3">
                            <select class="form-control" name="gender" required>
                                <option>GÉNERO</option>
                                <option value="F">FEMENINO</option>
                                <option value="M">MASCULINO</option>
                            </select>
                        </div>
                        <div class="col-lg-6 py-3" style="display: flex">
                            <input type="email" class="form-control" placeholder="CORREO ELECTRÓNICO" id="emailMec" name="email" required>
                            <p style="color: red; margin: 0;">*</p>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-6 py-3" style="display: flex">
                            <input type="password" class="form-control" placeholder="CONTRASEÑA" name="password" id="password" required>
                            <p style="color: red; margin: 0;">*</p>
                        </div>
                        <div class="col-lg-6 py-3" style="display: flex">
                            <input type="password" class="form-control" placeholder="CONFIRMAR CONTRASEÑA" name="confirmPassword" id="confirmPassword" required>
                            <p style="color: red; margin: 0;">*</p>
                        </div>
                    </div>
                    <input type="hidden" id="client_type" name="client_type" value="2">
                    <div class="modal-footer border-top-0">
                        <div class="form-check form-check-inline text-right">
                                <label class="form-check-label pr-2" for="inlineCheckbox1"  
                                    style="color: grey;font-size: 12px;">
                                    <strong>ACEPTAR</strong>
                                
                                <br>
                                <a href="#" data-toggle="modal" data-target="#modalAviso">
                                    AVISO DE PRIVACIDAD</a>
                                <br>
                                <a href="#" data-toggle="modal" data-target="#modalGeneralTerms">
                                    TÉRMINOS Y CONDICIONES</a>
                                </label>
                            <input class="form-check-input " style="width: 30px;height: 30px;" type="checkbox" id="inlineCheckbox1" value="option1" required>
                        </div>
                        <input type="submit" class="btn btn" style="background-color: #00A1E3;color: white;" 
                        id="btnSend" value="Enviar">
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