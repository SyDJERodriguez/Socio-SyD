<div class="col-lg-4 text-center py-3" >
    <h6 style="color: #143153;cursor: pointer;" data-toggle="modal"
        @if (Route::currentRouteName() == 'customer.benefits')
            data-target="#modal8"
        @else
            data-target="#modal9"
        @endif
        >
        <img class="py-2"
                style="width:150px; height:150px;"
                src="{{asset('img/perdida_organica.png')}}"
        ><br> <strong class="py-3"> PÉRDIDA ORGÁNICA
         </strong></h6>
         <a class="btn btn-outline-light btn-sm playBenefits"
              style="background-color: #143153"
              id="showVideoButton1"
              href="#"
              onclick="playVideoBenefit('perdidaOrganica')"
             >Ver video</a>
        </div>
<div class="col-lg-4 text-center iconInvalid">
    <h6 style="color: #143153;cursor: pointer" data-toggle="modal"
        @if (Route::currentRouteName() == 'customer.benefits')
            data-target="#modal8"
        @else
            data-target="#modal10"
        @endif
        >
        <img class="py-2"
                style="width:150px; height:150px;"
                src="{{asset('img/invalidez_total.png')}}">
        <br><strong class="py-3"> INVALIDEZ TOTAL <br> Y PERMANENTE <br>
            </strong></h6>
         <a class="btn btn-outline-light btn-sm playBenefits"
            style="background-color: #143153"
            id="showVideoButton2"
            href="#"
            onclick="playVideoBenefit('invalidezTotal')"
            >Ver video</a>
</div>
<div class="col-lg-4 py-3 text-center">
    <h6 style="color: #143153;cursor: pointer;" data-toggle="modal"
        @if (Route::currentRouteName() == 'customer.benefits')
            data-target="#modal8"
        @else
            data-target="#modal11"
        @endif
        >
        <img class="py-2"
            style="width:150px; height:150px;"
            src="{{asset('img/muerte_accidental.png')}}">
         <br><strong class="py-3"> MUERTE ACCIDENTAL
        </strong></h6>
        <a class="btn btn-outline-light btn-sm playBenefits"
              style="background-color: #143153"
              id="showVideoButton1"
              href="#"
              onclick="playVideoBenefit('muerteAccidental')"
             >Ver video</a>
</div>
<div class="col-lg-4 text-center py-3">
    <h6 style="color: #143153;cursor: pointer;" data-toggle="modal"
        @if (Route::currentRouteName() == 'customer.benefits')
            data-target="#modal8"
        @else
            data-target="#modal12"
        @endif
        >
        <img class="py-2"
        style="width:150px; height:150px;" src="{{asset('img/reembolso.png')}}">
        <br> <strong class="py-3">REEMBOLSO DE  <br> GASTOS MÉDICOS  <br>
    </strong></h6>
    <a class="btn btn-outline-light btn-sm playBenefits"
              style="background-color: #143153"
              id="showVideoButton1"
              href="#"
              onclick="playVideoBenefit('gastosMedicos')"
             >Ver video</a>
</div>

<div class="col-lg-4 offset-lg-4 py-3 text-center">
    <h6 style="color: #143153;cursor: pointer;" data-toggle="modal"
        @if (Route::currentRouteName() == 'customer.benefits')
            data-target="#modal8"
        @else
            data-target="#modal13"
        @endif
        >
        <img class="py-2"
        style="width:150px; height:150px;" src="{{asset('img/indemnización.png')}}"> <br>
        <strong class="py-3"> INDEMNIZACIÓN POR ACCIDENTE
        </strong></h6>
</div>
<p style="color: #143153;font-size: 13px;margin-bottom: 0px;">
    *Consulta términos y condiciones
</p>

{{-- Modal VIDEO HOME --}}
<div class="modal fade" id="modalVideoBenefits" tabindex="-1" role="dialog" aria-labelledby="modalVideoBenefits" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 rounded-0">
            <div class="modal-header d-flex flex-row-reverse" style="background-color: #ffffff;">
                <span class="times" data-dismiss="modal" aria-label="Close">X</span>
            </div>
            <div class="modal-body " style="background-color: #143153;padding-top: 0px;padding-bottom: 0px;">
                <div class="row">
                    <div class="div">
                        <video id="videoBenefits" class="videoInsert" controls>

                          Your browser does not support the video tag.
                          </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
