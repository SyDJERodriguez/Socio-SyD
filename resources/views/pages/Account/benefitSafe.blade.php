@extends('layouts.application')
@section('content')

<!--BUTTONS AND PROGRESS ARROW-->
@include('includes.options', ['active' => 1])

<div class="container-fluid" style="padding-left: 3rem !important;
    padding-right: 3rem !important;">
  <div class="row">
      @include('includes.Account.sidebarBenefits', ['active' => 1])
      <div class="col-lg-8 pb-5 pr-5 pl-5">

        <div class="row">
          <div class="col-5 text-center contenedorIcon">
            <img src="{{asset('img/iconno-1.png')}}" class="py-2 iconBene">
          </div>
          <div class="col-7 contenedorImg">
              <img src="{{asset('img/mecanico-1.png')}}" class="imgBene">
          </div>
        </div>
       <!-- <form>-->
          <div class="row" style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 30px;border-radius: 8px;">
            {{-- SPECIAL WEEK --}}
            @if (Auth::user()->created_at >= new Datetime("15-08-2021") && Auth::user()->created_at <= new Datetime("30-08-2021"))
                
                {{-- Benefits icons and videos --}}
                @include('includes.Account.benefitsIcons')

            @else
                @if($level>0 || $is_cnt === 'true')
                    
                    {{-- Benefits icons and videos --}}
                    @include('includes.Account.benefitsIcons')

                @else
                        <div class="modal-body " style="background-color: #143153;">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <h5 class="text-white">¡AÚN NO TIENES DERECHO A LOS BENEFICIOS DEL SEGURO!</h5>
                                    <p class="text-white"></p>
                                </div>
                            </div>
                        </div>
                @endif
                
            @endif
          </div>
       <!-- </form>-->
          @if(Auth::user()->client_type === "3")
              <div class="row">
                  <div class="col-md-12 col-sm-6" style="display: flex; justify-content: flex-end; padding: 10px 0;">
                      <button class="btn btn-primary" style="background-color: #009CE0;" data-toggle="modal" data-target="#modalQuestion">Quiero ser independiente</button>
                  </div>
              </div>
          @endif
    </div>



  </div>
</div>
@include('includes.termsAndConditions')
@include('includes.Account.unsuscribeEmployee')

@stop
