<?php
session_start();
if((isset($_SESSION["CONTRASEÑA"]))&&($_SESSION["TIPO"]=="C")){
echo $_POST["operacion_carrito"];
echo $_POST["code_producto_carrito"];
echo $_POST["nombre_producto_carrito"];
echo $_POST["precio_producto_carrito"];
echo date('Y-m-d H:i:s');
$time = date('Y-m-d H:i:s');
$db_host="localhost";
$db_nombre="productos";
$db_usuario="root";
$db_contra="";
$conexion=mysqli_connect($db_host,$db_usuario, $db_contra, $db_nombre);
if(mysqli_connect_errno()){
	echo "Fallo al conectar con la base de datos";
 }
else{
echo "Se ha conectado correctamente la base de datos";
}
mysqli_set_charset($conexion,"utf8");


$db_host="localhost";
$db_nombre="registro";
$db_usuario="root";
$db_contra="";
$conexion2=mysqli_connect($db_host,$db_usuario, $db_contra, $db_nombre);
if(mysqli_connect_errno()){
	echo "Fallo al conectar con la base de datos";
 }
else{
echo "Se ha conectado correctamente la base de datos";
}
mysqli_set_charset($conexion2,"utf8");
$busqueda= "select * from carrito where persona = '$_SESSION[CONTRASEÑA]' AND codigo_producto='$_POST[code_producto_carrito]'";
$coincidencia =mysqli_query($conexion2, $busqueda); 
$number = mysqli_num_rows($coincidencia);
print "este es el numero".$number;
if($_POST["operacion_carrito"]=="agregar" &&($number == 0)){
$sql="INSERT INTO carrito (cantidad,codigo_producto,fecha,nombre_producto,persona,precio) values (1,'$_POST[code_producto_carrito]','$time','$_POST[nombre_producto_carrito]','$_SESSION[CONTRASEÑA]','$_POST[precio_producto_carrito]')";
$result=mysqli_query($conexion2, $sql);
if(!($result)){
echo "Ha habido un fallo al agregar al carrito avise a soporte técnico por favor";	
}
else{
	header("location:ingresa.php?paginanumeracion=1&paginanumeracion2=1");

	}
}
else {
$sql="update carrito set cantidad = cantidad + 1 where persona = '$_SESSION[CONTRASEÑA]' AND codigo_producto='$_POST[code_producto_carrito]'";	
$result=mysqli_query($conexion2, $sql);
if(!($result)){
echo "Ha habido un fallo al agregar al carrito avise a soporte técnico por favor";	
}
else{
header("location:ingresa.php?paginanumeracion=1&paginanumeracion2=1");
}
}
if($_POST["operacion_carrito"]=="quitar"){
$sql="delete from carrito where persona = '$_SESSION[CONTRASEÑA]' AND codigo_producto='$_POST[code_producto_carrito]'";	
$result=mysqli_query($conexion2, $sql);
if(!($result)){
echo "Ha habido un fallo al agregar al carrito avise a soporte técnico por favor";	
}
else{
	header("location:ingresa.php?paginanumeracion=1&paginanumeracion2=1");
}
}
}
else{
	echo "debes logearte para entrar aqui";
}
?>