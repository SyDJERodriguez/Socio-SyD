<footer id="footer">
    <div class="container-fluid blue-dark py-5">
        <div class="row m-0">
            <div class="col-lg-3 text-white">
                <h4 class="text-white pb-3">Contáctanos</h4>
                <p>Ciudad de México <br><i class="fas fa-phone-alt"></i> 800 SyD (793) 101</p>
                <hr class="bg-primary">
                <p><i class="fas fa-envelope"></i> sociosyd@syd.com </p>
                <hr class="bg-primary">
            </div>
            <div class="col-lg-3 text-white">
                <h4 class="text-white pb-3">Consulta </h4>
                <p>Aviso de privacidad </p>
                <hr class="bg-primary">
                <p>Términos y condiciones</p>
                <hr class="bg-primary">
                <p>Preguntas frecuentes</p>
                <hr class="bg-primary">
            </div>
            <div class="col-lg-3 text-white">
                <h4 class="text-white pb-3">Síguenos en redes sociales </h4>
                <h6 style="display: flex; justify-content: center;">
                    <a href="#" class="text-white"><i class="fab fa-facebook-square fa-2x"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-instagram pl-3 fa-2x"></i></a>
                    <a href="#"  class="text-white"> <i class=" ml-3 fab fa-youtube-square fa-2x"></i> </a>
                </h6>

                <p>Compra en línea </p>
                <hr class="bg-primary">
                <a href="#" class="primary-color" data-toggle="modal" data-target="#modalContacto" style="color:white">
                    Contacto
                </a>
                <hr class="bg-primary">
            </div>
            <div class="col-lg-3 text-white text-right pr-0">
                <img src="{{asset('img/logo_2.png')}}" alt="">
            </div>
        </div>
    </div>

     <!-- Modal Contact-->
     <div class="modal fade" id="modalContacto" tabindex="-1" role="dialog" aria-labelledby="modalContacto" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse">
                    <span class="times" data-dismiss="modal" aria-label="Close">X</span>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-3 my-4 specialpart">
                                <h4 style="color: #143153;"><strong> CONTÁCTANOS</strong></h4><br>
                                <p>
                                    <span>TELÉFONO:</span><br>
                                      <a href="tel:800 SYD (723) 1010">800 SYD (723) 1010</a>
                                    <hr>
                                    <span>CORREO:</span><br>
                                      <a href="mailto:SOCIOSYD@SYD.COM">SOCIOSYD@SYD.COM</a>
                                    <br>
                                    <hr>
                                </p>
                            </div>
                            <div class="col-lg-9 p-0 my-4" style="border: 1px solid rgba(128, 128, 128, 0.719);">
                                <div class="text-center" style="background-color: #143153;padding: 20px;">
                                    <img src="{{asset('img/logo.png')}}" alt="logo"></div>
                                <br/>
                                <h6 class="py-2 ml-5" style="color: #143153;font-weight: 700;">INGRESA TUS DATOS</h6>
                                <form>
                                    <div class="form-row" style="padding: 0px  40px 40px 40px;">
                                      <div class="col-lg-6 py-2">
                                        <input type="text" class="form-control" placeholder="NOMBRE">
                                      </div>
                                      <div class="col-lg-6 py-2">
                                        <input type="text" class="form-control" placeholder="APELLIDOS">
                                      </div>
                                      <div class="col-lg-6 py-2">
                                        <input type="text" class="form-control" placeholder="CORREO ELECTRÓNICO">
                                      </div>
                                      <div class="col-lg-6 py-2">
                                        <input type="text" class="form-control" placeholder="No. TELEFÓNICO 10 DIGITOS">
                                      </div>
                                      <div class="col-lg-12 py-2">
                                          <textarea class="form-control" name="Comentario:" placeholder="Comentario:" id="" cols="103" rows="8"></textarea>
                                      </div>
                                      <div class="col-lg-6 py-2">
                                      </div>
                                      <div class="col-lg-6 py-2">
                                        <input type="button" class="btn btn text-white float-right" style="background-color: #00A1E3;" value="Enviar">
                                      </div>
                                    </div>
                                  </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
