<?php
$db_host="localhost";
$db_nombre="registro";
$db_usuario="root";
$db_contra="";
$conexion=mysqli_connect($db_host,$db_usuario, $db_contra, $db_nombre);
if(mysqli_connect_errno()){
	echo "Fallo al conectar con la base de datos";
}
else{
//echo "Se ha conectado correctamente la base de datos";
}
mysqli_set_charset($conexion,"utf8");
?>