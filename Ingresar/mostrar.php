<?php 
session_start();
if((isset($_SESSION["CONTRASEÑA"]))&&($_SESSION["TIPO"]=="C")){
?>
	<!DOCTYPE html>
	<html>
		<head><title></title>
			<meta charset="utf8">
		</head>
		<body>
			<div height="300" id="frame1">
				<?php
				include "../conexion/conectar_productos.php";
				$sql = "SELECT * FROM mercancia where nombre_producto like '%$_GET[buscar_producto_nombre]%'";
				mysqli_query($conexion, $sql);
				$cantidad_registros= mysqli_affected_rows($conexion);
				print"Número de coincidencias: ".$cantidad_registros;
				//Aqui se configura la cantidad de elementos que se van a ver
				$tamaño_paginas = 2;
				$total_paginas=$cantidad_registros/$tamaño_paginas;
				$total_paginas_redondeado = ceil($total_paginas);
				if(($total_paginas_redondeado > $total_paginas)&&($total_paginas_redondeado > 1)){
					$total_paginas_redondeado = $total_paginas_redondeado - 1;
				}
				if(($total_paginas_redondeado <= 1)){
					$total_paginas_redondeado = 1;
				}
				if($total_paginas_redondeado < $total_paginas){
					$total_paginas_redondeado = $total_paginas_redondeado + 1;
				}
				if($total_paginas_redondeado == $total_paginas){
					$total_paginas_redondeado = $total_paginas_redondeado;
				}
				if(!(isset($_GET["paginanumeracion3"])))
				{
					$pagina_mostrar = 1; 
					echo $pagina_mostrar;
				   
				} 
				elseif ($_GET["paginanumeracion3"] >= $total_paginas_redondeado) {
					$pagina_mostrar = $total_paginas_redondeado;
				 
				}
				elseif ($_GET["paginanumeracion3"] <= 1) {
					$pagina_mostrar = 1;
				 
				}
				else{
					$pagina_mostrar=$_GET["paginanumeracion3"];
				}
				$to =  ($pagina_mostrar*$tamaño_paginas)-$tamaño_paginas;
				$sql2 = "SELECT * FROM mercancia where nombre_producto like '%$_GET[buscar_producto_nombre]%' limit $to,$tamaño_paginas";
				mysqli_query($conexion, $sql2);
				if($resultado = mysqli_query($conexion,$sql2)){
					while ($row = mysqli_fetch_array($resultado)) {
					?>
						<a>
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
										} ?> 
									</td>
									<td>
										<form method="POST" action="carrito.php">
											<input type="hidden" name="code_producto_carrito" id="code_producto_carrito" value="<?php echo $row["code_producto"]; ?>">
											<input type="submit" name="agregar_carrito" id="agregar_carrito" value="quitar">
											<input type="hidden" name="operacion_carrito" id="operacion_carrito" value="quitar" onclick="myFunction()">
											<input type="hidden" name="nombre_producto_carrito" id="nombre_producto_carrito" value="<?php echo $row["nombre_producto"]; ?>">
											 <input type="hidden" name="precio_producto_carrito" id="precio_producto_carrito" value="<?php echo $row["precio_producto"]; ?>">
										</form>
										<form method="POST" action="carrito.php">
											<input type="submit" name="agregar_carrito" id="agregar_carrito" value="agregar">
											<input type="hidden" name="precio_producto_carrito" id="precio_producto_carrito" value="<?php echo $row["precio_producto"]; ?>">
											<input type="hidden" name="precio_producto_carrito" id="precio_producto_carrito" value="<?php echo $row["precio_producto"]; ?>">
											<input type="hidden" name="code_producto_carrito" id="code_producto_carrito" value="<?php echo $row["code_producto"]; ?>">
											<input type="hidden" name="operacion_carrito" id="operacion_carrito" value="agregar" onclick="myFunction()">
											<input type="hidden" name="nombre_producto_carrito" id="nombre_producto_carrito" value="<?php echo $row["nombre_producto"]; ?>">
										</form>
									</td>
								</tr>
							</table>
						</a>
				<?php 
					}	
				}
				?>
				<form action="mostrar.php" method="GET">
					<input type="submit" value="siguiente">
					<input type="hidden" value="<?php  echo $_GET["buscar_producto_nombre"]?>" name="buscar_producto_nombre">
					<input type="hidden" name="paginanumeracion3" value="<?php 
						if($pagina_mostrar <= $total_paginas_redondeado -1){
							$pagina_anterior = $_GET["paginanumeracion3"] + 1; 
							echo $pagina_anterior;
						}
						else{
							$pagina_anterior = $total_paginas_redondeado;  
							echo $pagina_anterior;
						}
					?>">
				</form>
				<form action="mostrar.php" method="GET">
					<input type="submit" value="anterior">
					<input type="hidden" value="<?php  echo $_GET["buscar_producto_nombre"]  ?>" name="buscar_producto_nombre">
					<input type="hidden" name="paginanumeracion3" value="<?php 
						if($pagina_mostrar > 1){
							$pagina_anterior = $_GET["paginanumeracion3"] - 1; 
							echo $pagina_anterior;
						}
						else{
						$pagina_anterior = 1;  
						echo $pagina_anterior;
						}
					?>">
				</form>
				<form action="mostrar.php" method="GET">
					<input type="hidden" value="<?php  echo $_GET["buscar_producto_nombre"]  ?>" name="buscar_producto_nombre">
					<input type="number" name="paginair" value="<?php echo $_GET["paginair"] ?>">
					<input type="hidden" value="<?php echo $_GET["paginanumeracion32"] ?>" name="paginanumeracion32">
					<input type="submit" value="Ir a">
				</form>
				<p>página <?php echo$pagina_mostrar ?>/<?php echo $total_paginas_redondeado; ?></p>
		    </div>
		</body>
    </html>
	 <?php
}
else {
	echo "Debes logearte para poder entrar aquí";
}
?>
