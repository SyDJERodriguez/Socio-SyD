<div class="col-lg-12">
    <hr style="height:2px; margin-left: 10px;margin-right: 10px ">
</div>
<div class="col-lg-3 benefits_sb" style="margin-left: 10px">
    <h6 style="font-size: 18px">Hola EDUARDO Martínez Pozos</h6>
    <p style="font-size: 18px">No. de Cliente <span style="color: #009CE0;"> {{Auth::user()->client_number}}</span></p>
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
            <a href="{{route('customer.benefits.signature')}}" class="<?php if($active === 3 ){echo 'active_sb';}?>"><span>- Firma electrónica</span></a>
        </div>
    </div>
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
    <span style="color: grey;font-size: 20px;"><strong>
                    SOLICITAR ASISTENCIA

                    <i class="fas fa-phone-alt" style="font-size: 30px;vertical-align: top;"></i></strong>
                <hr style="margin: 0; border: 1px solid grey;width: 60%;" />
                <br />
            </span>
    <button class="btn btn-lg text-white px-5" style="background-color: #143153;width: 100%;" type="button"
            data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false"
            aria-controls="collapseExample">
        <b> RED DE DESCUENTOS<i class="fas fa-caret-down pl-2"></i></b>
    </button>
    <p></p>
    <div class="collapse" id="collapseExample3">
        <div class="card card-body border-0 text-center p-5">


        </div>

    </div>
    <button class="btn"
            style="color: #143153;border:8px solid #009CE0;border-radius: 10px;width: 100%;font-size: 20px;"><b>TUVE
            UN ACCIDENTE</b> </button>

</div>
