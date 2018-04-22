<?php
//error_reporting(E_ALL ^ E_NOTICE);
$db_host="localhost";
$db_nombre="registro";
$db_usuario="root";
$db_contra="";
$conexion=mysqli_connect($db_host,$db_usuario, $db_contra, $db_nombre);
if(mysqli_connect_errno()){
	echo "Fallo al conectar con la base de datos";
}
else{
	
}
mysqli_set_charset($conexion,"utf8");
?>
<html>
	<head><title>NuevaContraseña</title>
	<meta charset="utf8">
	</head>
	<body>
		<?php
		@$usuario = mysqli_real_escape_string($conexion,$_POST["en"]);
		@$submitt =$_POST["submitt"];
		@$yano=$_POST["yano2"];
		@$code =mysqli_real_escape_string($conexion,$_POST["code"]);
		if((isset($usuario))&& (!(isset($yano)))){
			include("BuscarUsuario.php");
		}	
		if(($code != "") && (isset($code))){
			if($_POST["nv1"] == $_POST["nv2"]){  
				$imprimir = $_POST["cr"];      
				if($code == $imprimir){
					echo "El código introducido es el mismo";
					$pass_cifrado= password_hash($_POST["nuevacontraseña1"], PASSWORD_DEFAULT, array("cost"=>12));
					echo "$pass_cifrado";
					if((strlen($_POST["nv1"]) >=4) &&(strlen($_POST["nv1"])<=30)){
						mysqli_set_charset($conexion,"utf8");
						$usa= $_POST["use"];
						echo "La contraseña tiene la longitud necesaria";
						$pass_cifrado= password_hash($contraseña1A, PASSWORD_DEFAULT, array("cost"=>12));
						$result = mysqli_query($conexion,"   UPDATE login SET CONTRASEÑA = '$pass_cifrado' WHERE PERSONA='$usa'");	
						if($result == false)
						{
							echo "Fallo al actualizar la contraseña";
							mysqli_close($conexion);
						}
						else
						{
							echo "la contraseña se ha actualizado correctamente";
							?>
							<html>
							<head>
							</head>
							<body>
							<a href='../index.php'><input type='button' value='volver'></a>
							</body>
							</html>		
						<?php
						}		    
					}
					else
					{
						echo "La contraseña es muy larga o muy corta";
					}
				}
				else{
					echo "El código introducido es incorrecto";
				}
			}
			else {
				echo "los campos de contraseña no coinciden";
			}
		}
		mysqli_close($conexion);
		?>
	</body>
</html>