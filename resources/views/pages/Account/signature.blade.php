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
                @if ($imgData)
                <div class="row" style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 25px;border-radius: 8px;margin-right: -20%;">
                    <div class="col-lg-6 py-1 offset-md-4">
                        <img src="{{$imgData->imgData}}" id="signCustomer" alt="signatureCustomer" width="225"
                            height="190" style="display: block;">
                    </div>
                </div>
                @else
                <form method="POST" action="{{route('customer.efirm')}}">
                    @method('POST')
                    @csrf
                    <div class="row" id="contentCanvas"
                        style="border: 1px solid rgba(128, 128, 128, 0.637);padding: 10px;border-radius: 8px">
                        <div class="py-1 ">
                            <h6 style="text-align: right">DIBUJE SU FIRMA:</h6>
                            <div class="py-5 offset-md-10" >
                                <p class="btn btn-outline-dark btn-sm text-dark" id="limpiar">Limpiar</p>
                            </div>
                        </div>
                        <div class="py-1 offset-md-3">
                            <canvas id="efirm"></canvas>
                            <input type="hidden" id="imgData" name="imgData" required>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-7 py-1 offset-2">
                                <label for="terms">
                                    <h6>ACEPTO LOS TÉRMINOS Y CONDICIONES DEL PROGRAMA DE LEALTAD SOCIO SyD</h6>
                                </label>
                            </div>
                            <div class="col-1 py-1">
                                <input class="form-check-input" type="checkbox" value="" id="terms"
                                    style="height: 18px;width: 18px;" required>
                            </div>
                        </div>
                        
                        <div class="col-lg-12 py-4">
                            <input type="submit" class="btn btn text-white px-5 btn-block"
                                style="background-color: #009CE0;" 
                                id="confirmar"
                                value="FIRMAR">
                        </div>
                        <!-- <div>
                            <input type="hidden" name="googleResponseToken" id="googleResponseToken">
                        </div> -->
                    </div>
                </form>
                @endif

                @include('includes.Account.deleteButton')
            </div>
        </div>
    </div>
</div>
</div>

<script>
    document.getElementById("confirmar")
        .addEventListener("click", imgData); //click limpiar button to call imgData function

    function imgData() { //set format of canvas to pass in post as base64
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
    var cw = canvas.width = 350,
        cx = cw / 2;
    var ch = canvas.height = 190,
        cy = ch / 2;

    var dibujar = false;
    var factorDeAlisamiento = 5;
    var Trazados = [];
    var puntos = [];
    ctx.lineJoin = "round";

    limpiar.addEventListener('click', function (evt) { //clear the canvas
        dibujar = false;
        ctx.clearRect(0, 0, cw, ch);
        Trazados.length = 0;
        puntos.length = 0;
    }, false);


    canvas.addEventListener('mousedown', function (evt) { //start paint
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

    canvas.addEventListener("mousemove", function (evt) { //paint
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


    function redibujarTrazados() { //repaint 
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

    // Set up touch events for mobile, etc
    canvas.addEventListener("touchstart", function (e) {
        mousePos = getTouchPos(canvas, e);
        var touch = e.touches[0];
        var mouseEvent = new MouseEvent("mousedown", {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    }, false);
    canvas.addEventListener("touchend", function (e) {
        var mouseEvent = new MouseEvent("mouseup", {});
        canvas.dispatchEvent(mouseEvent);
    }, false);
    canvas.addEventListener("touchmove", function (e) {
        var touch = e.touches[0];
        var mouseEvent = new MouseEvent("mousemove", {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    }, false);

    // Get the position of a touch relative to the canvas
    function getTouchPos(canvasDom, touchEvent) {
        var rect = canvasDom.getBoundingClientRect();
        return {
            x: touchEvent.touches[0].clientX - rect.left,
            y: touchEvent.touches[0].clientY - rect.top
        };
    }

    // Prevent scrolling when touching the canvas
    canvas.addEventListener("touchstart", function (e) {
        if (e.target == canvas) {
            e.preventDefault();
        }
    }, false);
    canvas.addEventListener("touchend", function (e) {
        if (e.target == canvas) {
            e.preventDefault();
        }
    }, false);
    canvas.addEventListener("touchmove", function (e) {
        if (e.target == canvas) {
            e.preventDefault();
        }
    }, false);

</script>

@stop
