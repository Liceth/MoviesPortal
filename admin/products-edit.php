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
			<li><a href="products.php" target="_self" id="current">Recetas</a></li>
			<li><a href="genres.php" target="_self">Categorias</a></li>
			<li><a href="inventory.php" target="_self">Inventario</a></li>
			<li><a href="history.php" target="_self">Registro</a></li>
		</ul>
  </div>
  <div id="content">
    <h2>Editar producto</h2>
		<?php
		
			/* 
			 *  If user press button add
			 *	
			 */
		
			if( isset($_POST['edit']) ){
				
				/* 
				 *  Sanatize variables
				 *
				 *	@var string $id Category id
				 *	@var string $name Category name
				 *	@var string $modified Category modified date
				 *	
				 */
				
				$id = $_GET['id'];
				$name = $_POST['name'];
				$description = $_POST['description'];
				$genre = $_POST['genre'];
				$rating = $_POST['rating'];
				$price = $_POST['price'];
				$onsale = $_POST['onsale'];
				$modified = date("Y-m-d H:i:s");
				
				$photo = "";
				
				if( is_uploaded_file($_FILES['photo']['tmp_name'] )){
					
					if( move_uploaded_file($_FILES['photo']['tmp_name'],'../files/'.$_FILES['photo']['name']) ){
						
						$photo = "photo='files/".$_FILES['photo']['name']."', ";
					
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
				
				$query = "UPDATE products SET name='$name', description='$description', $photo genre_id=$genre, price = '$price', rating = '$rating', onsale = '$onsale', modified='$modified' WHERE id=$id";
				$result = mysql_query($query,$connection);
				
				if($result){
					
				/* 
				 *  If result was true the transaction was sucessful
				 *
				 */
		?>
		<p class="done">El producto ha sido editado</p>
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
		<?php
		
			/* 
			 *  If id exists in URL
			 *	
			 */
		
			if( isset($_GET['id']) ){
				
				/* 
				 *  Sanatize variables
				 *
				 *	@var int $id Category ID
				 *	
				 */
				
				$id = $_GET['id'];
				
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
				 *  Preparing query to update data
				 *	Save result of the transaction in the result variable 
				 *	
				 *	@var string $query Query
				 *	@var recordset $result Recordset
				 */
				
				$query = "SELECT products.name as name, products.description as description, products.photo as photo, genres.id as genre ,products.rating as rating,products.price as price,products.onsale as onsale FROM products,genres WHERE products.genre_id = genres.id and products.id=$id";			
				$result = mysql_query($query,$connection);
				
				if($result){
					
				/* 
				 *  If result was true the transaction was sucessful
				 *	We extract the record in variable $row
				 *
				 *	@var record $row Record 
 				 *	@var string $name Category name
				 */
				 	
					$row = mysql_fetch_array($result);					
					$name = $row['name'];
					$photo = $row['photo'];
					$description = $row['description'];
					$genre = $row['genre'];
					$rating = $row['rating'];
					$onsale = $row['onsale'];
					$price = $row['price'];
		
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
        <input name="name" type="text" id="name" size="80" value="<?php echo $name; ?>" />
      </p>
      <p>
				<label for="description">Descripción:</label>
      	<textarea name="description" id="description" cols="70" rows="8"><?php echo $description; ?></textarea>
			</p>
      <p>
      	<label>&nbsp;</label>
      	<img src="../<?php echo $photo; ?>" />
      </p>
		<p>
      	<label for="photo">Fotografía:</label>
      	<input type="file" name="photo" id="photo" />
      </p>
	   <p>
        <label for="price">Precio:</label>
        <input name="price" type="text" id="price" size="80" value="<?php echo $price; ?>" />
      </p>
	  
	   <p>
        <label for="rating">Valoración:</label>
        <?php echo "Anterior: ",$rating; echo "\n\n	Nueva: ";?>
				<select name="rating" id="rating">
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
			</select>
      </p>
	   <p>
        <label for="onsale">Promoción:</label>
        <?php 	if( $onsale == 1)
				{echo "Anterior: Sí"; echo "\n\n	Nueva: ";}
				else
				{echo "Anterior: No"; echo "\n\n	Nueva: ";}
				?>
				<select name="onsale" id="onsale">
				<option value="1">Si</option>
				<option value="0">No</option>
				
			</select>
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
					<option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $genre) echo 'selected="selected"'; ?>><?php echo $row['name']; ?></option>
			<?php
					}
				}
			?>
				</select>
      </p>
      <p>
        <label for="edit">&nbsp;</label>
        <input type="submit" name="edit" id="edit" value="Guardar" />
      </p>
    </form>
  </div>
</div>
</body>
</html>
