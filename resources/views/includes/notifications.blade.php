<!-- Modal NOTIFICATIONS-->
<div class="modal fade" id="modalNotifications" tabindex="-1" role="dialog" aria-labelledby="modalNotifications"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="toast-header text-white blue-dark p-0">
                <strong class="mr-auto ml-4">Notificaciones</strong>
                <button type="button" class="ml-2  close text-white p-2" data-dismiss="modal" aria-label="Close"
                    style="background-color:#00A5E6">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                @if (Auth::user())
                        @if ((int)Auth::user()->client_type == 1)
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span class="float-right">
                                    <i style="color: #00A5E6;" class="fas fa-circle"></i></span>
                                    <p class="float-left" style="font-size: 14px;width:95%">
                                    ¡Ya tienes derecho a tu seguro de accidentes personales</p>
                            </li>
                            <li class="list-group-item">
                                <span class="float-right">
                                    <i style="color: #00A5E6;" class="far fa-check"></i></span>
                                    <p class="float-left" style="font-size: 14px;width:95%">
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam </p>
                            </li>
                            <li class="list-group-item">
                                <span class="float-right">
                                    <i style="color: #00A5E6;" class="far fa-check"></i></span>
                                    <p class="float-left" style="font-size: 14px;width:95%">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam </p>
                            </li>
                            <li class="list-group-item">
                                <span class="float-right">
                                    <i style="color: #00A5E6;" class="far fa-check"></i></span>
                                    <p class="float-left" style="font-size: 14px;width:95%">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam </p>
                            </li>
                        </ul>
                    @else

                    @endif
                @endif

            </div>
        </div>
    </div>
</div>
