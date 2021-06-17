<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')
</head>

<body>
    <!-- Header - Navbar Start -->
    <div class="container-fluid">
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

        <!-- Header - Navbar End -->
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

        <!-- Content Start -->
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-body " style="background-color: #143153;">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <img src="{{asset('img/icon_check.png')}}">
                            <h5 class="text-white">REGISTRO REALIZADO CON ÉXITO</h5>
                            <p class="text-white">Sigue estos dos pasos para que empieces a disfrutar de los beneficios <br> que el programa <b>Socio SyD</b>® tiene para ti:</p>
                            <ul>
                                <li>
                                    <p class="text-white">Revisa tu bandeja de correo electrónico </p>
                                </li>
                                <li>
                                    <p class="text-white">Ingresa a la página <b>sociosyd.com</b> con tu correo y contraseña generada</p>
                                </li>
                            </ul>
                            
                            <a href="{{route('home')}}" class="text-white btn btn btn-sm px-4"
                                style="background-color: #00A5E6;">ENTRAR</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Content End -->

    <!-- Footer Start -->
    @include('includes.footer')
    @include('includes.modals')
    <!-- Footer End -->
    <!--    jquery cdn      -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <!--    bootstrap js    -->
    <script src="{{asset('js/bootstrap.js')}}" crossorigin="anonymous"></script>
    @include('includes.script')
</body>

</html>
