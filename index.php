<?php
	require("includes/configuration.php");
?>

<!DOCTYPE html>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="movies.css" rel="stylesheet" type="text/css" media="screen">
<title>Movies Portal - Jorge Martinez</title>

<link rel="stylesheet" href="flexslider.css" type="text/css" media="screen and (min-width: 990px)">
<link href="mobile.css" rel="stylesheet" type="text/css" media="only screen and (max-width: 990px)" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="jquery.flexslider.js"></script>

<!-- Place in the <head>, after the three links -->
<script type="text/javascript" >
  $(window).load(function() {
    $('.flexslider').flexslider();
	
	
  });
</script>
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
				<li class = "button"> <a href="index.php"> Inicio</a> </li>
				<li><a href="genres.php">Películas</a></li>
				<li><a href="#">Noticias</a></li>
				<li><a href="register.php">Contactos</a></li>
				<li class = "buttonborder2"><a href="#">Canales</a></li>
			</ul>
			</div>
	</div>
	</header>



<div id="wrapper">
		  
		<h2>Spotlight</h2>
		
		<!-- Place somewhere in the <body> of your page -->
		<div  id ="flexslider" class="flexslider">
		  <ul class="slides">
			<li>
			 <img src="images/re5.jpg" class="slideimg" alt="" />
			 
			 <div class="flex-caption gdl-slider-caption">
			 <div class="slider-Title">Resident evil 5</div>
			  Con la ayuda de nuevos aliados, amigos y familiares, Alice deberá luchar para sobrevivir el tiempo suficiente como para escapar de un mundo hostil al borde del olvido.</div>
			 
			</li>
			
			<li>
			  <img src="images/mib.jpg" class="slideimg" alt="" />
			  <div class="flex-caption gdl-slider-caption">
			  <div class="slider-Title">Men in Black: 3</div>
			  En esta nueva entrega de la saga "Hombres de negro, los agentes J y K regresan....pero esta vez al pasado. </div>
			</li>
			<li>
			  <img src="images/texas.gif" class="slideimg" alt="" />
			  <div class="flex-caption gdl-slider-caption">
			  <div class="slider-Title">Texas Chainsaw Massacre</div>
			  Un nuevo grupo de jóvenes decide visitar la zona porque uno de ellos ha heredado una propiedad allí, quedando claro bastante pronto que no toda la familia de matarifes fue exterminada en su momento.</div>
			  </li>
			<li>
			  <img src="images/batman.jpg" class="slideimg" alt="" />
			  <div class="flex-caption gdl-slider-caption">
			  <div class="slider-Title">Batman: The Dark Knight Rises</div>
			  Ocho años después de los acontecimientos de The Dark Knight, Gotham se encuentra en un estado de paz. En virtud de los poderes otorgados por la Ley Dent, el comisario Gordon casi ha erradicado la violencia y el crimen organizado. </div>
			  
			</li>
			 </ul>
		</div>

		<div id="recent">
		
		<h3>Últimas películas...</h3>
		<?php
			$connection = mysql_connect($db_host,$db_user,$db_password);
				mysql_select_db($db_schema,$connection);
				mysql_set_charset('utf8',$connection);
				
				$query = "SELECT id,name,photo FROM products WHERE publics = '1' ORDER BY modified DESC LIMIT 0,4";			
				$result = mysql_query($query,$connection);
				
				if($result){
				
					while ($row = mysql_fetch_array($result))
					{
						$name = $row['name'];
						$photo = $row['photo'];
					?>	
						<div><a href="details.php?id=<?php echo $row['id']; ?>"><img src="../<?php echo $photo; ?>" alt="" /></a><p><a href="details.php?id=<?php echo $row['id']; ?>"><?php echo $name ?></a></p></div>
					<?php
					}
				}else{
				
			?>
				<p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
			<?php		
				}
			
				mysql_close($connection);
			 
		?>
			
			<p class="more"><a href="#"> Ver más</a></p>
				
		</div>
		
		<div id ="content">
		<h2>Most viewed</h2>
		<h3>Noticias</h3>
			<div>
				<p class="title">Impactante trailer de "Iron Man 3</p>
				<img src="img/viewed/ironman3.jpg" alt="" />
				<p> Hace unos días se reveló un teaser que despertó toda la ansiedad de los fans por la tercera entrega de Iron Man. Ahora se presentó el 
				primer tráiler oficial del film que contiene imágenes realmente deslumbrantes y nos permite ver que las cosas han cambiado, Tony Stark ya 
				no es el de antes sino que vemos a un ser humano preocupado por las cosas y las personas que le importan. También tenemos la presentación 
				de Ben Kingsley como El Mandarín con una frase que nos asegura que tenemos un villano para temer</p>
				<p class="details"><a href="#">Detalles</a></p> 
				<p class="trailers"><a href="#">Trailer</a></p> 
				
			</div>
			
			<div id="video">
				<iframe class="youtube-player"  width="420" height="310" src="http://www.youtube.com/embed/bKWvs_yCT6c?rel=0"  seamless="seamless" ></iframe>
			</div>
		
		</div>
		
		<div id = "sidebar">
		
		<h3>Últimas promociones</h3>
		
		<div id = "next">
		<?php
			$connection = mysql_connect($db_host,$db_user,$db_password);
				mysql_select_db($db_schema,$connection);
				mysql_set_charset('utf8',$connection);
				
				$query = "SELECT id,photo FROM products WHERE onsale = '1' ORDER BY modified DESC LIMIT 0,3";			
				$result = mysql_query($query,$connection);
				
				if($result){
				
					while ($row = mysql_fetch_array($result))
					{
						$photo = $row['photo'];
					?>	
						<a href="details.php?id=<?php echo $row['id']; ?>"><img src="../<?php echo $photo; ?>" alt= ""/> </a>
					
					<?php
					}
				}else{
				
			?>
				<p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
			<?php		
				}
			
				mysql_close($connection);
			 
		?>
			
		<p class="more"><a href="#"> Ver Más</a></p> 
		</div>
		
		<h3> Trailers </h3>
		<div id="trailer">
		<div><img src="img/trailers/madagascar.jpg" alt=""/> <p>Animados</p><p> Madagascar 3</p><p></p></div>
		<div><img src="img/trailers/expendables2.jpg" alt="" /><p>Acción</p> <p>Los mercenarios 2</p><p></p></div>
		<div><img src="img/trailers/snow.jpg" alt="" /> <p>Aventura</p> <p>Blanca nieves y el cazador</p><p></p></div>
		
		<p class="more"><a href="#">Ver Más</a></p>
		</div>
		</div>
</div>

		<footer>
		<div><p> Movies Portal © 2012 - Privacy Policy </p>
	
		
		</div>
		</footer>


</body>

</html>
