<!-- Modal ALTA EMPLEADO -->
<div class="modal fade" id="modalSignUpEmployee" tabindex="-1" role="dialog" aria-labelledby="modalSignUpEmployee" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex flex-row-reverse">
                <span class="times" data-dismiss="modal" aria-label="Close">X</span>
            </div>
            <div class="modal-body">
                <h5 class="text-uppercase">ALTA EMPLEADO</h5>
                <img src="{{asset('img/line.png')}}" alt="line">
                <br>
                <br>
                <form method="POST" action="{{route('customer.addAssociate')}}">
                    @method("PUT")
                    @csrf
                    <input type="hidden" name="client_number" value="{{Auth::user()->client_number}}">
                    <input type="hidden" name="customer_id" value="{{Auth::user()->id}}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <input class="form-control-sm form-control" type="text"
                                        name="name"       
                                        placeholder="NOMBRE(S)"
                                        pattern="[A-Za-z].{3,}"
                                        required maxlength="30">

                            </div>
                            <div class="col-6">
                                <input class="form-control-sm form-control" type="text"
                                        name="last_name"       
                                        placeholder="APELLIDO PATERNO"
                                        pattern="[A-Za-z].{3,}"
                                        required maxlength="30">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <input class="form-control-sm form-control" type="text"
                                        name="second_last_name"
                                        placeholder="APELLIDO MATERNO"
                                        pattern="[A-Za-z].{3,}"
                                        required  maxlength="30">
                            </div>
                            <div class="col-6">
                                <input class="form-control-sm form-control" type="text"
                                        name="mobile_number"
                                        placeholder="NO. TELEFÓNICO 10 DIG"
                                        pattern="[0-9]{10}"
                                        required  maxlength="10">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <label class="text-muted sml p-0 m-0">FECHA DE NACIMIENTO</label><br>
                            </div>
                            <div class="col-6">
                                <input class="form-control-sm form-control" 
                                        type="email"
                                        name="email"
                                        placeholder="CORREO ELECTRÓNICO"
                                        required>

                            </div>
                            <div class="col-6">
                                <div>
                                    <div>
                                        <input class="form-control-sm form-control" type="date"
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
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info">ACEPTAR</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>