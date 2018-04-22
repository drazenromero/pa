<?php
session_start();
if((isset($_SESSION["CONTRASEÑA"]))&&($_SESSION["TIPO"]=="C")){
	$nombre_archivo = $_FILES["imagensubir"] ["name"];
	$tipo_archivo = $_FILES["imagensubir"]["type"];
	$tamagno_archivo= $_FILES["imagensubir"] ["size"];
	if($tamagno_archivo <= 10000000){
		if(($tipo_archivo =="image/jpeg") || ($tipo_archivo =="image/jpg") || ($tipo_archivo =="image/png") ){
			include "../conexion/conectar.php";
			$carpeta_destino=$_SERVER['DOCUMENT_ROOT'].'/intranet/uploads';
			move_uploaded_file($_FILES['imagensubir']['tmp_name'],'../intranet/subira/'.$nombre_archivo);
			$archivo_objetivo=fopen('../intranet/subira/'.$nombre_archivo, 'r');
			$contenido= fread($archivo_objetivo,$tamagno_archivo);
			$contenido=addslashes($contenido);
			fclose($archivo_objetivo);
			$usuarioafoto=$_SESSION["CONTRASEÑA"];
			$sql='delete from usuario_logeado where PERSONA="'.$usuarioafoto.'"';
			$sql2='insert into usuario_logeado (FOTO, PERSONA, FOTOTIPO, FOTONOMBRE) VALUES ("'.$contenido.'","'.$usuarioafoto.'","'.$tipo_archivo.'","'.$nombre_archivo.'")';
			echo $sql."<br>";
			mysqli_query($conexion,$sql);
			if(mysqli_affected_rows($conexion)>0){
				echo "Se ha entrado correctamente al delete"."<br>";
				mysqli_query($conexion,$sql2);
				if(mysqli_affected_rows($conexion)>0){
					echo "Se ha ejecutado correctamente el insert";
					header("location:ingresa.php?paginanumeracion=1&paginanumeracion2=1");	
				}
				else{
					echo "No se ha ejecutado correctamente el insert";
				}
			} 
			else {
				echo "No se ha ejecutado correctamente el delete";
			}
		}
		else{
			echo "solo se permiten imagenes de tipo png, jpeg o jpg ";
		}
	}
	else{
		echo "La imagen es demasiado grande para subirla tamaño maximo permitido 10mb";
	}
}
else{
	echo "Debes logearte para entrar en esta página";
}
?>