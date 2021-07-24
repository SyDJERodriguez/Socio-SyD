<!-- Modal ALTA EMPLEADO -->
<div class="modal fade" id="modalSignUpEmployee" tabindex="-1" role="dialog" aria-labelledby="modalSignUpEmployee" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex flex-row-reverse">
                <span class="times" data-dismiss="modal" aria-label="Close">X</span>
            </div>
            <div class="modal-body">
                <h5 class="text-uppercase" id="title">ALTA EMPLEADO</h5>
                <div class="line1">
                    <img src="{{asset('img/line2.png')}}" alt="">
                </div>
                <br>
                <div class="alert alert-danger" id="form_alert_phone_text_AEF" role="alert" style="border-radius: 6px;" hidden>
                </div>
                <div class="alert alert-danger" id="form_alert_dns_AEF" role="alert" style="border-radius: 6px;" hidden>
                </div>
                <br>
                <form autocomplete="off" id="addEmployeeForm" method="POST" action="{{route('customer.addEmployee')}}">
                    @method("PUT")
                    @csrf
                    <input type="hidden" name="client_number" value="{{Auth::user()->client_number}}">
                    <input type="hidden" name="customer_id" value="{{$data->id}}">
                    <input type="hidden" name="nameClient" value="{{$data->name}}">
                    <input type="hidden" name="lastNameClient" value="{{$data->last_name}}">
                    <input type="hidden" name="branch_number" value="{{ isset($data->branch_number) ? $data->branch_number : null }}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <input class="form-control-sm form-control nameInput" type="text"
                                        name="name"
                                        placeholder="NOMBRE(S)"
                                        pattern="[a-zA-Z\s]*"
                                        required maxlength="30">

                            </div>
                            <div class="col-6">
                                <input class="form-control-sm form-control nameInput" type="text"
                                        name="last_name"
                                        placeholder="APELLIDO PATERNO"
                                        pattern="[a-zA-Z\s]*"
                                        required maxlength="30">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <input class="form-control-sm form-control nameInput" type="text"
                                        name="second_last_name"
                                        placeholder="APELLIDO MATERNO"
                                        pattern="[a-zA-Z\s]*"
                                        required  maxlength="30">
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <div style="border: 1px solid black" class="input-group-text">+52</div>
                                    </div>
                                    <input type="text" class="form-control-sm form-control btnBorder mobileInput" 
                                    placeholder="NO. TELEFÓNICO 10 DIG"
                                    name="mobile_number" 
                                    maxlength="10" 
                                    pattern="[0-9]{10}" 
                                    required>
                                    <div class="input-group-append" id="form_alert_phone_AEF" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <label class="text-muted sml p-0 m-0">FECHA DE NACIMIENTO</label><br>
                            </div>
                            <div class="col-6">
                                <input class="form-control-sm form-control btnBorder"
                                        type="email"
                                        autocomplete="new-password"
                                        name="email"
                                        placeholder="CORREO ELECTRÓNICO"
                                        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                                        required>

                            </div>
                            <div class="col-6">
                                <div>
                                    <div>
                                        <input class="form-control-sm form-control btnBorder" type="date"
                                                name="bday"
                                                placeholder="FECHA DE NACIMIENTO"
                                                required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-8 text-right">
                                <p style="font-size:12px" class="primary-color">
                                    *Sino visualizas el correo en tu bandeja de entrada, revisa en correos no deseados
                                </p>
                            </div>
                            <div class="col-3">
                                <button type="submit" id="btnSend2" class="btn btn-info">ACEPTAR</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
