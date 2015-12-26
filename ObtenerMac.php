<html>
<head>
</head>
<body>
<?php
	function Obtener_Mac()
	{
		
		/*obtenemos la iP del cliente*/
		$IP=$_SERVER['REMOTE_ADDR'];
		if ( $IP=="::1" ) { /*el script se est� ejecutando en el servidor*/
			/*Cargamos la salida del comando ipconfig/all en un buffer interno*/
			ob_start();
			system('ipconfig/all');
			$buffer=ob_get_contents();
			ob_clean();
			/*buscamos la subcadena 'sica' que viene de f�sica*/
			$pMac=strpos($buffer, 'sica');
			/*Recogemos la direcci�n MAC a partir de la posici�n de la direcci�n IP + 22 */
			$mac=substr($buffer,$pMac+32,17);
			return $mac;
		}
		else{
			/*Cargamos la salida del comando arp -a en un buffer interno*/
			ob_start();
			system('arp -a');
			$tablaARP=ob_get_contents();
			ob_clean();
			/*Obtenenemos la posici�n donde est� la IP del cliente en el buffer*/
			$pIP = strpos($tablaARP, $IP);
			/*Recogemos la direcci�n MAC a partir de la posici�n de la direcci�n IP + 22 */
			$mac=substr($tablaARP,$pIP+22,17);
			return $mac;
		}
	}
	
	echo Obtener_Mac();

//By AngelDX�
?>

</body>
</html>
