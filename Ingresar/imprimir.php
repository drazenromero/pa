<html>
	<head>
		<meta charset="utf8">
	</head>
	<body>
		<?php
		session_start();
		@print "Usuario en sesión: ".$_SESSION["CONTRASEÑA"];
		?>
		<h3>Nota: Las facturas se muestran empezando por las más recientes</h3>
		<?php
		if((isset($_SESSION["CONTRASEÑA"]))&&($_SESSION["TIPO"]=="C")){
			include "../conexion/conectar.php";
			$sql="select * from factura2 where usuario='$_SESSION[CONTRASEÑA]'ORDER BY fecha DESC";
			$result=mysqli_query($conexion,$sql);
			if(!($result)){
				echo "Ha ocurrido un error a la hora de la consulta, nivel1<br>";
			}
			else{
				$id_fact;
				$numref;
				$arr;
				$i=0;
				$j=0;
				$z=0;
				while($row = mysqli_fetch_array($result)){
					$numref[$i]=$row["numero_factura"];
					if($i==0){
					$id_fact[$j]= $row["numero_factura"];
					$j++;
				}
				if(@($row["numero_factura"]!=$numref[$i-1])&&($i>0)){
					$id_fact[$j]= $row["numero_factura"];
					$j++;
				}
				$i++;
			}
			while($z<=(count($id_fact)-1)){
			?>
			<form method="GET" action="imprimir_mostrar.php" >
			<input type="hidden" value="<?php echo $id_fact[$z]?>" name="idfact" id="señal3">
			<input type="submit" value="Ir a factura:<?php echo $id_fact[$z]?>">
			</form>
			<?php
			$z++;
		}
    }
			?>
			<a href="ingresa.php?paginanumeracion=1&paginanumeracion2=1">Volver a página principal</a>
			<?php
		}
		else{
			header("location:../index.php");
		}
			?>
	</body>
</html>
