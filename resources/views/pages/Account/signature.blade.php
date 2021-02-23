@extends('layouts.application')
@section('content')

<!--BUTTONS AND PROGRESS ARROW-->
@include('includes.options', ['active' => 1])

<div class="barra">
    <div class="container-fluid" style="padding-left: 3rem !important;
    padding-right: 3rem !important;">
        <div class="row">
            @include('includes.Account.sidebarBenefits', ['active' => 3])

            <div class="col-lg-8 pt-0 pl-5 pr-5 pb-5" style="padding-bottom: 5rem !important;">
                <div class="row">
                    <div class="col-6 text-center p-4">
                        <img src="{{asset('img/captch.png')}}" height="80px" alt="">
                    </div>
                    <div class="col-6 p-0">
                        <img src="{{asset('img/benefeciroimg.png')}}" width="100%" alt="">
                    </div>
                </div>
                <form method="POST" action="{{route('customer.efirm')}}">
                    @method('POST')
                    @csrf
                    <div class="row" style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 30px;border-radius: 8px;">
                        <div class="col-lg-6 py-1 offset-md-3">
                            
                        </div>
                        <div class="col-lg-6 offset-md-3">
                           
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
                            <input type="submit" 
                                class="btn btn float-right text-white px-5"
                                style="background-color: #009CE0;" value="Confirmar">
                        </div>
                        <div>
                            <input type="hidden" name="googleResponseToken" id="googleResponseToken">
                        </div>
                    </div>
                </form>
                @include('includes.Account.deleteButton')
            </div>
        </div>
    </div>
</div>
</div>

<script>
      
      grecaptcha.ready(function() {
        grecaptcha.execute('6Lcj42QaAAAAACUH7dgidlq-nEKhvz2crDWbUQJ5', {action: 'homepage'}).then(function(token) {
            $('#googleResponseToken').val(token);
            
        });
      });
    
</script>

@stop
