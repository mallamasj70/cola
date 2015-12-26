<HTML>
	<?php
			require("cola.php");
			$cola=new cola("localhost");
	?>
	<HEAD>
		<TITLE>Unidad 4</TITLE>
		<link rel="stylesheet"  href="estilo.css"  type="text/css">
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<style>
			.listaEspera{
				margin: 5%, auto;
				background-color: black;
				color:white;
			}
		</style>
		<script type="text/javascript">
			
			
			//usamos Ajax, concretamente el método XMLHttpRequest.
			function crear_xhr()  //creamos el objeto.
			{
				var xhr=null;
				
				if (window.XMLHttpRequest)
				{
					xhr = new XMLHttpRequest();
				}
				else
				{
					xhr = new ActiveXObject("Microsoft.XMLHTTP");
				}
				return xhr;
			}
			
			function MostrarCola()
			{
				var objxhr=null;
				
				objxhr=crear_xhr();
				if (objxhr){
					//Programamos el evento readyState que se ejecuta cada vez que hay un cambio.
					objxhr.onreadystatechange=function()
					{
						if (objxhr.readyState==4 && objxhr.status==200) //si todo ha ido correcto, recogemos la respuesta.
						{
							document.getElementById("cola").innerHTML=objxhr.responseText;
						}
					}
					
					//con open ejecutamos la página PHP, tenemos que pasar el alumno que vamos a meter en cola.
					objxhr.open("GET", "Mostrarcola.php", true);
					objxhr.send(null); //para enviar la petición.
				}
				else alert("error");
			}
			
			function Temporizador()
			{
				setInterval(MostrarCola,1000);
			}
			
			function Actuar(opcion)
			{
				
				var objxhr=null;
					
				
				objxhr=crear_xhr();
				if (objxhr){
					
					if (opcion==1){ //en este caso metemos un alumno en la cola.
						var calumno=document.getElementById("alumno");
						var alumno=calumno.options[calumno.selectedIndex].value;
						
						//con open ejecutamos la página PHP, tenemos que pasar el alumno que vamos a meter en cola.
						objxhr.open("GET", "MeterCola.php?id='"+alumno+"'", true);
						objxhr.send(null); //para enviar la petición.
						//alert('Estás en espera.');
					}	
					else{ //sacamos el alumno de la cola, es decir, realmente lo que se saca es el puesto.
						objxhr.open("GET", "SacarCola.php", true);
						objxhr.send(null);
						//alert('Ya no estás en espera.');
					} 
				}
				else alert("error");
			}
			
		</script>
	</HEAD>
	<BODY bgcolor="#C0C0C0" link="black" vlink="black" alink="black" onload="Temporizador()">	
		<center>
		
		
		<?php
			
			echo "<div style='position:absolute;bottom:350px;left:50px;'>";
			echo "<table border='0' cellpadding='10'>";
			//mostrar el alumno o alumnos que pueden usar la cola en ese PC.
			$cola->ComboAlumnos(1);
			echo "<button type='button' onclick='Actuar(1);'>".utf8_encode("Pedir Número")."</button>";
			echo "</br><button type='button' onclick='Actuar(2);'>Salir de la cola</button>";
				
			echo "<tr><td color='red' align='center'><a href='profesor.php'><div class='botonTexto'>PROFESOR</div></a></td></tr>";
			echo "</table>";
			echo "</div>";
			$grupo = $cola->NombreGrupoActual();
			echo "<h1 class = 'listaEspera'>LISTA DE ESPERA GRUPO: $grupo</h1>";
			echo "<p id='cola'></p>";			
			
		?>
		
		
			
		
		</center>	
	</BODY>
</HTML>
