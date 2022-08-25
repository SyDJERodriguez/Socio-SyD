<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Consentimiento Póliza de Seguro</title>

    <style>
        /* CSS Document */
        header {
        	/* padding-bottom: 0px; */
        }
        body {
        	width: 612px;
        	padding: 10px 20px;
        	margin: 0 auto;
        }
        hr{
        	width: 100%;
        	margin: 0px;
        }

        a {
        	text-decoration: none;
        	color: #000;
        }

        .text{
        	font-family: Arial;
        	font-size: 12px;
        }
        .monto{
        	padding: 0px;
        	margin: 0px;
        }
        .header{
        	width: 100%;
        	align-content: center;
        	display: flex;
        }
        .header-chubb{
	        width: 40%;
            top: 0px;
	        padding: 0 40px 30px 100px;
	        margin: 0px auto;
            height: 50px;
        }
        div.logo-chubb img{
        	width: 25%;
        	padding: 0 10px;
        	vertical-align: top;
        }
        .logo-aba{
        	width: 90%;
        	padding: 0 10px;
        	vertical-align: top;
        }

        .contenedor {
        	width: 100%;
        	display: flex;
            justify-content: space-around;
        }

        .firma {
        	width: 30%;

        }
        td.borderRight{
            border-right: 1px solid #808080;
        }
        /* td.borderSolid{
            border: 1px solid black
        } */
        table.tablita {
            border: 1px solid black;
        }
        .page-break{
            page-break-after: always;
        }
        .fix-bot {
            position:fixed;
            bottom:50px;
            left:50px;
            right:50px;
        }

        .container{
            display: flex;
            flex-direction: row-reverse;
        }

        .item{
            height:40px;

        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo-chubb" align="left" style="position: absolute;top: 6px;">
            <img src="{{asset('img/chubb.png')}}" alt="CHUBB" style="position: relative;padding-left: 0px;">
        </div>
        <div class="header-chubb">
            <p class="text" style="margin-top: 0px;">Chubb Seguros México, S.A.<br>
                Paseo de la Reforma 250 Torre Niza<br>
                Piso 15 Col. Juárez, Del. Cuauhtémoc<br>
                Cd. de México, C.P. 06600<br>
                <a href="https://www.chubb.com/mx-es/" target="_blank" style="color: blue;">
                    www.chubb.com/mx
                </a></p>
        </div>
        <div class="logo-aba" align="right" style="position: absolute;top: 0px;padding-right: 0px;">
            <img src="{{asset('img/aba.png')}}" alt="ABA" style="position: relative; width: 200px;">
        </div>
    </div>

    <div>
        <p class="text" style="font-size: 16px; margin: 0px"><strong>CONSENTIMIENTO</strong></p>
        <p class="text" style="font-size: 14px; margin: 0px; margin: 0px 0px 20px"><strong>PÓLIZA DE SEGURO </strong>
        </p>
    </div>
    <table width="100%" align="center" border="1" cellpadding="0" cellspacing="0">
        <tr>
            <td rowspan="2" align="center">
                <p class="text" style="font-size: 16px"><strong>PÓLIZA: 70912</strong></p>
            </td>
            <td colspan="2">
                <p class="text" align="left" style="padding: 2px 5px; margin: 0px">
				    <strong>Vigencia:</strong> Del
                    {{date_format(date_create($initDate),'d-m-Y')}}
                    12:00 horas al
                    {{date_format(date_create($finDate),'d-m-Y')}}
                    12:00 horas
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="text" style="padding: 2px 5px; margin: 0px"><strong>No. de Consentimiento:</strong></p>
            </td>
            <td>
                <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Operación:</strong> Producto Paquete</p>
            </td>
        </tr>
    </table>
    <div>
        <p class="text">Por medio del presente documento otorgo mi consentimiento para ser asegurado en la Póliza de
            Seguro Colectivo<br>
            <u>58828</u> que el Contratante del Seguro tiene celebrada con Chubb Seguros México, S.A.</p>
    </div>
    <div>
        <p class="text" style="background-color: #ecedee; padding: 2px 5px; margin: 0px"><strong>Datos del contratante y
                asegurado</strong></p>
    </div>

    <table width="100%" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="2">
                <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Contratante: PLAN DE LEALTAD SYD, S.A DE
                        C.V</strong></p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Nombre del Asegurado:
                    {{$customer->name.' '.$customer->last_name.' '.$customer->second_last_name}}</strong></p>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <p class="text" style="padding: 2px 5px; margin: 0px">
                    <strong>Sexo: {{$customer->gender}}</strong></p>
            </td>
            <td width="50%">
                <p class="text" style="padding: 2px 5px; margin: 0px">
                    <strong>Fecha de nacimiento:
                    {{date_format(date_create($customer->birthday),'d-m-Y')}}</strong></p>
            </td>
        </tr>
    </table>
    <div>
        <p class="text" style="background-color: #ecedee; padding: 2px 5px; margin: 0px"><strong>Datos generales de la
                póliza</strong></p>
    </div>
    <table frame="void" width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr >
            <td width="40%" class="borderRight"></td>
            <td width="5%" class="borderRight">
                <p class="text" style="padding: 2px 5px; margin: 0px" align="center"><strong>Sí</strong></p>
            </td>
            <td width="5%" class="borderRight" style="border-right: 1px solid #808080;">
                <p class="text" style="padding: 2px 5px; margin: 0px" align="center"><strong>No</strong></p>
            </td>
            {{-- empty --}}
            <td>
                <p class="text" style="padding: 2px 5px; margin: 0px"></p>
            </td>
            <!-- <td  rowspan="4" width="50%">
		<p class="text" style="padding: 2px 5px; margin: 0px"><strong>Porcentaje:</strong> N/A</p>
			</td> -->
        </tr>
        <tr>
            <td style="border-top: 1px solid #808080;" class="borderRight">
                <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Prestación laboral:</strong></p>
            </td>
            <td width="5%" style="border-top: 1px solid #808080;" class="borderRight">
                <!--no-->
                <p class="text" style="padding: 2px 5px; margin: 0px" align="center"></p>
            </td>
            <!--si-->
            <td width="5%" style="border-top: 1px solid #808080;" class="borderRight">
                <p class="text" style="padding: 2px 5px; margin: 0px" align="center">X</p>
            </td>
             {{-- empty --}}
             <td>
                <p class="text" style="padding: 2px 5px; margin: 0px"></p>
            </td>
        </tr>
        <tr>
            <td class="borderRight">
                <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Participación en pago de primas:</strong>
                </p>
            </td>
            <td width="5%" class="borderRight">
                <!--no-->
                <p class="text" style="padding: 2px 5px; margin: 0px" ></p>
            </td>
            <!--si-->
            <td width="5%" class="borderRight">
                <p class="text" style="padding: 2px 5px; margin: 0px" align="center"></p>
            </td>
             <td>
                <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Porcentaje:</strong> N/A</p>
            </td>
        </tr>
        <tr>
            <td class="borderRight">
                <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Dividendos:</strong></p>
            </td>
            <td width="5%" class="borderRight">
                <!--no-->
                <p class="text" style="padding: 2px 5px; margin: 0px" align="center"></p>
            </td>
            <!--si-->
            <td width="5%" class="borderRight">
                <p class="text" style="padding: 2px 5px; margin: 0px" align="center">X</p>
            </td>
             {{-- empty --}}
             <td>
                <p class="text" style="padding: 2px 5px; margin: 0px"></p>
            </td>
        </tr>
    </table>
    <div>
        <p class="text" style="background-color: #ecedee; padding: 2px 5px; margin: 0px"><strong>Desglose de
                coberturas</strong></p>
    </div>
    <div style="padding-right: 13px; margin: 0 0 0 -3px;">

        <table width="99%" align="center" cellpadding="0" border="1" cellspacing="0">
            <tr>
                <td  width="50" >
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Cobertura</strong></p>
                </td>
                <td  width="50" style="padding-right: 25px;">
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Suma asegurada o regla para
                            determinarla</strong></p>
                </td>
            </tr>
            <tr>
                <!--Cobertura-->
                <td width="50" style="padding: 10px 0px;">
                    <p class="text" style="padding: 2px 5px; margin: 0px">Muerte Accidental</p>
                </td>
                <!--Suma asegurada-->
                <td width="50" style="padding: 10px 0px;">
                    <p class="text" style="padding: 2px 5px; margin: 0px">$50,000.00 m.n.</p>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Coberturas adicionales</strong></p>
                </td>
                <td width="50%">
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Suma asegurada o regla para
                            determinarla</strong></p>
                </td>
            </tr>
            <tr>
                <!--Coberturas adicionales-->
                <td width="50%" style="padding: 10px 0px;">
                    <table>
                        <tr>
                            <td>
                                <p class="text monto">Pérdidas orgánicas (Escala B)</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text monto">Invalidez Total y Permanente por Accidente</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text monto">Reembolso de gastos médicos por accidente</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text monto">Deducible de Gastos Médicos</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text monto">Renta diaria por hospitalización por accidente</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text monto">Período de beneficio (Hasta)</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text monto">Deducible de Hospitalización</p>
                            </td>
                        </tr>
                    </table>
                </td>
                <!--Suma asegurada-->
                <td width="50%">
                    <table >
                        <tr>
                            <td>
                                <p class="text monto">$50,000.00</p>
                            </td>
                            <td>
                                <p class="text monto">m.n</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text monto">$50,000.00</p>
                            </td>
                            <td>
                                <p class="text monto">m.n.</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text monto">$10,000.00</p>
                            </td>
                            <td>
                                <p class="text monto">m.n.</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text monto">-</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text monto">$
                                    <span style="padding-left: 14px;">300.00</span>
                                </p>
                            </td>
                            <td>
                                <p class="text monto">m.n.</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text monto" style="text-align:right;">20</p>
                            </td>
                            <td>
                                <p class="text monto">días</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text monto" style="text-align:right;">1</p>
                            </td>
                            <td>
                                <p class="text monto">día</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div>
        <p class="text" style="background-color: #ecedee; padding: 2px 5px; margin: 0px"><strong>Designación de
                beneficiarios</strong></p>
    </div>
    <table width="100%" align="center" cellpadding="0" border="1" cellspacing="0">
        <tr>
            <td width="50%">
                <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Nombre del beneficiario</strong></p>
            </td>
            <td width="15%">
                <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Parentesco</strong></p>
            </td>
            <td width="15%">
                <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Porcentaje</strong></p>
            </td>
            <td width="20%">
                <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Irrevocable (Sí/No)</strong></p>
            </td>
        </tr>
        @foreach ($beneficiary as $b)
        <tr>
            <!--Nombre beneficiario-->
            <td width="50%" style="padding: 10px 0px;">
                <p class="text" style="padding: 2px 5px; margin: 0px">
                    {{$b->name.' '.$b->last_name.' '.$b->second_last_name}}
                </p>
            </td>
            <!--Parentesco-->
            <td width="15%" style="padding: 10px 0px;">
                <p class="text" style="padding: 2px 5px; margin: 0px">
                    {{$b->relationship}}
                </p>
            </td>
            <!--Porcentaje-->
            <td width="15%" style="padding: 10px 0px;">
                <p class="text" style="padding: 2px 5px; margin: 0px">
                    {{$b->percent}} %
                </p>
            </td>
            <!--Irrevocable-->
            <td width="20%" style="padding: 10px 0px;">
                <p class="text" style="padding: 2px 5px; margin: 0px">
                </p>
            </td>
        </tr>
        @endforeach
    </table>

    {{-- <p class="text" style="padding: 20px 5px; margin: 0px; text-align: right">Pagina 1 de 2</p> --}}

    <div class="page-break"></div>

    <div class="header">
        <div class="logo-chubb" align="left" style="top: 6px;">
            <img src="{{asset('img/chubb.png')}}" alt="CHUBB" style="position: relative;padding-left: 0px;">
        </div>
        <div class="logo-aba" align="right" style="position: absolute;top: 0px;padding-right: 0px;">
            <img src="{{asset('img/aba.png')}}" width="160px" alt="ABA" style="position: relative; width: 200px;">
        </div>
    </div>

    <br><br>
    <div>
        <p class="text" style="font-size: 16px; margin: 0px"><strong>CONSENTIMIENTO</strong></p>
        <p class="text" style="font-size: 14px; margin: 0px; margin: 0px 0px 20px"><strong>PÓLIZA DE SEGURO
                COLECTIVO</strong></p>
    </div>
    <table width="100%" align="center" border="1" cellpadding="0" cellspacing="0">
        <tr>
            <td rowspan="2" align="center">
                <p class="text" style="font-size: 16px"><strong>PÓLIZA: 70912</strong></p>
            </td>
            <td colspan="2">
                <p class="text" align="left" style="padding: 2px 5px; margin: 0px">
				    <strong>Vigencia:</strong> Del
                    {{date_format(date_create($initDate),'d-m-Y')}}
                    12:00 horas al
                    {{date_format(date_create($finDate),'d-m-Y')}}
                    12:00 horas
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="text" style="padding: 2px 5px; margin: 0px"><strong>No. de Consentimiento:</strong></p>
            </td>
            <td>
                <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Operación:</strong> Producto Paquete</p>
            </td>
        </tr>
    </table>
    <div>
        <p class="text" style="background-color: #ecedee; padding: 2px 5px; margin: 5px 0px 0px"><strong>Notas</strong>
        </p>
    </div>
    <div>
        <p class="text" style="padding: 2px 5px; margin: 0px">
            <strong>IMPORTANTE:</strong> En el caso de que se desee nombrar beneficiarios a menores de edad, no se debe
            señalar a un mayor de edad como representante de los menores para efecto de que, en su representación, cobre
            la indemnización. Lo anterior porque las legislaciones civiles previenen la forma en que debe designarse
            tutores, albaceas, representantes de herederos u otros cargos similares y no consideran al contrato de
            seguro como instrumento adecuado para tales designaciones. La designación que se hiciera de un mayor de edad
            como representante de menores beneficiarios, durante la minoría de edad de ellos, legalmente puede implicar
            que se nombra beneficiario al mayor de edad, quien en todo caso sólo tendría una obligación moral, pues la
            designación que se hace de beneficiarios en un contrato de seguro le concede el derecho incondicionado de
            disponer de la Suma Asegurada.
        </p>
        <hr>
        <p class="text" style="padding: 2px 5px; margin: 0px">
            El asegurado tendrá derecho a designar o cambiar libremente a los beneficiarios que haya designado, mediante
            notificación por escrito a la Aseguradora. En caso de no recibir dicha notificación oportunamente, la
            Aseguradora quedará liberada de sus obligaciones si paga con base en la designación de beneficiarios más
            reciente de que tenga conocimiento.</p>
        <hr>
        <p class="text" style="padding: 2px 5px; margin: 0px">
            Si sólo se hubiere designado un beneficiario y éste muriere antes o al mismo tiempo que el asegurado y no
            existiere designación de nuevo beneficiario, el importe del seguro se pagará a la sucesión del asegurado,
            salvo pacto en contrario o que hubiere renuncia del derecho de revocar la designación de beneficiarios.</p>
        <hr>
        <p class="text" style="padding: 2px 5px; margin: 0px">
            El derecho de revocar la designación del beneficiario cesará solamente cuando el asegurado haga renuncia de
            él y, además, la comunique al beneficiario y a la Aseguradora. La renuncia se hará constar forzosamente en
            la póliza y esta constancia será el único medio de prueba admisible.</p>
        <hr>
        <p class="text" style="padding: 2px 5px; margin: 0px">
            Cualquier cuestionamiento o cláusula relacionada con la selección de riesgo, solamente aplicarán para
            aquellos supuestos en que los Asegurados se den de alta después de los treinta (30) días de haber adquirido
            el derecho de formar parte de la Colectividad.</p>
        <hr>
        <p class="text" style="padding: 2px 5px; margin: 0px; font-size: 14px">
            En cumplimiento a lo dispuesto en el Artículo 202 de la Ley de Instituciones de Seguros y de Fianzas, la
            documentación contractual y la nota técnica que integran este producto de seguro, quedaron registradas ante
            la Comisión Nacional de Seguros y Fianzas, a partir del día 13 de junio de 2016, con el número
            PPAQ-S0039-0036-2016 y 21 de febrero de 2018, con el número MODI-S0039-0071-2017 / CONDUSEF-002024-04.</p>
        <hr>
        <p class="text" style="padding: 5px 5px; margin: 0px">
            Para todos los efectos legales que pueda tener este consentimiento, hago constar que las declaraciones
            contenidas en él, las he hecho personalmente y que son verídicas.</p><br><br>

    </div>

    <div class="container">
            <div class="item">
                    <p class="text">México a {{$currentDate->isoFormat('dddd D MMMM YYYY')}}</p>
                <p class="text">_______________________________________</p>
                    <p class="text">Lugar y fecha</p>
            </div>

            <div class="item" align="right" style="position:absolute; top: 658px;; left:415px ;" >
                @if(isset($signature))
                    <img src="{{$signature->imgData}}" style="width: 100px; padding: 0px 70px;" >
                    <p class="text">_______________________________________</p>
                    <p class="text">Firma del solicitante</p>
                @else
                    <p class="text">_______________________________________</p>
                    <p class="text">Firma del solicitante</p>
                @endif
            </div>

	</div>

    <div class="fix-bot">
        <footer>

            <table border="1" bordercolor="#A0A0A0" width="100%" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td colspan="3">
                        <p class="text" style="background-color: #ecedee; padding: 2px 5px; margin: 0px 0px">
                            <strong>Contacto</strong></p>
                    </td>
                </tr>
                <tr>
                    <td width="35%">
                        <p class="text" style="padding: 2px 5px; margin: 0px; font-size: 11px;"><strong>Reporte de
                                siniestro:</strong><br>
                            Cd. de México, Monterrey y Guadalajara<br>
                            Teléfono:<br>
                            Resto del país: <a href="tel:8000874598" target="_blank">01 800 087 4598</a></p>
                    </td>
                    <td width="35%">
                        <p class="text" style="padding: 2px 5px; margin: 0px;font-size: 11px;"><strong>Servicio a
                                clientes:</strong><br>
                            Cd. de México, Monterrey y Guadalajara<br>
                            Teléfono:<br>
                            Resto del país: <a href="tel:8002232001" target="_blank">01 800 223 2001</a></p>
                    </td>
                    <td width="30%">
                        <p class="text" style="padding: 2px 5px; margin: 0px;"><strong>
                                <a href="https://www.chubb.com/mx-es/" target="_blank"
                                    style="color: blue;">www.chubb.com/mx</a></strong>
                        </p>
                    </td>
                </tr>
            </table>
        </footer>
     </div>

    {{-- <p class="text" style="padding: 20px 5px; margin: 0px; text-align: right">Pagina 2 de 2</p> --}}
</body>

</html>
