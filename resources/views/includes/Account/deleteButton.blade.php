<div class="row">
    <div class="col-lg-12 py-2 float-right">
            <a href="#" class="btn btn float-right text-white" style="background-color: #009CE0;"
               data-toggle="modal" data-target="#modalDelete">ELIMINAR MI CUENTA</a>
    </div>
</div>

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
                        <h5 class="text-white"><b>¿ESTÁS SEGURO QUE DESEAS ELIMINAR TU CUENTA?</b></h5>
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
                    <h5 class="text-white"><b>AL CLICK EN ACEPTAR, CONFIRMAS QUE:<br>
                    ESTAS CONSCIENTE DE QUE PERDERAS TUS BENEFICIOS DE SEGURO Y ASISTENCIAS.</b></h5>
                </div>
                <div class="row">
                
                    <div class="col-lg-12 text-center">
                        <a href="#" class="text-white btn btn bg-primary btn-sm my-2"
                        onclick="event.preventDefault();document.getElementById('deleteForm').submit();" 
                           style="">
                            ACEPTAR
                        </a>
                        <br>
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
</div>
