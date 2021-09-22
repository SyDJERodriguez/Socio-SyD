
<div class="container-fluid mt-3 pr-5 pl-5">
    <div class="row inside_nav someimpor optionsAccount"
    style="display: flex; justify-content: center; width: 100%;">
      <div class="col-lg-3 py-1 border-primary separadorBut">
        <a href="{{route('customer.benefits')}}"
            class="btn btn-md boton
            <?php if($active === 1 ){echo 'active';}?>">
            Beneficios obtenidos

        </a>
      </div>
      @if(Auth::user()->client_type === "1" || Auth::user()->client_type === "4")
        <div class="col-lg-3 py-1 border-primary separadorBut">
            <a href="{{route('customer.employees')}}"
                class="btn btn-md boton
                <?php if($active === 2 ){echo 'active';}?>">
                Mis Dependientes
            </a>
        </div>
        @endif
        @if(Auth::user()->client_type !== "3")
            <div class="col-lg-3 py-1 border-primary separadorBut">
                <a href="{{route('customer.myAccount')}}"
                    class="btn btn-md boton
                    <?php if($active === 3 ){echo 'active';}?>">
                    Estado de cuenta
                </a>
            </div>
        @endif
        <div class="col-lg-3 py-1 separadorBut">
            <a href="{{route('customer.myDocuments')}}"
                class="btn btn-md boton
                <?php if($active === 4 ){echo 'active';}?>">
                Mis documentos
            </a>
        </div>
        <!--<div class="col-lg-2 py-2">
            <a href="#" class="btn btn-lg btn-block boton <?php if($active === 5 ){echo 'active';}?>">referir amigos</a>
        </div>-->
    </div>
  </div>

<div class="container-fluid mt-3 pr-5 pl-5">
    <div class="row inside_nav someimpor optionsAccount"
    style="display: flex; justify-content: center; width: 100%;">
    </div>
</div>
<!--<div class="container-fluid mt-1 font-weight-bold" style="font-size: 14px;">
    <div class="row">
        <div class="col-lg-3 text-right pl-5">
            REGISTRO DE BENEFICIARIOS

        </div>
        <div class="col-lg-3 text-center pl-5"> ESTUDIO SOCIOECONÓMICO</div>
        <div class="col-lg-3 text-center pr-5"> SUBIR DOCUMENTOS</div>
        <div class="col-lg-3 text-left pl-5"> FIRMA ELECTRÓNICA</div>
    </div>
</div>-->
</div>
<!-- PROGRESS ARROW
<div class="container-fluid">
    <div class="d-flex justify-content-center mt-1">
        <div class="arrow-steps clearfix">
            <div class="row">
                <div class="col-lg-3 py-2 px-0">
                    <div class="step current"> <span class="float-right"> 25% </div>
                </div>
                <div class="col-lg-3 py-2 px-0">
                    <div class="step"> <span class="float-right">50% </div>
                </div>
                <div class="col-lg-3 py-2 px-0">
                    <div class="step" style="background-color: #009CE0;"> <span class="float-right"> 75% </div>
                </div>
                <div class="col-lg-3 py-2 px-0">
                    <div class="step" style="background-color: #009CE0;"> <span class="float-right">100% </div>
                </div>
            </div>

        </div>
    </div>
</div>

<h6>PROGRESO DE REGISTRO</h6> -->
