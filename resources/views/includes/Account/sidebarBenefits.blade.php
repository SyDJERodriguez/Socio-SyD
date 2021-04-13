<div class="col-lg-12">
    <hr style="height:2px; margin-left: 10px;margin-right: 10px ">
</div>
<div class="col-lg-3 benefits_sb">
    <div style="padding-left: 10px !important;">
        <h6>Hola {{$data->name.' '.$data->last_name.' '.$data->second_last_name}}<br>
           No. de Cliente <span style="color:#009ce0">{{substr(Auth::user()->client_number, 2)}}</span><br>
            @if ((int)Auth::user()->client_type == 1)
                Cuenta: Negocios
            @else
                Cuenta: Individual
            @endif
        </h6>
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#survey" style="color: white;">Nos interesa tu opinión</a>
        <hr>
     </div>
    <br>
    <button class="btn btn-lg text-white" style="background-color: #143153;font-size: 18px;width: 100%;"
            type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false"
            aria-controls="collapseExample">
        <b>SEGURO DE ACCIDENTES PERSONALES<i class="fas fa-caret-down pl-2"></i></b>
    </button>
    <p></p>
    <div class="collapse show" id="collapseExample">
        <div class="card card-body border-0">
            <a href="{{route('customer.benefits')}}" class="<?php if($active === 1 ){echo 'active_sb';}?>"><span>- Coberturas principales del seguro</span></a>
            <a href="{{route('customer.register.beneficiary')}}" class="<?php if($active === 2 ){echo 'active_sb';}?>"><span> - Registro de beneficiarios</span></a>
            <!--<span>- Estudio Socioeconómico</span>
            <span>- Subir documentos</span>-->
            <a href="{{route('customer.benefits.signature')}}" class="<?php if($active === 3 ){echo 'active_sb';}?>"><span>- Firma digital</span></a>
        </div>
        <a href="tel:8000874598" class="btn"
                style="color: #143153;border:8px solid #009CE0;border-radius: 10px;width: 100%;font-size: 20px;"  id="assistanceCall"><b>TUVE
                UN ACCIDENTE</b> </a>
    </div>
    <br>
    <button class="btn btn-lg text-white px-5" style="background-color: #143153;font-size: 20px;width: 100%;"
            type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false"
            aria-controls="collapseExample">
        <b> ASISTENCIAS ACTIVAS<i class="fas fa-caret-down pl-2"></i></b>
    </button>
    <p></p>
    <div class="collapse show" id="collapseExample2">
        <div class="card card-body border-0">
            <a href="{{route('customer.benefits.assistance')}}" class="<?php if($active === 4 ){echo 'active_sb';}?>"><span>- Tipo de asistencia</span></a>

        </div>
    </div>
    <a href="tel:5511052682" style="color: grey;font-size: 20px;"><strong>
                    SOLICITAR ASISTENCIA

                    <i class="fas fa-phone-alt" style="font-size: 30px;vertical-align: top;"></i></strong>
                <hr style="margin: 0; border: 1px solid grey;width: 60%;" />
                <br />
            </a>
    <!--<button class="btn btn-lg text-white px-5" style="background-color: #143153;width: 100%;" type="button"
            data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false"
            aria-controls="collapseExample">
        <b> RED DE DESCUENTOS<i class="fas fa-caret-down pl-2"></i></b>
    </button>
    <p></p>
    <div class="collapse" id="collapseExample3">
        <div class="card card-body border-0 text-center p-5">


        </div>

    </div>-->


</div>
