<div class="col-lg-12">
    <hr style="height:2px; margin-left: 10px;margin-right: 10px ">
</div>
<div class="col-lg-3 benefits_sb">
    <div style="padding-left: 10px !important;">

        @include('includes.accountData')

        <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#modalUpdateData"
        style="background-color: #143153;color: #FFF;margin-bottom: 2px">Actualizar datos</a>
        <br>

        @include('includes.opinionButton')

        <p style="font-size: 13px">
            Contacto de SyD®:
              <a href="tel:8007931010">800-SyD-(793)-1010</a>
        </p>
        <hr>
     </div>
    <button class="btn btn-lg text-white btnSideBenefits"
            type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false"
            aria-controls="collapseExample">
            <div class="row">
                <div class="col-10">
                    <span class="textSeguro">
                        <b>SEGURO DE ACCIDENTES PERSONALES</b>
                    </span>
                </div>
                <div class="col-2">
                    <i class="fas fa-caret-down" style="font-size:30px"></i>
                </div>
            </div>
    </button>
<br>
    <div class="collapse show" id="collapseExample">
        <div class="card card-body border-0">
            <a href="{{route('customer.benefits')}}" class="<?php if($active === 1 ){echo 'active_sb';}?>">
                <span style="font-size: 13px">- Coberturas principales del seguro</span></a>
            <a href="{{route('customer.register.beneficiary')}}"
            class="<?php if($active === 2 ){echo 'active_sb';}?>"
            title="Recuerda que las personas dadas de alta en esta sección recibirán los beneficios del seguro en caso de que no estés">
                <span style="font-size: 13px"> - Registra tus beneficiarios <b>AQUÍ</b></span></a>
            <!--<span>- Estudio Socioeconómico</span>
            <span>- Subir documentos</span>-->
            <a href="{{route('customer.benefits.signature')}}"
            title="Tu firma digital se utilizará únicamente para firmar tu certificado."
            class="<?php if($active === 3 ){echo 'active_sb';}?>">
            <span style="font-size: 13px;font-weight: bold">- FIRMA DIGITAL</span></a>
        </div>

        @if (Auth::user()->created_at >= new DateTime("15-08-2021") && Auth::user()->created_at <= new DateTime("30-08-2021"))
            {{-- SPECIAL WEEK --}}
        @else
            @if ($level === 'oro' || $level === 'plata' || $level >0)
            <a href="{{route('customer.myDocuments')}}" class="btn"
                    style="color: #143153;border:8px solid #009CE0;border-radius: 10px;
                    width: 100%;font-size: 20px;"
                    id="assistanceCall">
                    <b>TUVE UN ACCIDENTE</b> </a>
            <p style="font-size: 13px">
                Atención Chubb: <a href="tel:8007931010">800-SyD-(793)-1010</a>
            </p>
            @endif
        @endif

    </div>

    <br>

    <button class="btn btn-lg text-white btnSideBenefits"
            type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false"
            aria-controls="collapseExample">
            <div class="row">
                <div class="col-10 py-1">
                    <span style="padding-top: 10px" class="textSeguro">
                        <b>ASISTENCIAS ACTIVAS</b>
                    </span>
                </div>
                <div class="col-2">
                    <i class="fas fa-caret-down" style="font-size:30px"></i>
                </div>
            </div>
    </button>

    <div class="collapse show" id="collapseExample2">
        <div class="card card-body border-0">
            <a href="{{route('customer.benefits.assistance')}}"
            class="<?php if($active === 4 ){echo 'active_sb';}?>" style="font-size: 13px">
            <span>- Tipo de Asistencia:

                {{-- SPECIAL WEEK --}}
                @if ( Auth::user()->created_at >= new DateTime("15-08-2021") && Auth::user()->created_at <= new DateTime("30-08-2021") )
                    Ninguna
                @else
                    @if ($level === 'oro' || $level === 3)
                    Oro
                    @elseif($level === 'plata' || $level === 2)
                    Plata
                    @else
                    Ninguna
                    @endif
                @endif

            </span></a>

        </div>

    </div>

    @if (Auth::user()->created_at >= new DateTime("15-08-2021") && Auth::user()->created_at <= new DateTime("30-08-2021"))
        {{-- SPECIAL WEEK --}}
    @else
        @if ($level === 'oro' || $level === 'plata' || $level === 3 || $level === 2)
        <div style="padding-top: 10px">
            <a href="tel:5511052682" style="color: grey;font-size: 17px;">
                <b>SOLICITAR ASISTENCIA</b>
            <i class="fas fa-phone-alt" style="font-size: 20px;vertical-align: top;"></i>
            <br>
            <hr style="margin: 0; border: 1px solid grey;width: 60%;" />
            </a>
            <p style="font-size: 13px">
                Contacto Telasist: <a href="tel:5511052682">551-105-2682</a>
            </p>
        </div>
        @endif
    @endif
    <button class="btn btn-lg text-white btnSideBenefits"
    type="button" ><span style="padding-top: 10px" class="textSeguro">
    <b style="font-size: 13px">BENEFICIOS DEL MES ANTERIOR</b>
    </span>
    </button>
    <div>
     <br>
     <h6>-
    @if ( Auth::user()->created_at >= new DateTime("15-08-2021") && Auth::user()->created_at <= new DateTime("30-08-2021") )
    Ninguna
    @else
    @if ($level_before === 'oro' || $level_before === 3)
    Seguro de accidentes y asistencias oro
    @elseif($level_before === 'plata' || $level_before === 2)
    Seguro de accidentes y asistencias plata
    @elseif($level_before === 'bronce' || $level_before === 1)
    Seguro de accidentes
    @else
    Ninguno
    @endif
    @endif
</h6>
    </div>
<br>
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



