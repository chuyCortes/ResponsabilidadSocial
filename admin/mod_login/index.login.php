<form action="index.php" method="POST">
	<br />
	<table cellspacing="2" cellpadding="4" border="0" width="250" align="center">
		<tr>
			<th class="enc" colspan="2">Acceso al Sistema:</th>
		</tr>
		<tr>
			<th>Usuario:</th>
			<td><input type="text" name="login_us_form" value="<?php echo $_POST["login_us_form"]; ?>" size="20" /></td>
		</tr>
		<tr>
			<th>Contraseña:</th>
			<td><input type="password" name="password_us_form" value="<?php echo $_POST["password_us_form"]; ?>" size="20" /></td>
		</tr>
	</table>
	<p align="center"><input type="submit" name="einfo_us_evarios" value="Entrar" /></p>
</form>