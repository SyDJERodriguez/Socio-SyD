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
                    <div class="row" style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 30px;border-radius: 8px;">
                        <div class="col-lg-12">
                            <button class="btn btn float-right text-white px-5"
                                    style="background-color: #009CE0;" id="btnAddBeneficiary">MÁS BENEFICIARIOS</button>
                        </div>


                        <form id="beneficiaryParent">
                            <div class="col-lg-12">
                                <h6>BENEFICIARIO 1</h6>
                            </div>
                            <div class="row inputsBeneficiary" id="inputsBeneficiary">
                                <div class="col-lg-12 py-2">
                                    <input type="text" class="form-control" name="name[]"  placeholder="NOMBRE"
                                           pattern="[A-Za-z].{2,}"
                                           required maxlength="30">
                                </div>
                                <div class="col-lg-6 py-2">
                                    <input type="text" class="form-control" name="lastname[]" placeholder="APELLIDOS"
                                           pattern="[A-Za-z].{2,}"
                                           required maxlength="30">
                                </div>
                                <div class="col-lg-6 py-2">
                                    <input type="text" class="form-control" name="parent[]" placeholder="PARENTESCO"
                                           pattern="[A-Za-z].{2,}"
                                           required maxlength="30">
                                </div>
                                <div class="col-lg-6 py-2">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">%</div>
                                        </div>
                                        <input type="text" class="form-control" name="percent[]" placeholder="PORCENTAJE DESTINADO"
                                               pattern="[0-9].{1,2}"
                                               required maxlength="3">
                                    </div>
                                </div>
                                <div class="col-lg-6 py-2">
                                    <input type="text" class="form-control" name="phone[]" placeholder="No. TELEFÓNICO 10 DÍGITOS"
                                           pattern="[0-9]{10}"
                                           required  maxlength="10">
                                </div>

                            </div>

                        </form>
                        <div class="col-lg-12 py-2">
                            <input type="submit" class="btn btn float-right text-white px-5"
                                   style="background-color: #009CE0;" value="CONFIRMAR">
                        </div>
                    </div>

                </div>
                @include('includes.Account.deleteButton')
            </div>

        </div>
    </div>
</div>

    @stop
