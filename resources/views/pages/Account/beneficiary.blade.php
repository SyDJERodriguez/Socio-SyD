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
                    <div class="col-5 text-center contenedorIcon">
                        <img src="{{asset('img/socioeconomico.png')}}" class="py-2 iconBene">
                    </div>
                    <div class="col-7 contenedorImg">
                        <img src="{{asset('img/mecanico-1.png')}}" class="imgBene">
                    </div>
                </div>

                <div>
                    <div class="row"
                    style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 20px;border-radius: 8px">
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
                                        <h5 class="text-white">¡Tus beneficiarios ya han sido registrados!</h5>
                                        <br>
                                        <div class="text-white">
                                            @for ($i = 0; $i < count($beneficiary); $i++)
                                                <p>Beneficiario {{$i+1}}:
                                                    {{strtoupper($beneficiary[$i]->name)}}
                                                    {{strtoupper($beneficiary[$i]->last_name)}}
                                                    {{strtoupper($beneficiary[$i]->second_last_name)}}</p>
                                            @endfor
                                        </div>
                                        <br>
                                        <h5 class="text-white">¡Recuerda agregar tu firma al certificado!</h5>
                                        <br>
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
                        {{-- SPECIAL WEEK --}}
                    @elseif( $level != 0 || (Auth::user()->created_at >= new Datetime("15-08-2021") && Auth::user()->created_at <= new Datetime("30-08-2021")) )
                            {{-- Modal BeneficiarySignUp --}}
                            <div class="modal fade" id="modalBeneficiarySignUp" tabindex="-1" role="dialog" aria-labelledby="modalBeneficiarySignUp" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content border-0 rounded-0">
                                        <div style="height: 34px;">
                                            <button type="button" class="close" style="padding: 0.1rem 1rem 0.5rem;background-color: #00A5E6;" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" class="text-white">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body " style="background-color: #143153;">
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <img src="{{asset('img/icon_check.png')}}">
                                                    <h5 class="text-white">REGISTRO DE BENEFICIARIOS</h5>
                                                    <p class="text-white">Recuerda que estas personas que des de alta, son quienes recibirán los beneficios del seguro en caso de que tú sufras algún accidente</p>
                                                    <a href="#" data-dismiss="modal" class="text-white btn btn btn-sm px-4" style="background-color: #00A5E6;">
                                                        ACEPTAR
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- call modalBeneficiarySignUp --}}
                            <script>
                                $(function() {
                                    $('#modalBeneficiarySignUp').modal('show');
                                });
                            </script>

                            <form autocomplete="off" method="POST" action="{{route('customer.benefits.add.beneficiary')}}">
                                @csrf
                                <div id="beneficiaryParent">

                                    <div class="row inputsBeneficiary" id="inputsBeneficiary">
                                        <div class="col-lg-12">
                                            <h6>BENEFICIARIO 1</h6>
                                        </div>
                                        <input type="hidden" id="branch_number1" name="branch_number[]" value="{{$data->branch_number}}">

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
                                        <input type="hidden" id="branch_number" name="branch_number[]" value="{{$data->branch_number}}">
                                        
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
                    </div>

                </div>
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
</div>
@include('includes.Account.unsuscribeEmployee')
    @stop
