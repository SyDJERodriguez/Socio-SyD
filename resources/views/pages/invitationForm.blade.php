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
                 <div class="alert alert-success" id="alertSuccessCodeinv" role="alert" style="border-radius: 6px;" hidden>
                    <button type="button" class="close alertClose" aria-hidden="true" >&times;</button>
                    <p style="margin-bottom: 0;">Se ha enviado un código de verificación al telefóno celular indicado</p>
                </div>
                <div class="alert alert-danger" id="error_code_inv" role="alert" style="border-radius: 6px;" hidden>
                </div>
                 <form id="mechanicForm" method="POST" action="{{route('signUpInvitation')}}" >
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
                             name="name" value="{{$employee->name}}" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*" required>
                             <p style="color: red; margin: 0;">*</p>
                         </div>
                         <div class="col-lg-6 py-2" style="display: flex">
                             <input type="text" class="form-control nameInput" placeholder="PRIMER APELLIDO"
                             id="lastNameInv" value="{{$employee->last_name}}" name="last_name" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*" required>
                             <p style="color: red; margin: 0;">*</p>
                         </div>
                         <div class="col-lg-6 py-2" style="display: flex">
                             <input type="text" class="form-control nameInput" placeholder="SEGUNDO APELLIDO"
                             id="secondLastNameInv" value="{{$employee->second_last_name}}" name="second_last_name" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*" required>
                             <p style="color: red; margin: 0;">*</p>
                         </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-6 py-3" id="mobile" style="display: flex; flex-direction: column;">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div style="border: 1px solid black" class="input-group-text">+52</div>
                                </div>
                                <input type="text" class="form-control btnBorder mobileInput" placeholder="NO. TELEFÓNICO 10 DIG"
                                id="mobileInv" name="mobile" value="{{$employee->mobile_number}}" maxlength="10" pattern="[0-9]{10}" required>
                                <div class="input-group-append" id="form_alert_phone_inv" hidden>
                                </div>
                                <p style="color: red; margin: 0;">*</p>
                            </div>
                           
                            <div class="input-group mb-3" style="margin-top: 1rem">
                                <input type="hidden" class="form-control btnBorder" placeholder="CÓDIGO DE VERIFICACIÓN 6 DIG"
                                       id="codeinv" name="verification_code" maxlength="6" pattern="[0-9]{6}" required style="border-radius: .25rem;">
                                <input type="hidden" class="form-control btnBorder" placeholder="CÓDIGO DE VERIFICACIÓN 6 DIG"
                                       id="codeConfirminv" name="confirm_code" maxlength="6" pattern="[0-9]{6}" required style="border-radius: .25rem;">
                                <p style="color: red; margin: 0;" hidden id="requiredSignalinv">*</p>
                            </div>
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
                                 <option selected="true" disabled="true" value="">GÉNERO</option>
                                 <option value="F">FEMENINO</option>
                                 <option value="M">MASCULINO</option>
                                </select>
                                <p style="color: red; margin: 0;">*</p>
                         </div>
                         <div class="col-lg-6 py-2" style="display: flex">
                             <input type="email" class="form-control" value="{{$employee->email}}"
                             autocomplete="new-password" placeholder="CORREO ELECTRÓNICO" id="emailMec" name="email"
                             pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9._%+-]+@[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9.-]+\.[a-zA-ZñÑ]{2,}$"
                             style="border: 1px solid black;" required readonly>
                             <p style="color: red; margin: 0;">*</p>
                         </div>
                     </div>
                     <div class="row ">
                        <div class="col-lg-6 order-0 order-lg-0 py-2" style="display: flex">
                            <input type="text" class="form-control" placeholder="R.F.C" id="rfcInv" name="rfc">
                            <p style="color: red; margin: 0;visibility: hidden">*</p>
                        </div>
                         <div class="col-lg-6 order-1 order-lg-1 py-2" style="display: flex">
                             <input type="password" class="form-control"
                             autocomplete="new-password" placeholder="CONTRASEÑA" name="password" id="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,20}$" title="La contraseña debe tener más de 8 caracteres, una mayúscula, un número y un caracter especial " required>
                             <p style="color: red; margin: 0;">*</p>
                             <label class="labelgre py-2" style="top: 35px; font-size:10.2px;">* Debe contener mayúsculas, minúsculas, números y caracteres especiales</label>
                             <br><br>
                         </div>
                         <div class="col-lg-6 order-3 order-lg-2 py-2" style="display: flex">
                            <select autocomplete="new-password" class="form-control btnBorder" name="channel" id="channelinv" onchange="showselect()" required>
                                <option value="">CANAL DE COMPRA</option>
                                <option value="1" >SUCURSAL</option>
                                <option value="2">CAT</option>
                                <option value="3">TIENDA EN LINEA</option>
                            </select>
                            <p style="color: red; margin: 0;">*</p>
                        </div>
                         <div class="col-lg-6 order-2 order-lg-3 py-2" style="display: flex">
                             <input type="password" class="form-control" placeholder="CONFIRMAR CONTRASEÑA" name="confirmPassword" id="confirmPassword" required>
                             <p style="color: red; margin: 0;">*</p>
                         </div>
                        <div class="col-lg-6 order-4 order-lg-4 py-2" style="display: none" id="showbranch">
                            <select class="form-control btnBorder"  id="branch_idinv" name="branch_id">
                                <option value="">SUCURSAL DE COMPRA</option>
                                @if(isset($branches))
                                    @foreach ($branches as $branch) 
                                      @if ( $branch->id != 0 and $branch->id != 2 and $branch->id != 24 and $branch->id != 45 and $branch->id != 47)
                                         <option value="{{$branch->id}}">{{$branch->name}}</option>                                     
                                      @endif 
                                    @endforeach
                                @endif
                            </select>
                            <p style="color: red; margin: 0;">*</p>
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
                         <input type="submit" class="btn btn" 
                         style="background-color: #00A1E3;color: white;"
                         id="btnSend" onclick="focusrfc('rfcInv')" value="Enviar">
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
        /* this for mechanic */
    let length       = 0;
    let hostName     = window.location.origin+"/send_sms_verification/";
    let mobileInputinv  = document.querySelector('#mobileInv');
    let inputCodeMecinv = document.querySelector('#codeinv');
    let alertCodeinv    = document.querySelector('#alertSuccessCodeinv');
    let requiredCodeinv = document.querySelector('#requiredSignalinv');
    let codeConfirminv  = document.querySelector('#codeConfirminv');

    window.addEventListener("load", function(){
        length = mobileInputinv.value.length;
        if ( length < 10 ) return null;

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            console.log(this.response)
            if (this.readyState == 4 && this.status == 200) {
                codeConfirminv.value = this.response;
            }
        };

        let url = hostName+mobileInputinv.value;
        xhttp.open("GET", url, true);
        xhttp.send();

        alertCodeinv.hidden    = false;
        requiredCodeinv.hidden = false;
        setTimeout(() =>{alertCodeinv.hidden = true},3500);
        inputCodeMecinv.type = 'text';
        
    });

     /* this for invitation */
    let mobileInputinvn  = document.querySelector('#mobileInv');
    let inputCodeMecinvn = document.querySelector('#codeinv');
    let alertCodeinvn    = document.querySelector('#alertSuccessCodeinv');
    let requiredCodeinvn = document.querySelector('#requiredSignalinv');
    let codeConfirminvn  = document.querySelector('#codeConfirminv');

    mobileInputinvn.addEventListener('input', function (){
        length = mobileInputinvn.value.length;
        if ( length < 10 ) return null;

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            console.log(this.response)
            if (this.readyState == 4 && this.status == 200) {
                codeConfirminvn.value = this.response;
            }
        };

        let url = hostName+mobileInputinvn.value;
        xhttp.open("GET", url, true);
        xhttp.send();

        alertCodeinvn.hidden    = false;
        requiredCodeinvn.hidden = false;
        setTimeout(() =>{alertCodeinvn.hidden = true},3500);
        inputCodeMecinvn.type = 'text';
        
    }); 

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
