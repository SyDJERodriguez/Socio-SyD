@extends('layouts.application')
@section('content')

<!--BUTTONS AND PROGRESS ARROW-->
@include('includes.options', ['active' => 1])

<div class="barra">
    <div class="row">
        @include('includes.Account.sidebarBenefits', ['active' => 3]);

        <div class="col-lg-8 pt-0 pl-5 pr-5 pb-5">
            <div class="row">
                <div class="col-6 text-center p-4">
                    <img src="{{asset('img/captch.png')}}" height="80px" alt="">
                </div>
                <div class="col-6 p-0">
                    <img src="{{asset('img/benefeciroimg.png')}}" width="100%" alt="">
                </div>
            </div>
            <form>
                <div class="row" style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 30px;border-radius: 8px;">
                    <div class="col-lg-6 py-1 offset-md-3">
                        <label for="signFile" style="text-align:right">
                            <h6>Selecciona un archivo:</h6>
                        </label>
                    </div>
                    <div class="col-lg-6 offset-md-3">
                        <input type="file"
                        id="signFile" name="ignFile"
                        accept="image/png, image/jpeg"
                        required>
                    </div>
                    <br>
                    <div class="col-lg-4 py-5 offset-md-3">
                        <label for="terms" style="text-align:right">
                            <h6>ACEPTO LOS TÉRMINOS Y CONDICIONES DEL PROGRAMA DE LEALTAD SOCIO SyD</h6>
                        </label>
                    </div>
                    <div class="col-lg-1 py-5">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="terms" 
                            style="height: 18px;width: 18px;" required>
                        </div>
                    </div>
                    <div class="col-lg-6 offset-md-1">
                        <input type="submit" class="btn btn float-right text-white px-5"
                            style="background-color: #009CE0;" value="Confirmar">
                    </div>
            </form>
           
            
        </div>
        <div class="col-lg-12 py-2">
            <div >
                <input type="submit" class="btn btn float-right text-white px-5" style="background-color: #f33f3f;"
                    value="ELIMINAR MI CUENTA">
            </div>
        </div>
    </div>
</div>
</div>

@stop
