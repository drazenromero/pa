<html>
	<head>
		<meta charset="utf8">
	</head>
	<body>
		<?php
		session_start();
		@print $_SESSION["CONTRASEÑA"];
		if((isset($_SESSION["CONTRASEÑA"]))&&($_SESSION["TIPO"]=="A")){
			include "../conexion/conectar.php";
			?>
			<form method="POST" action="Insertar_administrador.php">
			Registrar Administrador<br>
				<input type="text" name="registrarusuario" value="usuario">
				 usuario <br>
				<input type="password" name="c1">
				contraseña <br>
				<input type="password" name="c2">
				confirmar contraseña<br>
				<input type="text" name="correo" value="Correo">
				correo<br>
				<input type="submit" value="Registrar Administrador">
			</form>
			<?php
			if(isset($_POST["registrarusuario"])){
			$nombre = $_POST["registrarusuario"]; (string) $nombre;
			$nombreA = mysqli_real_escape_string($conexion,$nombre);
			$contraseña1 =  $_POST["c1"];(string) $contraseña1;
			$contraseña1A = mysqli_real_escape_string($conexion, $contraseña1);
			$contraseña2 =  $_POST["c2"];  (string) $contraseña2;
			$correo =  $_POST["correo"]; (string) $correo;
			$correocomprueba =  strstr($correo, '@' );



				if((strlen($nombreA) >= 5) && (strlen($nombreA) <= 30)){
					if((strlen($contraseña1A) >=5) &&(strlen($contraseña1A) <=30) ){
						if($contraseña1 == $contraseña2){
							if(($correocomprueba =='@gmail.com') || ($correocomprueba=='@hotmail.com') || ($correocomprueba==
							 '@outlook.com')){
								$nuevousuario = mysqli_query($conexion,"select PERSONA FROM login WHERE PERSONA='$nombreA'");
									if(mysqli_num_rows($nuevousuario)>0){
										echo "Este nombre ya esta registrado";
									 
									}    
									else{
										$nuevoemail=mysqli_query($conexion,"SELECT CORREO FROM login WHERE CORREO='$correo'");	
										if(mysqli_num_rows($nuevoemail)>0){
											echo "Este correo ya esta registrado";
										}
										else {
											$pass_cifrado= password_hash($contraseña1A, PASSWORD_DEFAULT, array("cost"=>12));
											$result = mysqli_query($conexion,"INSERT INTO login (CONTRASEÑA,CORREO,PERSONA,Ofertas,TIPO) VALUES ('$pass_cifrado','$correo','$nombreA',0,'A')");	
											if($result == false){
												echo "Fallo al guardar el usuario";
												mysqli_close($conexion);
											}
											else{
												echo "El usuario se ha guardado correctamente";
												mysqli_close($conexion);
												?>
												<script type="text/javascript">
													function Redirect(){
													   window.close();
													}
													document.write("Tu usuario administrador se ha creado correctamente");
													setTimeout('Redirect()', 10000);
												</script>
												<?php
											}		  
										}			    
									}	
							}

						}
					}
				}
		    }
		}
        else{
			header("location:../index.php")
		}
		?>
	</body>
</html>