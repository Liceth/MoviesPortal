<?php

/* 
 *  Load configuration file
 *	
 */
 
require("includes/configuration.php");

?>

<!DOCTYPE html>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="movies.css" rel="stylesheet" type="text/css" media="screen">
<title>Contactos</title>

<link rel="stylesheet" href="flexslider.css" type="text/css">
</head>

<body>

<header>
	<div>
	<?php 
		session_start();
		include('includes/suscription-info.php');	 ?>
		<h1> Movies Portal</h1>
		
		<h2>Menu</h2>
			<div id="nav"> <ul>
				<li class="buttonborder"> <a href="index.php"> Inicio</a> </li>
				<li><a href="genres.php">Películas</a></li>
				<li><a href="#">Noticias</a></li>
				<li class = "buttoncolor"><a href="register.php">Contactos</a></li>
				<li class = "buttonborder2"><a href="#">Canales</a></li>
			</ul>
			</div>
	</div>
	</header>



<div id="wrapper">
		 		
		<div id ="content">
		<h2>Most viewed</h2>
		<h3>Registro de usuario</h3>
		
			<form action="" method="post" enctype="multipart/form-data" name="users-add-form" id="users-add-form">
				<h2>Contact form</h2>
				
				<label for="user">Usuario</label>
				<p class="formulario">
					<input id="user" name="user" type="text"/> 
				</p> 
				
				<label for="password">Contraseña </label>
				<p class="formulario">
					<input id="password" name="password" type="password"/> 
				</p> 
							
				<label>Nombre</label>
				<p class="formulario">
					<input id="name" name="name" type="text"/> 
				</p> 
				
				<label for="lastname">Apellido</label>
				<p class="formulario">
					<input id="lastname" name="lastname" type="text"/> 
				</p>
				
				<label for="address">Dirección</label>
				<p class="formulario">
					<input id="address" name="address" type="text"/> 
				</p> 
				
				<label for="telephone">Teléfono - celular</label>
				<p class="formulario">
					<input id="telephone" name="telephone" type="text"/> 
				</p> 
							
				<label for="email">Correo electrónico</label>
				<p class="formulario">
					<input id="email" name="email" type="text"/> 
				</p> 

			
			<label>&nbsp;</label>
					<input type="submit"  value = "Guardar" name="add" id="add" class="button4"/>
				
			</form>
			
			<?php
		
		
			if( isset($_POST['add']) ){
			
				$user = $_POST['user'];
				$name = $_POST['name'];
				$lastname = $_POST['lastname'];
				$email = $_POST['email'];
				$address = $_POST['address'];
				$telephone = $_POST['telephone'];
				$password = md5($_POST['password']);
				$created = date("Y-m-d H:i:s");
		
				
				$connection = mysql_connect($db_host,$db_user,$db_password);
				mysql_select_db($db_schema,$connection);
				mysql_set_charset('utf8',$connection);
		
				
				$query = "INSERT INTO suscriptions(user,name,lastname,email,password,telephone,address,created) VALUES('$user','$name','$lastname','$email','$password','$telephone','$address','$created')";			
				$result = mysql_query($query,$connection);
				
				if($result){
			
		?>
				<p class="done">El usuario ha sido agregado</p>
		<?php	
				}else{

		?>
		<p>Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
		<?php		
				}
				
				/* 
				 *  Close connection with MySQL Server
				 *
				 */
				
				mysql_close($connection);
			} 
		?>	
		 
		 </div>
		
		<div id = "sidebar">
		
		<h3>Beneficios...</h3>
		
		<div id = "benefits">
		
		<p class="ticket"></p>
		
		<p> <a target ="_blank" class="ficha_peli_dato">Crear tu lista - </a> Encuentra todo lo que deseas mirar</p>
		<p> <a target="_blank" class="ficha_peli_dato">Tus Ratings- </a> Evalúa y recuerda todo lo que habías visto antes</p>	
		<p> <a target="_blank" class="ficha_peli_dato">Comparte- </a> Muestra tus opiniones a través de las redes sociales</p>			
		
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
		<p  class="twitter"></p> 
		<p ><a href="#">@JorgMrtnz</a></p>
		
		<p ><a href="#">Jorge Martínez Gómez</a></p>
		<p  class="facebook"></p> 
		
		</div>
		</footer>


</body>

</html>