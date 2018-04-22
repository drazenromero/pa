<?php
if((isset($_SESSION["CONTRASEÑA"]))&&($_SESSION["TIPO"]=="C")){
	include "../conexion/conectar.php";
	mysqli_set_charset($conexion, "utf8");
	$consulta = "Select * from usuario_logeado where PERSONA='".$_SESSION["CONTRASEÑA"]."'";
	//print $consulta;
	$resultado=mysqli_query($conexion,$consulta);
	while($fila=mysqli_fetch_array($resultado)){
		$Id =$fila["PERSONA"];
		$contenido=$fila["FOTO"];
		$tipo= $fila["FOTOTIPO"];
	}
	if($tipo=="image/png"){
		echo "<img width='300' height='300' src='data:image/png; base64,". base64_encode($contenido)."'>";
	}
	if($tipo=="image/jpg"){
		echo "<img width='300' height='300' src='data:image/jpg; base64,". base64_encode($contenido)."'>";	
	}
	if($tipo=="image/jpeg"){
		echo "<img width='300' height='300' src='data:image/jpeg; base64,". base64_encode($contenido)."'>";	
	}
}
else{
	print "Debes de Logearte primero para entrar en esta página";
}
?>