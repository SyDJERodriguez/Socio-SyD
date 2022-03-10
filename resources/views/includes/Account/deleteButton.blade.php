{{-- <div class="row">
    <div class="col-lg-12 py-2 float-right">
            <a href="#" class="btn btn-outline-dark btn-sm float-right" style="background-color: #bfbfbf"
               data-toggle="modal" data-target="#modalDelete">ELIMINAR MI CUENTA</a>
    </div>
</div> --}}

<!-- Modal DEACTIVATE-->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDelete"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 500px;">
        <div class="modal-content border-0 rounded-0" style="background:transparent">
            <div class="modal-header" style="height: 35px; background-color: #fff !important;">
                <button type="button" class="close"
                        style="margin: 0rem 0rem -1rem auto;padding: 0.1rem 1rem 0.5rem;background-color: #00A5E6;"
                        data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body blue-dark">
                <div>
                    <div>
                        <h5 class="text-white"><b>¿Estás seguro que quieres eliminar tu cuenta?</b></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9 py-2 text-center">
                        <img src="{{asset('img/logo.png')}}" alt="logo" width="50%"></div>
                    <div class="col-lg-3 py2 text-center">
                        <a href="#" class="text-white btn btn bg-primary btn-sm my-2" 
                           style="padding-left: 40px;padding-right: 40px;"
                           data-toggle="modal" data-target="#modalConfirmDelete" data-dismiss="modal">
                            SI
                        </a>
                        <br>
                        <input type="button" class="btn btn-light btn-sm" value="NO" data-dismiss="modal"
                               style="padding-left: 35px;padding-right: 35px;background-color: white;color: #00A5E6;">
                        <form method="POST" action="{{route('customer.deactivate')}}" id="deleteForm"
                              style="display: none;">
                            @method("PUT")
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL CONFIRM DEACTIVATE ACCOUNT --}}
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDelete"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 500px;">
        <div class="modal-content border-0 rounded-0" style="background:transparent">
            <div class="modal-header" style="height: 35px; background-color: #fff !important;">
                <button type="button" class="close"
                        style="margin: 0rem 0rem -1rem auto;padding: 0.1rem 1rem 0.5rem;background-color: #00A5E6;"
                        data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body blue-dark">
                <div class="col-lg-12 py-2 text-center">
                    <img src="{{asset('img/logo.png')}}" alt="logo" width="50%"></div>
                <div>
                    <h5 class="text-white"><b>Al hacer click en aceptar, confirmas:<br>
                        que estas de acuerdo en que perderás los beneficios de Seguro de Accidentes Personales 
                        y Servicios de Asistencias</b></h5>
                </div>
                <div class="row">
                
                    <div class="col-lg-12 text-center">
                        <a href="#" class="text-white btn btn bg-primary btn-sm my-2"
                           style=""  data-toggle="modal" data-target="#modalform" data-dismiss="modal">
                            ACEPTAR
                        </a>
                        <br>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Modal form-->
<div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-labelledby="modalform"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 500px;">
        <div class="modal-content border-0 rounded-0" style="background:transparent">
            <div class="modal-header" style="height: 35px; background-color: #fff !important;">
                <button type="button" class="close"
                        style="margin: 0rem 0rem -1rem auto;padding: 0.1rem 1rem 0.5rem;background-color: #00A5E6;"
                        data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body blue-dark">
                <div class="col-lg-12 py-2 text-center">
                    <img src="{{asset('img/logo.png')}}" alt="logo" width="50%"></div>
                <div>
                    <h5 class="text-white"><b>Tu cuenta será eliminada pero antes de que te vayas nos gustaría conocer porqué te das de baja:</b></h5>
                </div>
                <div class="row" style="color: white">
                    <form class="container" method="POST" action="{{route('customer.deactivate')}}" id="deleteForm">
                        @method('POST')
                        @csrf
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="Nunca me inscribí a Socio SyD" id="radio1" name="grupo1">
                            <label class="form-check-label" for="radio1">
                                Nunca me inscribí a Socio SyD
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="No me parecen atractivos los beneficios" id="radio2" name="grupo1">
                            <label class="form-check-label" for="radio2">
                                No me parecen atractivos los beneficios
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="No me interesa el programa" id="radio3" name="grupo1">
                            <label class="form-check-label" for="radio1">
                                No me interesa el programa
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="Recibo demasiada información" id="radio3" name="grupo1">
                            <label class="form-check-label" for="radio1">
                                Recibo demasiada información
                            </label>
                        </div>
                        <div class="form-check">
                                <input class="form-check-input" type="radio" value="1" id="radio5" name="grupo1" onchange="message()" required>
                            <input type="text" placeholder="Otro" id="otro" value="">
                          </div>                          
                    <div class="col-lg-12 text-center">
                       <button type="submit" class="text-white btn btn bg-primary btn-sm my-2"
                       style=""> 
                            ACEPTAR
                      </button> 
                    </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<script>
    function message(){
    let radio = document.querySelector('#radio5');
    let radio5 = radio.value;
    let otro = document.querySelector('#otro');
    let otrotext = canal.value;
    if (radio5==1) {
        otro.required=true;
        radio5.value=otrotext;
    }
</script>
