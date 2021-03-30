<!-- Modal NOTIFICATIONS-->
<div class="modal fade" id="modalNotifications" tabindex="-1" role="dialog" aria-labelledby="modalNotifications"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="toast-header text-white blue-dark p-0">
                <strong class="mr-auto ml-4">Notificaciones</strong>
                
            </div>

            <div class="modal-body">
                @if (Auth::user())
                    @if ((int)Auth::user()->client_type == 1)
                        <ul class="list-group list-group-flush">
                            @if ($total)
                                    @if ($total < 2500.01)
                                        <li class="list-group-item">
                                            <span class="float-right">
                                                <i style="color: #00A5E6;" class="fas fa-circle" hidden></i></span>
                                                <p class="float-left" style="font-size: 14px;width:95%">
                                                Aún no alcanzas el nivel mínimo de lealtad.</p>
                                        </li>
                                    @else
                                        <li class="list-group-item">
                                            <span class="float-right">
                                                <i style="color: #00A5E6;" class="fas fa-circle"></i></span>
                                                <p class="float-left" style="font-size: 14px;width:95%">
                                                    Has alcanzado los beneficios de nivel 
                                                    @if ($total > 2500 && $total <= 4500)
                                                        Bronce
                                                    @elseif($total > 4500 && $total <= 7000)
                                                        Plata
                                                    @elseif($total > 7000)
                                                        Oro
                                                    @endif
                                                     dentro de tu plan de lealtad.
                                                </p>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="float-right">
                                                <i style="color: #00A5E6;" class="far fa-check"></i></span>
                                                <p class="float-left" style="font-size: 14px;width:95%">
                                                ¡Ya tienes derecho a tu seguro de accidentes personales!</p>
                                        </li>
                                    @if ($total > 4500)
                                        <li class="list-group-item">
                                            <span class="float-right">
                                                <i style="color: #00A5E6;" class="far fa-check"></i></span>
                                                <p class="float-left" style="font-size: 14px;width:95%">
                                                Ya eres acreedor a la cobertura de asistencias de nivel
                                                   @if ($total > 4500 && $total <= 7000)
                                                        Plata.
                                                   @elseif($total > 7000)
                                                        Oro.
                                                   @endif
                                                </p>
                                        </li>
                                    @endif

                                @endif
                            @else
                                <li class="list-group-item">
                                    <span class="float-right">
                                        <i style="color: #00A5E6;" class="fas fa-circle" hidden></i></span>
                                        <p class="float-left" style="font-size: 14px;width:95%">
                                        No hay notificaciones disponibles.</p>
                                </li>
                            @endif
                            
                        </ul>
                    @else 
                    {{-- notifications individual account --}}
                        <ul class="list-group list-group-flush">
                            @if ($total < 200.01)
                                <li class="list-group-item">
                                    <span class="float-right">
                                        <i style="color: #00A5E6;" class="fas fa-circle" hidden></i></span>
                                        <p class="float-left" style="font-size: 14px;width:95%">
                                        Aun no alcanzas el nivel minimo de lealtead.</p>
                                </li>
                            @else
                                <li class="list-group-item">
                                    <span class="float-right">
                                        <i style="color: #00A5E6;" class="fas fa-circle"></i></span>
                                        <p class="float-left" style="font-size: 14px;width:95%">
                                        Tu nivel de lealtead actual es: 
                                            @if ($total > 200.02 && $total <= 500)
                                                Bronce
                                            @elseif($total > 500.01 && $total <= 1300)
                                                Plata
                                            @elseif($total > 1300)
                                                Oro
                                            @endif
                                        </p>
                                </li>
                                <li class="list-group-item">
                                    <span class="float-right">
                                        <i style="color: #00A5E6;" class="far fa-check"></i></span>
                                        <p class="float-left" style="font-size: 14px;width:95%">
                                        ¡Ya tienes derecho a tu seguro de accidentes personales!</p>
                                </li>
                                @if ($total > 500)
                                <li class="list-group-item">
                                    <span class="float-right">
                                        <i style="color: #00A5E6;" class="far fa-check"></i></span>
                                        <p class="float-left" style="font-size: 14px;width:95%">
                                        Ya eres acreedor al nivel de asistencia 
                                           @if ($total > 500.01 && $total <= 1300)
                                                Plata
                                           @elseif($total > 1300)
                                                Oro
                                           @endif  
                                        </p>
                                </li>
                                @endif

                            @endif
                        </ul>

                    @endif
                @endif
                    <br>
                    <a class="btn btn-sm btn-block" href="{{route('customer.dismissNotification', Auth::user()->client_number)}}">
                        Aceptar
                    </a>
            </div>
        </div>
    </div>
</div>
