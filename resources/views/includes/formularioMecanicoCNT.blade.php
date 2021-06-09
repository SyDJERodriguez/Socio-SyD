<div class="modal fade rounded-0" id="modalCNT" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <h2>REGISTRO MECÁNICO CNT</h2>
                    <div class="line1">
                        <img src="{{asset('img/line2.png')}}" alt="">
                    </div>
                </div>
            </div>
          <div class="alert alert-danger" id="form_alert_cnt_email" role="alert" style="border-radius: 6px;" hidden>
          </div>
              <div class="alert alert-danger" id="form_alert_cnt_pass" role="alert" style="border-radius: 6px;" hidden>
              </div>
              <div class="alert alert-danger" id="form_alert_cnt_mobile" role="alert" style="border-radius: 6px;" hidden>
              </div>
              <div class="alert alert-danger" id="form_alert_cnt_ncnt" role="alert" style="border-radius: 6px;" hidden>
              </div>
            <form autocomplete="off" id="cntForm" method="POST" action="{{route('cnt.register')}}">
                @csrf
                <div class="row">
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control mobileInput" placeholder="NÚMERO CNT"
                               id="cnt_number" name="cnt_number" maxlength="4" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control mobileInput" placeholder="NÚMERO DE CLIENTE" 
                        id="client_number_cnt" name="client_number" pattern="[0-9]{8}" maxlength="8">
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control nameInput" placeholder="NOMBRE" id="nameCNT"
                        name="name" pattern="[a-zA-Z ]" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control nameInput" placeholder="PRIMER APELLIDO" 
                        id="lastNameCNT" name="last_name" pattern="[a-zA-Z ]" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control nameInput" placeholder="SEGUNDO APELLIDO" 
                        id="secondLastNameCNT" name="second_last_name" pattern="[a-zA-Z ]" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" id="mobile" style="display: flex">
                        <input type="text" class="form-control mobileInput" placeholder="NO. TELEFÓNICO 10 DIG"
                               id="mobileCNT" name="mobile" maxlength="10" pattern="[0-9]{10}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 py-3" style="display: flex">
                        <label for="genderCNT" class="labelgre py-2" style="top: -10px;padding-left: 4px">Fecha de Nacimiento</label>
                        <input class="form-control btnBorder" type="date" id="birthdayCNT"
                            name="birthday" value="<?php echo date('Y-m-d');?>" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-3" style="display: flex">
                        <select class="form-control btnBorder" name="gender" required id="genderCNT">
                            <option>GÉNERO</option>
                            <option value="F">FEMENINO</option>
                            <option value="M">MASCULINO</option>
                        </select>
                        <p style="color: red; margin: 0;visibility:hidden">*</p>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-6 py-2" style="display: flex">
                        <input autocomplete="new-password" type="email" class="form-control btnBorder" placeholder="CORREO ELECTRÓNICO" 
                        id="emailCNT" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input autocomplete="new-password" type="password" class="form-control" placeholder="CONTRASEÑA" name="password" id="password" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control" placeholder="R.F.C" id="rfcCNT" name="rfc" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="password" class="form-control" placeholder="CONFIRMAR CONTRASEÑA" name="confirmPassword" id="confirmPassword" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                </div>
                <input type="hidden" id="client_type" name="client_type" value="2">

                 {{-- Modal ¿Olvidaste tu numero cliente --}}
                 <div class="col-lg-12 py-2" style="display: flex;padding-left: 0px;">
                    <p>
                        <a href="#" data-toggle="modal" data-target="#modalForgotNum">
                            ¿Olvidaste tu número de cliente?</a>
                    </p>
                </div>
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
      </div>
    </div>
    <script>
        document.getElementById('rfcCNT').addEventListener('focus',function() {
            console.log("hola");
            var rfc = document.getElementById('rfcCNT');
            var fecha = $('#birthdayCNT').val().split('-');
    
            var CURP = [];
            CURP[0] = $("#lastNameCNT").val().charAt(0).toUpperCase();
            for (let i = 1; i < $("#lastNameCNT").val().length; i++) {
                if($("#lastNameCNT").val().charAt(i).match(/[aeiou]/gi)){
                    CURP[1] = $("#lastNameCNT").val().charAt(i).toUpperCase();
                    break;    
                }
            }
            CURP[2] = $("#secondLastNameCNT").val().charAt(0).toUpperCase();
            CURP[3] = $("#nameCNT").val().charAt(0).toUpperCase();
            CURP[4] = fecha[0].slice(2);//year
            CURP[5] = fecha[1];//mont
            CURP[6] = fecha[2];//day
    
            $('#rfcCNT').val(CURP.join("").toString());
            
        })
    </script>
