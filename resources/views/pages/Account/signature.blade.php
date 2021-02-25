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
                    <div class="row"
                        style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 30px;border-radius: 8px;">
                        <div class="col-lg-6 py-1">
                            <h6 style="text-align: right">DIBUJE SU FIRMA:</h6>
                            <div class="col-lg-6 offset-md-10" style="margin-top:32%">
                                <p class="btn btn-outline-dark btn-sm text-dark" id="limpiar">Limpiar</p>
                            </div>
                        </div>
                        <div class="col-lg-6 py-1">
                            <canvas id="efirm"></canvas>
                            <input type="hidden" id="imgData" name="imgData" required>
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
                                style="background-color: #009CE0;" 
                                id="confirmar"
                                value="Confirmar">
                        </div>
                        <!-- <div>
                            <input type="hidden" name="googleResponseToken" id="googleResponseToken">
                        </div> -->
                    </div>
                </form>
                @include('includes.Account.deleteButton')
            </div>
        </div>
    </div>
</div>
</div>

<script>
    document.getElementById("confirmar")
    .addEventListener("click", imgData);//click limpiar button to call imgData function

    function imgData() {//set format of canvas to pass in post as base64
        var canvas = document.getElementById("efirm");
        $("#imgData").val(canvas.toDataURL());
    }

    /*grecaptcha.ready(function () { //call captcha api and get the token
        grecaptcha.execute('6Lcj42QaAAAAACUH7dgidlq-nEKhvz2crDWbUQJ5', { //SITE KEY
            action: 'homepage'
        }).then(function (token) {
            $('#googleResponseToken').val(token);
        });
    });*/

    var canvas = document.getElementById("efirm");
    var ctx = canvas.getContext("2d");
    var cw = canvas.width = 400,
        cx = cw / 2;
    var ch = canvas.height = 200,
        cy = ch / 2;

    var dibujar = false;
    var factorDeAlisamiento = 5;
    var Trazados = [];
    var puntos = [];
    ctx.lineJoin = "round";

    limpiar.addEventListener('click', function (evt) {//clear the canvas
        dibujar = false;
        ctx.clearRect(0, 0, cw, ch);
        Trazados.length = 0;
        puntos.length = 0;
    }, false);


    canvas.addEventListener('mousedown', function (evt) {//start paint
        dibujar = true;
        puntos.length = 0;
        ctx.beginPath();

    }, false);

    canvas.addEventListener('mouseup', function (evt) {
        redibujarTrazados();
    }, false);

    canvas.addEventListener("mouseout", function (evt) {
        redibujarTrazados();
    }, false);

    canvas.addEventListener("mousemove", function (evt) {//paint
        if (dibujar) {
            var m = oMousePos(canvas, evt);
            puntos.push(m);
            ctx.lineTo(m.x, m.y);
            ctx.stroke();
        }
    }, false);

    function reducirArray(n, elArray) { //smooth painting
        var nuevoArray = [];
        nuevoArray[0] = elArray[0];
        for (var i = 0; i < elArray.length; i++) {
            if (i % n == 0) {
                nuevoArray[nuevoArray.length] = elArray[i];
            }
        }
        nuevoArray[nuevoArray.length - 1] = elArray[elArray.length - 1];
        Trazados.push(nuevoArray);
    }

    function calcularPuntoDeControl(ry, a, b) { //bezier
        var pc = {}
        pc.x = (ry[a].x + ry[b].x) / 2;
        pc.y = (ry[a].y + ry[b].y) / 2;
        return pc;
    }

    function alisarTrazado(ry) { //smother paiting
        if (ry.length > 1) {
            var ultimoPunto = ry.length - 1;
            ctx.beginPath();
            ctx.moveTo(ry[0].x, ry[0].y);
            for (i = 1; i < ry.length - 2; i++) {
                var pc = calcularPuntoDeControl(ry, i, i + 1);
                ctx.quadraticCurveTo(ry[i].x, ry[i].y, pc.x, pc.y);
            }
            ctx.quadraticCurveTo(ry[ultimoPunto - 1].x, ry[ultimoPunto - 1].y, ry[ultimoPunto].x, ry[ultimoPunto].y);
            ctx.stroke();
        }
    }


    function redibujarTrazados() {//repaint 
        dibujar = false;
        ctx.clearRect(0, 0, cw, ch);
        reducirArray(factorDeAlisamiento, puntos);
        for (var i = 0; i < Trazados.length; i++)
            alisarTrazado(Trazados[i]);
    }

    function oMousePos(canvas, evt) {
        var ClientRect = canvas.getBoundingClientRect();
        return { //objeto
            x: Math.round(evt.clientX - ClientRect.left),
            y: Math.round(evt.clientY - ClientRect.top)
        }
    }

</script>

@stop
