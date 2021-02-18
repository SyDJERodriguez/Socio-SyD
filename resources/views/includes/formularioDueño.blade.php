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
                    <div class="line1" style="height: 2px;width: 447px;background-color: black;"></div>
                    <div class="line1 float-right " style="height: 2px;width: 60px;background-color: black;  transform: rotate(33deg);;margin-top: 14.3px;"></div>
                </div>
            </div>

              <div class="alert alert-danger" id="form_alert" role="alert" style="border-radius: 6px;" hidden>
              </div>

            <form id="ownerForm" method="POST" action="{{route('customer.update')}}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-lg-6 py-4">
                        <input type="text" class="form-control" placeholder="NÚMERO DE CLIENTE" id="client_number_pro" name="client_number" required pattern="[01234567889]{8}">
                    </div>
                    <div class="col-lg-6 py-4">
                        <input type="text" class="form-control" placeholder="NOMBRE" id="namePro" name="name" required>
                    </div>
                    <div class="col-lg-6 py-4">
                        <input type="text" class="form-control" placeholder="PRIMER APELLIDO" id="lastNamePro" name="last_name" required>
                    </div>
                    <div class="col-lg-6 py-4">
                        <input type="text" class="form-control" placeholder="SEGUNDO APELLIDO" id="secondLastNamePro" name="second_last_name" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 py-2" id="company">
                        <input type="text" class="form-control" placeholder="RAZON SOCIAL" id="companyPro" name="company" required>
                    </div>
                    <div class="col-lg-6 py-2">
                        <label for="birthday" class="labelgre">FECHA DE NACIMIENTO</label>
                        <input class="form-control" type="date" id="birthday" name="birthday" value="<?php echo date('Y-m-d');?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 py-3">
                        <input type="tel" class="form-control" placeholder="NO. TELEFÓNICO 10 DIG" id="mobilePro" name="mobile" required pattern="[01234567889]{10}">
                    </div>
                    <div class="col-lg-6 py-3">
                        <input type="email" class="form-control" placeholder="CORREO ELECTRONICO" id="emailPro" name="email" required pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}">
                    </div>
                </div>
                <div class="row ">
                    <div class="col-lg-6 py-3">
                        <input type="text" class="form-control" placeholder="R.F.C" id="rfc" name="rfc" required>
                    </div>
                    <div class="col-lg-6 py-3">
                        <input type="password" class="form-control" placeholder="CONTRASEÑA" name="password" id="password" required>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-lg-6 py-3">
                        <select class="form-control" name="work" required>
                            <option>TIPO DE NEGOCIO</option>
                            <option>Refaccionaria</option>
                            <option>Mayorista</option>
                            <option>Taller</option>
                            <option>Otro</option>
                        </select>
                    </div>
                    <div class="col-lg-6 py-3">
                        <input type="password" class="form-control" name="confirmPassword" placeholder="CONFIRMAR CONTRASEÑA" id="confirmPassword" required>
                    </div>

                    <input type="hidden" id="confirmPassword" name="client_type" value="1">
                </div>
                <div class="modal-footer border-top-0">
                    <div class="form-check form-check-inline text-right">
                        <label class="form-check-label pr-2" for="inlineCheckbox1"  style="color: grey;font-size: 12px;"><strong>ACEPTAR</strong><br>
                            AVISO DE PRIVACIDAD
                            <br>
                            TÉRMINOS Y CONDICIONES</label>
                        <input class="form-check-input " style="width: 30px;height: 30px;" type="checkbox" id="inlineCheckbox1" value="option1" required>
                    </div>
                    <input type="submit" class="btn btn" style="background-color: #00A1E3;color: white;" id="btnSend" value="Enviar">
                </div>
            </form>
          </div>

        </div>
      </div>
    </div>
