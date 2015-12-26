<?php
class cola{

	private $id_conexion;
	
	function __construct($servidor)
	{
	  $this->id_conexion=@mysql_connect($servidor, "root", "")
		or die("<font face='times new roman' size='3' color='black'>No hay conexión<br /></font>");
    
		//seleccionamos la base de datos.
		mysql_select_db("colegio");
	
	}
	
	/*Rellena un combo con el nombre de los alumnos de un determinado grupo*/
	/*Se debe usar dentro de un formulario*/
	//Modo -> 0 trae todos los alumnos.
	//Modo -> 1 Trae los alumnos asignados al terminal
	public function ComboAlumnos($modo)
	{
	
		/*Nos traemos el grupo actual*/		
		$consulta="select grupo from configuracion";
		$result=@mysql_query($consulta, $this->id_conexion) or die("Error en la función ComboAlumnos al traer el grupo");
		$fila=mysql_fetch_array($result);
		$grupo=$fila["grupo"];
		
		if ($modo==0)
		{
			$consulta="select codigo, nombre from alumno where codGrupo= $grupo order by nombre;";
		}
		else if ($modo==1)
		{
			$mac=$this->ObtenerMac();
			$consulta="select codigo, nombre from alumno where codGrupo= $grupo and puesto='$mac' order by nombre;";
		}	
	  
		$result=@mysql_query($consulta, $this->id_conexion) or die("Error en la función ComboAlumnos al traer los alumnos");
		
		echo "<select name='comboAlumnos' id='alumno'>";
		while ($fila=mysql_fetch_array($result))
		{
			//Los datos.
			printf ("<option>%s(%d)</option>",$fila["nombre"], $fila["codigo"]);
		}
		
		echo "</select>";	
		
	}
	
	/*Rellena un combo con el nombre de los grupos*/
	/*Se debe usar dentro de un formulario*/
	public function ComboGrupos()
	{
		/*Traemos el grupo que actual de la tabla configuracion*/
		$consulta="select grupo from configuracion";
		$result=@mysql_query($consulta, $this->id_conexion) or die("Error en la función ComboGrupos al traer el grupo de configuración");
		$fila=mysql_fetch_array($result);
		$codGrupo=$fila["grupo"];
		
		if ($codGrupo==0) {
			echo "<font color='red' color='red' size='5'>Se debe asignar grupo</font></br>";
		}
		
		/*ahora llenamos el combo de los grupos seleccionando el actual*/
		$consulta="select * from grupo";
		$result=@mysql_query($consulta, $this->id_conexion) or die("Error en la función ComboGrupos");
		
		echo "<select name='comboGrupos'>";
		while ($fila=mysql_fetch_array($result))
		{
			//Los datos.
			if ($fila["codigo"]==$codGrupo) 
			{
				printf ("<option selected>%s-%s</option>", $fila["codigo"], $fila["nombre"]);
			}
			else
			{
				printf ("<option>%s-%s</option>", $fila["codigo"], $fila["nombre"]);
			}
		}
		
		echo "</select>";	
		
	}
	
	/*Establece el grupo actual en la tabla configuración*/
	function EstablecerGrupo($grupo,$password)
	{
		$consulta="select password from configuracion";
		$result=mysql_query($consulta, $this->id_conexion) or die ("Error en la función AsignarPuesto");
		$fila=mysql_fetch_array($result);
		if (strcmp($password,$fila["password"])==0) 
		{
			/*nos quedamos solo con el codigo, separando el nombre*/
			$codigo=strtok($grupo,"-");
		
			/*ahora actualizamos el campo grupo en la tabla configuración*/
			$consulta="update configuracion set grupo= $codigo" ;
			$result=@mysql_query($consulta, $this->id_conexion) 
			or die("Error en la función EstablecerGrupo");
			echo "<script language='javascript'>alert('grupo $grupo establecido');</script>";
		}
		else {
			echo "<script language='javascript'>alert('contraseña incorrecta')</script>";
		}
	}
	
	/*Quita el grupo actual se debe hacer cuando se termina la clase*/
	function QuitarGrupo($password)
	{
		/*Tremos el grupo actual*/
		$grupo=$this->GrupoActual();
		
		$consulta="select password from configuracion";
		$result=mysql_query($consulta, $this->id_conexion) or die ("Error en la función AsignarPuesto");
		$fila=mysql_fetch_array($result);
		if (strcmp($password,$fila["password"])==0) {
			$consulta="update configuracion set grupo=0" ;
			$result=@mysql_query($consulta, $this->id_conexion) 
			or die("Error en la función QuitarGrupo");
			echo "<script language='javascript'>alert('grupo $grupo quitado')</script>";
		}
		else {
			echo "<script language='javascript'>alert('contraseña incorrecta')</script>";
		}
	}
	
	/*dibujar la cola del grupo actual*/
	function Mostrar()
	{
		
		/*Traemos el grupo actual de la tabla configuracion*/
		$codGrupo=$this->GrupoActual();
		
		//Ahora traemos los alumnos que están esperando*/
		$consulta="select nombre, puesto from alumno where codGrupo=$codGrupo and orden is not null order by orden";
		$result=@mysql_query($consulta, $this->id_conexion) or die("Error en la Mostrar al traer los alumnos");
		
		$puesto=$this->ObtenerMac();
		echo "<table border='1'>";
		while ($fila=mysql_fetch_array($result))
		{
			if ($fila["puesto"]==$puesto)
				echo "<tr align='center'><td><font color='blue' size='3' face='arial'>---->".utf8_encode($fila["nombre"])."<----</font></td></tr>"; 
			else
				echo "<tr align='center'><td><font face='arial'>".utf8_encode($fila["nombre"])."</font></td></tr>";
		}	
		echo "</table>";		
	}
	
	//Esta función obtener la dirección MAC de un equipo.
	private function ObtenerMac()
	{
		
		/*obtenemos la iP del cliente*/
		$IP=$_SERVER['REMOTE_ADDR'];
		if (( $IP=="::1" ) || ($IP=="127.0.0.1")) { /*el script se está ejecutando en el servidor*/
			/*Cargamos la salida del comando ipconfig/all en un buffer interno*/
			ob_start();
			system('ipconfig/all');
			$buffer=ob_get_contents();
			ob_end_clean();
			/*buscamos la subcadena 'sica' que viene de física*/
			$pMac=strpos($buffer, 'sica');
			/*Recogemos la dirección MAC a partir de la posición de la dirección IP + 22 */
			$mac=substr($buffer,$pMac+24,17);
			return $mac;
		}
		else{
			/*Cargamos la salida del comando arp -a en un buffer interno*/
			ob_start();
			system('arp -a');
			$tablaARP=ob_get_contents();
			ob_end_clean();
			/*Obtenenemos la posición donde está la IP del cliente en el buffer*/
			$pIP = strpos($tablaARP, $IP);
			/*Recogemos la dirección MAC a partir de la posición de la dirección IP + 22 */
			$mac=substr($tablaARP,$pIP+22,17);
			return $mac;
		}
	}
	
	//Esta función asigna una mac ( un puesto ) a un alumno determinado o lo elimina del puesto.
	// 1.- Asigna el Puesto.
	// 0.- Quita el puesto 
	function AsignarPuesto($alumno, $password, $modo)
	{
		//Nos traemos el password.
		$consulta="select password from configuracion";
		$result=mysql_query($consulta, $this->id_conexion) or die ("Error en la función AsignarPuesto");
		$fila=mysql_fetch_array($result);
		if (strcmp($password,$fila["password"])) {
			echo "<script language='javascript'>alert('Contraseña incorrecta!!!')</script>";
		}
		else 
		{
			//sacar el código.
			list($nombre, $codigo) = preg_split("/\(/", $alumno);
			$codigo=strtok($codigo, ")");
			
			//Asignamos o desasignamos el puesto al alumno.
			$mac=$this->ObtenerMac();
			if ($modo==1) //alumno se asigna al puesto.
				$consulta="update alumno set puesto='$mac', orden=null where codigo=$codigo";
			else //alumno se desasigna del puesto.
				$consulta="update alumno set puesto=null, orden=null where codigo=$codigo";
			//lanzamos la consulta.
			$result=mysql_query($consulta, $this->id_conexion) or die ("Error en la función AsignarPuesto al poner la mac");
			//Mensaje final.
			if ($modo==1) 
				echo "<script language='javascript'>alert ('$alumno asignado al puesto $mac. Pulsa en volver para regresar')</script>";
			else
				echo "<script language='javascript'>alert ('$alumno ha sido quitado del puesto $mac. Pulsa en volver para regresar')</script>";
				
			
		}
	
	}
	
	//Esta función quita un alumno determinado de la cola.
	function QuitarAlumnoCola($alumno, $password)
	{
		//Nos traemos el password.
		$consulta="select password from configuracion";
		$result=mysql_query($consulta, $this->id_conexion) or die ("Error en la función AsignarPuesto");
		$fila=mysql_fetch_array($result);
		if (strcmp($password,$fila["password"])) {
			echo "<script language='javascript'>alert('Contraseña incorrecta!!!')</script>";
		}
		else 
		{
			//sacar el código.
			list($nombre, $codigo) = preg_split("/\(/", $alumno);
			$codigo=strtok($codigo, ")");
			
			//lo sacamos de la cola.
			$consulta="update alumno set orden=null where codigo=$codigo";
			//lanzamos la consulta.
			$result=mysql_query($consulta, $this->id_conexion) or die ("Error en la función QuitarAlumnoCola");
			//Mensaje final.
			echo "<script language='javascript'>alert ('$alumno quitado de la cola. Pulsa en volver para regresar')</script>";
		}
	
	}
	
	//Nombre del grupo actual.
	public function NombreGrupoActual()
	{
		$grupo = $this->GrupoActual();

		$consulta = "select nombre from grupo where codigo=$grupo";
		$result = mysql_query($consulta, $this->id_conexion) or die("Error en la función NombreGrupoActual");
		$fila = mysql_fetch_array($result);
		return $fila["nombre"];
	}

	//obtener el grupo actual.
	public function GrupoActual()
	{
		$consulta="select grupo from configuracion";
		$result=mysql_query($consulta, $this->id_conexion) or die ("Error en la función GrupoActual");
		$fila=mysql_fetch_array($result);
		return $fila["grupo"];
	}
	//Esta función saca el puesto de la cola.
	function SacarPuesto()
	{
		
		$grupo=$this->GrupoActual();
		
		/*Vemos qué puesto es el primero, el que tiene el menor orden del grupo.
		$consulta="select puesto from alumno where orden in (select min(orden) from alumno where codGrupo=$grupo)";
		$result=@mysql_query($consulta, $this->id_conexion) or die("Error (POP) al traer el puesto con el mínimo orden");
		$fila=mysql_fetch_array($result);
		if (isset($fila["puesto"])) //Si existe, se procede a sacarlo de la cola -> poner orden a null.
		{
			$consulta="update alumno set orden=null where puesto='$fila[puesto]'";
			$result=@mysql_query($consulta, $this->id_conexion) or die("Error (POP) al poner orden a null");
		}*/
		
		//sacar el puesto de la cola.
		$puesto=$this->ObtenerMac();
		$consulta="update alumno set orden=null where puesto='$puesto' and codGrupo=$grupo";
		$result=@mysql_query($consulta, $this->id_conexion) or die("Error (POP) al poner orden a null");
		
	}
	
	//Esta función, dado un alumno, lo pone en la cola.
	function Push($alumno)
	{	
		//sacar el código.
		list($nombre, $codigo) = preg_split("/\(/", $alumno);
		$codigo=strtok($codigo, ")");
		
		//Comprobamos si su puesto ya está en cola.
		$puesto=$this->ObtenerMac();
		
		$consulta="update configuracion set pruebas='1'";
		$result=mysql_query($consulta, $this->id_conexion);
		
		$grupo=$this->GrupoActual();
		
		
		$consulta="select nombre from alumno where codGrupo=$grupo and puesto='$puesto' and orden is not null";
		$result=mysql_query($consulta, $this->id_conexion) or die ("Error en la función Push al ver si ya está el puesto en la cola");
		if ( mysql_num_rows($result) > 0) return;
		
		//Si no hay nadie del puesto en la cola.Lo introducimos*/
		$consulta="select orden from alumno where codigo=$codigo";
		$result=mysql_query($consulta, $this->id_conexion) or die ("Error en la función Push al introducir en cola");
		$fila=mysql_fetch_array($result);
		if (!isset($fila["orden"])) //lo metemos en la cola.
		{
			$orden=time(); //introducimos un dato de tipo timestamp.
			$consulta="update alumno set orden=$orden where codigo=$codigo";
			$result=mysql_query($consulta, $this->id_conexion) or die ("Error en la función Push al introducir en cola");
		}
	}
}

?>

