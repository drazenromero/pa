<?php
session_start();
@print $_SESSION["CONTRASEÑA"];
if((isset($_SESSION["CONTRASEÑA"]))&&($_SESSION["TIPO"]=="A")){
	include "../conexion/conectar_productos.php";
	//error_reporting(0);
	?>
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf8">
		</head>
		<body>
			<form method="post" action="Insertar_producto.php" enctype='multipart/form-data'>
				<input type="text" name="codigos" id="codigos" > Codigo Producto<br>
				<input type="text" name="nombre_producto" id="nombre_producto" > Nombre Producto<br>
				<input type="number"  name="precio_producto" step="0.0001" id="precio_producto"> Precio Producto<br>
				<input type="number" name="cantidad_producto" id="cantidad_producto"> Cantidad Producto<br>
				<textarea name="nota_producto" id="nota_producto"></textarea>Nota Producto<br>
				<input type="text" name="marca_producto" id="marca_producto"> Marca Producto<br>
				<input type="text" name="importante_producto" id="importante_producto"> Importante Producto<br>
				<input type="file" name="imagen_producto" id="imagen_producto"> Imagen Producto<br>
				<input type="submit" value="Insertar">
			</form>
			<script type="text/javascript">
				function volver(){
				    window.close();
				}
			</script>
			<input type="button" value="cerrar" onclick="volver()">
		</body>
	</html>
	<?php
	if(($_POST["codigos"]!="") && ($_POST["precio_producto"]!="") &&($_POST["cantidad_producto"]!="")){
		echo "entra";
		$tamagno_archivo = $_FILES["imagen_producto"]["size"];
		$tipo_archivo = $_FILES["imagen_producto"]["type"];
		$nombre_archivo = $_FILES["imagen_producto"] ["name"];
		$codigo_producto = mysqli_real_escape_string($conexion, $_POST["codigos"]);
		$precio_producto = mysqli_real_escape_string($conexion, $_POST["precio_producto"]);
		$cantidad_producto = mysqli_real_escape_string($conexion, $_POST["cantidad_producto"]);
		$nota_producto = mysqli_real_escape_string($conexion, $_POST["nota_producto"]);
		$nombre_producto = mysqli_real_escape_string($conexion, $_POST["nombre_producto"]);
		$marca_producto = mysqli_real_escape_string($conexion, $_POST["marca_producto"]);	
		$importante_producto = mysqli_real_escape_string($conexion, $_POST["importante_producto"]);	 	  
		if($tamagno_archivo <= 20000000){
			if(($tipo_archivo =="image/jpeg") || ($tipo_archivo =="image/jpg") || ($tipo_archivo =="image/png")){
				$sqlc="select * from mercancia where code_producto = '$codigo_producto' or nombre_producto = '$nombre_producto'";
				$resulta=mysqli_query($conexion,$sqlc);
				$number = mysqli_num_rows($resulta); 
				if($number == 0){
					move_uploaded_file($_FILES['imagen_producto']['tmp_name'],'../intranet/productos/'.$nombre_archivo);
					$archivo_objetivo=fopen('../intranet/productos/'.$nombre_archivo, 'r');
					$contenido= fread($archivo_objetivo,$tamagno_archivo);
					$contenido=addslashes($contenido);
					fclose($archivo_objetivo);
					$sql = "INSERT INTO mercancia (cantidad_producto,code_producto,Imagen,nombre_producto,nota_producto,precio_producto, Imagen_tipo,imagen_nombre,marca,importante) VALUES ('$cantidad_producto','$codigo_producto','$contenido','$nombre_producto','$nota_producto','$precio_producto','$tipo_archivo','$nombre_archivo','$marca_producto','$importante_producto')";
					mysqli_query($conexion,$sql);
					if(mysqli_affected_rows($conexion)>0){
						echo "Se ha insertado exitosamente el producto <br>"; 
						if(copy("../productos/"."ArchivoBase.php","../productos/".$codigo_producto.".php")){
							echo "El fichero se ha creado correctamente<br>"; 
						}
						else{
							echo "Ha habido un error al crear el fichero<br>";
					    }
					    ?>
					    <?php				 
					}			
					else{
						echo "No se ha podido insertar el producto <br>";  
					}
				}
				else {
					echo "El producto ya existe"; 
				}
			}
			else{
			echo "Los formatos de Imagen Permitidos son png,jpg o jpeg";
			}
        }
		else{
			echo "El archivo es demasiado grande"; 
		}
	}
}
else{
	header("location:../index.php");
}
?>
