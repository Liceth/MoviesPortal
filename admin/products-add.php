<?php 
session_start();
if( !isset($_SESSION['bp_logged']) ){	
	header('Location: login.php'); 
} 
?>

<?php

/* 
 *  Load configuration file
 *	
 */
 
require("../includes/configuration.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>MoviesPortal</title>
<meta name="Robots" content="none" />
<link href="screen.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="container">
	<?php	include('../includes/admin-user-info.php');	?>
  <div id="header">
    <h1><a href="index.php" target="_self"><img src="../img/logo.png" /></a></h1>
  </div>
  <div id="navcontainer">
    <ul>
			<li><a href="index.php" target="_self">Inicio</a></li>
			<li><a href="products.php" target="_self" id="current">Productos</a></li>
			<li><a href="genres.php" target="_self">Géneros</a></li>
			<li><a href="inventory.php" target="_self">Inventario</a></li>
			<li><a href="history.php" target="_self">Registro</a></li>
		</ul>
  </div>
  <div id="content">
    <h2>Agregar Producto</h2>
		<?php
		
			/* 
			 *  If user press button add
			 *	
			 */
		
			if( isset($_POST['add']) ){
				
				/* 
				 *  Sanatize variables
				 *
				 *	@var string $name genre name
				 *	@var date $created genre creation date
				 *	
				 */
				
				$name = $_POST['name'];
				$description = $_POST['description'];
				$genre = $_POST['genre'];
				$user = $_SESSION['bp_id'];
				$rating = $_POST['rating'];
				$created = date("Y-m-d H:i:s");
				$modified = $created;
				$price = $_POST['price'];
				$onsale = $_POST['onsale'];
				$publics = $_POST['publics'];
			
				
				if( is_uploaded_file($_FILES['photo']['tmp_name'] )){
					
					if( move_uploaded_file($_FILES['photo']['tmp_name'],'../files/'.$_FILES['photo']['name']) ){
						
						$photo = 'files/'.$_FILES['photo']['name'];
					
					}
					
				}
				
				/* 
				 *  Connect to MySQL Server
				 *	Select the default schema
				 *	Set charset connection between PHP and MySQL Server
				 *	
				 */
				
				$connection = mysql_connect($db_host,$db_user,$db_password);
				mysql_select_db($db_schema,$connection);
				mysql_set_charset('utf8',$connection);
				
				/* 
				 *  Preparing query to insert data
				 *	Save result of the transaction in the result variable 
				 *	
				 *	@var string $query Query
				 *	@var recordset $result Recordset
				 */
				
				$query = "INSERT INTO products(name,description,photo,genre_id,created,modified,user_id,rating,price,onsale,publics) VALUES('$name','$description','$photo','$genre','$created','$modified','$user','$rating','$price','$onsale','$publics')";			
				$result = mysql_query($query,$connection);
				
				if($result){
					
				/* 
				 *  If result was true the transaction was sucessful
				 *
				 */
		?>
		<p class="done">El producto ha sido agregado</p>
		<?php	
				}else{
					
				/* 
				 *  If result is false, something was wrong with the transaction
				 *
				 */	
		?>
		<p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
		<?php		
				}
				
				/* 
				 *  Close connection with MySQL Server
				 *
				 */
				
				mysql_close($connection);
			} 
		?>	
    <form action="" method="post" enctype="multipart/form-data" name="users-add-form" id="users-add-form">
		<p>
			<label for="name">Nombre:</label>
			<input name="name" type="text" id="name" size="40" />
		</p>
		<p>
			<label for="description">Descripción:</label>
			<textarea name="description" id="description" cols="50" rows="8"></textarea>
		</p>
		<p>
			<label for="rating">Valoración:</label>
			<select name="rating" id="rating">
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
			</select>
		</p>
			
		<p>
			<label for="photo">Fotografía:</label>
			<input name="photo" type="hidden" value="None"/>
			<input type="file" name="photo" id="photo" />
		</p>
		<p>
      	<label for="genre">Categoria:</label>
      	<select name="genre" id="genre">
     	<?php
		
				/* 
				 *  Connect to MySQL Server
				 *	Select the default schema
				 *	Set charset connection between PHP and MySQL Server
				 *	
				 */
				
				$connection = mysql_connect($db_host,$db_user,$db_password);
				mysql_select_db($db_schema,$connection);
				mysql_set_charset('utf8',$connection);
				
				/* 
				 *  Preparing query select data
				 *	Save result of the transaction in the result variable 
				 *	
				 *	@var string $query Query
				 *	@var recordset $result Recordset
				 */
				
				$query = "SELECT id, name FROM genres ORDER BY name ASC";
				$result = mysql_query($query,$connection);
				
				if($result){
					
				/* 
				 *  If result was true the transaction was sucessful
				 *
				 */
				 	while( $row = mysql_fetch_array($result) ){
			?>
					<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
			<?php
					}
				}
			?>
				</select>
      </p>
		<p>
			<label for="price">Precio:</label>
			<input name="price" type="text" id="price" size="40" />
		</p>
		<p>
			<label for="onsale">Promoción:</label>
			<input name="onsale" type="hidden" value="0"/>
			<input name="onsale" type="checkbox" value="1" id="onsale" size="40" />
		</p>
		<p>
			<label for="publics">Público:</label>
			<input name="publics" type="hidden" value="0"/>
			<input name="publics" type="checkbox" value="1" id="publics" size="40" />
		</p>
		
	  
      <p>
        <label for="add">&nbsp;</label>
        <input type="submit" name="add" id="add" value="Guardar" />
      </p>
    </form>
  </div>
</div>
</body>
</html>
