<?php
require('../conexion/conectar.php');
$contraseña = mysqli_real_escape_string($conexion,$_POST["ca"]);
$usuario = mysqli_real_escape_string($conexion,$_POST["usuario"]); 
$consulta = "SELECT PERSONA,CONTRASEÑA,TIPO FROM login WHERE PERSONA='$usuario'"; 
$resultado =mysqli_query($conexion,$consulta);
while($fila=mysqli_fetch_array($resultado, MYSQL_ASSOC)){
	if(($fila["PERSONA"] == $usuario) && (password_verify($contraseña, $fila["CONTRASEÑA"])) && ($fila["TIPO"] == "C")){
		echo "Te has logeado correctamente";
		session_destroy();
		session_start();
		header("location:../Ingresar/ingresa.php?paginanumeracion=1&paginanumeracion2=1");
		$_SESSION["CONTRASEÑA"] = $_POST["usuario"];
		$_SESSION["TIPO"] = $fila["TIPO"];
		echo"Entro aqui";
	}
	else if(($fila["PERSONA"] == $usuario) && (password_verify($contraseña, $fila["CONTRASEÑA"])) && ($fila["TIPO"] == "A")){
		echo "Te has logeado correctamente";
		session_destroy();
		session_start();
		header("location:../IngresarAdministrador/ingresa.php?paginanumeracion=1");
		$_SESSION["CONTRASEÑA"] = $_POST["usuario"];
		$_SESSION["TIPO"] = $fila["TIPO"];
		echo "Entro alla";	
	}
	if((!(password_verify($contraseña, $fila["CONTRASEÑA"])))&& $fila=mysqli_fetch_array($resultado, MYSQL_ASSOC)){
		echo "usuario o contraseña incorrecto";
	}
}
if(!($fila=mysqli_fetch_array($resultado, MYSQL_ASSOC))){
	echo "usuario o contraseña incorrecto ";	
}
mysqli_close($conexion);
?>