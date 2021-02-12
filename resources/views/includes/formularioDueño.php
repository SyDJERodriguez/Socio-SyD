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
                <div class="col-lg-7 pt-2 pb-5">
                    <h2>Registro Dueño de negocio</h2>
                    <div class="line1" style="height: 2px;width: 380px;background-color: black;"></div>
                    <div class="line1 float-right " style="height: 2px;width: 60px;background-color: black;  transform: rotate(33deg);;margin-top: 14.3px;"></div>
                </div>
            </div>
            <form>
                <div class="row">
                    <div class="col-lg-6 py-4">
                        <input type="text" class="form-control" placeholder="NÚMERO DE CLIENTE" id="client_number_pro">
                    </div>
                    <div class="col-lg-6 py-4">
                        <input type="text" class="form-control" placeholder="NOMBRE" id="namePro">
                    </div>
                    <div class="col-lg-6 py-4">
                        <input type="text" class="form-control" placeholder="PRIMER APELLIDO" id="lastNamePro">
                    </div>
                    <div class="col-lg-6 py-4">
                        <input type="text" class="form-control" placeholder="SEGUNDO APELLIDO" id="secondLastNamePro">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 py-2">
                        <input type="text" class="form-control" placeholder="RAZON SOCIAL" id="companyPro">
                    </div>
                    <div class="col-lg-6 py-2">
                        <label for="" class="labelgre">FECHA DE NACIMIENTO</label>
                        <input class="form-control" type="date" id="start" name="trip-start" value="<?php echo date('Y-m-d');?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 py-3">
                        <input type="text" class="form-control" placeholder="NO. TELEFÓNICO 10 DIG" id="mobilePro">
                    </div>
                    <div class="col-lg-6 py-3">
                        <input type="email" class="form-control" placeholder="CORREO ELECTRONICO" id="emailPro">
                    </div>
                </div>
                <div class="row ">
                    <div class="col-lg-6 py-3">
                        <select class="form-control">
                            <option>R.F.C.</option>
                        </select>
                    </div>
                    <div class="col-lg-6 py-3">
                        <input type="text" class="form-control" placeholder="CONTRASEÑA">
                    </div>
                </div>
                <div class="row ">
                    <div class="col-lg-6 py-3">
                        <select class="form-control">
                            <option>TIPO DE NEGOCIO</option>
                            <option>Refaccionaria</option>
                            <option>Mayorista</option>
                            <option>Taller</option>
                            <option>Otro</option>
                        </select>
                    </div>
                    <div class="col-lg-6 py-3">
                        <input type="text" class="form-control" placeholder="CONFIRMAR CONTRASEÑA">
                    </div>
                </div>
            </form>
          </div>
          <div class="modal-footer border-top-0">
            <div class="form-check form-check-inline text-right">
                <label class="form-check-label pr-2" for="inlineCheckbox1"  style="color: grey;font-size: 12px;"><strong>ACEPTAR</strong><br>
                  AVISO DE PRIVACIDAD
                  <br>
                  TÉRMINOS Y CONDICIONES</label>
                <input class="form-check-input " style="width: 30px;height: 30px;" type="checkbox" id="inlineCheckbox1" value="option1">
              </div>
              <button type="button" class="btn btn" style="background-color: #00A1E3;color: white;">Enviar</button>
          </div>
        </div>
      </div>
    </div>
