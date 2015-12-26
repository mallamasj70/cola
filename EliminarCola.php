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
			
			if (isset($_POST["btnQuitarCola"]))
			{
				$cola->SacarPuesto();
				echo "<script language='javascript'>alert('Ya no estás en espera. Pulsa abajo en VOLVER para regresar');</script>";
			}
			
			echo "<form action='EliminarCola.php' method='POST'>";
			echo "<font size='5'><u><b>¿Salir de la cola?</b></u></font>";
			echo "</br><input type='submit' value='ACEPTAR' name='btnQuitarCola'>";
			echo "<a href='alumno.php'><div class='botonTexto'>VOLVER</div></a>";
			echo "</form>";	
				
			
			
			
		?>
		
		
			
		
		</center>	
	</BODY>
</HTML>