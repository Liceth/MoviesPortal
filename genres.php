<?php
	require("includes/configuration.php");
?>

<!DOCTYPE html>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="movies.css" rel="stylesheet" type="text/css" media="screen">
<title>Géneros</title>

<link rel="stylesheet" href="flexslider.css" type="text/css">
</head>

<body>

<header>
	<div>
		<?php session_start();
		include('includes/suscription-info.php');	 ?>
		<h1> Movies Portal</h1>
		
		<h2>Menu</h2>
			<div id="nav"> <ul>
				<li class="buttonborder"> <a href="index.php"> Inicio</a> </li>
				<li class = "buttoncolor"><a href="genres.php">Películas</a></li>
				<li><a href="#">Noticias</a></li>
				<li ><a href="register.php">Contactos</a></li>
				<li class = "buttonborder2"><a href="#">Canales</a></li>
			</ul>
			</div>
	</div>
	</header>



<div id="wrapper">
		 		
		<div id ="content">
		<h3>Productos</h3>
		
		<?php
			if( isset($_GET['id']) )
			{
				$id = $_GET['id'];
			}
			else
			{	$id = 1;}
			
				$connection = mysql_connect($db_host,$db_user,$db_password);
				mysql_select_db($db_schema,$connection);
				mysql_set_charset('utf8',$connection);
				
				$query = "SELECT id,name,photo FROM products WHERE genre_id = $id";			
				$result = mysql_query($query,$connection);
				
				if($result){
				
					while ($row = mysql_fetch_array($result))
					{
						$movie = $row['name'];
						$pic = $row['photo'];
					?>	
						<div class="movielist">
						<p>
						<a href="details.php?id=<?php echo $row['id']; ?>" ><img src="../<?php echo $pic; ?>" alt="" /></a>
						<a href="details.php?id=<?php echo $row['id']; ?>" ><?php echo $movie; ?></a></p>
						</div>
					
					<?php
					}
				}else{
				
			?>
				<p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
			<?php		
				}
			
				mysql_close($connection);
			
			 
		?>
		 
		 </div>
		
		<div id = "sidebar">
		
		<h3>Secciones...</h3>
		
		
		<div id = "genres">
		
		
		<?php
			$connection = mysql_connect($db_host,$db_user,$db_password);
				mysql_select_db($db_schema,$connection);
				mysql_set_charset('utf8',$connection);
				
				$query = "SELECT id,name FROM genres";			
				$result = mysql_query($query,$connection);
				
				if($result){
				
					while ($row = mysql_fetch_array($result))
					{
						$name = $row['name'];
						$idhere = $row['id'];
						
						if($idhere != $id)
						{
					?>	
						<p><a href="genres.php?id=<?php echo $idhere; ?>" > <?php echo $name; ?></a></p>
					
					<?php
					}	else{
					?>	
						<p class="buttonhere"><a href="genres.php?id=<?php echo $idhere; ?>" > <?php echo $name; ?></a></p>
					
					<?php
						
					}
					}
				}else{
				
			?>
				<p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
			<?php		
				}
			
				mysql_close($connection);
			 
		?>
		
		</div>
		
		<h3> Iniciar sesión</h3>
		<div id="login">
		
		<p class="log"></p>
		
		<p> Inicia sesión con tu nombre de usuario y contraseña</p>
		
		
		<p class="more"><a href="#">Iniciar sesión</a></p>
		</div>
		
		<h3> Registrarse con Facebook </h3>
		<div id="facebook">
		
		<p class="fb"></p>
		
		<p> Regitrarse utilizando cuenta de facebook</p>
		
		
		<p class="fbutton"><a href="#">Iniciar sesión en Facebook</a></p>
		</div>
		</div>
</div>

		<footer>
		<div><p> Movies Portal © 2012 - Privacy Policy </p>
		
		
		</div>
		</footer>


</body>

</html>
