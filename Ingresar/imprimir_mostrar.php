<html>
	<head>
	<meta charset="utf8">
	</head>
	<style type="text/css">
		td {
			width: 120px;	
		}
		.titulo{
			text-align: center;
		}	
		.tb{
			margin: auto;
		}
		.link{
			margin: auto;
		 text-align: center;
		}
	</style>
	<body>
		<?php
		session_start();
		if((isset($_SESSION["CONTRASEÑA"]))&&($_SESSION["TIPO"]=="C")){
		?>
			<h1 class="titulo">Id factura:<?php echo $_GET["idfact"]; ?></h1>
			<h2 class="titulo">Comprador:<?php echo $_SESSION["CONTRASEÑA"]; ?></h2>
			<h3 class="titulo">Amadeus Computer C.A</h3>
			<table border="1" class="tb">
				<tr>
					<td>Código del Producto</td>
					<td>Nombre del Producto</td>
					<td>Cantidad del Producto</td>
					<td>Precio del Producto</td>
				</tr>	
				<?php 
				if(isset($_GET["idfact"])){
					$prueba = new baseDatos();
					$prueba->conectar("localhost","root","","registro");
					$prueba->query("select * from factura2 where usuario='$_SESSION[CONTRASEÑA]' and numero_factura=$_GET[idfact]");
					$b=$prueba->hacerArreglo();
					$prueba->tamañoArray();
					$y=0;
					while($y<=(($prueba->tamY)-1)){
					?>
						<tr>
							<td><?php echo $b[$y][1];?></td>
							<td><?php echo $b[$y][3];?></td>
							<td><?php echo $b[$y][0];?></td>
							<td><?php echo $b[$y][5];?></td>
						</tr>	
					<?php
						$y++;
					}
				}
				?>
			</table>
			<table border="1" class="tb">
				<tr>
					<td>Total a pagar:<?php echo $b[0][6]; ?></td>
					<td>Fecha de Compra: <?php echo $b[0][2]; ?></td>
				</tr>
			</table>
			<div class="link"><a href="imprimir.php">Volver a sección de facturas</a></div>
			<div class="link"> <input type="button" value="Imprimir" onclick="window.print()" /></div>
			<?php
		$prueba->cerrarconexion();
		}
		else{
			echo "Debes de logearte para poder entrar";
		}
 ?>
	</body>
</html>
<?php
class baseDatos{
	private $contraseña;	
	private $servidor;
	private $usuario;
	private $tabla;
	private $enlace;
	private $fetch_query=false;
	private $fetch_arrays=false;
	private $resultado=false;
	private $row2 = array();
	private $row3;
	public $tamX;
	public $tamY;
	function conectar($servidor,$usuario,$contraseña,$tabla){
		$this->usuario = $usuario;
		$this->contraseña = $contraseña;
		$this->servidor = $servidor;
		$this->tabla = $tabla;
		$enlace = new mysqli($servidor,$usuario,$contraseña,$tabla);
		if(mysqli_connect_errno()){
			echo "No se pudo establecer la conexión error: ".mysqli_connect_error()."<br>";  
		}
		else{
			$this->enlace = $enlace;
			return $this->enlace;
		}
	}
	function query($sql){
		if($resultado = $this->enlace->query($sql)){
			@$row_count=$resultado->num_rows;
			if(isset($row_count)){
				$this->resultado=$resultado;
				$this->fetch_query=true;
				return $resultado;
			}
			else{
		  
			}
		}	 
		else{
		  echo "La operacion ha fallado <br>";
		}
	}
	function hacerArreglo(){
		if($this->fetch_query){
			$i = 0;
			while($row =$this->resultado->fetch_array(MYSQLI_BOTH)){
				$number =$this->resultado->field_count;
				$j = 0;
				while($j < $number){
					$this->row2[$i][$j]= $row[$j];
					$j++;
				}
				$i++;	 
			}
			return $this->row2;
		}
		else{
			echo "Error debes hacer una consulta antes de obtener los resultados de una consulta. <br>";
		}
	}
	function tamañoArray(){
		$tam = $this->row2;
		$this->tamX=sizeof($tam[0]);
		$this->tamY=sizeof($tam);
	}
	function limpiar(){
		unset($this->row2); 
		unset($this->row3);
    } 
	function cerrarconexion(){
		mysqli_close($this->enlace);
	}
	 
}?>