<html>
	<head>
		<link rel=stylesheet href="CSS/style.css" type="text/css">
		<meta charset="utf8">
		<script type="text/javascript">
			var mensaje;
			var opcion = confirm("Esta pagina usa cookies");
			if (opcion == true) {
				
			} 
			else {
				window.location="negado.html";
			}
		</script>
		<title>Mejorado</title>
	</head>
	<body>
		<div id="titulo"><h1><u>Bienvenidos a Amadeus Computer C.A.</u></h1></div>
		<div id="quienes_somos"><h3><!-- Aquí se configura
		quienes somos -->
		En Amadeus computer nos encargamos de tener
		la mejor tecnología al alcance de su mano
		computadora, celulares, impresoras, componentes
		<br>
		si necesita algo de tecnología nosotros lo tenemos.
		Tambien nos encargamos de reparaciones de computadoras
		y damos diversos cursos sobre tecnología, ven inscribete
		y recibiras el primer mes gratis.
		</h3>
		</div>
		<div id="loginss">
			<form method="POST" action="ValidarEntrada/valida.php" id="login_form">
				Login<br>
				<input type="text" name="usuario" value="Usuario">
				usuario<br>
				<input type="password" value="Contraseña" name="ca">
				contraseña<br>
				<input type="submit" value="Entrar">
				<a href="http://localhost/pa/CambiarContrasena/recuperarcontrasena.php"> <input type="button" name="boton" value="He olvidado mi contraseña" /> </a> 
			</form>
		</div>
		<div id="registro">
			<form method="POST" action="InsertarUsuario/INSERTAR.php">
				Registrarse<br>
				<input type="text" name="registrarusuario" value="usuario">
				 usuario <br>
				<input type="password" name="c1">
				contraseña <br>
				<input type="password" name="c2">
				confirmar contraseña<br>
				<input type="text" name="correo" value="Correo">
				correo<br>
				<input type="checkbox" name="recibircorreo" value="off">
				deseo recibir correos de notificaciones<br>
				<input type="submit" value="Registrarse">
			</form>
		</div>
		<div id="shana">
			<video  width="600" height="406" src="videos/video.mp4" poster="Ima/c.jpg" controls ></video>
		</div>
		<div id="cs">
			<a id="referencia" name="links" href=""> <img name="slider" alt="Error al mostrar la imagen" width="600" height="600" id="ss"></a>
			<script type="text/javascript">
				window.addEventListener('load', function(){
					var imagenes =[];
					var links=[];
					imagenes[0]= "Ima/ima1.jpg";
					imagenes[1]= "Ima/ima2.jpg";
					imagenes[2]= "Ima/ima3.jpg";
					imagenes[3]= "Ima/ima4.png";
					links[0]="https://www.google.com/";
					links[1]="https://www.facebook.com/";
					links[2]="https://www.youtube.com/";
					links[3]="https://www.wikipedia.org/";
					var indiceimagenes = 0;
					function cambiarimagenes(){
						document.slider.src = imagenes[indiceimagenes];
						document.getElementById("referencia").href =links[indiceimagenes];
						if(indiceimagenes <3){
							indiceimagenes++;
						 }
						else{
							indiceimagenes = 0;
						}
					}
					cambiarimagenes();
					setInterval(cambiarimagenes, 4000);
				});
			</script>
		</div>
	</body>
</html>