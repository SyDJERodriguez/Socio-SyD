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
                    <h2>Registro Mecanico </h2>
                    <div class="line1" style="height: 2px;width: 380px;background-color: black;"></div>
                    <div class="line1 float-right " style="height: 2px;width: 60px;background-color: black;  transform: rotate(33deg);;margin-top: 14.3px;"></div>
                </div>
            </div>
            <form id="mechanicForm" method="POST" action="{{route('customer.update')}}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-lg-6 py-4">
                        <input type="text" class="form-control" placeholder="Número de cliente" id="client_number_mec" name="client_number">
                    </div>
                    <div class="col-lg-6 py-4">
                        <input type="text" class="form-control" placeholder="Nombre" id="nameMec" name="name">
                    </div>
                    <div class="col-lg-6 py-4">
                        <input type="text" class="form-control" placeholder="Primer apellido" id="lastNameMec" name="last_name">
                    </div>
                    <div class="col-lg-6 py-4">
                        <input type="text" class="form-control" placeholder="Segundo apellido" id="secondLastNameMec" name="second_last_name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 py-2">
                        <input type="text" class="form-control" placeholder="Telefono" id="mobileMec" name="mobile">
                    </div>
                    <div class="col-lg-6 py-2">
                        <label for="" class="labelgre">FECHA DE NACIMIENTO</label>
                        <input class="form-control" type="date" id="birthday" name="birthday" value="<?php echo date('Y-m-d');?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 py-3">
                        <input type="email" class="form-control" placeholder="correo electrónico" id="emailMec" name="email">
                    </div>
                </div>
                <div class="row ">
                    <div class="col-lg-6 py-3">
                        <input type="text" class="form-control" placeholder="contraseña" name="password">
                    </div>
                    <div class="col-lg-6 py-3">
                        <input type="text" class="form-control" placeholder="CONFIRMAR contraseña" id="confirmPassword">
                    </div>
                </div>
                <input type="hidden" id="confirmPassword" name="client_type" value="2">
                <div class="modal-footer border-top-0">
                    <div class="form-check form-check-inline text-right">
                        <label class="form-check-label pr-2" for="inlineCheckbox1"  style="color: grey;font-size: 12px;"><strong>ACEPTAR</strong><br>
                            AVISO DE PRIVACIDAD
                            <br>
                            TÉRMINOS Y CONDICIONES</label>
                        <input class="form-check-input " style="width: 30px;height: 30px;" type="checkbox" id="inlineCheckbox1" value="option1">
                    </div>
                    <input type="submit" class="btn btn" style="background-color: #00A1E3;color: white;" id="btnSend" value="Enviar">
                </div>
            </form>
          </div>

        </div>
      </div>
    </div>
