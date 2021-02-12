<a href="#" class="whatsapp"><img src="{{asset('img/1x/wht.png')}}" alt=""></a>

<div class="container-fluid">
    <!--header-->
    <div class="row header ml-0">
        <div class="col-lg-3 p-2 pl-4">
            <img src="{{asset('img/logo.png')}}" width="250px" alt="">
        </div>
        <div class="col-lg-7 pl-6 pt-1">
            <form id="login-form" method="POST" action="{{ route('customer.login') }}">
                @csrf
                <div class="form-row align-items-center">
                    <div class="col-sm-5 my-1">
                        <input type="text" class="form-control border-input" id="inlineFormInputName" placeholder="CORREO" name="email">
                        <div class="col-sm-12" style="display: flex; justify-content: center; align-items: flex-end;">
                            <p class="primary-color pr-3" style="margin-bottom: 0"><b>¿No tienes una cuenta?</b></p>
                            <a href="#" data-toggle="modal" data-target="#modalClientType" class="btn btn p-0" style="background-color: #143153;color:white;font-size: 12px; width: 90px;">¡REGÍSTRATE!</a>
                        </div>
                    </div>
                    <div class="col-sm-5 my-1">
                        <input type="text" class="form-control border-input" id="inlineFormInputGroupUsername" placeholder="CONTRASEÑA" name="password">
                        <div class="col-sm-12" style="display: flex; justify-content: center; align-items: flex-end;">
                            <a href="#" class="primary-color" data-toggle="modal" data-target="#modal4"><b>¿Olvidaste tu contraseña?</b></a>
                        </div>
                    </div>

                    <div class="col-sm-2 my-1">
                        <button type="submit" class="btn btn px-2" style="background-color: #143153;color:white; width: 200px">INICIAR SESIÓN</button>
                        <a href="#" class="disabl">Iniciar sesión</a>
                    </div>

                    <!-- <div class="col-sm-2 my-1">
                        <button type="submit" class="btn btn px-2"
                        style="background-color: #143153;color:white; width: 200px"
                        data-toggle="modal" data-target="#modalTypeClient">Registro exitoso</button>
                        <a href="#" class="disabl">Cerrar sesión</a>
                    </div>-->
                </div>
            </form>
        </div>
        <div class="col-lg-2 notification" style="padding-left: 160px;padding-top: 25px;">
            <div class="btn-group dropleft">
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="badge badge-danger mr-1 rounded-circle" style="font-size:10px;">1</span><i class="far fa-bell" style="color: white; font-size: 28px;"> </i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Separated link</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal LOGOUT-->
    <div class="modal fade" id="modalLogOut" tabindex="-1" role="dialog" aria-labelledby="modalLogOut" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 rounded-0" style="background:transparent">
                <div class="modal-header" style="height: 35px;">
                  <button type="button" class="close" style="margin: 0rem 0rem -1rem auto;padding: 0.1rem 1rem 0.5rem;background-color: #00A5E6;"  data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                  </button>
                </div>
                <div class="modal-body blue-dark">
                    <div>
                        <div>
                            <h5 class="text-white"><b>¿ESTÁS SEGURO QUE DESEAS SALIR?</b></h5>
                        </div>
                    </div>
                  <div class="row">
                      <div class="col-lg-9 py-2 text-center">
                        <img src="{{asset('img/logo.png')}}" alt="logo" width="50%"></div>
                      <div class="col-lg-3 py2 text-center">
                          <input type="button" class="text-white btn btn bg-primary btn-sm my-2" value="si" style="padding-left: 40px;padding-right: 40px;"><br>
                          <input type="button" class="btn btn-light btn-sm" value="No" style="padding-left: 35px;padding-right: 35px;background-color: white;color: #00A5E6;">
                      </div>
                  </div>
                </div>
              </div>
        </div>
    </div>

    <!-- Modal CLIENT TYPE-->
    <div class="modal fade" id="modalClientType" tabindex="-1" role="dialog" aria-labelledby="modalClientType" aria-hidden="true">
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
                                <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modal3" style="width: 270px">DUEÑO DE NEGOCIO</button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modal5" style="width: 270px;">MECÁNICO INDEPENDIENTE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!--menu-->
<nav class="navbar navbar-expand-lg navbar blue-dark top-bar">
    <a class="navbar-brand" href="#">
        <img class="logo-menu" src="{{asset('img/logo.png')}}" width="120px" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars text-white"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto" id="main-menu">
            <li class="nav-item">
                <a class="nav-link active" href="#">¿QUÉ ES? <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#section2">¿CÓMO FUNCIONA?</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#section3">TIPO DE CUENTA</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#section4">BENEFICIOS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#section5">TESTIMONIALES</a>
            </li>
            <!--<li class="nav-item">
                <a class="nav-link" href="#section6">COMPRA EN LÍNEA<i class="far fa-shopping-cart"></i></a>
            </li>-->
        </ul>
    </div>
</nav>

<!-- Modal formulario dueño de negocio-->
@include('includes.formularioDueño')

<!-- Modal formulario Mecanico-->
@include('includes.formularioMecanico')
