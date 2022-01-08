<!doctype html>
<html>
<head>
<title>Socio SyD</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table id="Tabla_01" width="600" height="" border="0" cellpadding="0" cellspacing="0" align="center" style="display: block">
	<tr>
		<td colspan="3">
			<img src="https://resources.quaxar.net/SyD/Socio_SyD/Socio_SyD_17_01.jpg" width="600" height="310" alt="" border="0" style="display: block"></td>
	</tr>
	<tr>
		<td colspan="3">
			<p style="font-family: Arial; font-size: 24px; text-align: center; padding: 10px; vertical-align: middle;">
				Hola:<strong>{{ mb_strtoupper($data['name']) }}</strong><br>
				muy pronto serás <strong>SOCIO SyD</strong>®,<br>
				{{ mb_strtoupper($data['nameClient']) .' '. mb_strtoupper($data['lastNameClient'])}} <br>
				te dió de alta como colaborador
			</p>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<img src="https://resources.quaxar.net/SyD/Mailing_Socio_SyD/1121/Mailing_Socio_SyD_17_03.jpg" width="600" height="550" alt="" border="0" style="display: block"></td>
	</tr>
	<tr>
		<td colspan="3">
			<a href="{{url('invitation/'.$data['client_number'].'/'.$data['mobile_number'] )}}" >
			<img src="https://resources.quaxar.net/SyD/Mailing_Socio_SyD/1121/Mailing_Socio_SyD_17_04.jpg" width="600" height="120" alt="" border="0" style="display: block"></a></td>
	</tr>
	<tr>
		<td colspan="3">
			<a href="http://www.sociosyd.com.mx/" target="_blank">
			<img src="https://resources.quaxar.net/SyD/Mailing_Socio_SyD/1121/Mailing_Socio_SyD_17_05.jpg" width="600" height="180" alt="" border="0" style="display: block"></td>
	</tr>
	<tr>
		<td>
			<a href="http://www.sociosyd.com.mx/" target="_blank">
			<img src="https://resources.quaxar.net/SyD/Mailing_Socio_SyD/1121/Footer_1.jpg" width="220" height="48" alt="" border="0" style="display: block"></a></td>
		<td>
			<a href="https://www.facebook.com/DAR.Refaccionarias/" target="_blank">
			<img src="https://resources.quaxar.net/SyD/Mailing_Socio_SyD/1121/Footer_2.jpg" width="140" height="48" alt="" border="0" style="display: block"></a></td>
		<td>
			<a href="https://www.instagram.com/dar.refaccionarias/?hl=es" target="_blank">
			<img src="https://resources.quaxar.net/SyD/Mailing_Socio_SyD/1121/Footer_3.jpg" width="241" height="48" alt="" border="0" style="display: block"></a></td>
	</tr>
</table>
</body>
</html>