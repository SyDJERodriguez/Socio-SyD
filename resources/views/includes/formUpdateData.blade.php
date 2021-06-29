<div class="modal fade rounded-0" id="modalUpdateData" tabindex="-1" role="dialog" aria-labelledby="modalUpdateData" aria-hidden="true">
    <div class="modal-dialog modal-lg rounded-0" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-header border-0 rounded-0" style="background-color: #143153;;">
          <h5 class="modal-title" id="modalUpdateData"></h5>
          <div class="modal-header d-flex flex-row-reverse">
            <span class="times" data-dismiss="modal" aria-label="Close">X</span>
        </div>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-lg-8 pt-2 pb-5">
                  <h2>ACTUALIZA TUS DATOS</h2>
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
            <div class="alert alert-danger" id="form_alert_pass_UDF" role="alert" style="border-radius: 6px;" hidden>
            </div>
            <div class="alert alert-danger" id="form_alert_phone_text_UDF" role="alert" style="border-radius: 6px;" hidden>
            </div>

          @if (isset($data))
              <form autocomplete="off" id="updateDataForm" method="POST" action="{{route('customer.updateData')}}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-lg-12 py-2" style="display: flex;">
                        <h6 style="padding-left: 1px">Datos personales</h6>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder mobileInput" placeholder="NÚMERO DE CLIENTE" id="client_number"
                        name="client_number" maxlength="8" required pattern="[0-9]{8}"
                        value="{{substr($data->client_number,2)}}" readonly>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder nameInput" placeholder="NOMBRE" id="nameUp" name="name"
                        value="{{$data->name}}" pattern="[a-zA-Z ]{2,}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder nameInput" placeholder="PRIMER APELLIDO" id="lastNameUp" name="last_name"
                        value="{{$data->last_name}}" pattern="[a-zA-Z ]{2,}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex"> 
                        <input type="text" class="form-control btnBorder nameInput" placeholder="SEGUNDO APELLIDO" id="secondLastNameUp" name="second_last_name"
                        value="{{$data->second_last_name}}" pattern="[a-zA-Z ]{2,}" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                </div>
                <div class="row">
                
                </div>
                <div class="row">
                    <div class="col-lg-6 py-3" style="display: flex">
                        <label for="birthdayUp" class="labelgre py-2" style="top: -10px;padding-left: 4px">Fecha de Nacimiento</label>
                        <input class="form-control btnBorder" type="date" id="birthdayUp" name="birthday" value="<?php echo $data->birthday;?>" required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-3" style="display: flex">
                        <select class="form-control btnBorder" name="gender" required>
                            <option value="" disabled hidden>GÉNERO</option>
                            <option value="F" {{(($data->gender) == 'F' ? 'selected' : '')}}>FEMENINO</option>
                            <option value="M" {{(($data->gender) == 'M' ? 'selected' : '')}}>MASCULINO</option>
                        </select>
                        <p style="color: red; margin: 0;visibility:hidden">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div style="border: 1px solid black" class="input-group-text">+52</div>
                            </div>
                            <input type="text" class="form-control btnBorder mobileInput" placeholder="NO. TELEFÓNICO 10 DIG"
                            id="mobilePro" name="mobile" maxlength="10" pattern="[0-9]{10}" value="{{$data->mobile_number}}" required>
                            <div class="input-group-append" id="form_alert_phone_UDF" hidden>
                            </div>
                        </div>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input autocomplete="new-password" type="email" class="form-control btnBorder" placeholder="CORREO ELECTRONICO"
                        id="emailPro" name="email"
                        value="{{$data->email}}"
                        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" readonly>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                </div>
            
                <div class="row ">
                      <div class="col-lg-6 py-2" style="display: flex">
                          <input type="text" class="form-control btnBorder" placeholder="R.F.C" id="rfcUp" name="rfc"
                          value="{{$data->rfc}}" maxlength="10" required>
                          <p style="color: red; margin: 0;">*</p>
                      </div>
                      <div class="col-lg-6 py-2" style="display: flex">
                          <input autocomplete="new-password" type="password" class="form-control btnBorder" placeholder="CONTRASEÑA" name="password" id="password">
                          <p style="color: red; margin: 0;">*</p>
                      </div>
                      <div class="col-lg-6 offset-lg-6 py-2" style="display: flex">
                          <input type="password" class="form-control btnBorder" name="confirmPassword" placeholder="CONFIRMAR CONTRASEÑA" id="confirmPassword">
                          <p style="color: red; margin: 0;">*</p>
                      </div>
                  
                  
                    <input type="hidden" id="client_type" name="client_type" value="{{Auth::user()->client_type}}">
                </div>
            
                @if ((int)Auth::user()->client_type == 1)
                <div class="row">
                    <div class="col-lg-12 py-2" style="display: flex">
                        <h6 style="padding-left: 1px">Razón social</h6>
                    </div>
                    <div class="col-lg-6 py-2" id="company" style="display: flex">
                        <input type="text" class="form-control btnBorder" placeholder="RAZÓN SOCIAL" id="companyPro" name="company"
                        value="{{$data->company}}"
                        required>
                        <p style="color: red; margin: 0;">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <select class="form-control btnBorder" name="work" required>
                            <option value="" disabled hidden>TIPO DE NEGOCIO</option>
                            <option value="1" {{(($data->work) == '1' ? 'selected' : '')}} >TALLER GENERAL</option>
                            <option value="2" {{(($data->work) == '2' ? 'selected' : '')}} >TALLER SUSPENSIONISTA</option>
                            <option value="3" {{(($data->work) == '3' ? 'selected' : '')}} >MECANICO INDEPENDIENTE</option>
                            <option value="4" {{(($data->work) == '4' ? 'selected' : '')}} >REFACCIONARIA</option>
                            <option value="5" {{(($data->work) == '5' ? 'selected' : '')}} >MAYORISTA</option>
                            <option value="6" {{(($data->work) == '6' ? 'selected' : '')}} >OTRO</option>
                        </select>
                        <p style="color: red; margin: 0;visibility:hidden">*</p>
                    </div>
                    <div class="col-lg-6 py-2" style="display: flex">
                        <input type="text" class="form-control btnBorder" placeholder="R.F.C EMPRESA" id="RFC_Company" name="RFC_Company"
                        value="{{(($data->RFC_Company) !== null ? $data->RFC_Company : '')}}">
                        <p style="color: red; margin: 0;visibility:hidden">*</p>
                    </div>
                </div>
                @endif
            
                <div class="modal-footer border-top-0">
                    <input type="submit" class="btn btn" style="background-color: #00A1E3;color: white;" id="btnSend3" value="Enviar">
                </div>
            </form>
          @endif
        </div>

      </div>
    </div>
  </div>
<script>
  document.getElementById('rfcUp').addEventListener('focus',function() {
      var rfc = document.getElementById('rfcUp');
      var fecha = $('#birthdayUp').val().split('-');

      var CURP = [];
      CURP[0] = $("#lastNameUp").val().charAt(0).toUpperCase();
      for (let i = 1; i < $("#lastNameUp").val().length; i++) {
          if($("#lastNameUp").val().charAt(i).match(/[aeiou]/gi)){
              CURP[1] = $("#lastNameUp").val().charAt(i).toUpperCase();
              break;
          }
      }
      CURP[2] = $("#secondLastNameUp").val().charAt(0).toUpperCase();
      CURP[3] = $("#nameUp").val().charAt(0).toUpperCase();
      CURP[4] = fecha[0].slice(2);//year
      CURP[5] = fecha[1];//mont
      CURP[6] = fecha[2];//day

      $('#rfcUp').val(CURP.join("").toString());

  })
</script>
