@extends('layouts.application')
@section('content')
    <section id="section1">
        <div class="container-fluid">
            <div class="row m-0">
                <div class="col-lg-6 blue-dark text-center px-auto py-5">
                    <h1 class="nav-link"> <STRONG>SOCIO SyD®</STRONG></h1>
                    <h3 class="nav-link">ES EL PROGRAMA<br>
                        EN EL QUE TODOS LOS MECÁNICOS<BR>RECIBEN BENEFICIOS,<br>
                        POR HACER LAS COMPRAS DE SIEMPRE.
                    </h3>
                </div>
                <div class="col-lg-6 p-0">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{asset('img/slider2.png')}}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{asset('img/slider1.png')}}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{asset('img/slider3.png')}}" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="section2">
        <div class="p-5">
            <div class="row">
                <div class="col-lg-3 py-5"><div class="bg-primary bar" style="height: 2px;"></div></div>
                <div class="col-lg-6 py-3"> <h1 class="primary-color text-center"><strong>CÓMO FUNCIONA SOCIO SyD®</strong></h1></div>
                <div class="col-lg-3 py-5"><div class="bg-primary bar" style="height: 2px;"></div></div>
            </div>
            <div class="row primary-color">
                <div class="col-lg-4 mx-auto text-center img1">
                    <img class="mx-auto py-2" src="{{asset('img/icon_pc.png')}}" alt="">
                    <h2 class="text-center pt-3"><strong>REGÍSTRATE</strong></h2>
                    <h5 style="font-weight: 400;">Hazlo desde<br>
                        cualquier dispositivo.</h5>
                </div>
                <div class="col-lg-4 mx-auto text-center img2">
                    <img class="mx-auto py-2" src="{{asset('img/shopping.png')}}" alt="">
                    <h2 class="text-center pt-3"><strong>COMPRA</strong></h2>
                    <h5 style="font-weight: 400;">Haz una compra mínima<br>
                        de <b>$200</b> pesos al mes.</h5>
                </div>
                <div class="col-lg-4 mx-auto text-center img3">
                    <img class="mx-auto py-2 pb-3" src="{{asset('img/check.png')}}" alt="">
                    <h2 class="text-center pt-3"><strong>OBTÉN BENEFICIOS</strong></h2>
                    <h5 style="font-weight: 400;">
                        Obtén tu seguro de accidentes<br>
                        y más beneficios.</h5>
                </div>
            </div>
        </div>
        <div class="container-fluid pb-5">
            <div class="row m-0">
                <div class="col-lg-4 py-2"><img src="{{asset('img/slider2.png')}}" class="img-fluid" alt="Responsive image">
                </div>
                <div class="col-lg-4 py-2"><img src="{{asset('img/slider1.png')}}" class="img-fluid" alt="Responsive image">
                </div>
                <div class="col-lg-4 py-2"><img src="{{asset('img/slider3.png')}}" class="img-fluid" alt="Responsive image">
                </div>
            </div>
        </div>
    </section>

    <section id="section3">
            <div class="row m-0">
                <div class="col-lg-3 p-5"><div class="bg-primary" style="height: 2px;"></div></div>
                <div class="col-lg-6 p-3"> <h1 class="primary-color text-center"><strong>TIPO DE CUENTA</strong></h1></div>
                <div class="col-lg-3 p-5"><div class="bg-primary" style="height: 2px;"></div></div>
            </div>

        <div class="container-fluid ">
            <div class="row background m-0">

                <div class="col-lg-6 mx-auto text-center py-1">
                    <div class="bg-primary py-1">
                        <h4 class="primary-color mt-5 mb-2"><strong>DUEÑO DE NEGOCIO</strong></h4>
                        <img class="my-3" src="{{asset('img/car.png')}}" alt="">
                        <div style="text-align: left; display: flex; align-items: center; flex-direction: column; justify-content: flex-start;">
                            <p class="my-2 text-white">Registra a tus empleados para que siempre<br>
                                estén seguros en su lugar de trabajo:<br>

                                <strong>
                                    • Seguro contra Accidentes<br>
                                    • Asistencia las 24 horas
                                </strong>
                            </p>
                        </div>

                        <div class="my-4 mb-5">
                            <button class="btn btn blue-dark text-white " data-toggle="modal" data-target="#modal3">REGISTRARME</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mx-auto text-center py-1">
                    <div class="bg-primary py-1">
                        <h4 class="primary-color mt-5 mb-2"><strong>MECÁNICO INDEPENDIENTE</strong></h4>
                        <img class="my-3" src="{{asset('img/men_2.png')}}" alt="">
                        <div style="text-align: left; display: flex; align-items: center; flex-direction: column; justify-content: flex-start;">
                            <p class="my-2 text-white">
                                Regístrate y obtén beneficios como:<br>
                                <strong>
                                    • Seguro contra accidentes<br>
                                    • Asistencia las 24 horas<br>
                                </strong>
                                Te brindamos la seguridad que nadie te da.
                            </p>
                        </div>
                        <div class="my-4 mb-5">
                            <button class="btn btn blue-dark text-white " data-toggle="modal" data-target="#modal5">REGISTRARME</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="section4">
        <div class="row my-3 mx-0">
            <div class="col-lg-3 col-xs-3 p-5"><div class="bg-primary bar" style="height: 2px;"></div></div>
            <div class="col-lg-6 col-xs-6 p-3"> <h1 class="primary-color text-center"><strong>BENEFICIOS</strong></h1></div>
            <div class="col-lg-3 col-xs-3 p-5"><div class="bg-primary bar" style="height: 2px;"></div></div>
        </div>
        <div class="container-fluid">
            <div class="row blue-dark py-5 m-0">
                <div class="col-lg-6 text-center text-white">
                    <img src="{{asset('img/segor.png')}}" class="pb-4" alt="">
                    <h5 class="text-white mt-2"><strong>SEGURO DE ACCIDENTES<br>
                            PERSONALES</strong></h5>
                    <p>Hasta $50,000 pesos<br>por muerte accidental.</p>
                </div>
                <div class="col-lg-6 text-center text-white">
                    <img src="{{asset('img/servicios.png')}}" class="pb-4" alt="">
                    <h5 class="text-white"><strong>SERVICIOS<br>
                        DE ASISTENCIA</strong></h5>
                    <p>Asistencia Médica 24 horas<br>
                        /Servicio de Grúa/Ambulancia<br>Terrestre/Servicio Funerario<br>
                        por hasta $10,000.</p>
                </div>
            </div>
        </div>
    </section>


    <section id="section5">
        <div class="row my-3 mx-0">
            <div class="col-lg-3 p-5"><div class="bg-primary" style="height: 2px;"></div></div>
            <div class="col-lg-6 p-3"> <h1 class="primary-color text-center"><strong>TESTIMONIALES</strong></h1></div>
            <div class="col-lg-3 p-5"><div class="bg-primary" style="height: 2px;"></div></div>
        </div>

        <div class="container-fluid">
            <div class="bd-example" style="background-image: url({{asset('img/slider_1.png')}});background-size: cover;background-repeat: no-repeat;background-position: center;">
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">

                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="carousel-caption">
                                <img class="my-3" src="{{asset('img/person.png')}}" alt="">
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet<br>
                                    dolore magna aliquam erat volucommodo consequat. Duis autem vel eum.</p>
                                <h5 class="py-3">Mario Meza</h5>
                                <button class="btn btn-primary text-white">COMPÁRTENOS TU HISTORIA</button>

                            </div>
                        </div>
                        <div class="carousel-item">

                            <div class="carousel-caption">
                                <img class="my-3" src="{{asset('img/person.png')}}" alt="">
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet<br>
                                    dolore magna aliquam erat volucommodo consequat. Duis autem vel eum.</p>
                                <h5 class="py-3">Second slide label</h5>
                                <button class="btn btn-primary text-white">COMPÁRTENOS TU HISTORIA</button>

                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="carousel-caption">
                                <img class="my-3" src="{{asset('img/person.png')}}" alt="">
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet<br>
                                    dolore magna aliquam erat volucommodo consequat. Duis autem vel eum.</p>
                                <h5 class="py-3">Third slide label</h5>
                                <button class="btn btn-primary text-white">COMPÁRTENOS TU HISTORIA</button>

                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="section6">
        <div class="container-fluid py-5">
            <div class="jumbotron text-center mx-auto">
                <div class="row text-center">
                    <div class="col-lg-4 p-4"><div class="bg-white " style="height: 1px;"></div></div>
                    <div class="col-lg-4 ">
                        <h1 class="text-white text-center"><strong>COMPRA EN LÍNEA
                            </strong></h1>
                        <br/>
                    </div>
                    <div class="col-lg-4 p-4"><div class="bg-white" style="height: 1px;"></div></div>
                </div>

                <h5 class=" text-white text-center py-4"><strong>OBTÉN LOS PRODUCTOS QUE NECESITAS <br>EN UN SÓLO CLIC</strong></h5>
                <a class="btn btn-primary text-center" href="#" role="button">COMPRA AHORA</a>
            </div>
        </div>
    </section>
    @include('includes.modals')
@stop
