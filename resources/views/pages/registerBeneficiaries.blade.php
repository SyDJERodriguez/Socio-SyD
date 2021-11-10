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
                                    {{mb_strtoupper($beneficiary[$i]->name)}}
                                    {{mb_strtoupper($beneficiary[$i]->last_name)}}
                                    {{mb_strtoupper($beneficiary[$i]->second_last_name)}}</p>
                            @endfor
                        </div>
                        <br>
                        <h5 class="text-white">¡Recuerda agregar tu firma al certificado!</h5>
                        <br>
                        <a href="{{route('sms.generate.pdf', ['client_number' => $client_number, 'branch_number' => $branch_number])}}" class="btn btn" style="background-color: #00A1E3;color: #FFF;">VER CERTIFICADO</a>
                        <p class="text-white"></p>
                    </div>
                </div>
            </div>
        @else
            <div class="card border-secondary mb-3" style="max-width: 40rem; ">
                <div class="card-header" style="background-color: #143153; color: #ffffff;">REGISTRO DE BENEFICIARIOS</div>
                <div class="card-body text-secondary">
                    @if(isset($error))
                        <div class="alert alert-danger" id="form_alert" role="alert" style="border-radius: 6px;" >
                            <strong>{{$error}}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                        </div>
                    @endif
                    <form autocomplete="off" method="POST" action="{{route('add.beneficiaries')}}">
                        @csrf
                        <div id="beneficiaryParent">

                            <div class="row inputsBeneficiary" id="inputsBeneficiary">
                                <div class="col-lg-12">
                                    <h6>BENEFICIARIO 1</h6>
                                </div>
                                <input type="hidden" id="branch_number1" name="branch_number[]" value="">

                                <div class="col-lg-6 py-2">
                                    <input type="text" class="form-control nameInput" name="name[]"  placeholder="NOMBRE"
                                           pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
                                           required maxlength="30" value="{{ isset($request) ? $request['name'][0] : null  }}">
                                </div>
                                <div class="col-lg-6 py-2">
                                    <input type="text" class="form-control nameInput" name="lastname[]" placeholder="PRIMER APELLIDO"
                                           pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
                                           required maxlength="30" value="{{ isset($request) ? $request['lastname'][0] : null  }}">
                                </div>
                                <div class="col-lg-6 py-2">
                                    <input type="text" class="form-control nameInput" name="second_lastname[]" placeholder="SEGUNDO APELLIDO"
                                           pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
                                           required maxlength="30" value="{{ isset($request) ? $request['second_lastname'][0] : null  }}">
                                </div>
                                <div class="col-lg-6 py-2">
                                    <input type="text" class="form-control nameInput" name="parent[]" placeholder="PARENTESCO"
                                           pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
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
                                           pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
                                           maxlength="30" value="{{ isset($request) ? $request['name'][1] : null  }}">
                                </div>
                                <div class="col-lg-6 py-2">
                                    <input type="text" class="form-control nameInput" name="lastname[]" placeholder="PRIMER APELLIDO"
                                           pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
                                           maxlength="30" value="{{ isset($request) ? $request['lastname'][1] : null  }}">
                                </div>
                                <div class="col-lg-6 py-2">
                                    <input type="text" class="form-control nameInput" name="second_lastname[]" placeholder="SEGUNDO APELLIDO"
                                           pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
                                           maxlength="30" value="{{ isset($request) ? $request['second_lastname'][1] : null  }}">
                                </div>
                                <div class="col-lg-6 py-2">
                                    <input type="text" class="form-control nameInput" name="parent[]" placeholder="PARENTESCO"
                                           pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"
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

                        @if(isset($email))
                            <input type="hidden" value="{{$email}}" name="email">
                        @endif

                        @if(isset($branch_number))
                            <input type="hidden" value="{{$branch_number}}" name="branch_number">
                        @endif

                        <div class="col-lg-12 py-2">
                            <input type="submit" class="btn btn float-right text-white px-5"
                                   style="background-color: #009CE0;" value="CONFIRMAR">
                        </div>
                    </form>
                </div>
            </div>
        @endif
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
