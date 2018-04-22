<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<?php
		session_start();
		@print "Usuario en sesión: ".$_SESSION["CONTRASEÑA"];
		if((isset($_SESSION["CONTRASEÑA"]))&&($_SESSION["TIPO"]=="A")){
		include "../conexion/conectar_productos.php";
		?>
			<form method="post" action="modificar_producto.php" enctype='multipart/form-data'>
				<input type="number" name="precioproducto" step="0.0001"> Precio del producto<br>
				<input type="number" name="cantidadproducto">Cantidad del producto<br>
				<textarea name="nota_producto"></textarea>Nota del producto<br>
				<input type="file" name="imagenactualizar" size="20">Imagen del producto<br>
				<input type="hidden" name="procede" value="si">
				<input type="hidden" name="codigoa" value="<?php echo $_POST['code_producto_modificar'] ?>
				">
				<input type="hidden" name="code_producto_modificar" value="<?php echo $_POST['code_producto_modificar'] ?>
				">
				<input type="text" name="importante">Información importante del producto<br>
				<input type="submit" value="Actualizar">
			</form>
			<?php
			echo "Código del producto: ".$_POST["code_producto_modificar"]."<br>";
			if(@$_POST["procede"]=="si"){
				$tamagno_archivo = $_FILES["imagenactualizar"]["size"];
				$tipo_archivo = $_FILES["imagenactualizar"]["type"];
				$nombre_archivo = $_FILES["imagenactualizar"] ["name"];
				if($tamagno_archivo <= 20000000){
					if(($tipo_archivo =="image/jpeg") || ($tipo_archivo =="image/jpg") || ($tipo_archivo =="image/png")){
						if(($_POST["precioproducto"]!="")&&($_POST["cantidadproducto"]!="")&&($_POST["nota_producto"]!="")&&
						($tamagno_archivo>0)&&($_POST["importante"]!="")){
							$codigo_producto = $_POST["codigoa"]; 
							move_uploaded_file($_FILES['imagenactualizar']['tmp_name'],'../intranet/productos/'.$nombre_archivo);
							$archivo_objetivo=fopen('../intranet/productos/'.$nombre_archivo, 'r');
							$contenido= fread($archivo_objetivo,$tamagno_archivo);
							$contenido=addslashes($contenido);
							fclose($archivo_objetivo);
							$sql ="update mercancia set precio_producto=$_POST[precioproducto], cantidad_producto=cantidad_producto+$_POST[cantidadproducto], nota_producto=$_POST[nota_producto], Imagen='$contenido', Imagen_tipo='$tipo_archivo',
							imagen_nombre='$nombre_archivo', importante='$_POST[importante]' where code_producto='$codigo_producto'";
							$result = mysqli_query($conexion,$sql);
							if(($result)){
								echo "Query exitosa";
								header("location:ingresa.php?paginanumeracion=1");
							}
						}
					    else{
							echo "Has dejado algún campo en vacío, todos los campos han de ser llenados";
						}
					}
					else{
						echo "El tipo de archivo permitido son jpg,jpeg,png";  
					}
				}
				else {
					echo "El tamaño del archivo es demasiado grande";  
				}
			}
		}		  
	    else{
			echo "Debes de Logearte para acceder a esta página";
		}
		?>
	</body>
</html>