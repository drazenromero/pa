<?php
session_start();
@print $_SESSION["CONTRASEÑA"]."<br>";
if((isset($_SESSION["CONTRASEÑA"]))&&($_SESSION["TIPO"]=="C")){
?>
	<html>
		<head> 
			<meta charset="utf8">
			<title>Inicio</title>
			<style>
				body {
					margin: 0;
					/*background-image: url('../Ima/b.jpg');*/
				}
				#menuprincipal
				{
					position:absolute;
					height:50px;
					width:70%;
					margin-left:15%;
					background-color: RGBA(0,  101,  93,  0.8);
				}
				#imagendelusuario{
					width: 300px;
					height:300px;
				}
				#cajaimagen{
					background-image: url('../Ima/ima4.jpg');
					-webkit-background-size: cover;
					-moz-background-size: cover;
					-o-background-size: cover;
					background-size: cover;
					height: 300px;
					width: 300px;
				}
				#frame1{
					background-color: lightblue;
					width:50%;
					position: relative;
				}
				#frame2{
					background-color: yellow;
					width:50%;
				}
				#busqueda{
					background-color: lightgreen;
					width:50%;
				}
				#pagar{
					border: 1px solid black;	
					width: 20%;
				}
			</style>
		</head>
		<body>
			<a href='../Ingresar/cerrar.php'  style='color: black;'>Cerrar Sesión</a>
			<form method='POST' action='subirimagen.php' enctype='multipart/form-data'>
				<input type='file' name='imagensubir' size='20'>
				<input type='hidden' name='usus' value='$_SESSION[CONTRASEÑA]'>
				<input type='submit' value='Subir Archivo'>
			</form>
			<div id="cajaimagen">
				<?php 
				include "recuperarimagen.php";
				?>
			</div>
			<div height="300" id="frame1">
				<?php
				include "../conexion/conectar_productos.php";
				$sql = "SELECT * FROM mercancia";
				mysqli_query($conexion, $sql);
				$cantidad_registros= mysqli_affected_rows($conexion);
				//Especifíca aquí el número de Items en el mostrar productos
				$tamaño_paginas = 3;
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
				if(!(isset($_GET["paginanumeracion"]))){
					$pagina_mostrar = 1; 
					echo $pagina_mostrar;
				   
				} 
				elseif ($_GET["paginanumeracion"] >= $total_paginas_redondeado) {
					$pagina_mostrar = $total_paginas_redondeado;
				 
				}
				elseif ($_GET["paginanumeracion"] <= 1) {
					$pagina_mostrar = 1;
				}
				else{
					$pagina_mostrar= $_GET["paginanumeracion"];
				}
				$to =  ($pagina_mostrar*$tamaño_paginas)-$tamaño_paginas;
				$sql2 = "SELECT * FROM mercancia limit $to,$tamaño_paginas";
				mysqli_query($conexion, $sql2);
				if($resultado = mysqli_query($conexion,$sql2)){
					while ($row = mysqli_fetch_array($resultado)){
				?>
						<a href="<?php $ruta = '../productos/'. $row['code_producto'].'.php'; echo $ruta ?>">
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
				?>
					<form action="ingresa.php" method="GET">
						<input type="submit" value="siguiente">
						<input type="hidden" value="<?php echo $_GET["paginanumeracion2"]?>" name="paginanumeracion2">
						<input type="hidden" name="paginanumeracion" value="<?php 
						if($pagina_mostrar <= $total_paginas_redondeado -1){
							$pagina_anterior = $_GET["paginanumeracion"] + 1; 
							echo $pagina_anterior;
						}
						else{
						$pagina_anterior = $total_paginas_redondeado;  
						echo $pagina_anterior;
						}
						?>">
					</form>
					<form action="ingresa.php" method="GET">
						<input type="hidden" value="<?php echo $_GET["paginanumeracion2"]  ?> " name="paginanumeracion2">
						<input type="submit" value="anterior">
						<input type="hidden" name="paginanumeracion" value="<?php 
						if($pagina_mostrar > 1){
							$pagina_anterior = $_GET["paginanumeracion"] - 1; 
							echo $pagina_anterior;
						}
						else{
							$pagina_anterior = 1;  
							echo $pagina_anterior;
						}
						?>">
					</form>
					<form action="ingresa.php" method="GET">
						<input type="number" name="paginanumeracion" value="<?php echo $_GET["paginanumeracion"] ?>">
						<input type="hidden" value="<?php echo $_GET["paginanumeracion2"]  ?> " name="paginanumeracion2">
						<input type="submit" value="Ir a">
					</form>
					<p>página <?php echo$pagina_mostrar ?>/<?php echo $total_paginas_redondeado; ?></p>
				 <?php
				}
				else {
					echo "Error al tratar de mostrar los registros";
				}
				?>
			</div>
			<div id="frame2" height="300">contenido
				<?php
				$db_host="localhost";
				$db_nombre="registro";
				$db_usuario="root";
				$db_contra="";
				$conexion2=mysqli_connect($db_host,$db_usuario, $db_contra, $db_nombre);
				if(mysqli_connect_errno()){
					echo "Fallo al conectar con la base de datos";
				}
				else{
			
				}
				mysqli_set_charset($conexion2,"utf8");
				$sql2 = "SELECT * FROM carrito where persona='$_SESSION[CONTRASEÑA]'";
				mysqli_query($conexion2, $sql2);
				$cantidad_registros2= mysqli_affected_rows($conexion2);
				//Aqui configuras la cantidad de elementos que se ven en el carrito
				$tamaño_paginas2 = 2;
				$total_paginas2=$cantidad_registros2/$tamaño_paginas2;
				$total_paginas_redondeado2 = ceil($total_paginas2);
				if(($total_paginas_redondeado2 > $total_paginas2)&&($total_paginas_redondeado2 > 1)){
					$total_paginas_redondeado2 = $total_paginas_redondeado2 - 1;
				}
				if(($total_paginas_redondeado2 <= 1)){
					$total_paginas_redondeado2 = 1;
				}
				if($total_paginas_redondeado2 < $total_paginas2){
					$total_paginas_redondeado2 = $total_paginas_redondeado2 + 1;
				}
				if($total_paginas_redondeado2 == $total_paginas2){
					$total_paginas_redondeado2 = $total_paginas_redondeado2;
				}
				if(!(isset($_GET["paginanumeracion2"])))
				{
					$pagina_mostrar2 = 1; 
					echo $pagina_mostrar2;
				   
				} 
				elseif($_GET["paginanumeracion2"] >= $total_paginas_redondeado2){
					$pagina_mostrar2 = $total_paginas_redondeado2;
				 
				}
				elseif ($_GET["paginanumeracion2"] <= 1){
					$pagina_mostrar2 = 1;
				}
				else{
					$pagina_mostrar2 = $_GET["paginanumeracion2"]; 
				}
				$to2 =  ($pagina_mostrar2*$tamaño_paginas2)-$tamaño_paginas2;
				$sql3 = "SELECT * FROM carrito where persona='$_SESSION[CONTRASEÑA]' limit $to2, $tamaño_paginas2";
				if($resultado2 = mysqli_query($conexion2,$sql3)){
					while ($row2 = mysqli_fetch_array($resultado2)){
				?>
						<a>
							<table border="1" id="caja_mostrar2">
								<tr> 
									<td><?php echo"producto: " .$row2["nombre_producto"] ?></td> 
									<td><?php echo "codigo: ".$row2["codigo_producto"] ?></td> 
									<td><?php echo "precio: ".$row2["precio"]*$row2["cantidad"] ?></td> 
									<td><?php echo "cantidad: ".$row2["cantidad"] ?></td>    
									<td>
										<form method="POST" action="carrito.php">
											<input type="hidden" name="code_producto_carrito" id="code_producto_carrito" value="<?php echo $row2["codigo_producto"]; ?>">
											<input type="submit" name="agregar_carrito" id="agregar_carrito" value="quitar">
											<input type="hidden" name="operacion_carrito" id="operacion_carrito" value="quitar" onclick="myFunction()">
											<input type="hidden" name="nombre_producto_carrito" id="nombre_producto_carrito" value="<?php echo $row2["nombre_producto"]; ?>">
											<input type="hidden" name="precio_producto_carrito" id="precio_producto_carrito" value="<?php echo $row2["precio"]; ?>">
										</form>
										<form method="POST" action="carrito.php">
											<input type="submit" name="agregar_carrito" id="agregar_carrito" value="agregar">
											<input type="hidden" name="precio_producto_carrito" id="precio_producto_carrito" value="<?php echo $row2["precio"]; ?>">
											<input type="hidden" name="code_producto_carrito" id="code_producto_carrito" value="<?php echo $row2["codigo_producto"]; ?>">
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
				<div border="2" id="pagar">
					Total a pagar<br>
					<B><?php  
						$sqlprecio = "SELECT precio FROM carrito where persona='$_SESSION[CONTRASEÑA]'";
						$resultadoprecio = mysqli_query($conexion2,$sqlprecio);
						while ($rowprecio = mysqli_fetch_array($resultadoprecio)){
							@$preciodefinitivo = $preciodefinitivo + $rowprecio[0];
						}
						echo $preciodefinitivo;
					?>
					</B>
				</div>
				<div border=1>
					<form action="ingresa.php" method="GET">
						<input type="submit" value="siguiente">
						<input type="hidden" value="<?php echo $_GET["paginanumeracion"] ?>" name="paginanumeracion">
						<input type="hidden" name="paginanumeracion2" value="<?php 
							if($pagina_mostrar2 <= $total_paginas_redondeado2 -1){
								$pagina_anterior2 = $_GET["paginanumeracion2"] + 1; 
								echo $pagina_anterior2;
							}
							else{
								$pagina_anterior2 = $total_paginas_redondeado2;  
								echo $pagina_anterior2;
							}
						?>">
					</form>
					<form action="ingresa.php" method="GET">
						<input type="submit" value="anterior">
						<input type="hidden" value="<?php echo $_GET["paginanumeracion"] ?>" name="paginanumeracion">
						<input type="hidden" name="paginanumeracion2" value="<?php 
							if($pagina_mostrar2 > 1){
								$pagina_anterior2 = $_GET["paginanumeracion2"] - 1; 
								echo $pagina_anterior2;
							}
							else{
								$pagina_anterior2 = 1;  
								echo $pagina_anterior2;
							}
						?>">
					</form>
					<form action="ingresa.php" method="GET">
						<input type="number" name="paginanumeracion2" value="<?php echo $_GET["paginanumeracion2"] ?>">
						<input type="hidden" value="<?php echo $_GET["paginanumeracion"] ?>" name="paginanumeracion">
						<input type="submit" value="Ir a">
					</form>
					<p>página <?php echo$pagina_mostrar2 ?>/<?php echo $total_paginas_redondeado2; ?></p>
				</div>
			</div>
			<div id="busqueda">
				<form method="GET" action="mostrar.php" target="blanco" onsubmit="window.open('', 'blanco', 'top=10px,left=20px,width=600px,height=400px')">
					<input type="text" name="buscar_producto_nombre" id="buscar_producto_nombre">Nombre Producto
					<input type="hidden" name="paginanumeracion3" value="1">
					<input type="submit" value="buscar">
				</form>
				<form method="GET" action="mostrar2.php" target="blanco2" onsubmit="window.open('', 'blanco2', 'top=10px,left=20px,width=600px,height=400px')">
					<input type="text" name="buscar_producto_nombre" id="buscar_producto_nombre">Code Producto
					<input type="hidden" name="paginanumeracion3" value="1">
					<input type="submit" value="buscar">
				</form>
			</div>
			<form method="GET" action="" id="este">
				<input id="identificar" type="hidden" name="paginanumeracion" value="">
				<input id="identificar2" type="hidden" name="paginanumeracion2" value="">
			</form>
			<script type="text/javascript">
				function comprobarurl(){
					var url = window.location+"";
					var cmp	= url.indexOf('paginanumeracion');
					var cmp2	= url.indexOf('paginanumeracion2');   
					if ((cmp == -1)||(cmp2 == -1)){
						
						 document.getElementById("identificar").value=1;
						document.getElementById("identificar2").value=1;
						document.getElementById("este").submit();
					}
					else{
						
					}
				}
				comprobarurl();
			</script>
			<div id="orden_comprar">
				<?php
				if(@$_GET["procede"] =="si"){
					$numcarrito = "select max(numero_factura) from factura2";
					$numerofactura = mysqli_query($conexion2, $numcarrito);
					$numerofactura = mysqli_fetch_array($numerofactura);
					$numerofactura = $numerofactura[0];
					if(!isset($numerofactura)){
						$numerofactura = 0;
						echo "La variable no esta definida";
					}
					$sql4 = "SELECT * FROM carrito where persona='$_SESSION[CONTRASEÑA]'";
					$result4 = mysqli_query($conexion2, $sql4);
					if(!($result4)){
						echo "Ha habido un error";
					}
					$time = date('Y-m-d H:i:s');
					$numfactura = $numerofactura + 1;
					while($row3 = mysqli_fetch_array($result4)){
						$sqlcomprobarexistencia="select cantidad_producto from mercancia where code_producto='$row3[codigo_producto]'";
						$secomprobo=mysqli_query($conexion,$sqlcomprobarexistencia);
						if(!($secomprobo)){
							echo "ha habido un error en la comprobación<br>";
						}
						$secomprobo=mysqli_fetch_array($secomprobo);
						if($row3["cantidad"]  <= $secomprobo["cantidad_producto"]){
							$sql6="insert into factura2 (cantidad, codigo_producto,fecha,nombre_producto,numero_factura,precio_producto, total_pagar,usuario) values ('$row3[cantidad]','$row3[codigo_producto]','$time','$row3[nombre_producto]',$numfactura,'$row3[precio]','$preciodefinitivo','$_SESSION[CONTRASEÑA]')";
							$final = mysqli_query($conexion2, $sql6);
							if(!($final)){
								echo "Ha ocurrido un error fatal";
								echo mysqli_error($conexion2);
							}
							$quitarexistencia="update mercancia set cantidad_producto=cantidad_producto-$row3[cantidad] where code_producto='$row3[codigo_producto]'";
							$secomproboquitar=mysqli_query($conexion,$quitarexistencia);
							if(!($secomproboquitar)){
								echo "Error al actualizar la cantidad disponible";
							}
						}
						else{
							?>	
							<script type="text/javascript">
								alert("No se dispone de tal cantidad del producto: <?php echo $row3["nombre_producto"] ?>");
							</script>
							<?php
						}
					}
				}
				?>
				<form method="GET" action="ingresa.php" name="este2">
					<input type="hidden" value="" name="paginanumeracion" id="señal1">
					<input type="hidden" value="" name="paginanumeracion2" id="señal2"> 
					<input type="hidden" value="" name="procede" id="señal3">
					<input type="submit" value="comprar" onclick="comprobarcomprar()">
				</form>
			</div>
			<script type="text/javascript">
				function comprobarcomprar(){
					var r = confirm("¿Deseas continuar?, la compra no puede ser revertida");
					if (r == true){
						alert("Confirmaste la compra");
						 document.getElementById("señal1").value=1;
						document.getElementById("señal2").value=1;
						document.getElementById("señal3").value="si";
						document.getElementById("este2").submit();
					}
					else{
						alert("La compra ha sido cancelada");
					}
				}
			</script>
			<script type="text/javascript">
				window.addEventListener('load', function(){
					var ur = window.location+"";
					var cmp3	= ur.indexOf('procede=si');
					if(cmp3 != -1){
						location.href="ingresa.php?paginanumeracion=1&paginanumeracion2=1";
					}
				});
			</script>
			<a href="imprimir.php">Ver facturas</a>
		</body>
	</html>
	<?php	
}
else{
	echo "Contraseña o Usuario Incorrecto";
}
?>


 

