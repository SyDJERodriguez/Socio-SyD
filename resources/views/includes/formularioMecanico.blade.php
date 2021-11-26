<div class="modal fade rounded-0" id="modal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg rounded-0" role="document">
        <div class="modal-content rounded-0">
          <div class="modal-header border-0 rounded-0" style="background-color: #143153;;">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <div class="modal-header d-flex flex-row-reverse">
              <span class="times" data-dismiss="modal" aria-label="Close">X</span>
          </div>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-lg-7 pt-2 pb-5">
                    <h2>CUENTA INDIVIDUAL </h2>
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
            <form autocomplete="off" id="mechanicForm" method="POST" action="{{route('customer.update')}}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder mobileInput" placeholder="NÚMERO DE CLIENTE"
                        id="client_number_mec" name="client_number" pattern="[0-9]{8}" maxlength="8"required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder nameInput" placeholder="NOMBRE" id="nameMec"
                        name="name" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder nameInput" placeholder="PRIMER APELLIDO"
                        id="lastNameMec" name="last_name" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder nameInput" placeholder="SEGUNDO APELLIDO"
                        id="secondLastNameMec" name="second_last_name" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 py-3" id="mobile" style="display: flex; flex-direction: column;">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div style="border: 1px solid black" class="input-group-text">+52</div>
                            </div>
                            <input type="text" class="form-control btnBorder mobileInput" placeholder="TELEFÓNO CELULAR 10 DIG"
                                   id="mobileMec" name="mobile" maxlength="10" pattern="[0-9]{10}" required style="border-radius: 0 .25rem .25rem 0">
                            <div class="input-group-append" id="form_alert_phone_mec" hidden>
                            </div>
                            <p style="color: red; margin: 0;">*</p>
                        </div>
                        <div class="input-group mb-3" style="margin-top: 1rem">
                            <input type="hidden" class="form-control btnBorder" placeholder="CÓDIGO DE VERIFICACIÓN 6 DIG"
                                   id="codeMec" name="verification_code" maxlength="6" pattern="[0-9]{6}" required style="border-radius: .25rem;">
                            <input type="hidden" class="form-control btnBorder" placeholder="CÓDIGO DE VERIFICACIÓN 6 DIG"
                                   id="codeMecConfirm" name="confirm_code" maxlength="6" pattern="[0-9]{6}" required style="border-radius: .25rem;">
                            <p style="color: red; margin: 0;" hidden id="requiredSignal">*</p>
                        </div>
                    </div>
                    <div class="col-lg-6 py-3" style="display: flex">
                        <label for="" class="labelgre py-2" style="top: -10px;padding-left: 4px">Fecha de Nacimiento</label>
                        <input class="form-control btnBorder" type="date" id="birthdayMec"
                            name="birthday" value="<?php echo date('Y-m-d');?>" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input autocomplete="new-password" type="email" class="form-control btnBorder" placeholder="CORREO ELECTRÓNICO"
                        id="emailMec" name="email" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9._%+-]+@[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9.-]+\.[a-zA-ZñÑ]{2,}$" required>
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
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder" placeholder="R.F.C" id="rfcMec" name="rfc">
                        <p style="color: red; margin: 0;visibility: hidden">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input autocomplete="new-password" type="password" class="form-control btnBorder" placeholder="CONTRASEÑA" name="password" id="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[-¡!$%^&*()_+|~=`{}\[\]:@;'<>¿?,.\/]).{8,20}$" title="La contraseña debe tener más de 8 caracteres, una mayúscula, un número y un caracter especial "  required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <select  class="form-control btnBorder" name="channel" id="channelMec" onchange="mostrarMec()" required>
                            <option value="">CANAL DE COMPRA</option>
                            <option value="1" >SUCURSAL</option>
                            <option value="2">CAT</option>
                            <option value="3">TIENDA EN LINEA</option>
                        </select>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="password" class="form-control btnBorder" placeholder="CONFIRMAR CONTRASEÑA" name="confirmPassword" id="confirmPassword" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display:none " id="muestraMec">
                        <select class="form-control btnBorder" id="branch_idMec" name="branch_id">
                            <option value="">SUCURSAL DE COMPRA</option>
                            @if(isset($branches))
                                @foreach ($branches as $branch) 
                                    @if ( $branch->id != 0 and $branch->id != 2 and $branch->id != 24 and $branch->id != 45 and $branch->id != 47 )
                                        <option value="{{$branch->id}}">{{$branch->name}}</option>                                     
                                    @endif 
                                @endforeach
                            @endif
                            
                        </select>
                        <p style="color: red; margin: 0;">*</p>
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
                    id="btnSend"
                    onclick="focusrfc('rfcMec')";
                    value="Enviar">
                </div>
            </form>
          </div>

        </div>
      </div>
    </div>

    <script>
        document.getElementById('rfcMec').addEventListener('focus',function() {
            var rfc = document.getElementById('rfc');
            var fecha = $('#birthdayMec').val().split('-');

            var CURP = [];
            CURP[0] = $("#lastNameMec").val().charAt(0).toUpperCase();
            for (let i = 1; i < $("#lastNameMec").val().length; i++) {
                if($("#lastNameMec").val().charAt(i).match(/[aeiou]/gi)){
                    CURP[1] = $("#lastNameMec").val().charAt(i).toUpperCase();
                    break;
                }
            }
            CURP[2] = $("#secondLastNameMec").val().charAt(0).toUpperCase();
            CURP[3] = $("#nameMec").val().charAt(0).toUpperCase();
            CURP[4] = fecha[0].slice(2);//year
            CURP[5] = fecha[1];//mont
            CURP[6] = fecha[2];//day

            $('#rfcMec').val(CURP.join("").toString());

        })
    </script>
