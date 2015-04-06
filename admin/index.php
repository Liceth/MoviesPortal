<?php 
session_start();
if( !isset($_SESSION['bp_logged']) ){	
	header('Location: login.php'); 
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>MoviesPortal</title>
<meta name="Robots" content="none" />
<link href="screen.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="container">
	<?php	include('../includes/admin-user-info.php');	?>
	<div id="header">
		<h1><a href="index.php" target="_self"><img width="183" height="69" alt="" src="../img/logo.png" /></a></h1>
	</div>
	<div id="navcontainer">
		<ul>
			<li><a href="index.php" target="_self" id="current">Inicio</a></li>
			<li><a href="products.php" target="_self">Productos</a></li>
			<li><a href="genres.php" target="_self">Géneros</a></li>
			<li><a href="inventory.php" target="_self">Inventario</a></li>
			<li><a href="history.php" target="_self">Registro</a></li>
		</ul>
	</div>
	<div id="content">
		<p>&nbsp;</p>
	</div>
</div>
</body>
</html>