<div class="modal fade rounded-0" id="modalCadenas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg rounded-0" role="document">
        <div class="modal-content rounded-0">
          <div class="modal-header border-0 rounded-0" style="background-color: #143153;">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <div class="modal-header d-flex flex-row-reverse">
              <span class="times" data-dismiss="modal" aria-label="Close">X</span>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-lg-8 pt-2 pb-5">
                    <h2>REGISTRO CADENAS</h2>
                    <div class="line1">
                        <img src="{{asset('img/line2.png')}}" alt="">
                    </div>
                </div>
            </div>


            <form autocomplete="off" id="cadenasForm" method="POST" action="{{route('customer.updateCadena')}}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-lg-12 py-2" style="display: flex;">
                        <h6 style="padding-left: 1px">Datos personales</h6>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder mobileInput" placeholder="NÚMERO DE CLIENTE" id="clientNumberBr"
                        name="client_number" maxlength="8" required pattern="[0-9]{8}">
                        <p style="color: red; margin: 0;">*</p>
                    </div>

                    <input type="hidden" id="isBranch" name="is_branch" value="1">

                    <div class="col-lg-6 py-2" style="display: flex">
                        <select class="form-control btnBorder" id="branch_name" name="branch_number" required>
                            <option disabled selected value="">SUCURSAL</option>
                        </select>
                        <p style="color: red; margin: 0;visibility:hidden">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder nameInput" placeholder="NOMBRE" id="nameBr"
                        name="name" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder nameInput" placeholder="PRIMER APELLIDO" id="lastNameBr"
                        name="last_name" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder nameInput" placeholder="SEGUNDO APELLIDO" id="secondLastNameBr"
                        name="second_last_name" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <select class="form-control btnBorder" name="gender" required>
                            <option selected="true" disabled="true" value="">GÉNERO</option>
                            <option value="F">FEMENINO</option>
                            <option value="M">MASCULINO</option>
                        </select>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                </div>
                <div class="row">

                </div>
                <div class="row">
                    <div class="col-lg-6 py-3" style="display: flex">
                        <label for="birthday" class="labelgre py-2" style="top: -10px;padding-left: 4px">Fecha de Nacimiento</label>
                        <input class="form-control btnBorder" type="date" id="birthdayBr" name="birthday" value="<?php echo date('Y-m-d');?>" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-3" style="display: flex">
                        <input autocomplete="new-password" type="email" class="form-control btnBorder" placeholder="CORREO ELECTRONICO"
                        id="emailBr" name="email" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9._%+-]+@[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9.-]+\.[a-zA-ZñÑ]{2,}$" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex; flex-direction: column;">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div style="border: 1px solid black" class="input-group-text">+52</div>
                            </div>
                            <input type="tel" class="form-control btnBorder mobileInput" placeholder="TELEFÓNO CELULAR 10 DIG" id="mobileBr"
                                   name="mobile" maxlength="10" pattern="[0-9]{10}" required style="border-radius: 0 .25rem .25rem 0">
                            <div class="input-group-append" id="form_alert_phone_br" hidden>
                            </div>
                            <p style="color: red; margin: 0;">*</p>
                        </div>

                        <div class="input-group mb-3" style="margin-top: 1rem">
                            <input type="hidden" class="form-control btnBorder" placeholder="CÓDIGO DE VERIFICACIÓN 6 DIG"
                                   id="codeBr" name="verification_code" maxlength="6" pattern="[0-9]{6}" required style="border-radius: .25rem;">
                            <input type="hidden" class="form-control btnBorder" placeholder="CÓDIGO DE VERIFICACIÓN 6 DIG"
                                   id="codeBrConfirm" name="confirm_code" maxlength="6" pattern="[0-9]{6}" required style="border-radius: .25rem;">
                            <p style="color: red; margin: 0;" hidden id="requiredSignalBr">*</p>
                        </div>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input autocomplete="new-password" type="password" class="form-control btnBorder" placeholder="CONTRASEÑA" name="password" id="passwordBr" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[-¡!$%^&*()_+|~=`{}\[\]:@;'<>¿?,.\/]).{8,20}$" title="La contraseña debe tener más de 8 caracteres, una mayúscula, un número y un caracter especial " required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                </div>

                <div class="row ">
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder" placeholder="R.F.C" id="rfcBr" name="rfc">
                        <p style="color: red; margin: 0;visibility: hidden">*</p>
                    </div>

                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="password" class="form-control btnBorder" name="confirmPassword" placeholder="CONFIRMAR CONTRASEÑA" id="confirmPasswordBr" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>

                    <div class="col-lg-6 py-2" style="display: flex">
                        <select autocomplete="new-password" class="form-control btnBorder" name="canal" id="canalBr" onchange="mostrarBr()" required>
                            <option selected>CANAL DE COMPRA</option>
                            <option value="1" >SUCURSAL</option>
                            <option value="2">CAT</option>
                            <option value="3">TIENDA EN LINEA</option>
                        </select>
                        <p style="color: red; margin: 0;">*</p>
                    </div>

                    <div class="col-lg-6 py-2" style="display: none" id="muestraBr">
                        <select class="form-control btnBorder"  id="branch_idBr" name="branch_id" required>
                            <option selected>SUCURSAL DE COMPRA</option>
                            @if(isset($branches))
                                @foreach ($branches as $branch) 
                                  <option value="{{$branch->id}}">{{$branch->name}}</option>
                                @endforeach
                            @endif
                        </select>
                        <p style="color: red; margin: 0;">*</p>
                    </div>

                    <input type="hidden" id="client_type" name="client_type" value="4">
                </div>

                <div class="row">
                    <div class="col-lg-12 py-2" style="display: flex">
                        <h6 style="padding-left: 1px">Razón social</h6>
                    </div>
                    <div class="col-lg-6 py-2" id="company" style="display: flex">
                        <input type="text" class="form-control btnBorder" placeholder="RAZÓN SOCIAL" id="companyBr" name="company" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <select class="form-control btnBorder" name="work" required>
                            <option>TIPO DE NEGOCIO</option>
                            <option value="1">TALLER GENERAL</option>
                            <option value="2">TALLER SUSPENSIONISTA</option>
                            <option value="3">MECANICO INDEPENDIENTE</option>
                            <option value="4">REFACCIONARIA</option>
                            <option value="5">MAYORISTA</option>
                            <option value="6">OTRO</option>
                        </select>
                        <p style="color: red; margin: 0;visibility:hidden">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder" placeholder="R.F.C EMPRESA" id="RFC_CompanyBr" name="RFC_Company">
                        <p style="color: red; margin: 0;visibility:hidden">*</p>
                    </div>

                    {{-- Modal ¿Olvidaste tu numero cliente --}}
                    <div class="col-lg-12 py-2" style="display: flex; flex-direction: column;">
                        <div style="display: flex;">
                            <p style="color: red; margin: 0;">*&nbsp;</p>
                            <p>Obligatorio llenar</p>
                        </div>
                        <p style="padding-left: 1px">
                            <a href="#" data-toggle="modal" data-target="#modalForgotNum">
                                ¿Olvidaste tu número de cliente?</a>
                        </p>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <div class="form-check form-check-inline text-right">
                        <label class="form-check-label pr-2" for="inlineCheckbox1"  style="color: grey;font-size: 12px;"><strong>ACEPTAR</strong><br>
                            <a href="#" data-toggle="modal" data-target="#modalAviso">
                                AVISO DE PRIVACIDAD</a>
                                <br>
                                <a href="#" data-toggle="modal" data-target="#modalGeneralTerms">TÉRMINOS Y CONDICIONES</a></label>
                                <input class="form-check-input " style="width: 30px;height: 30px;" type="checkbox" id="inlineCheckbox1" value="option1" required>
                            </div>
                            <input type="submit" class="btn btn"
                            style="background-color: #00A1E3;color: white;"
                            id="btnSend4" onclick="focusrfc('rfcBr')" value="Enviar">
                        </div>
                    </form>
                    <div class="alert alert-danger alert-dismissible" id="form_alert_br" role="alert" style="border-radius: 6px;" hidden>
                    </div>
                    <div class="alert alert-danger" id="form_alert_email_br" role="alert" style="border-radius: 6px;" hidden>
                    </div>
                    <div class="alert alert-danger" id="form_alert_mobile_br" role="alert" style="border-radius: 6px;" hidden>
                    </div>
                    <div class="alert alert-danger" id="form_alert_pass_br" role="alert" style="border-radius: 6px;" hidden>
                    </div>
                    <div class="alert alert-danger" id="form_alert_phone_text_br" role="alert" style="border-radius: 6px;" hidden>
                    </div>
                    <div class="alert alert-danger" id="form_alert_dns_br" role="alert" style="border-radius: 6px;" hidden>
                    </div>
              <div class="alert alert-success" id="alertSuccessCodeBr" role="alert" style="border-radius: 6px;" hidden>
                  <button type="button" class="close alertClose" aria-hidden="true" >&times;</button>
                  <p style="margin-bottom: 0;">Se ha enviado un código de verificación al telefóno celular indicado</p>
              </div>
              <div class="alert alert-danger" id="error_code_br" role="alert" style="border-radius: 6px;" hidden>
              </div>
                </div>

            </div>
        </div>
    </div>
<script>
    document.getElementById('rfcBr').addEventListener('focus',function() {
        var rfc = document.getElementById('rfcBr');
        var fecha = $('#birthdayBr').val().split('-');

        var CURP = [];
        CURP[0] = $("#lastNameBr").val().charAt(0).toUpperCase();
        for (let i = 1; i < $("#lastNameBr").val().length; i++) {
            if($("#lastNameBr").val().charAt(i).match(/[aeiou]/gi)){
                CURP[1] = $("#lastNameBr").val().charAt(i).toUpperCase();
                break;
            }
        }
        CURP[2] = $("#secondLastNameBr").val().charAt(0).toUpperCase();
        CURP[3] = $("#nameBr").val().charAt(0).toUpperCase();
        CURP[4] = fecha[0].slice(2);//year
        CURP[5] = fecha[1];//mont
        CURP[6] = fecha[2];//day

        $('#rfcBr').val(CURP.join("").toString());

    })
</script>
