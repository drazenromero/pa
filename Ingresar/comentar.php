<?php
session_start();
if((isset($_SESSION["CONTRASEÑA"]))&&($_SESSION["TIPO"]=="C")){
	include "../conexion/conectar_productos.php";
	$sql3 = "INSERT INTO comentarios (codigo_producto, comentario, fecha, nombre_producto, usuario) values ('$_POST[informacion]','$_POST[nota_producto]','$_POST[date]','$_POST[nom]','$_POST[usuario]')";
	if($resultado2 = mysqli_query($conexion,$sql3)){
		header("location:../productos/".$_POST["informacion"].".php");
	}
	else{
		echo "No se inserto correctamente el comentario";
	}
}
else{
	header("location:../index.php");
}
?>