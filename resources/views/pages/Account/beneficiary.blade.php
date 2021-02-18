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
                <form id="beneficiaryForm1" method="POST" action="{{route('customer.addBeneficiary')}}">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="client_number" value="{{Auth::user()->client_number}}">
                    <input type="hidden" name="customer_id" value="{{Auth::user()->id}}">
                    <div class="row" style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 30px;border-radius: 8px;">
                        <div class="col-lg-12">
                            <h6>BENEFICIARIO 1</h6>
                        </div>

                        <div class="col-lg-6 py-2">
                            <input type="text" class="form-control" name="name"  placeholder="NOMBRE"
                            pattern="[A-Za-z].{2,}"
                            required maxlength="30">
                        </div>
                        <div class="col-lg-6 py-2">
                            <input type="text" class="form-control" name="last_name" placeholder="APELLIDOS"
                            pattern="[A-Za-z].{2,}"
                            required maxlength="30">
                        </div>
                        <div class="col-lg-6 py-2">
                            <input type="text" class="form-control" name="relationship" placeholder="PARENTESCO"
                            pattern="[A-Za-z].{2,}"
                            required maxlength="30">
                        </div>
                        <div class="col-lg-6 py-2">
                            <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">%</div>
                              </div>
                            <input type="text" class="form-control" name="percent" placeholder="PORCENTAJE DESTINADO"
                            pattern="[0-9].{1,2}"
                            required maxlength="3">
                            </div>
                        </div>
                        <div class="col-lg-6 py-2">
                            <input type="text" class="form-control" name="mobile_number" placeholder="No. TELEFÓNICO 10 DÍGITOS"
                            pattern="[0-9]{10}"
                            required  maxlength="10">
                        </div>
                        <div class="col-lg-6 py-2">
                            <input type="submit" class="btn btn float-right text-white px-5"
                                style="background-color: #009CE0;" value="Confirmar">
                        </div>
                    </form>
                    <form action="">
                        <div class="row" style="padding: 10px;border-radius: 8px;">
                        <div class="col-lg-12">
                            <h6>BENEFICIARIO 2</h6>
                        </div>

                        <div class="col-lg-6 py-2">
                            <input type="text" class="form-control" name="name"  placeholder="NOMBRE"
                            pattern="[A-Za-z].{2,}"
                            required maxlength="30">
                        </div>
                        <div class="col-lg-6 py-2">
                            <input type="text" class="form-control" name="lastname" placeholder="APELLIDOS"
                            pattern="[A-Za-z].{2,}"
                            required maxlength="30">
                        </div>
                        <div class="col-lg-6 py-2">
                            <input type="text" class="form-control" name="parent" placeholder="PARENTESCO"
                            pattern="[A-Za-z].{2,}"
                            required maxlength="30">
                        </div>
                        <div class="col-lg-6 py-2">
                            <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">%</div>
                              </div>
                            <input type="text" class="form-control" name="percent" placeholder="PORCENTAJE DESTINADO"
                            pattern="[0-9].{1,2}"
                            required maxlength="3">
                            </div>
                        </div>
                        <div class="col-lg-6 py-2">
                            <input type="text" class="form-control" name="phone" placeholder="No. TELEFÓNICO 10 DÍGITOS"
                            pattern="[0-9]{10}"
                            required  maxlength="10">
                        </div>
                        <div class="col-lg-6 py-2">
                            <input type="submit" class="btn btn float-right text-white px-5"
                                style="background-color: #009CE0;" value="Confirmar">
                        </div>
                    </div>
                </form>
                @include('includes.Account.deleteButton')
            </div>
        </div>
    </div>
</div>

    @stop
