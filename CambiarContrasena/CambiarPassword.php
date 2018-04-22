<?php
$db_host="localhost";
$db_nombre="registro";
$db_usuario="root";
$db_contra="";
$conexion=mysqli_connect($db_host,$db_usuario, $db_contra, $db_nombre);
if(mysqli_connect_errno()){
	echo "Fallo al conectar con la base de datos"."<BR>";
}
else{

}
mysqli_set_charset($conexion,"utf8");
$persona = mysqli_real_escape_string($conexion, $_POST["usuario2"]);
$consulta = "SELECT CORREO FROM login WHERE PERSONA='$persona'"; 
$resultado =mysqli_query($conexion,$consulta);
if(mysqli_num_rows($resultado)>0){
	$consulta = "SELECT CORREO FROM login WHERE PERSONA='$persona'"; 
	$resultado =mysqli_query($conexion,$consulta);
	while($fila=mysqli_fetch_array($resultado, MYSQL_ASSOC)){
		echo $fila["CORREO"]."<BR>";
		$correo = $fila["CORREO"];
		function generarCodigo($longitud, $tipo=0)
		{
			$codigo = "";
			$caracteres="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$max=strlen($caracteres)-1;
			for($i=0;$i < $longitud;$i++)
			{
				$codigo.=$caracteres[rand(0,$max)];
			}
			return $codigo;
		}
		$clave = generarCodigo(10);
		echo "$clave";
		echo utf8_decode("Un código ha sido enviado a tu correo para crear una contraseña nueva")."<BR>";	
		$destino= $correo;                                   //$correo;
		$desde = "From: Drazen";
		$asunto = "Recuperación de Contraseña";
		$mensaje = "El código es '$clave'";
		$correct = mail($destino, $asunto, $mensaje, $desde);
		if ($correct == true){
			echo "El correo ha sido enviado correctamente";
		}
		else{
			echo "Ha habido un fallo al enviar el correo";
		}
	}	
}
else {
echo "el usuario no existe";
}
?>
<html>
	<head>
		<title>RecuperarPassword</title>
		<meta charset="utf8">
	</head>
	<body>
		<form method="POST" action="recuperarcontrasena.php">
			<input type="text" name="code" value="por favor introduce el codigo aquí">
			<input type ="password" name="nv1">
			<input type ="password" name="nv2">
			<input type="submit" name="submitt">
			<input type="hidden" name="yano2" value="on">
			<input type="hidden" name="en" value="on">
			<input type="hidden" name="cr" value="<?php echo $clave ?>">
			<input type="hidden" name="use" value="<?php echo $persona ?>">
	    </form>
	</body>
</html>