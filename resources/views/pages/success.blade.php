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
        <div class="modal-body " style="background-color: #143153;">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <img src="{{asset('img/icon_check.png')}}">
                    <br>
                    <br>
                    <h5 class="text-white">¡Cliente agregado exitosamente!</h5>
                    <br>
                  <a href="{{url()->previous()}}"><button class="btn btn-info" style="background-color: #00A1E3; border-color: #00a1e3;">Aceptar</button></a>  
                    <p class="text-white"></p>
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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!--    bootstrap js    -->
<script src="{{asset('js/bootstrap.js')}}" crossorigin="anonymous"></script>
@include('includes.script')
</body>
</html>