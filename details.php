<?php
	require("includes/configuration.php");
?>
<!DOCTYPE html>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="movies.css" rel="stylesheet" type="text/css" media="screen">
<title>Información</title>

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
				<li class = "buttoncolor"><a href="genres.php">Películas</a></li>
				<li><a href="#">Noticias</a></li>
				<li><a href="contacts.html">Contactos</a></li>
				<li class = "buttonborder2"><a href="#">Canales</a></li>
			</ul>
			</div>
	</div>
	</header>
	
	
<div id="wrapper">
		  
			
		<div id ="content">
		<h2>Most viewed</h2>
		<h3>Información</h3>
		<div>
	
		 <?php
		
			if( isset($_GET['id']) ){
				
				$id = $_GET['id'];
	
				
				$connection = mysql_connect($db_host,$db_user,$db_password);
				mysql_select_db($db_schema,$connection);
				mysql_set_charset('utf8',$connection);
		
				
				$query = "SELECT products.name as name,products.photo as photo,products.description as description,products.rating as rating,products.price as price,genres.name as genre,products.visited as visited FROM products,genres WHERE products.id=$id AND products.genre_id = genres.id";			
				$result = mysql_query($query,$connection);
				
				if($result){
							 	
					$row = mysql_fetch_array($result);					
					$name = $row['name'];
					$photo = $row['photo'];
					$description = $row['description'];
					$rating = $row['rating'];
					$price = $row['price'];
					$genre = $row['genre'];
					$visited = (int) $row['visited'];
					
					$visited = $visited + 1;
					
					$resultquery = mysql_query("UPDATE products SET visited = '$visited' WHERE id = $id",$connection);
					
					//	Data acquisition from inventory
					$query2 = "SELECT quantity FROM inventory WHERE product_id = $id";
					$ans = mysql_query($query2,$connection);
					
					if($ans)
					{
						$row = mysql_fetch_array($ans);
						$quant = $row['quantity'];
					}
			?>	

			<p class="title"><?php echo $name ?></p>
			<p><strong>Cantidades disponibles: </strong> 
			<?php if ($quant >= 0) {echo $quant;} else {echo "Agotado";} ?>
			
			</p>
				<img src="../<?php echo $photo; ?>" alt="" />
				
				<?php
					
					if ($quant <= 0)
					{
					?>
					<img class="out" src="visual/soldout.png"></img>
					<?php
					}
				?>
			<p>
				<a target="_blank" class="ficha_peli_dato">Género: </a> <?php echo $genre ?> </br> </br>
				<a target="_blank" class="ficha_peli_dato">Precio: </a> $<?php echo $price ?> </br> </br>
				<a target="_blank" class="ficha_peli_dato">Descripción: </a> <?php echo $description ?>

			</p>
			
		<?php
			
			if( isset($_SESSION['mp_logged']) )
				if( $quant != 0)
				{
			
			{
		?>
			<form action="" method="post" enctype="multipart/form-data" name="buy-form" id="users-add-form">
				
				<p> <strong> Agregar al carro de compras </strong>
					<img class="shop" src="visual/cart.png" width="32px" height="32px"></img>
				</p>
				
				<p class="formulario">
					<label for="buy">Cantidad: </label>
					<input id="quantity" name="quantity" type="text" size="40"/> 
					<input type="submit"  value = "Agregar" name="buy" id="buy" class="button4"/>
				</p> 
				
					
				
			</form>
		<?php				
			}	
				}			
		?>
		
			<?php
		
				
			if( isset($_POST['buy']) ){
								
				$quantity = (int) $_POST['quantity'];
				$created = date("Y-m-d H:i:s");
				
				$exc = (int)$quant - $quantity;
				if( $exc < 0 )
				{
				 $exc = $exc * -1;
				?>
				<p class="done">La cantidad a comprar excede al inventario por <?php echo $exc;?> items</p>
				<?php
				}else
				
				{
					$totalprice = (int) $price * $quantity;
					$user = (string) $_SESSION['mp_id'];
							
					$queryuser = "INSERT INTO shops (suscription_id,product_id,quantity,totalprice,created) VALUES ('$user','$id','$quantity','$totalprice','$created')";			
					$ansuser = mysql_query($queryuser,$connection);
				
					if($ansuser){
				?>
				<p class="done">Se ha agregado al carro de compras $<?php echo $totalprice;?></p>
				<?php	
						}else{
				?>
				<p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
				<?php		
						}
					}
				}					
				?>	
	
		
			</div>		
		</div>
			
		<div id = "sidebar">
			
			<h3>Rating</h3>
		
			<div id = "rating">
			
			<p class="star"><?php echo $rating ?></p>
			
			<p> Ratings: <a target="_blank"><?php echo $rating ?> </a>/5 from <a href="#">356,325 users</a>   Metascore: <a href="#">69/100 </a>  
				Reviews: 1,231 user | 527 critic | 43 from <a href="#">Metacritic.com</a>	</p>
			
			</div>
			
			<?php
			
				}else{
		
		?>
		<p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
		<?php		
				}
				
					
				mysql_close($connection);
			} 
		?>
		
			<h3> Trailers </h3>
			<div id="trailer">
			<div> <img src="img/trailers/madagascar.jpg" alt=""/> </a><p>Animados</p><p> Madagascar 3</p><p></p></div>
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
