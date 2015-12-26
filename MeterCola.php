<html>
	<head>
	</head>
	<body>
		<?php
			require("cola.php");
			$cola=new cola("localhost");
			
			$cola->Push($_GET["id"]);
			
			$cola->Mostrar();
		?>
	</body>
</html>
