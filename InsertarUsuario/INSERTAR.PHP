<?php
//Hay que arreglar el error que dice undefined desearecibirnotificaciones cuando no se cumple la
//condición de la contraseña, sea desactivando las notificaciones de manera global, local o con 
//un condicional que redefina la variable cuando esta esta vacia
require('../conexion/conectar.php');
$nombre =                          $_POST["registrarusuario"]; (string) $nombre;
$nombreA =                         mysqli_real_escape_string($conexion,$nombre);
$contraseña1 =  $_POST["c1"];(string) $contraseña1;
$contraseña1A = mysqli_real_escape_string($conexion, $contraseña1);
$contraseña2 =  $_POST["c2"];  (string) $contraseña2;
$correo =                          $_POST["correo"]; (string) $correo;
$correocomprueba =                   strstr($correo, '@' );
$desearecibirnotificaciones =  $_POST["recibircorreo"];

echo $desearecibirnotificaciones;
if((strlen($nombreA) >= 5) && (strlen($nombreA) <= 30)){
	if((strlen($contraseña1A) >=5) &&(strlen($contraseña1A) <=30) ){
     if($contraseña1 == $contraseña2){
	 	 if(($correocomprueba =='@gmail.com') || ($correocomprueba=='@hotmail.com') || ($correocomprueba==
		 '@outlook.com'))
		 {
			 if((isset($desearecibirnotificaciones))){
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
					  $result = mysqli_query($conexion,"INSERT INTO login (CONTRASEÑA,CORREO,PERSONA,Ofertas,TIPO) VALUES ('$pass_cifrado','$correo','$nombreA',1,'C')");	
				              if($result == false){
						     echo "Fallo al guardar el usuario";
					         mysqli_close($conexion);
					        }
	                   	  else{
							echo "El usuario se ha guardado correctamente";
						    mysqli_close($conexion);
							?>
							<html>
                            <head>
                            <script type="text/javascript">
						    function Redirect() {
							   window.location="../index.php";
							}
							document.write("Tu usuario se ha creado correctamente");
							setTimeout('Redirect()', 10000);
				            </script>
						    </head>
						    <body>
						    </body>
						    </html>
						    <?php
						
							
							}		  
				        }			    
					}
				  
				} else{
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
					 $result = mysqli_query($conexion,"INSERT INTO login (CONTRASEÑA,CORREO,PERSONA,Ofertas,TIPO) VALUES ('$pass_cifrado','$correo','$nombreA',0,'C')");	
				              if($result == false){
						     echo "Fallo al guardar el usuario";
					         mysqli_close($conexion);
					        }
	                   	  else{
							echo "El usuario se ha guardado correctamente";
						    mysqli_close($conexion);
							?>
							<html>
                            <head>
                            <script type="text/javascript">
						    function Redirect() {
							   window.location="../index.php";
							}
							document.write("Tu usuario se ha creado correctamente");
							setTimeout('Redirect()', 10000);
				            </script>
						    </head>
						    <body>
						    </body>
						    </html>
							
							
							<?php 
							}		  
				        }			    
					}
				
				}
			
			}
			
          else {
			echo "Has introducido un correo no valido"; 
		  }		
		}
	     else{
			echo "No has introducido un correo válido";
		 }
	 }	
	else {
		echo "Las contraseñas no coinciden";
	}
	}
    if(strlen($contraseña1A) <5){
		echo "la contraseña es demasiado corta";
	}
	if(strlen($contraseña1A) > 30){
		echo "La contraseña es demasiado larga";
	}
	
if(strlen($nombreA) <5){
	echo "El nombre es muy corto";
}
if(strlen($nombreA) >30){
	echo "El nombre es demasiado largo";
}

?>