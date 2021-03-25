<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Certificado de Seguro de Masa</title>
        <link href="css/estilos_2_2.css" rel="stylesheet" type="text/css">
        <style>
            /* CSS Document */
            header {
                padding-bottom: 0;
            }

            body {
                width: 612px;
                padding: 10px 20px;
                margin: 0 auto;
            }

            hr{
                width: 100%;
                margin: 0;
            }

            a {
                text-decoration: none;
                color: #000;
            }

            .text{
                font-family: Arial;
                font-size: 12px;
            }
            .header{
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 10%;
            }

            .logo-chubb{
                width: 100%;
                vertical-align: center;
                padding: 20px 10px;
            }
            .logo-aba{
                width: 100%;
                vertical-align: center;
                padding: 5px 10px;
            }

            .contenedor {
                width: 100%;
                display: flex;
            }
            .fecha {
                width: 60%;
                padding: 5px;
            }

            .firma {
                width: 40%;
                padding: 5px;
            }

            .page-break {
                page-break-after: always;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <div class="logo-chubb" align="left">
                <img src="{{asset('img/chubb.png')}}" width="130px" alt="CHUBB">
            </div>
            <div class="header-chubb" style="width: 100%;" align="center">
                <p class="text">Chubb Seguros México, S.A.<br>
                    Paseo de la Reforma 250 Torre Niza<br>
                    Piso 15 Col. Juárez, Del.<br>
                    Cuauhtémoc Cd. de México, C.P. 06600<br>
                    <a href="https://www.chubb.com/mx-es/" target="_blank">www.chubb.com/mx</a></p>
            </div>
            <div class="logo-aba" align="right">
                <img src="{{asset('img/aba.png')}}" width="130px" alt="ABA">
            </div>
        </div>

        <div>
            <p class="text" style="font-size: 16px; margin: 0px"><strong>CONSENTIMIENTO</strong></p>
            <p class="text" style="font-size: 14px; margin: 0px; margin: 0px 0px 20px"><strong>PÓLIZA DE SEGURO DE GRUPO</strong></p>
        </div>
        <table width="100%" align="center" border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td rowspan="2" align="center">
                    <p class="text" style="font-size: 16px"><strong>PÓLIZA</strong></p>
                </td>
                <td colspan="2">
                    <p class="text" align="left" style="padding: 2px 5px; margin: 0px"><strong>Vigencia:</strong> Del hola 12:00 horas al &nbsp 12:00 horas</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>No. de Consentimiento:</strong></p>
                </td>
                <td>
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Operación:</strong> Gastos Funerarios</p>
                </td>
            </tr>
        </table>
        <div>
            <p class="text">Por medio del presente documento otorgo mi consentimiento para ser asegurado en la Póliza de Seguro de Grupo<br>
                ________________________que el Contratante del Seguro tiene celebrada con Chubb Seguros México, S.A.</p>
        </div>
        <div>
            <p class="text" style="background-color: #ecedee; padding: 2px 5px; margin: 0px"><strong>Datos del contratante y asegurado</strong></p>
        </div>

        <table width="100%" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2">
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Contratante:</strong></p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Nombre del Asegurado: {{$customer->name.' '.$customer->last_name.' '.$customer->second_last_name}}</strong></p>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Sexo: {{$customer->gender}}</strong></p>
                </td>
                <td width="50%">
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Fecha de nacimiento: {{date_format(date_create($customer->birthday),'d-m-Y')}}</strong></p>
                </td>
            </tr>
        </table>
        <div>
            <p class="text" style="background-color: #ecedee; padding: 2px 5px; margin: 0px"><strong>Datos generales de la póliza</strong></p>
        </div>
        <table frame="void" rules="cols" width="100%" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td width="40%"></td>
                <td width="5%">
                    <p class="text" style="padding: 2px 5px; margin: 0px" align="center"><strong>Sí</strong></p>
                </td>
                <td width="5%">
                    <p class="text" style="padding: 2px 5px; margin: 0px" align="center"><strong>No</strong></p>
                </td>
                <td  rowspan="4" width="50%">
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Porcentaje:</strong></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Prestación laboral:</strong></p>
                </td>
                <td width="5%">
                    <p class="text" style="padding: 2px 5px; margin: 0px" align="center"></p>
                </td>
                <td width="5%">
                    <p class="text" style="padding: 2px 5px; margin: 0px" align="center"></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Participación en pago de primas:</strong></p>
                </td>
                <td width="5%">
                    <p class="text" style="padding: 2px 5px; margin: 0px" align="center"></p>
                </td>
                <td width="5%">
                    <p class="text" style="padding: 2px 5px; margin: 0px" align="center"></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Dividendos:</strong></p>
                </td>
                <td width="5%">
                    <p class="text" style="padding: 2px 5px; margin: 0px" align="center"></p>
                </td>
                <td width="5%">
                    <p class="text" style="padding: 2px 5px; margin: 0px" align="center"></p>
                </td>
            </tr>
        </table>
        <div>
            <p class="text" style="background-color: #ecedee; padding: 2px 5px; margin: 0px"><strong>Desglose de coberturas</strong></p>
        </div>
        <table width="100%" align="center" cellpadding="0" border="1" cellspacing="0">
            <tr>
                <td>
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Cobertura</strong></p>
                </td>
                <td>
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Suma asegurada o regla para determinarla</strong></p>
                </td>
            </tr>
            <tr>
                <td width="50%" height="100">
                    <p class="text" style="padding: 2px 5px; margin: 0px"></p>
                </td>
                <td width="50%" height="100">
                    <p class="text" style="padding: 2px 5px; margin: 0px"></p>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Coberturas adicionales</strong></p>
                </td>
                <td width="50%">
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Suma asegurada o regla para determinarla</strong></p>
                </td>
            </tr>
            <tr>
                <td width="50%" height="100">
                    <p class="text" style="padding: 2px 5px; margin: 0px"></p>
                </td>
                <td width="50%" height="100">
                    <p class="text" style="padding: 2px 5px; margin: 0px"></p>
                </td>
            </tr>
        </table>
        <div>
            <p class="text" style="background-color: #ecedee; padding: 2px 5px; margin: 0px"><strong>Designación de beneficiarios</strong></p>
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
            @foreach($beneficiary as $b)
            <tr>
                <td width="50%">
                    <p class="text" style="padding: 2px 5px; margin: 0px">{{$b->name.' '.$b->last_name.' '.$b->second_last_name}}</p>
                </td>
                <td width="15%">
                    <p class="text" style="padding: 2px 5px; margin: 0px">{{$b->relationship}}</p>
                </td>
                <td width="15%">
                    <p class="text" style="padding: 2px 5px; margin: 0px">{{$b->percent}} %</p>
                </td>
                <td width="20%">
                    <p class="text" style="padding: 2px 5px; margin: 0px"></p>
                </td>
            </tr>
                @endforeach
        </table>

        <div class="page-break"></div>

        <div class="header">
            <div class="logo-chubb" align="left">
                <img src="{{asset('img/chubb.png')}}" width="130px" alt="CHUBB">
            </div>
            <div style="width: 530px;" align="center"></div>
            <div class="logo-aba" align="right" >
                <img src="{{asset('img/aba.png')}}" width="130px" alt="ABA">
            </div>
        </div>

        <div>
            <p class="text" style="font-size: 16px; margin: 0px"><strong>CONSENTIMIENTO</strong></p>
            <p class="text" style="font-size: 14px; margin: 0px; margin: 0px 0px 20px"><strong>PÓLIZA DE SEGURO DE GRUPO</strong></p>
        </div>
        <table width="100%" align="center" border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td rowspan="2" align="center">
                    <p class="text" style="font-size: 16px"><strong>PÓLIZA</strong></p>
                </td>
                <td colspan="2">
                    <p class="text" align="left" style="padding: 2px 5px; margin: 0px"><strong>Vigencia:</strong> Del &nbsp 12:00 horas al &nbsp 12:00 horas</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>No. de Consentimiento:</strong></p>
                </td>
                <td>
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Operación:</strong> Gastos Funerarios</p>
                </td>
            </tr>
        </table>
        <div>
            <p class="text" style="background-color: #ecedee; padding: 2px 5px; margin: 5px 0px 0px"><strong>Notas</strong></p>
        </div>
        <div>
            <p class="text" style="padding: 2px 5px; margin: 0px">
                <strong>IMPORTANTE:</strong> En el caso de que se desee nombrar beneficiarios a menores de edad, no se debe señalar a un mayor de edad como representante de los menores para efecto de que, en su representación, cobre la indemnización. Lo anterior porque las legislaciones civiles previenen la forma en que debe designarse tutores, albaceas, representantes de herederos u otros cargos similares y no consideran al contrato de seguro como instrumento adecuado para tales designaciones. La designación que se hiciera de un mayor de edad como representante de menores beneficiarios, durante la minoría de edad de ellos, legalmente puede implicar que se nombra beneficiario al mayor de edad, quien en todo caso sólo tendría una obligación moral, pues la designación que se hace de beneficiarios en un contrato de seguro le concede el derecho incondicionado de disponer de la Suma Asegurada.</p>
            <hr>
            <p class="text" style="padding: 2px 5px; margin: 0px">
                El asegurado tendrá derecho a designar o cambiar libremente a los beneficiarios que haya designado, mediante notificación por escrito a la Aseguradora. En caso de no recibir dicha notificación oportunamente, la Aseguradora quedará liberada de sus obligaciones si paga con base en la designación de beneficiarios más reciente de que tenga conocimiento.</p>
            <hr>
            <p class="text" style="padding: 2px 5px; margin: 0px">
                Si sólo se hubiere designado un beneficiario y éste muriere antes o al mismo tiempo que el asegurado y no existiere designación de nuevo beneficiario, el importe del seguro se pagará a la sucesión del asegurado, salvo pacto en contrario o que hubiere renuncia del derecho de revocar la designación de beneficiarios.</p>
            <hr>
            <p class="text" style="padding: 2px 5px; margin: 0px">
                El derecho de revocar la designación del beneficiario cesará solamente cuando el asegurado haga renuncia de él y, además, la comunique al beneficiario y a la Aseguradora. La renuncia se hará constar forzosamente en la póliza y esta constancia será el único medio de prueba admisible.</p>
            <hr>
            <p class="text" style="padding: 2px 5px; margin: 0px">
                Cualquier cuestionamiento o cláusula relacionada con la selección de riesgo, solamente aplicarán para aquellos supuestos en que los Asegurados se den de alta después de los treinta (30) días de haber adquirido el derecho de formar parte de la Colectividad.</p>
            <hr>
            <p class="text" style="padding: 2px 5px; margin: 0px; font-size: 14px">
                En cumplimiento a lo dispuesto en el Artículo 202 de la Ley de Instituciones de Seguros y de Fianzas, la documentación contractual y la nota técnica que integran este producto de seguro, quedaron registradas ante la Comisión Nacional de Seguros y Fianzas, a partir del día 24 de noviembre de
                2016, con el número CNSF-S0039-0780-2016 y 26 de enero de 2018, con el número CGEN-S0039-0163-2017 / CONDUSEF-002145-03.</p>
            <hr>
            <p class="text" style="padding: 2px 5px; margin: 0px">
                Para todos los efectos legales que pueda tener este consentimiento, hago constar que las declaraciones contenidas en él,
                las he hecho personalmente y que son verídicas.</p><br><br>

        </div>
        <div class="contenedor">
            <div class="fecha" align="left" style="width: 100%">
                <p class="text">México a </p>
                <p class="text">_______________________________________</p>
                <p class="text" style=" padding: 0 80px;">Lugar y fecha</p>
            </div>
            <div style="width: 700px;"></div>
            <div class="firma" align="right" style="width: 100%">
                @if(isset($signature))
                    <img src="{{$signature->imgData}}" style="width: 100px; padding: 0 70px;" >
                @endif
                <p class="text">_______________________________________</p>
                <p class="text" style=" padding: 0 70px;">Firma del solicitante</p>
            </div>
        </div>

        <table frame="void" rules="cols" width="100%" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="3">
                    <p class="text" style="background-color: #ecedee; padding: 2px 5px; margin: 5px 0px 0px"><strong>Contacto</strong></p>
                </td>
            </tr>
            <tr>
                <td width="35%">
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Reporte de siniestro:</strong><br>
                        Cd. de México, Monterrey y Guadalajara<br>
                        Teléfono:<br>
                        Resto del país: 01800 087 4598</p>
                </td>
                <td width="35%">
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong>Servicio a clientes:</strong><br>
                        Cd. de México, Monterrey y Guadalajara<br>
                        Teléfono:<br>
                        Resto del país: 01800 223 2001</p>
                </td>
                <td width="30%">
                    <p class="text" style="padding: 2px 5px; margin: 0px"><strong><a href="https://www.chubb.com/mx-es/" target="_blank">www.chubb.com/mx</a></strong></p>
                </td>
            </tr>
        </table>
    </body>
</html>
