@extends('layouts.application')
@section('content')
    <section id="section1">
        <div class="container-fluid">
            <div class="row m-0">
                <div class="col-lg-6 blue-dark text-center px-auto py-5" style="display: flex; justify-content: center; align-items: center;">
                    <p class="nav-link" style="font-size: 30px;line-height:90%">
                        <STRONG>SOCIO SyD®</STRONG>
                        <br>
                        <span style="font-size: 23px"> ES EL PROGRAMA<br>
                        EN EL QUE TODOS LOS MECÁNICOS<BR>
                        RECIBEN BENEFICIOS,<br>
                        POR HACER LAS COMPRAS DE SIEMPRE
                        </span>
                    </p>
                </div>
                <div class="col-lg-6 p-0">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{asset('img/slider_0.jpg')}}" class="d-block w-100 carousel" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{asset('img/slider2.jpg')}}" class="d-block w-100 carousel" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{asset('img/C1.png')}}" class="d-block w-100 carousel" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{asset('img/C2.png')}}" class="d-block w-100 carousel" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{asset('img/C3.png')}}" class="d-block w-100 carousel" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{asset('img/C4.png')}}" class="d-block w-100 carousel" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{asset('img/C5.png')}}" class="d-block w-100 carousel" alt="...">
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
                <div class="col-lg-6 py-3">
                    <h2 class="primary-color text-center">
                        <strong>CÓMO FUNCIONA SOCIO SyD®</strong>
                    </h2>
                </div>
                <div class="col-lg-3 py-5"><div class="bg-primary bar" style="height: 2px;"></div></div>
            </div>
            <div class="row primary-color">
                <div class="col-lg-4 mx-auto text-center img1">
                    <img class="mx-auto py-2" src="{{asset('img/icon_pc.png')}}" width="120px" alt="" style="padding-top: 6% !important;">
                    <p class="text-center" style="font-size: 18px;line-height:90%; margin-top: -3%">
                        <br>
                        <strong>REGÍSTRATE</strong>
                        <br><br>
                    <span style="font-size:15px;">
                        Hazlo desde<br>
                        cualquier dispositivo
                        </span>
                    </p>
                </div>
                <div class="col-lg-4 mx-auto text-center img2">
                    <img class="mx-auto py-2" src="{{asset('img/shopping.png')}}" alt=""
                    width="120px">
                    <p class="text-center" style="font-size: 18px;line-height:90%; margin-top: 1% !important;">
                        <br>
                        <strong>COMPRA</strong>
                        <br><br>
                    <span style="font-size:15px;">
                        Haz una compra mínima<br>
                        de <b>$200</b> pesos al mes <br> en cualquier sucursal <br>
                        DAR Refaccionarias
                    </span>
                    </p>
                </div>
                <div class="col-lg-4 mx-auto text-center img3">
                    <img class="mx-auto py-2 pb-3" src="{{asset('img/check.png')}}"  width="120px" height="155px" alt="" style="margin-top: 5% !important;">
                    <p class="text-center"  style="font-size: 18px;line-height:90%; margin-top: -4% !important;">
                        <strong>OBTÉN BENEFICIOS</strong>
                        <br><br>
                    <span  style="font-size:15px;">
                        Obtén tu seguro de accidentes<br>
                        y más beneficios
                    </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="container-fluid pb-5">
            <div class="row m-0">
                <div class="col-lg-4 py-2" >
                    <img src="{{asset('img/B1.png')}}" class="img-fluid" alt="Responsive image">
                </div>
                <div class="col-lg-4 py-2">
                    <img src="{{asset('img/B2.png')}}" class="img-fluid" alt="Responsive image">
                </div>
                <div class="col-lg-4 py-2">
                    <img src="{{asset('img/B3.png')}}" class="img-fluid" alt="Responsive image">
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

        <div class="container-fluid pb-5">
            <div class="row background m-0">

                <div class="col-lg-6 mx-auto text-center py-1">
                    <div class="bg-primary py-1" style="background-color: #00a5e6 !important;">
                        <h4 class="primary-color mt-5 mb-2"><strong>DUEÑO DE NEGOCIO</strong></h4>
                        <img class="my-3" src="{{asset('img/car.png')}}" width="160px" alt="">
                        <div style="text-align: left; display: flex; align-items: center; flex-direction: column; justify-content: flex-start;">
                            <p class="my-2 text-white">Registra a tus empleados para que siempre<br>
                                estén seguros en su lugar de trabajo:<br>

                                <strong>
                                    • Seguro contra accidentes<br>
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
                    <div class="bg-primary py-1" style="background-color: #00a5e6 !important;">
                        <h4 class="primary-color mt-5 mb-2"><strong>MECÁNICO INDEPENDIENTE</strong></h4>
                        <img class="my-3" src="{{asset('img/men_2.png')}}" width="160px" alt="">
                        <div style="text-align: left; display: flex; align-items: center; flex-direction: column; justify-content: flex-start;">
                            <p class="my-2 text-white">
                                Regístrate y obtén beneficios como:<br>
                                <strong>
                                    • Seguro contra accidentes<br>
                                    • Asistencia las 24 horas<br>
                                </strong>
                                Te brindamos la seguridad que nadie te da
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
                <div class="col-lg-6 text-center text-white" style="cursor: pointer;" data-toggle="modal" data-target="#modalSeguros">
                    <img src="{{asset('img/segor.png')}}" class="pb-4" alt="">
                    <h5 class="text-white mt-2"><strong>SEGURO DE ACCIDENTES<br>
                            PERSONALES</strong></h5>
                    <p>Hasta $50,000 pesos<br>por muerte accidental</p>
                </div>
                <div class="col-lg-6 text-center text-white" style="cursor: pointer;" data-toggle="modal" data-target="#modalAsistencias">
                    <img src="{{asset('img/servicios.png')}}" class="pb-4" alt="">
                    <h5 class="text-white"><strong>SERVICIOS<br>
                        DE ASISTENCIA</strong></h5>
                    <p>Asistencia Médica 24 horas/<br>
                        Servicio de Grúa/Ambulancia<br>Terrestre/Servicio Funerario<br>
                        por hasta $10,000</p>
                </div>
            </div>
        </div>
    </section>


    <!--<section id="section5">
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
    </section>-->

    <section id="section6">
        <div class="container-fluid py-5">
            <div class="row my-3 mx-0">
                <div class="col-lg-3 col-xs-3 p-5"><div class="bg-primary bar" style="height: 2px;"></div></div>
                <div class="col-lg-6 col-xs-6 p-3"> <h1 class="primary-color text-center"><strong>¿DÓNDE COMPRAR?</strong></h1></div>
                <div class="col-lg-3 col-xs-3 p-5"><div class="bg-primary bar" style="height: 2px;"></div></div>
            </div>
            <!--<a href="https://www.refaccionarias-dar.com/" target="_blank">-->
                <div class="our-branches__content-address">

                    <div class="our-branches__content-address-map sucursal col-md-4">
                    </div>

                    <div class="our-branches__content-address-location col-md-4">

                        <div class="our-branches__content-address-location-search">
                            <label class="our-branches__content-address-location-search-label" style="color: #00A1E3">
                                <h6>Por favor elige la opción que deseas ver:</h6>
                                <select class="our-branches__content-estate-location-search-select sucursal" type="text">
                                    <option disabled selected>Selecciona un estado</option>
                                </select>
                                <select class="our-branches__content-address-location-search-select sucursal" type="text">
                                    <option disabled selected>Selecciona una ubicación</option>
                                </select>
                            </label>
                        </div>



                        <div class="our-branches__content-address-location-result">
                            <div class="our-branches__content-address-location-title--wrapper">
                                <p class="our-branches__content-address-location-title sucursal darTitle">
                                    DAR Santa Elena:
                                </p>
                            </div>

                            <div class="row">
                                <div class="col-2 mapIcon">
                                    <svg aria-hidden="true"  width="30" focusable="false" data-prefix="fas" data-icon="map-marked-alt" class="svg-inline--fa fa-map-marked-alt fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#00A1E3" d="M288 0c-69.59 0-126 56.41-126 126 0 56.26 82.35 158.8 113.9 196.02 6.39 7.54 17.82 7.54 24.2 0C331.65 284.8 414 182.26 414 126 414 56.41 357.59 0 288 0zm0 168c-23.2 0-42-18.8-42-42s18.8-42 42-42 42 18.8 42 42-18.8 42-42 42zM20.12 215.95A32.006 32.006 0 0 0 0 245.66v250.32c0 11.32 11.43 19.06 21.94 14.86L160 448V214.92c-8.84-15.98-16.07-31.54-21.25-46.42L20.12 215.95zM288 359.67c-14.07 0-27.38-6.18-36.51-16.96-19.66-23.2-40.57-49.62-59.49-76.72v182l192 64V266c-18.92 27.09-39.82 53.52-59.49 76.72-9.13 10.77-22.44 16.95-36.51 16.95zm266.06-198.51L416 224v288l139.88-55.95A31.996 31.996 0 0 0 576 426.34V176.02c0-11.32-11.43-19.06-21.94-14.86z"></path></svg>
                                </div>
                                <div class="col-9" >
                                    <div class="our-branches__content-address-location-result-item-body item_direccion sucursal text-wrap" style="padding-left: 15px">
                                        <div class="text-wrap">
                                            Av. de los Maestros #804, Fraccionamiento Jardines de Sta.
                                            Elena C.P. 20236, Aguascalientes, Aguascalientes.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 mapIcon">
                                    <svg aria-hidden="true"  width="30" focusable="false" data-prefix="far" data-icon="clock" class="svg-inline--fa fa-clock fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#00A1E3" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z"></path></svg>
                                </div>
                                <div class="col-9">
                                    <div class="our-branches__content-address-location-result-item-body item_horario sucursal" style="padding-left: 15px;">
                                        <div class="text-wrap">
                                            <p>
                                                Lunes a Viernes de 9:00am a 7:00pm
                                                <br> Sábado de 9:00am a 5:00pm
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 mapIcon">
                                    <svg aria-hidden="true" width="30" focusable="false" data-prefix="fas" data-icon="phone-alt" class="svg-inline--fa fa-phone-alt fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#00A1E3" d="M497.39 361.8l-112-48a24 24 0 0 0-28 6.9l-49.6 60.6A370.66 370.66 0 0 1 130.6 204.11l60.6-49.6a23.94 23.94 0 0 0 6.9-28l-48-112A24.16 24.16 0 0 0 122.6.61l-104 24A24 24 0 0 0 0 48c0 256.5 207.9 464 464 464a24 24 0 0 0 23.4-18.6l24-104a24.29 24.29 0 0 0-14.01-27.6z"></path></svg>
                                </div>
                                <div class="col-9">
                                    <div class="our-branches__content-address-location-result-item-body item_tel sucursal text-wrap" style="padding-left: 15px;">
                                        <p> Tel: 01(449) 140-5442 <br> Tel: 01(449) 978-1196 </p>
                                    </div>
                                </div>

                                <div class="col-2 py-2 mapIcon">
                                    <svg aria-hidden="true" width="30" focusable="false" data-prefix="fab" data-icon="whatsapp" class="svg-inline--fa fa-whatsapp fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="#00A1E3" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path></svg>
                                </div>
                                <div class="col-9 py-1">
                                    <div class="our-branches__content-address-location-result-item-body item_whats sucursal text-wrap" style="padding-left: 15px; padding-top: 3%;">
                                        <p> 55-1016-8974</p>
                                        <br>
                                    </div>
                                </div>

                                <div class="col-2 py-1 mapIcon">
                                    <div class="our-branches__content-address-location-result-item-body item_servicio sucursal d-none">
                                        <svg aria-hidden="true" width="30" focusable="false" data-prefix="fab" data-icon="car" class="svg-inline--fa fa-whatsapp fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#00A1E3" d="M23.5 7c.276 0 .5.224.5.5v.511c0 .793-.926.989-1.616.989l-1.086-2h2.202zm-1.441 3.506c.639 1.186.946 2.252.946 3.666 0 1.37-.397 2.533-1.005 3.981v1.847c0 .552-.448 1-1 1h-1.5c-.552 0-1-.448-1-1v-1h-13v1c0 .552-.448 1-1 1h-1.5c-.552 0-1-.448-1-1v-1.847c-.608-1.448-1.005-2.611-1.005-3.981 0-1.414.307-2.48.946-3.666.829-1.537 1.851-3.453 2.93-5.252.828-1.382 1.262-1.707 2.278-1.889 1.532-.275 2.918-.365 4.851-.365s3.319.09 4.851.365c1.016.182 1.45.507 2.278 1.889 1.079 1.799 2.101 3.715 2.93 5.252zm-16.059 2.994c0-.828-.672-1.5-1.5-1.5s-1.5.672-1.5 1.5.672 1.5 1.5 1.5 1.5-.672 1.5-1.5zm10 1c0-.276-.224-.5-.5-.5h-7c-.276 0-.5.224-.5.5s.224.5.5.5h7c.276 0 .5-.224.5-.5zm2.941-5.527s-.74-1.826-1.631-3.142c-.202-.298-.515-.502-.869-.566-1.511-.272-2.835-.359-4.441-.359s-2.93.087-4.441.359c-.354.063-.667.267-.869.566-.891 1.315-1.631 3.142-1.631 3.142 1.64.313 4.309.497 6.941.497s5.301-.184 6.941-.497zm2.059 4.527c0-.828-.672-1.5-1.5-1.5s-1.5.672-1.5 1.5.672 1.5 1.5 1.5 1.5-.672 1.5-1.5zm-18.298-6.5h-2.202c-.276 0-.5.224-.5.5v.511c0 .793.926.989 1.616.989l1.086-2z"/></svg>
                                    </div>
                                </div>
                                <div class="col-9 py-1">
                                    <div class="our-branches__content-address-location-result-item-body item_servicio sucursal text-wrap d-none" style="padding-left: 15px;" >
                                        <p>Contamos con servicio de taller. <br></p>
                                    </div>
                                </div>

                                <div class="col-10 offset-1 py-2"
                                style="right: 6px;">
                                    <div >
                                        <a href="https://www.refaccionarias-dar.com/"  class="btn btn btn-sm btn-block btnComprar" >
                                            Compra aquí
                                            </a>
                                    </div>
                                </div>

                                {{-- fin ROw --}}
                            </div>

                        </div>

                    </div>


                </div>

                <!--<div class="jumbotron">

                <div class="row text-center">
                    <div class="col-lg-4 p-4"><div class="bg-white " style="height: 1px;"></div></div>
                    <div class="col-lg-4 ">
                        <h1 class="text-white text-center"><strong>¿DÓNDE COMPRAR?</strong></h1>
                        <br/>
                    </div>
                    <div class="col-lg-4 p-4"><div class="bg-white" style="height: 1px;"></div></div>
                </div>

                <h5 class=" text-white text-center py-4"><strong>OBTÉN LOS PRODUCTOS QUE NECESITAS <br>EN UN SÓLO CLIC</strong></h5>
                <a class="btn btn-primary text-center" href="https://www.refaccionarias-dar.com/" role="button">COMPRA AHORA</a>
                </div>
            </a>-->
        </div>
    </section>
    @include('includes.modals')
@stop
