<html>
<head>
</head>
<body>
<?php
	function Obtener_Mac()
	{
		
		/*obtenemos la iP del cliente*/
		$IP=$_SERVER['REMOTE_ADDR'];
		if ( $IP=="::1" ) { /*el script se está ejecutando en el servidor*/
			/*Cargamos la salida del comando ipconfig/all en un buffer interno*/
			ob_start();
			system('ipconfig/all');
			$buffer=ob_get_contents();
			ob_clean();
			/*buscamos la subcadena 'sica' que viene de física*/
			$pMac=strpos($buffer, 'sica');
			/*Recogemos la dirección MAC a partir de la posición de la dirección IP + 22 */
			$mac=substr($buffer,$pMac+32,17);
			return $mac;
		}
		else{
			/*Cargamos la salida del comando arp -a en un buffer interno*/
			ob_start();
			system('arp -a');
			$tablaARP=ob_get_contents();
			ob_clean();
			/*Obtenenemos la posición donde está la IP del cliente en el buffer*/
			$pIP = strpos($tablaARP, $IP);
			/*Recogemos la dirección MAC a partir de la posición de la dirección IP + 22 */
			$mac=substr($tablaARP,$pIP+22,17);
			return $mac;
		}
	}
	
	echo Obtener_Mac();

//By AngelDX™
?>

</body>
</html>
