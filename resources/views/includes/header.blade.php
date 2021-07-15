<a href="https://api.whatsapp.com/send?phone=8007931010&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20SocioSyD®" target="_blank"
    class="whatsapp">
    <img src="{{asset('img/whatsIcon.png')}}" style="width: 30% !important;" alt="">
</a>
<a href="#oneSection" class="upButton">
    <img src="{{asset('img/goUp.png')}}" width="30%">
</a>

<div class="container-fluid" id="oneSection">
    <!--header-->
    <div class="row ml-0 header " id="header">
        <div class="col-lg-4 p-3 pl-4" id="main-logo" >

            <div id="backHeader">
                <img src="{{asset('img/headerBack.png')}}" alt=""
                style="position: absolute;z-index:1; height: 110px; left: 0px;top: 0px;">
                <img src="{{asset('img/logo.png')}}" width="300px" alt="logo"
                class="logoHeader">
            </div>

        </div>
        <div class="col-lg-7 pl-6 pt-1 formLogin" >
            @if(session()->has('error'))
            <p class="error" style="position: absolute;">
                {{ session()->get('error') }}
            </p>
            @endif
                @if(session()->has('deactivate'))
                    <p class="error" style="position: absolute;">
                        Su cuenta se encuentra desactivada. Haz <a href="#" data-toggle="modal" data-target="#modalActivate">clic aquí</a> para activarla
                    </p>
                @endif

                @if(session()->has('register'))
                    <p class="error" style="position: absolute;">
                        El email no se encuentra registrado dentro de nuestra plataforma.
                    </p>
                @endif
            @guest
            <form id="login-form" method="POST" action="{{ route('customer.login') }}">
                @csrf
                <div class="form-row align-items-center">
                    <div class="col-lg-6 my-2" style="padding-top:4px">
                        <input type="text" class="form-control border-input" id="inlineFormInputName"
                            placeholder="CORREO" name="email" required style="margin-top: 7px; border-color: black">
                            <div class="row" style="margin-top: 3px">
                                <div class="col-sm-7 " style="display: flex;">
                                    <p class="primary-color"
                                    style="margin-bottom: 0; font-size:13px;text-align:center;padding-top:5px">
                                        <b id="lblNoAccount" class="noDown">¿No tienes una cuenta?</b>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <a href="#" data-toggle="modal" data-target="#modalClientType" class="btn adios"
                                    style="background-color: #00a5e6;color:white;font-size: 11px; width: 100px;">
                                    ¡REGÍSTRATE!
                                    </a>
                                </div>
                            </div>

                    </div>
                    <div class="col-lg-4 my-2" style="padding-top:6px">
                        <input type="password" class="form-control border-input" id="inlineFormInputGroupUsername"
                            placeholder="CONTRASEÑA" name="password" required style="border-color: black">
                        <div class="row " style="margin-top: 5px">
                            <div class="col-sm-10">
                                <a href="#"
                                style="margin-bottom: 0; font-size:13px;text-align:center;padding-top:5px"
                                class="primary-color" data-toggle="modal" data-target="#modal4">
                                    <b class="noDown">¿Olvidaste tu contraseña?</b>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="modal" data-target="" class="btn btn-sm p-0 adios"
                                style="background-color: #143153;color:white;font-size: 11px; width: 70px;visibility:hidden">
                                {{-- boton no visibile --}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2" id="buttonLogin" style="margin-top: -23px !important;">
                        <button type="submit" id="login-button" class="btn btn"
                            style="background-color: #143153;color:white; width: 150px">
                            INICIAR SESIÓN
                        </button>
                    </div>


                </div>

            </form>
            @else
            <div style="display: flex; justify-content: flex-end;">
                <div class="form-row align-items-center">
                    <div class="col-sm-5 my-1"></div>
                    <div class="col-sm-5 my-1"></div>
                </div>
                <div class="col-sm-2 my-3">
                    <a href="#" class="btn btn px-2" style="background-color: #143153;color:white; width: 160px"
                        data-toggle="modal" data-target="#modalLogOut">CERRAR SESIÓN</a>
                </div>


            </div>

            @endguest
        </div>

    </div>

    <!-- Modal LOGOUT-->
    <div class="modal fade" id="modalLogOut" tabindex="-1" role="dialog" aria-labelledby="modalLogOut"
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
                            <h5 class="text-white"><b>¿Estás seguro que deseas salir?</b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-9 py-2 text-center">
                            <img src="{{asset('img/logo.png')}}" alt="logo" width="50%"></div>
                        <div class="col-lg-3 py2 text-center">
                            <a href="#" class="text-white btn btn bg-primary btn-sm my-2" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                style="padding-left: 40px;padding-right: 40px;">SI</a><br>
                            <input type="button" class="btn btn-light btn-sm" value="NO" data-dismiss="modal"
                                style="padding-left: 35px;padding-right: 35px;background-color: white;color: #00A5E6;">
                            <form id="logout-form" action="{{ route('customer.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal CLIENT TYPE-->
    <div class="modal fade" id="modalClientType" tabindex="-1" role="dialog" aria-labelledby="modalClientType"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="container ">
                    <div class="row mt-4 mx-2">
                        <div class="col-10">
                            <span class="md2-heading" style="color: #143153;"><b>TIPO DE CLIENTE</b></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modal3"
                                    style="width: 270px">DUEÑO DE NEGOCIO</button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modal5"
                                    style="width: 270px;">MECÁNICO INDEPENDIENTE</button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                            <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modalCadenas"
                                    style="width: 270px;">CADENAS</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!--menu-->
<nav class="navbar navbar-expand-lg navbar blue-dark top-bar" id="oneSection" style="padding-top: 14px;
padding-bottom: 14px;">
    <a class="navbar-brand" href="#">
        <img class="logo-menu" src="{{asset('img/logo.png')}}" width="120px" alt="">
    </a>

    <div class="form-inline my-lg-0">
        @if(!empty(Auth::user()))
        <div class="navbar-toggler">
            <div class="btn-group">
                <button id="bell1" class="btn" data-toggle="modal" data-target="#modalNotifications">
                    @if(isset($noti))
                        @if ($noti != false)
                            @if ($noti->available == 1 && $noti->seen == 0)
                            <span class="badge badge-danger mr-1 rounded-circle" style="font-size:10px;">
                                1
                            </span>
                            @endif
                        @endif
                    @endif
                    <i class="far fa-bell" style="color: white; font-size: 22px;"> </i>
                </button>
            </div>
        </div>
        @endif
        <div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarLogin"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-user" style="color: white; font-size: 18px;"></i>
            </button>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars text-white"></i>
        </button>
    </div>

    {{-- navbar login --}}
    <div class="collapse navbar-collapse" id="navbarLogin">
        <div class="col-lg-7 pl-6 pt-1" id="formLogin2"  >
            @if(session()->has('error'))
            <p class="error2">
                {{ session()->get('error') }}
            </p>
            @endif
                @if(session()->has('deactivate'))
                    <p class="error2">
                        Su cuenta se encuentra desactivada. Haz <a href="#" data-toggle="modal" data-target="#modalActivate">clic aquí</a> para activarla
                    </p>
                @endif

                @if(session()->has('register'))
                    <p class="error2">
                        El email no se encuentra registrado dentro de nuestra plataforma.
                    </p>
                @endif
            @guest
            <form id="login-form" method="POST" action="{{ route('customer.login') }}">
                @csrf
                <div class="form-row align-items-center">
                    <div class="col-sm-12 my-1">
                        <input type="text" class="form-control border-input" id="inlineFormInputName"
                            placeholder="CORREO" name="email" required>
                        <div class="col-sm-12" style="display: flex; justify-content: space-between; align-items: flex-end;">
                            <p class="text-white pr-3" style="margin-bottom: 7px; margin-left: -15px">
                                <b>¿No tienes una cuenta?</b>
                            </p>
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#modal3"
                                style="color:white;font-size: 14px;">
                                ¡REGÍSTRATE!
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-12 my-1">
                        <input type="password" class="form-control border-input" id="inlineFormInputGroupUsername"
                            placeholder="CONTRASEÑA" name="password" required>
                        <div class="col-sm-12" style="display: flex; justify-content: center; align-items: flex-end;">
                            <a href="#" class="text-white" data-toggle="modal" data-target="#modal4">
                                <b>¿Olvidaste tu contraseña?</b>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-12" id="buttonLogin">
                        <button type="submit" class="btn btn-sm btn-block"
                        style="background-color: #3cb3e7;color:white">
                            INICIAR SESIÓN
                        </button>

                    </div>

                </div>
            </form>
            @else
            <div >
                <div class="col-lg-12 my-2">
                    <a href="#" class="btn btn-sm btn-block"
                    style="background-color: #3cb3e7;color:white"
                        data-toggle="modal" data-target="#modalLogOut">CERRAR SESIÓN</a>
                </div>
            </div>
            @endguest
        </div>
    </div>

    {{-- navbar collapse --}}
    <div class="collapse navbar-collapse" id="navbarNav">

      <ul class="navbar-nav" id="main-menu">
        <!--<li class="nav-item">
                <a class="nav-link active" href="#">¿QUÉ ES? <span class="sr-only">(current)</span></a>
            </li>-->
            <li class="nav-item">
                @if(!Auth::check())
                    <a class="navItemHeader" href="#section2" onclick="irAbajo()">¿CÓMO FUNCIONA?</a>
                @endif
                @if(Auth::check())
                    <a class="navItemHeader" style="width:165px" href="{{route('customer.home')}}/#section2">¿CÓMO FUNCIONA?</a>
                @endif

            </li>
            <li class="nav-item">
                @if(!Auth::check())
                    <a class="navItemHeader" href="#section3">TIPO DE CUENTA</a>
                @endif
                @if(Auth::check())
                    <a class="navItemHeader" style="width:165px" href="{{route('customer.home')}}/#section3">TIPO DE CUENTA</a>
                @endif

            </li>
            <li class="nav-item">
                @if(!Auth::check())
                    <a class="navItemHeader" href="#section4">BENEFICIOS</a>
                @endif
                @if(Auth::check())
                    <a class="navItemHeader" style="width:165px" href="{{route('customer.home')}}/#section4">BENEFICIOS</a>
                @endif
            </li>
            <!--<li class="nav-item">
                <a class="nav-link" href="#section5">TESTIMONIALES</a>
            </li>-->
            <li class="nav-item">
                @if(!Auth::check())
                    <a class="navItemHeader" href="#section6">¿DÓNDE COMPRAR?</a>
                @endif
                @if(Auth::check())
                    <a class="navItemHeader" style="width:165px" href="{{route('customer.home')}}/#section6">¿DÓNDE COMPRAR?</a>
                @endif
            </li>

          <li class="nav-item">
              @if(Auth::check())
                  @if(Auth::user()->client_type !== '3')
                    <a class="navItemHeader" style="width:165px" href="{{route('customer.myAccount')}}">MI CUENTA</a>
                  @else
                      <a class="navItemHeader" style="width:165px" href="{{route('customer.benefits')}}">MI CUENTA</a>
                  @endif
              @endif
          </li>
      </ul>

      @if(!empty(Auth::user()))
        <div class="bell2">
            <div class="btn-group" >
                <button class="btn" data-toggle="modal" data-target="#modalNotifications">
                    @if ($noti != false)
                        @if ($noti->available == 1 && $noti->seen == 0)
                        <span class="badge badge-danger mr-1 rounded-circle" style="font-size:10px;">
                            1
                        </span>
                        @endif
                    @endif
                    <i class="far fa-bell" style="color: white; font-size: 22px;"> </i>
                </button>
            </div>
        </div>
        @endif

    </div>
  </nav>

<!-- Modal formulario dueño de negocio-->
@include('includes.formularioDueño')

<!-- Modal formulario Mecanico-->
@include('includes.formularioMecanico')

<!-- Modal formulario Mecanico-->
@include('includes.formularioMecanicoCNT')

<!--Modal formulario Canales -->
@include('includes.formularioCanales')

@if(Auth::check())
{{-- Modal notifications --}}
@include('includes.notifications')

{{-- Modal update datos --}}
@include('includes.formUpdateData')
@endif

@if (\Session::has('exito'))
    <!-- Modal UPDATE SUCCESS-->
    <div class="modal fade" id="modalUpdateSuccess" tabindex="-1" role="dialog" aria-labelledby="modalUpdateSuccess" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 rounded-0">
                <div style="height: 34px;">
                    <button type="button" class="close" style="padding: 0.1rem 1rem 0.5rem;background-color: #00A5E6;"  data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body " style="background-color: #143153;">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <p class="text-white" id="clientName">
                                {{strtoupper($data->name).' '.strtoupper($data->last_name).' '.strtoupper($data->second_last_name)}}
                            </p>
                            <p class="text-white" id="clientNumber">No. de cliente {{substr($data->client_number,2)}}</p>
                            <img src="{{asset('img/icon_check.png')}}">
                            <p class="text-white" id="clientMessage"></p>
                            <h5 class="text-white" style="font-size: 34px">TUS DATOS SE ACTUALIZARON CORRECTAMENTE</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(function() {
        $('#modalUpdateSuccess').modal('show');
    });
    </script>
@endif

@if (\Session::has('forgot'))
    <!-- Modal client number modal remember-->
    <div class="modal fade" id="modalClientNumber" tabindex="-1" role="dialog" aria-labelledby="modalClientNumber" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 rounded-0">
                <div style="height: 34px;">
                    <button type="button" class="close" style="padding: 0.1rem 1rem 0.5rem;background-color: #00A5E6;"  data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body " style="background-color: #143153;border: 1px solid black;">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h5 class="text-white">ESTE ES TU NÚMERO DE CLIENTE</h5>
                            <h5 class="text-white btn btn-lg" 
                            style="background-color: #143153; border: 3px solid #00A5E6;">
                            {{ substr(Session::get('forgot'),2) }}
                            </h5>
                            <br>
                            <p class="text-white" id="clientMessage" style="font-size: 12px">
                                Consérvalo y tenlo siempre disponible <br>
                                Este número es personal e intransferible
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('#modalClientNumber').modal('show');
        });
        </script>
@endif

@if (\Session::has('msg'))
            {{-- Modal algo salio mal (msg) --}}
            <div class="modal fade" id="modalErrorUpdate" tabindex="-1" role="dialog" aria-labelledby="modalErrorUpdate" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content border-0 rounded-0">
                        <div style="height: 34px;">
                            <button type="button" class="close" style="padding: 0.1rem 1rem 0.5rem;background-color: #00A5E6;" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="text-white">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body " style="background-color: #143153;">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <p><i class="fas fa-times" style="font-size: 28px;color: #00A1E3"></i></p>
                                    <h5 class="text-white">NO SE ACTUALIZARON LOS DATOS</h5>
                                    <p class="text-white">{{Session::get('msg')}}</p>
                                    <a href="#" data-dismiss="modal" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;">
                                        ACEPTAR
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(function() {
                    $('#modalErrorUpdate').modal('show');
                });
                </script>
@endif