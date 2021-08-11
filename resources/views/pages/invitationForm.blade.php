@extends('layouts.application')
@section('content')

<div style="padding-left: 3rem !important;
    padding-right: 3rem !important;">
    <br>
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
                 @if ($employee == null)
                    <div>
                        <h5>Error: Número de cliente o número de teléfono no existe.</h5>
                    </div>
                 @else
                 <form id="mechanicForm" method="POST" action="{{route('signUpInvitation')}}">
                     @method('POST')
                     @csrf
                     <div class="row">
                         <div class="col-lg-6 py-2" style="display: flex">
                             <input type="text" class="form-control mobileInput" value="{{substr($employee->client_number, 2)}}"
                             id="client_number_mec" name="client_number" pattern="[0-9]{8}" readonly required>
                             <p style="color: red; margin: 0;">*</p>
                         </div>
                         <div class="col-lg-6 py-2" style="display: flex">
                             <input type="text" class="form-control nameInput" placeholder="NOMBRE" id="nameInv"
                             name="name" value="{{$employee->name}}" pattern="[a-zA-Z\s]*" required>
                             <p style="color: red; margin: 0;">*</p>
                         </div>
                         <div class="col-lg-6 py-2" style="display: flex">
                             <input type="text" class="form-control nameInput" placeholder="PRIMER APELLIDO"
                             id="lastNameInv" value="{{$employee->last_name}}" name="last_name" pattern="[a-zA-Z\s]*" required>
                             <p style="color: red; margin: 0;">*</p>
                         </div>
                         <div class="col-lg-6 py-2" style="display: flex">
                             <input type="text" class="form-control nameInput" placeholder="SEGUNDO APELLIDO"
                             id="secondLastNameInv" value="{{$employee->second_last_name}}" name="second_last_name" pattern="[a-zA-Z\s]*" required>
                             <p style="color: red; margin: 0;">*</p>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-lg-6 py-3" id="mobile" style="display: flex">
                             <input type="text" class="form-control mobileInput" placeholder="NO. TELEFÓNICO 10 DIG"
                             id="mobileMec" name="mobile" value="{{$employee->mobile_number}}" maxlength="10" pattern="[0-9]{10}" required>
                             <p style="color: red; margin: 0;">*</p>
                         </div>
                         <div class="col-lg-6 py-3" style="display: flex">
                             <label for="birthday" class="labelgre py-2" style="top: -10px;padding-left: 4px">Fecha de Nacimiento</label>
                             <input class="form-control"  type="date" id="birthdayM"
                                style="border: 1px solid black;"
                                name="birthday" value="<?php echo date($employee->birthday);?>" required>
                             <p style="color: red; margin: 0;">*</p>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-lg-6 py-2" style="display: flex">
                             <select class="form-control" name="gender"
                             style="border: 1px solid black;" required>
                                 <option>GÉNERO</option>
                                 <option value="F">FEMENINO</option>
                                 <option value="M">MASCULINO</option>
                                </select>
                                <p style="color: red; margin: 0;visibility:hidden">*</p>
                         </div>
                         <div class="col-lg-6 py-2" style="display: flex">
                             <input type="email" class="form-control" value="{{$employee->email}}"
                             autocomplete="new-password" placeholder="CORREO ELECTRÓNICO" id="emailMec" name="email"
                             pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                             style="border: 1px solid black;" required readonly>
                             <p style="color: red; margin: 0;">*</p>
                         </div>
                     </div>
                     <div class="row ">
                         <div class="col-lg-6 py-2" style="display: flex">
                             <input type="password" class="form-control"
                             autocomplete="new-password" placeholder="CONTRASEÑA" name="password" id="password" required>
                             <p style="color: red; margin: 0;">*</p>
                         </div>
                         <div class="col-lg-6 py-2" style="display: flex">
                             <input type="password" class="form-control" placeholder="CONFIRMAR CONTRASEÑA" name="confirmPassword" id="confirmPassword" required>
                             <p style="color: red; margin: 0;">*</p>
                         </div>
                         <div class="col-lg-6 py-2" style="display: flex">
                            <input type="text" class="form-control" placeholder="R.F.C" id="rfcInv" name="rfc">
                            <p style="color: red; margin: 0;visibility: hidden">*</p>
                        </div>
                     </div>
                     <input type="hidden" id="client_type" name="client_type" value="3">
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

                 @endif
            </div>
        </div>
        <br>

    </div>
    <br>

    <br><br><br><br>
</div>

<script>
    //jQuery.noConflict();
    document.getElementById('rfcInv').addEventListener('focus',function() {

        var rfc = document.getElementById('rfcInv');
        var fecha = $('#birthdayM').val().split('-');

        var CURP = [];
        CURP[0] = $("#lastNameInv").val().charAt(0).toUpperCase();
        for (let i = 1; i < $("#lastNameInv").val().length; i++) {
            if($("#lastNameInv").val().charAt(i).match(/[aeiou]/gi)){
                CURP[1] = $("#lastNameInv").val().charAt(i).toUpperCase();
                break;
            }
        }
        CURP[2] = $("#secondLastNameInv").val().charAt(0).toUpperCase();
        CURP[3] = $("#nameInv").val().charAt(0).toUpperCase();
        CURP[4] = fecha[0].slice(2);//year
        CURP[5] = fecha[1];//mont
        CURP[6] = fecha[2];//day

        $('#rfcInv').val(CURP.join("").toString());

    })
</script>
@stop
