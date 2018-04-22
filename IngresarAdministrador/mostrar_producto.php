<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf8">
		<style>
		#caja_mostrar{
			//height:100px;
			//width:90%;
			background-color:yellow;
		}
		</style>
	</head>
	<body>
		<?php
		session_start();
		if((isset($_SESSION["CONTRASEÑA"]))&&($_SESSION["TIPO"]=="A")){
			include "../conexion/conectar_productos.php";
			$tamaño_paginas = 2;
			$sql = "SELECT * FROM mercancia";
			mysqli_query($conexion, $sql);
			$cantidad_registros= mysqli_affected_rows($conexion);
			$total_paginas=$cantidad_registros/$tamaño_paginas;
			if($resultado = mysqli_query($conexion,$sql)){
				while ($row = mysqli_fetch_array($resultado)) {
					?>
					<table border="1" id="caja_mostrar">
						<tr> 
							<td><?php echo"producto: " .$row["nombre_producto"] ?></td> 
							<td><?php echo "codigo: ".$row["code_producto"] ?></td> 
							<td><?php echo "precio: ".$row["precio_producto"] ?></td> 
							<td> <?php   $imagen = $row["Imagen"];$nombre_imagen = $row["imagen_nombre"]; $tipo_imagen=$row["Imagen_tipo"];
								if($tipo_imagen=="image/png"){
									echo "<img width='80' height='80' src='data:image/png; base64,". base64_encode($imagen)."'>";
								}
								if($tipo_imagen=="image/jpg"){
									echo "<img width='80' height='80' src='data:image/jpg; base64,". base64_encode($imagen)."'>";	
								}
								if($tipo_imagen=="image/jpeg"){
									echo "<img width='80' height='80' src='data:image/jpeg; base64,". base64_encode($imagen)."'>";	
								} 
								?> 
							</td>
						</tr>
					</table>

				
				
			<?php
				}	
			}
			else {
				echo "Error al tratar de mostrar los registros";
			}
		}
		else{
			header("location:../index.php");
		}
		?>
	</body>
</html>