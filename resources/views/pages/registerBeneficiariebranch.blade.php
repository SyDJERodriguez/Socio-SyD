<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.head')
</head>
<body>
<!-- Header - Navbar Start -->
<div class="container-fluid" id="oneSection">
    <!--header-->
    <div id="backHeader">
        <img src="{{asset('img/headerBack.png')}}" alt=""
             style="position: absolute;z-index:1; height: 110px;">
    </div>
    <div class="row ml-0 header " id="header">
        <div class="col-lg-4 p-3 pl-4" id="main-logo" >
            <div class="fondoLogo">
                <img src="{{asset('img/logo.png')}}" width="250px" alt=""
                     style="position :absolute;z-index:2">

            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar blue-dark top-bar">
        <a class="navbar-brand" href="#">
            <img class="logo-menu" src="{{asset('img/logo.png')}}" width="120px" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto" id="main-menu" style="height: 40px">
            </ul>
        </div>
    </nav>
    <!-- Header - Navbar End -->

    <!-- Content Start -->
    <div class="container-fluid" style="display: flex; justify-content: center; padding: 100px 0;">
        @if ($data->validated === true)
        <div class="container">
            <h5 class="text-uppercase" id="title">ALTA EMPLEADO</h5>
            <div class="line1">
                <img src="{{asset('img/line2.png')}}" alt="">
            </div>
            <br>
            <div class="alert alert-danger" id="form_alert_phone_text_AEF" role="alert" style="border-radius: 6px;" hidden>
            </div>
            <div class="alert alert-danger" id="form_alert_dns_AEF" role="alert" style="border-radius: 6px;" hidden>
            </div>
            <br>
            <form autocomplete="off" id="addEmployeeFormbranch" method="POST" action="{{route('addEmployeebranch')}}">
                @method("PUT")
                @csrf
                    <input type="hidden" name="client_number" value="{{ isset($data->branch_number) ? $data->branch_number : null }}">
                    <input type="hidden" name="email_auth" value="{{$data->email}}">
                    <input type="hidden" name="client_type" value="{{$client_type}}">
                    <input type="hidden" name="mobile_auth" value="{{$data->mobile_number}}">
                    <input type="hidden" name="customer_id" value="{{$data->id}}">
                    <input type="hidden" name="nameClient" value="{{$data->name}}">
                    <input type="hidden" name="lastNameClient" value="{{$data->last_name}}">
                    <input type="hidden" name="branch_number" value="{{ isset($data->branch_number) ? $data->branch_number : null }}">
             <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <input class="form-control-sm form-control nameInput" type="text"
                                    name="name"
                                    placeholder="NOMBRE(S)"
                                    pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*"
                                    required maxlength="30">

                        </div>
                        <div class="col-6">
                            <input class="form-control-sm form-control nameInput" type="text"
                                    name="last_name"
                                    placeholder="APELLIDO PATERNO"
                                    pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*"
                                    required maxlength="30">

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <input class="form-control-sm form-control nameInput" type="text"
                                    name="second_last_name"
                                    placeholder="APELLIDO MATERNO"
                                    pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*"
                                    required  maxlength="30">
                        </div>
                        <div class="col-6">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <div style="border: 1px solid black" class="input-group-text">+52</div>
                                </div>
                                <input type="text" class="form-control-sm form-control btnBorder mobileInput"
                                placeholder="NO. TELEFÓNICO 10 DIG"
                                name="mobile_number"
                                maxlength="10"
                                pattern="[0-9]{10}"
                                required>
                                <div class="input-group-append" id="form_alert_phone_AEF" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6">
                            <label class="text-muted sml p-0 m-0">FECHA DE NACIMIENTO</label><br>
                        </div>
                        <div class="col-6">
                            <input class="form-control-sm form-control btnBorder"
                                    type="email"
                                    autocomplete="new-password"
                                    name="email"
                                    placeholder="CORREO ELECTRÓNICO"
                                    pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9._%+-]+@[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9.-]+\.[a-zA-ZñÑ]{2,}$"
                                    required>

                        </div>
                        <div class="col-6">
                            <div>
                                <div>
                                    <input class="form-control-sm form-control btnBorder" type="date"
                                            name="bday"
                                            placeholder="FECHA DE NACIMIENTO"
                                            required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-8 text-right">
                            <p style="font-size:12px" class="primary-color">
                                *Sino visualizas el correo en tu bandeja de entrada, revisa en correos no deseados
                            </p>
                        </div>
                        <div class="col-3">
                            <button type="submit" id="btnSend2" class="btn btn-info" style="background-color: #00A1E3; border-color: #00a1e3;">ACEPTAR</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @else 
        <div class="modal-body " style="background-color: #143153;">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <img src="{{asset('img/icon_check.png')}}">
                    <br>
                    <br>
                    <h5 class="text-white">¡Aún no cuentas con los beneficios de Socio SYD o llegaste al límite de usuarios!</h5>
                    <br>
                    <p class="text-white"></p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Content End -->
<!-- Footer Start -->
@include('includes.footer')
@include('includes.modals')
<!-- Footer End -->
<!--    jquery cdn      -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!--    bootstrap js    -->
<script src="{{asset('js/bootstrap.js')}}" crossorigin="anonymous"></script>
@include('includes.script')
</body>
</html>
