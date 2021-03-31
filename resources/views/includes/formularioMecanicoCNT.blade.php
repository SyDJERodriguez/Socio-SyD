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
            <form id="cntForm" method="POST" action="{{route('cnt.register')}}">
                @csrf
                <div class="row">
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control" placeholder="NÚMERO CNT"
                               id="cnt_number" name="cnt_number" maxlength="4" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control" placeholder="NÚMERO DE CLIENTE" 
                        id="client_number_cnt" name="client_number" pattern="[0-9]{8}" maxlength="8">
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control nameInput" placeholder="NOMBRE" id="nameCNT"
                        name="name" pattern="[a-zA-Z]{3,}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control nameInput" placeholder="PRIMER APELLIDO" 
                        id="lastNameCNT" name="last_name" pattern="[a-zA-Z]{3,}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control nameInput" placeholder="SEGUNDO APELLIDO" 
                        id="secondLastNameCNT" name="second_last_name" pattern="[a-zA-Z]{3,}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" id="mobile" style="display: flex">
                        <input type="text" class="form-control mobileInput" placeholder="NO. TELEFÓNICO 10 DIG"
                               id="mobileCNT" name="mobile" maxlength="10" pattern="[0-9]{10}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 py-2" style="display: flex">
                        <label for="" class="labelgre py-1">FECHA DE NACIMIENTO</label>
                        <input class="form-control" type="date" id="birthdayCNT"
                            name="birthday" value="<?php echo date('Y-m-d');?>" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-3">
                        <select class="form-control" name="gender" required id="genderCNT">
                            <option>GÉNERO</option>
                            <option value="F">FEMENINO</option>
                            <option value="M">MASCULINO</option>
                        </select>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-6 py-3" style="display: flex">
                        <input type="email" class="form-control" placeholder="CORREO ELECTRÓNICO" id="emailCNT" name="email" required>
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
      </div>
    </div>
