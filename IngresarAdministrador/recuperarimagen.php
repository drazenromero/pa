<?php
if((isset($_SESSION["CONTRASEÑA"])) &&($_SESSION["TIPO"]=="A")){
	include "../conexion/conectar.php";
	$consulta = "Select * from usuario_logeado where PERSONA='".$_SESSION["CONTRASEÑA"]."'";
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
	header("location:../index.php");
}
?>