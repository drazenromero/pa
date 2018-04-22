<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<?php
		session_start();
		@print $_SESSION["CONTRASEÑA"];
		if((isset($_SESSION["CONTRASEÑA"]))&&($_SESSION["TIPO"]=="A")){
			include "../conexion/conectar_productos.php";
			if(isset($_POST["code_producto_borrar"])){
				?>
				<form method="POST" action="borrar_producto.php" name="borrar" id="borrar">
					<input type="hidden" value="" name="procedeborrar" id="señal3">
					<input type="hidden" value="" name="code_producto_borrar2" id="señal2">
				</form>
				<script type="text/javascript">
					function comprobarborrar(){
					    var r = confirm("¿Deseas continuar?, Una vez borrado el producto no se puede continuar");
						if (r == true){
							alert("El producto sera borrado");
							document.getElementById("señal3").value="si";
							document.getElementById("señal2").value="<?php echo $_POST["code_producto_borrar"] ?>";
							document.getElementById("borrar").submit();
						}
						else{
						window.location="ingresa.php";
						}
					}
					comprobarborrar();
				</script>
				<?php
			}
			if(($_POST["procedeborrar"]=="si")&&(isset($_POST["code_producto_borrar2"]))){
				$borrar=$_POST["code_producto_borrar2"];
				$sql="delete from mercancia where code_producto='$borrar'";
				$result=mysqli_query($conexion,$sql);
				if(!($result)){
					echo "Ha habido una falla al realizar la operación<br>";	 
					echo mysqli_error($conexion);
				}
				else{
					header ("location:ingresa.php"); 
				}
			}
		}
		else{
			echo "Debes de logearte para poder entrar en esta sección";
		}
		?>
	</body>
</html>