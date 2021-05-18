<!doctype html>
<html>

<head>
    <title>Socio SyD</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table id="Tabla_01" width="600" height="" border="0" cellpadding="0" cellspacing="0" align="center"
        style="display: block">
        <tr>
            <td colspan="3">
                <img src="https://resources.quaxar.net/SyD/Socio_SyD/email-16_01.jpg" width="600" height="309" alt=""
                    border="0" style="display: block">
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <p
                    style="font-family: Arial; font-size: 24px; text-align: center; padding: 10px; vertical-align: middle;">
                    Hola:<strong>{{ strtoupper($data['name']) }}</strong><br>
                    muy pronto serás <strong>SOCIO SyD</strong>®,<br>
                    {{ strtoupper($data['nameClient']) .' '. strtoupper($data['lastNameClient'])}} <br>
                    te dió de alta como beneficiario
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <img src="https://resources.quaxar.net/SyD/Socio_SyD/email-16_03.jpg" width="600" height="565" alt=""
                    border="0" style="display: block">
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <a href="{{url('invitation/'.$data['client_number'].'/'.$data['mobile_number'] )}}" >
                    <img src="https://resources.quaxar.net/SyD/Socio_SyD/email-16_04.jpg" width="600" height="90" alt=""
                        border="0" style="display: block"></a>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <a href="https://www.syd.com.mx/" target="_blank">
                    <img src="https://resources.quaxar.net/SyD/Socio_SyD/email-16_05.jpg" width="600" height="192"
                        alt="" border="0" style="display: block"></a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="https://sociosyd.com/" target="_blank">
                    <img src="https://resources.quaxar.net/SyD/Socio_SyD/email-footer_01.jpg" width="225" height="49"
                        alt="" border="0" style="display: block"></a></td>
            <td>
                <a href="https://www.facebook.com/SyDMexico/" target="_blank">
                    <img src="https://resources.quaxar.net/SyD/Socio_SyD/email-footer_02.jpg" width="125" height="49"
                        alt="" border="0" style="display: block"></a></td>
            <td>
                <a href="https://www.instagram.com/syd.mexico/" target="_blank">
                    <img src="https://resources.quaxar.net/SyD/Socio_SyD/email-footer_03.jpg" width="250" height="49"
                        alt="" border="0" style="display: block"></a></td>
        </tr>
    </table>
</body>

</html>
