<a href="#" class="whatsapp"><img src="{{asset('img/1x/wht.png')}}" alt=""></a>

<div class="container-fluid">
    <!--header-->
    <div class="row header ml-0">
        <div class="col-lg-3 p-2 pl-4">
            <img src="{{asset('img/logo.png')}}" width="250px" alt="">
        </div>
        <div class="col-lg-7 pl-6 pt-1">
            <form id="login-form">
                <div class="form-row align-items-center">
                    <div class="col-sm-5 my-1">
                        <input type="text" class="form-control border-input" id="inlineFormInputName" placeholder="CORREO">
                        <div class="col-sm-12" style="display: flex; justify-content: center; align-items: flex-end;">
                            <p class="primary-color pr-3" style="margin-bottom: 0"><b>¿No tienes una cuenta?</b></p>
                            <a href="#" data-toggle="modal" data-target="#modal2" class="btn btn p-0" style="background-color: #143153;color:white;font-size: 12px; width: 90px;">¡REGISTRATE!</a>
                        </div>
                    </div>
                    <div class="col-sm-5 my-1">
                        <input type="text" class="form-control border-input" id="inlineFormInputGroupUsername" placeholder="CONTRASEÑA">
                        <div class="col-sm-12" style="display: flex; justify-content: center; align-items: flex-end;">
                            <a href="#" class="primary-color" data-toggle="modal" data-target="#modal4"><b>¿Olvidaste tu contraseña?</b></a>
                        </div>
                    </div>

                    <div class="col-sm-2 my-1">
                        <button type="submit" class="btn btn px-2" style="background-color: #143153;color:white; width: 200px">INICIAR SESIÓN</button>
                        <a href="#" class="disabl">Iniciar sesión</a>
                    </div>
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
            <li class="nav-item">
                <a class="nav-link" href="#section6">COMPRA EN LÍNEA<i class="far fa-shopping-cart"></i></a>
            </li>
        </ul>
    </div>
</nav>

<!-- Modal tipo de cliente-->
<div class="modal fade " id="modal2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
       aria-hidden="true">
      <div class="modal-dialog modal-sm">
          <div class="modal-content">
              <div class="container ">
                  <div class="row mt-4 mx-2">
                      <div class="col-10">
                          <span class="md2-heading">TIPO DE CLIENTE</span>
                      </div>
                      <div class="col-2">
                          <i class="fa fa-caret-down md2-icon"></i>
                      </div>
                  </div>
                  <div class="row md2-row2 mx-1">
                      <span  data-dismiss="modal" data-toggle="modal" data-target="#modal3" class="pl-3" style="cursor: pointer;">DUEÑO DE NEGOCIO</span>
                  </div>
                  <div class="row md2-row3 mx-4">
                      <span  class="font-weight-bold">MECÁNICO INDEPENDIENTE</span>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Modal formulario dueño de negocio-->
  <div class="modal fade rounded-0" id="modal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg rounded-0" role="document">
        <div class="modal-content rounded-0">
          <div class="modal-header border-0 rounded-0" style="background-color: #143153;;">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <div class="modal-header d-flex flex-row-reverse">
              <span class="times" data-dismiss="modal" aria-label="Close">X</span>
          </div>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-lg-7 pt-2 pb-5">
                    <h2>Registro Dueño de negocio</h2>
                    <div class="line1" style="height: 2px;width: 380px;background-color: black;"></div>
                    <div class="line1 float-right " style="height: 2px;width: 60px;background-color: black;  transform: rotate(33deg);;margin-top: 14.3px;"></div>
                </div>
            </div>
            <form>
                <div class="row">
                    <div class="col-lg-6 py-4"> 
                      <input type="text" class="form-control" placeholder="Nombre">
                    </div>
                    <div class="col-lg-6 py-4">
                      <input type="text" class="form-control" placeholder="Número de cliente">
                    </div>
                    <div class="col-lg-6 py-4">
                      <input type="text" class="form-control" placeholder="Primer apellido">
                    </div>
                    <div class="col-lg-6 py-4">
                      <input type="text" class="form-control" placeholder="Segundo apellido">
                    </div>
                </div>
                  <div class="row">
                    <div class="col-lg-6 py-2"> 
                      <input type="text" class="form-control" placeholder="Razón social">
                    </div>
                    <div class="col-lg-6">
                      <label for="" class="labelgre">FECHA DE NACIMIENTO</label>
                      <div class="row">
                        <div class="col-lg-4 py-2">
                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                <option selected>DÍA</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                              </select>
                        </div>
                        <div class="col-lg-4 py-2">
                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect2">
                                <option selected>MES</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                              </select>
                        </div>
                        <div class="col-lg-4 py-2">
                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect3">
                                <option selected>AÑO</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                              </select>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  <div class="row">
                    <div class="col-lg-6 py-3"> 
                      <input type="text" class="form-control" placeholder="no. telefónico 10 dig">
                    </div>
                    <div class="col-lg-6 py-3">
                      <input type="email" class="form-control" placeholder="correo electrónico">
                    </div>
                  </div>
                  <div class="row ">
                    <div class="col-lg-6 py-3"> 
                        <select class="form-control">
                            <option>R.F.C.</option>
                          </select>
                         </div>
                    <div class="col-lg-6 py-3">
                      <input type="text" class="form-control" placeholder="contraseña">
                    </div>
                  </div>
                  <div class="row ">
                    <div class="col-lg-6 py-3"> 
                        <select class="form-control">
                            <option>Refaccionaria</option>
                            <option>Mayorista</option>
                            <option>Taller</option>
                            <option>Otro</option>
                          </select>
                         </div>
                    <div class="col-lg-6 py-3">
                      <input type="text" class="form-control" placeholder="CONFIRMAR contraseña">
                    </div>
                  </div>
            </form>
          </div>
          <div class="modal-footer border-top-0">
            <div class="form-check form-check-inline text-right">
                <label class="form-check-label pr-2" for="inlineCheckbox1"  style="color: grey;font-size: 12px;"><strong>ACEPTAR</strong><br>
                  AVISO DE PRIVACIDAD
                  <br>
                  TÉRMINOS Y CONDICIONES</label>
                <input class="form-check-input " style="width: 30px;height: 30px;" type="checkbox" id="inlineCheckbox1" value="option1">
              </div>
              <button type="button" class="btn btn" style="background-color: #00A1E3;color: white;">Enviar</button>
          </div>
        </div>
      </div>
    </div>
