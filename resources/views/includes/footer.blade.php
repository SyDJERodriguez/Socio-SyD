<footer id="footer">
    <div class="container-fluid blue-dark py-5">
        <div class="row m-0">
            <div class="col-lg-3 text-white">
                <h4 class="text-white pb-3">Contáctanos</h4>
                <p>Ciudad de México <br><i class="fas fa-phone-alt"></i><a href="tel:8007931010" class="primary-color" style="color:white; padding-left: 5px;">800SyD (793) 1010</a></p>
                <hr class="bg-primary">
                <p><i class="fas fa-envelope"></i><a href="mailto:sociosyd@syd.com" class="primary-color" style="color:white; padding-left: 5px;">sociosyd@syd.com </a></p>
                <hr class="bg-primary">
            </div>
            <div class="col-lg-3 text-white">
                <h4 class="text-white pb-3">Consulta </h4>
                <a href="#" class="primary-color" data-toggle="modal" data-target="#modalAviso" style="color:white">
                  Aviso de Privacidad
                </a>
                <hr class="bg-primary">
                <a href="#" class="primary-color" data-toggle="modal" data-target="#modal8" style="color:white">
                  Términos y condiciones
                </a>
                <hr class="bg-primary">
                <a href="#" class="primary-color" data-toggle="modal" data-target="#modalPreguntas" style="color:white">
                  Preguntas Frecuentes
                </a>
                <hr class="bg-primary">
            </div>
            <div class="col-lg-3 text-white">
                <h4 class="text-white pb-3">Síguenos en redes sociales </h4>
                <h6 style="display: flex; justify-content: center;">
                    <a href="https://www.facebook.com/DAR.Refaccionarias/" class="text-white"><i class="fab fa-facebook-square fa-2x"></i></a>
                    <a href="https://www.instagram.com/dar.refaccionarias/" class="text-white"><i class="fab fa-instagram pl-3 fa-2x"></i></a>
                    <a href="https://www.youtube.com/channel/UCztsDKlObp-vPvv4wJR8wWQ"  class="text-white"> <i class=" ml-3 fab fa-youtube-square fa-2x"></i> </a>
                </h6>

                <a href="https://www.refaccionarias-dar.com/" style="color:white">¿Dónde comprar?</a>
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
     <div class="modal fade rounded-0" id="modalContacto" tabindex="-1" role="dialog" aria-labelledby="modalContacto" aria-hidden="true">
        <div class="modal-dialog modal-xl rounded-0" role="document">
          <div class="modal-content rounded-0">
            <div class="modal-header border-0 rounded-0" style="background-color: #143153; margin-left: -1px; margin-right: 1px;">
              <h5 class="modal-title" id="exampleModalLabel"></h5>
              <div class="modal-header d-flex flex-row-reverse">
                <span class="times" data-dismiss="modal" aria-label="Close">X</span>
            </div>
            </div>
            <div class="modal-body">
              <div class="container-fluid">
                  <div class="row" style="margin-right: 0 !important;">
                      <div class="col-lg-3 my-4 specialpart">
                          <h4 style="color: #143153;"><strong> CONTÁCTANOS</strong></h4><br>
                          <p>
                              <span>TELÉFONO:</span><br>
                                <a href="tel:8007931010">800SyD (793) 1010</a>
                              <hr>
                              <span>CORREO:</span><br>
                                <a href="mailto:sociosyd@syd.com">SOCIOSYD@SYD.COM</a>
                              <br>
                              <hr>
                          </p>
                      </div>
                      <div class="col-lg-9 p-0 my-4" style="border: 1px solid rgba(128, 128, 128, 0.719);">
                          <div class="text-center" style="background-color: #143153;padding: 20px;"><img src="{{'img/logo.png'}}" alt="logo"></div>
                          <br/>
                          <h6 class="py-2 ml-5" style="color: #143153;font-weight: 700;">INGRESA TUS DATOS</h6>
                          <form method="POST" action="/contact_us" id="form-contact-us">
                          {{ csrf_field() }}
                              <div class="form-row" style="padding: 0px  40px 40px 40px;">
                                <div class="col-lg-6 py-2">
                                  <input type="text" class="form-control" id="contact-name" pattern="[A-Za-z].{3,}" placeholder="NOMBRE" required >
                                </div>
                                <div class="col-lg-6 py-2">
                                  <input type="text" class="form-control"  id="contact-lastname" pattern="[A-Za-z].{3,}" placeholder="APELLIDOS" required>
                                </div>
                                <div class="col-lg-6 py-2">
                                  <input type="text" class="form-control"  id="contact-email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="'example: correo@dominio.com'" placeholder="CORREO ELECTRÓNICO" required>
                                </div>
                                <div class="col-lg-6 py-2">
                                  <input type="text" class="form-control"  id="contact-phone" placeholder="No. TELEFÓNICO 10 DÍGITOS" pattern="[0-9]{10}" maxlength="10"  title="Ten digits code" required>
                                </div>
                                <div class="col-lg-12 py-2">
                                    <textarea class="form-control" name="Comentario:"  id="contact-comment" pattern="[A-Za-z0-9].{15,}" placeholder="COMENTARIO:" id="" cols="103" rows="8" required></textarea>
                                </div>
                                <div class="col-lg-6 py-2">
                                </div>
                                <div class="col-lg-6 py-2">
                                  <input id="contact_us_button" onClick="sendContact()" type="button" class="btn btn text-white float-right" style="background-color: #00A1E3;" value="Enviar">
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

      <!-- MODAL PREGUNTAS-->
      @extends('includes.preguntas')

      <!-- MODAL AVISO -->
      @extends('includes.aviso')

      <!-- MODAL TERMINOS -->
      @extends('includes.terms')

        <!-- MODAL GENERAL TERMS -->
    @extends('includes.generalTerms')
</footer>
