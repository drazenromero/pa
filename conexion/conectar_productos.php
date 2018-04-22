<?php
$db_host="localhost";
$db_nombre="productos";
$db_usuario="root";
$db_contra="";
$conexion=mysqli_connect($db_host,$db_usuario, $db_contra, $db_nombre);
if(mysqli_connect_errno()){
	echo "Fallo al conectar con la base de datos";
}
else{

}
mysqli_set_charset($conexion,"utf8");
?>