<HTML>
	<HEAD>
		<TITLE>Unidad 4</TITLE>
		<link rel="stylesheet"  href="estilo.css"  type="text/css">
	</HEAD>
	<BODY bgcolor="#C0C0C0" link="black" vlink="black" alink="black">	
		<center>
		
		<?php
			require("cola.php");
			$cola=new cola("localhost");
			
			/*pedir número, si el alumno lo ha pedido y mostrar formulario de entrada al alumno*/
			if (isset($_POST["btnPedirNumero"]))
			{
				$cola->Push($_POST["comboAlumnos"]);
				echo "<script language='javascript'>alert('Estas en espera. Pulsa en VOLVER para regresar');</script>";
			}
				
			echo "<form name='PedirNumero' method='POST' action='PedirNumero.php'>";
			$cola->ComboAlumnos(1);
			echo "<input type='submit' value='Pedir Número' name='btnPedirNumero'>";
			echo "<a href='alumno.php'><div class='botonTexto'>VOLVER</div></a>";
			echo "</form>";	
		?>
		
		
			
		
		</center>	
	</BODY>
</HTML>
