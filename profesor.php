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
			
			
			
			if (isset($_POST["btnAsignar"])) //En este caso asignamos el puesto al alumno.
			{
				$cola->AsignarPuesto($_POST["comboAlumnos"], $_POST["txtPassword"], 1);
			}
			if (isset($_POST["btnQuitar"])) //Lo dejamos sin puesto (Desasignar).
			{
				$cola->AsignarPuesto($_POST["comboAlumnos"], $_POST["txtPassword"], 0);
			}
			if (isset($_POST["btnQuitarAlumno"])) //Lo sacamos de la cola.
			{
				$cola->QuitarAlumnoCola($_POST["comboAlumnos"], $_POST["txtPassword"]);
			}
			if (isset($_POST["btnEstablecerGrupo"]))
			{
				$cola->EstablecerGrupo($_POST["comboGrupos"],$_POST["txtPassword"]);
			}
			
			//formulario para eliminar a un alumno de la cola*/
			echo "<form name='asignar' method='POST' action='profesor.php'>";
			echo "</br>Password: <input type='password' value='' name='txtPassword'></br>";
			$cola->ComboAlumnos(0);
			echo "<input type='submit' value='Asignar' name='btnAsignar'>";
			echo "<input type='submit' value='Desasignar' name='btnQuitar'>";
			echo "<input type='submit' value='Sacar de la Cola' name='btnQuitarAlumno'>";
			echo "<hr>";
			echo "<h3>Seleccionar grupo</h3>";
			$cola->ComboGrupos();
			echo "<input type='submit' value='Establecer Grupo' name='btnEstablecerGrupo'>";
			echo "<a href='alumno.php'><div class='botonTexto'>VOLVER</div></a>";
			echo "</form>";	
		?>
		
		
			
		
		</center>	
	</BODY>
</HTML>
