<!DOCTYPE html>
<html>
	<head><title></title>
		<meta charset="utf8">
	</head>
	<style>
		#imagen_del_producto{
			width:700px;
			height:400px;
			background-color: yellow;
		}
		#informacion_del_producto{
			position: relative;
			top:-900px;
			width: 50%;
			height: 400px;
			overflow-y: scroll;
			text-align: justify;
			background-color: rgba(39, 142, 231, 1)
		}
        #informacionprimordial{
			background-color: green;
			width:25%;
			height:300px;
			position:relative;
			left: 25%;
			bottom:305px;
			
		}
		#posting{
		   position: relative;
		   bottom: 600px;
		   left: 50%;
		   width: 50%;
		   height:600px;
		   background-color: rgba(167, 179, 200, 1);
		   overflow-y: scroll;
		}
		#ima{
			width:25%;
		}
	</style>
	<body>
	<form method="GET" action="" id="este">
		<input id="identificar" type="hidden" name="ide" value="">
		<input id="identificar2" type="hidden" name="paginanumeracion" value="">
	</form>
	<script type="text/javascript">
		function codigoProducto(){
			var url = window.location+"";
			var caracter = url.lastIndexOf('/') + 1;
			var longitud_cadena = url.lastIndexOf('.php');
			var nombre = url.substring(caracter,longitud_cadena);
			return nombre;
		}
		var nombre = codigoProducto();
		function comprobarurl(nombre){
			var url = window.location+"";
			var cmp	= url.indexOf('ide');
			var cmp2	= url.indexOf('paginanumeracion'); 
			if ((cmp == -1)||(cmp2 == -1)){
				document.getElementById("identificar").value=nombre;
				document.getElementById("identificar2").value=1;
				document.getElementById("este").submit();
			}
			else{
				
			}
		}
		comprobarurl(nombre);
	</script>
	<?php
	session_start();
	include "../conexion/conectar_productos.php";
	?>
	<?php 
	mysqli_set_charset($conexion, "utf8");
	$sql2 = "SELECT * FROM mercancia where code_producto = '$_GET[ide]'";
	mysqli_query($conexion, $sql2);
	$resultado=mysqli_query($conexion,$sql2);
	while($fila=mysqli_fetch_array($resultado)){
		$contenido=$fila["Imagen"];
		$tipo= $fila["Imagen_tipo"];
		?>
		<div id="contienelaimagen">
			<?php
			if($tipo=="image/png"){
				echo "<img width='300' height='300' id='ima' src='data:image/png; base64,". base64_encode($contenido)."'>";
			}
			if($tipo=="image/jpg"){
				echo "<img width='300' height='300' id='ima' src='data:image/jpg; base64,". base64_encode($contenido)."'>";	
			}
			if($tipo=="image/jpeg"){
				echo "<img width='300' height='300' id='ima' src='data:image/jpeg; base64,". base64_encode($contenido)."'>";	
			}
			?>
		</div>
		<div id="informacionprimordial">
			Código: <?php echo $fila["code_producto"];?><br>
			Nombre: <?php echo $fila["nombre_producto"];?><br>
			Precio: <?php echo $fila["precio_producto"]; ?> <br>
			Marca: <?php echo $fila["marca"]; ?> <br>
			Importante: <?php echo $fila["importante"]; ?> <br>
			<?php
			if((isset($_SESSION["CONTRASEÑA"]))&&($_SESSION["TIPO"]=="C")){
				?>
				<form method="POST" action="../Ingresar/carrito.php">
					<input type="hidden" value="agregar" name="operacion_carrito">
					<input type="hidden" value="<?php echo $fila["code_producto"] ?>" name="code_producto_carrito">
					<input type="hidden" value="<?php echo $fila["nombre_producto"] ?>" name="nombre_producto_carrito">
					<input type="hidden" value="<?php echo $fila["precio_producto"] ?>" name="precio_producto_carrito">
					<input type="submit" value="Agregar al carrito">
				</form>
				<?php
			}
			else{
				?>
				<script type="text/javascript">
					function quiero(){
						alert("Debes primero Logearte para poder comprar");
					    window.location="../index.php";
					}
				</script>
				<form method="POST" action="../index.php">
					<input type="button" name="quierocomprar" onclick="quiero()" value="quierocomprar">
				</form>	
				<?php 
			}
			?>
		</div>
		<div id="posting">
			<?php
			$sql = "select * from comentarios where codigo_producto = '$_GET[ide]' order by fecha ASC";
			$result2 = mysqli_query($conexion, $sql);
			$cantidad_registros= mysqli_affected_rows($conexion);
			$tamaño_paginas = 4;
			$total_paginas=$cantidad_registros/$tamaño_paginas;
			//print "lamadre".$total_paginas;
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
			$sql3 = "select * from comentarios where codigo_producto = '$_GET[ide]' order by fecha limit $to,$tamaño_paginas";
			$result3 = mysqli_query($conexion, $sql3);
			if(!($result3)){
				echo "Ha ocurrido un error en la sección de comentarios";
			}
			while ($fila2=mysqli_fetch_array($result3)){ 
				?>
				<table border="1">
					<tr>
					   <td>Usuario:<?php echo $fila2["usuario"]; ?></td>
					   <td>Fecha: <?php echo $fila2["fecha"]; ?></td>
					   <td>Codigo Producto: <?php echo $fila2["codigo_producto"]; ?></td>
					   <td>Nombre Producto: <?php echo $fila2["nombre_producto"];  ?></td>
					</tr>
				</table>
				<?php echo $fila2["comentario"]; ?>
				<?php 
			}
			$fila2=mysqli_fetch_array($result2)
			?>
			<form method="POST" action="../Ingresar/comentar.php">
				<textarea name="nota_producto" id="nota_producto">Escribe Aqui tu comentario</textarea>
				<input type="hidden" name="informacion" id="informacion" value="<?php echo $_GET["ide"]; ?>">
				<input type="hidden" name="usuario" id="usuario" value="<?php echo @$_SESSION["CONTRASEÑA"]?>">
				<input type="hidden" name="date" id="usuario" value="<?php  
				$time = date('Y-m-d H:i:s'); echo $time; ?>">
				<input type="hidden" name="nom" value="<?php echo $fila["nombre_producto"]; ?>">
				<input type="submit" name="Enviar" value="Enviar">
			</form>
			<form action="<?php echo $_GET["ide"].".php"?>" method="GET">
				<input type="submit" value="siguiente">
				<input type="hidden" value="<?php echo $_GET["ide"]?>" name="ide">
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
			<form action="<?php echo $_GET["ide"].".php"?>" method="GET">
			 <input type="hidden" value="<?php echo $_GET["ide"]?>" name="ide">
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
			pagina<?php echo $_GET["paginanumeracion"]?>/<?php echo $total_paginas_redondeado ?>
		</div>
		<div id="informacion_del_producto">
			<?php 
			echo $fila["nota_producto"];
			?>
		</div>
		<?php
	}
?>
</body>
</html>