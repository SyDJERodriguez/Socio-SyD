@extends('layouts.application')
@section('content')

<!--BUTTONS AND PROGRESS ARROW-->
@include('includes.options', ['active' => 1])

<div class="barra">
    <div class="container-fluid" style="padding-left: 3rem !important;
    padding-right: 3rem !important;">
        <div class="row">
            @include('includes.Account.sidebarBenefits', ['active' => 2])

            <div class="col-lg-8 pt-0 pl-5 pr-5 pb-5">
                <div class="row">
                    <div class="col-6 text-center p-4">
                        <img src="{{asset('img/Asset8.png')}}" height="80px" alt="">
                    </div>
                    <div class="col-6 p-0">
                        <img src="{{asset('img/benefeciroimg.png')}}" width="100%" alt="">
                    </div>
                </div>
                <div>
                    <div class="row" 
                    style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 20px;border-radius: 8px;margin-right:-30px">
                        @if(isset($error))
                            <div class="alert alert-danger" id="form_alert" role="alert" style="border-radius: 6px;" >
                                <strong>{{$error}}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                            </div>
                        @endif

                    @if(isset($beneficiary))
                            <div class="modal-body " style="background-color: #143153;">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <img src="{{asset('img/icon_check.png')}}">
                                        <h5 class="text-white">¡TUS BENEFICIARIOS YA HAN SIDO REGISTRADOS!</h5>
                                        <a href="{{route('customer.myDocuments')}}" class="btn btn" style="background-color: #00A1E3;color: #FFF;">VER CERTIFICADO</a>
                                        <p class="text-white"></p>
                                    </div>
                                </div>
                            </div>
                    @elseif($level <= 0 && $is_cnt !== 'true')
                        <div class="modal-body " style="background-color: #143153;">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <h5 class="text-white">¡AÚN NO TIENES DERECHO A LOS BENEFICIOS DEL SEGURO!</h5>
                                    <p class="text-white"></p>
                                </div>
                            </div>
                        </div>
                    @else

                            <!--<div class="col-lg-12">
                                <button class="btn btn float-right text-white px-5"
                                        style="background-color: #009CE0;" id="btnAddBeneficiary">MÁS BENEFICIARIOS</button>
                            </div>-->


                            <form autocomplete="off" method="POST" action="{{route('customer.benefits.add.beneficiary')}}">
                                @csrf
                                <div id="beneficiaryParent">

                                    <div class="row inputsBeneficiary" id="inputsBeneficiary">
                                        <div class="col-lg-12">
                                            <h6>BENEFICIARIO 1</h6>
                                        </div>
                                        <div class="col-lg-6 py-2">
                                            <input type="text" class="form-control nameInput" name="name[]"  placeholder="NOMBRE"
                                                   pattern="[A-Za-z].{2,}"
                                                   required maxlength="30" value="{{ isset($request) ? $request['name'][0] : null  }}">
                                        </div>
                                        <div class="col-lg-6 py-2">
                                            <input type="text" class="form-control nameInput" name="lastname[]" placeholder="PRIMER APELLIDO"
                                                   pattern="[A-Za-z].{2,}"
                                                   required maxlength="30" value="{{ isset($request) ? $request['lastname'][0] : null  }}">
                                        </div>
                                        <div class="col-lg-6 py-2">
                                            <input type="text" class="form-control nameInput" name="second_lastname[]" placeholder="SEGUNDO APELLIDO"
                                                   pattern="[A-Za-z].{2,}"
                                                   required maxlength="30" value="{{ isset($request) ? $request['second_lastname'][0] : null  }}">
                                        </div>
                                        <div class="col-lg-6 py-2">
                                            <input type="text" class="form-control nameInput" name="parent[]" placeholder="PARENTESCO"
                                                   pattern="[A-Za-z].{2,}"
                                                   required maxlength="30" value="{{ isset($request) ? $request['parent'][0] : null  }}">
                                        </div>
                                        <div class="col-lg-6 py-2">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                                <input type="text" class="form-control mobileInput" name="percent[]" placeholder="PORCENTAJE DESTINADO"
                                                       pattern="[0-9].{1,2}"
                                                       required maxlength="3" value="{{ isset($request) ? $request['percent'][0] : null  }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 py-2">
                                            <input type="text" class="form-control mobileInput" name="phone[]" placeholder="No. TELEFÓNICO 10 DÍGITOS"
                                                   pattern="[0-9]{10}"
                                                   required  maxlength="10" value="{{ isset($request) ? $request['phone'][0] : null  }}">
                                        </div>
                                    </div>

                                    <div class="row inputsBeneficiary" id="inputsBeneficiary">
                                        <div class="col-lg-12">
                                            <h6>BENEFICIARIO 2</h6>
                                        </div>
                                        <div class="col-lg-6 py-2">
                                            <input type="text" class="form-control nameInput" name="name[]"  placeholder="NOMBRE"
                                                   pattern="[A-Za-z].{2,}"
                                                    maxlength="30" value="{{ isset($request) ? $request['name'][1] : null  }}">
                                        </div>
                                        <div class="col-lg-6 py-2">
                                            <input type="text" class="form-control nameInput" name="lastname[]" placeholder="PRIMER APELLIDO"
                                                   pattern="[A-Za-z].{2,}"
                                                    maxlength="30" value="{{ isset($request) ? $request['lastname'][1] : null  }}">
                                        </div>
                                        <div class="col-lg-6 py-2">
                                            <input type="text" class="form-control nameInput" name="second_lastname[]" placeholder="SEGUNDO APELLIDO"
                                                   pattern="[A-Za-z].{2,}"
                                                    maxlength="30" value="{{ isset($request) ? $request['second_lastname'][1] : null  }}">
                                        </div>
                                        <div class="col-lg-6 py-2">
                                            <input type="text" class="form-control nameInput" name="parent[]" placeholder="PARENTESCO"
                                                   pattern="[A-Za-z].{2,}"
                                                    maxlength="30" value="{{ isset($request) ? $request['parent'][1] : null  }}">
                                        </div>
                                        <div class="col-lg-6 py-2">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                                <input type="text" class="form-control mobileInput" name="percent[]" placeholder="PORCENTAJE DESTINADO"
                                                       pattern="[0-9].{1,2}"
                                                        maxlength="3" value="{{ isset($request) ? $request['percent'][1] : null  }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 py-2">
                                            <input type="text" class="form-control mobileInput" name="phone[]" placeholder="No. TELEFÓNICO 10 DÍGITOS"
                                                   pattern="[0-9]{10}"
                                                     maxlength="10" value="{{ isset($request) ? $request['phone'][1] : null  }}">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-12 py-2">
                                    <input type="submit" class="btn btn float-right text-white px-5"
                                           style="background-color: #009CE0;" value="CONFIRMAR">
                                </div>
                            </form>
                    @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

    @stop
