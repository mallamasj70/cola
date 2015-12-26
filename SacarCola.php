<html>
	<head>
	</head>
	<body>
		<?php
			require("cola.php");
			$cola=new cola("localhost");
			
			$cola->SacarPuesto();
			
			$cola->Mostrar();
		?>
	</body>
</html>
