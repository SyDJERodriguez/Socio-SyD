<div class="modal fade rounded-0" id="modal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <div class="col-lg-8 pt-2 pb-5">
                    <h2>REGISTRO DUEÑO DE NEGOCIO</h2>
                    <div class="line1">
                        <img src="{{asset('img/line2.png')}}" alt="">
                    </div>
                </div>
            </div>

              <div class="alert alert-danger alert-dismissible" id="form_alert" role="alert" style="border-radius: 6px;" hidden>
              </div>
              <div class="alert alert-danger" id="form_alert_email" role="alert" style="border-radius: 6px;" hidden>
              </div>
              <div class="alert alert-danger" id="form_alert_mobile" role="alert" style="border-radius: 6px;" hidden>
              </div>
              <div class="alert alert-danger" id="form_alert_pass_pro" role="alert" style="border-radius: 6px;" hidden>
              </div>
              <div class="alert alert-danger" id="form_alert_phone_text" role="alert" style="border-radius: 6px;" hidden>
              </div>
              <div class="alert alert-danger" id="form_alert_dns" role="alert" style="border-radius: 6px;" hidden>
              </div>

            <form autocomplete="off" id="ownerForm" method="POST" action="{{route('customer.update')}}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-lg-12 py-2" style="display: flex;">
                        <h6 style="padding-left: 1px">Datos personales</h6>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder mobileInput" placeholder="NÚMERO DE CLIENTE" id="client_number_pro"
                        name="client_number" maxlength="8" required pattern="[0-9]{8}">
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder nameInput" placeholder="NOMBRE" id="namePro"
                        name="name" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder nameInput" placeholder="PRIMER APELLIDO" id="lastNamePro"
                        name="last_name" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder nameInput" placeholder="SEGUNDO APELLIDO" id="secondLastNamePro"
                        name="second_last_name" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                </div>
                <div class="row">

                </div>
                <div class="row">
                    <div class="col-lg-6 py-3" style="display: flex">
                        <label for="birthday" class="labelgre py-2" style="top: -10px;padding-left: 4px">Fecha de Nacimiento</label>
                        <input class="form-control btnBorder" type="date" id="birthday" name="birthday" value="<?php echo date('Y-m-d');?>" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-3" style="display: flex">
                        <select class="form-control btnBorder" name="gender" required>
                            <option selected="true" disabled="true" value="">GÉNERO</option>
                            <option value="F">FEMENINO</option>
                            <option value="M">MASCULINO</option>
                        </select>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div style="border: 1px solid black" class="input-group-text">+52</div>
                            </div>
                            <input type="tel" class="form-control btnBorder mobileInput" placeholder="TELEFÓNO CELULAR 10 DIG" id="mobilePro"
                                   name="mobile" maxlength="10" pattern="[0-9]{10}" required style="border-radius: 0 .25rem .25rem 0">
                            <div class="input-group-append" id="form_alert_phone" hidden>
                            </div>
                        </div>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input autocomplete="new-password" type="email" class="form-control btnBorder" placeholder="CORREO ELECTRONICO"
                        id="emailPro" name="email" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9._%+-]+@[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9.-]+\.[a-zA-ZñÑ]{2,}$" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                </div>

                <div class="row ">
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder" placeholder="R.F.C" id="rfc" name="rfc">
                        <p style="color: red; margin: 0;visibility:hidden">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input autocomplete="new-password" type="password" class="form-control btnBorder" placeholder="CONTRASEÑA" name="password" id="password" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 offset-lg-6 py-2" style="display: flex">
                        <input type="password" class="form-control btnBorder" name="confirmPassword" placeholder="CONFIRMAR CONTRASEÑA" id="confirmPassword" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>

                    <input type="hidden" id="client_type" name="client_type" value="1">
                </div>

                <div class="row">
                    <div class="col-lg-12 py-2" style="display: flex">
                        <h6 style="padding-left: 1px">Razón social</h6>
                    </div>
                    <div class="col-lg-6 py-2" id="company" style="display: flex">
                        <input type="text" class="form-control btnBorder" placeholder="RAZÓN SOCIAL" id="companyPro" name="company">
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
                        <input type="text" class="form-control btnBorder" placeholder="R.F.C EMPRESA" id="RFC_Company" name="RFC_Company">
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
                    id="btnSend" onclick="focusrfc('rfc')" value="Enviar">
                </div>
            </form>
          </div>

        </div>
      </div>
    </div>
<script>
    document.getElementById('rfc').addEventListener('focus',function() {
        var rfc = document.getElementById('rfc');
        var fecha = $('#birthday').val().split('-');

        var CURP = [];
        CURP[0] = $("#lastNamePro").val().charAt(0).toUpperCase();
        for (let i = 1; i < $("#lastNamePro").val().length; i++) {
            if($("#lastNamePro").val().charAt(i).match(/[aeiou]/gi)){
                CURP[1] = $("#lastNamePro").val().charAt(i).toUpperCase();
                break;
            }
        }
        CURP[2] = $("#secondLastNamePro").val().charAt(0).toUpperCase();
        CURP[3] = $("#namePro").val().charAt(0).toUpperCase();
        CURP[4] = fecha[0].slice(2);//year
        CURP[5] = fecha[1];//mont
        CURP[6] = fecha[2];//day

        $('#rfc').val(CURP.join("").toString());

    })
</script>
