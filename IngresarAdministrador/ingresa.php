<?php
session_start();
@print "Usuario en sesión: ".$_SESSION["CONTRASEÑA"]."<br>";

if((isset($_SESSION["CONTRASEÑA"]))&&($_SESSION["TIPO"]=="A")){
?>
	<html>
		<head> 
			<meta charset="utf8">
			<title>Inicio</title>
			<style>
				body{
					/*background-image: url('../Ima/b.jpg');*/
				}
				#menuprincipal{
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
				#cajadelosproductos{
					background-color: lightblue;
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
			<a href="javascript: popup2();">Insertar administrador</a><br>
			<script language="javascript">
				function popup() {
					window.open ("Insertar_producto.php", "","width=400,height=300");
				}
				function popup2() {
					window.open ("Insertar_administrador.php", "","width=400,height=200");
				}
				</script>
			<a href="javascript: popup();">Insertar producto</a>
			<div height="300" id="frame1">
				<?php
				include "../conexion/conectar_productos.php";
				$sql = "SELECT * FROM mercancia";
				mysqli_query($conexion, $sql);
				$cantidad_registros= mysqli_affected_rows($conexion);
				//Aquí se configura la cantidad de productos que se muestran
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
				if(!(isset($_GET["paginanumeracion"])))
				{
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
					while ($row = mysqli_fetch_array($resultado)) {
						?>
						<div id="cajadelosproductos">
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
											} 
										?> 
										</td> 
										<td>
											<form method="POST" action="borrar_producto.php">
												<input type="hidden" name="code_producto_borrar" id="code_producto_borrar" value="<?php echo $row["code_producto"]; ?>">
												<input type="submit" name="borrar_producto" id="borrar_producto" value="borrar producto">
											</form>
											<form method="POST" action="modificar_producto.php" target="blanco" onsubmit="window.open('', 'blanco', 'top=10px,left=20px,width=400px,height=300px')">
												<input type="submit" name="modificar_producto" id="modificar_producto" value="modificar producto">
												<input type="hidden" name="code_producto_modificar" id="code_producto_modificar" value="<?php echo $row["code_producto"]; ?>">
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
									<input type="submit" value="Ir a">
								</form>
								<p>página <?php echo$pagina_mostrar ?>/<?php echo $total_paginas_redondeado; ?></p>
						</div>
						<?php
				       
				}
				else{
					echo "Error al tratar de mostrar los registros";
				}
				?>
				<form method="GET" action="" id="este">
					<input id="identificar" type="hidden" name="paginanumeracion" value="">
				</form>
			</div>
			<script type="text/javascript">
				function comprobarurl(){
				    var url = window.location+"";
				    var cmp	= url.indexOf('paginanumeracion');
					if (cmp == -1){
						
						document.getElementById("identificar").value=1;
						document.getElementById("este").submit();
					}
					else{
						
					}
				}
				comprobarurl();
			</script>
		</body>
	</html>
	<?php	
}
else{
	header("location:../index.php");
}
?>
