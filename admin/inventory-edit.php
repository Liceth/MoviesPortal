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
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Movies Portal</title>
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
			<li><a href="products.php" target="_self">Películas</a></li>
			<li><a href="inventory.php" target="_self" >Géneros</a></li>
			<li><a href="inventory.php" target="_self" id="current">Inventario</a></li>
			<li><a href="history.php" target="_self">Registro</a></li>
		</ul>
  </div>
  <div id="content">
    <h2>Editar producto del inventario</h2>
		<?php

		
			if( isset($_GET['id']) ){
	
				
				$id = $_GET['id'];
	
				
				$connection = mysql_connect($db_host,$db_user,$db_password);
				mysql_select_db($db_schema,$connection);
				mysql_set_charset('utf8',$connection);

				
				$query = "SELECT products.name as name,inventory.quantity as quantity FROM products,inventory WHERE inventory.id=$id AND products.id = inventory.product_id";			
				$result = mysql_query($query,$connection);
				
				if($result){
	
				 	
					$row = mysql_fetch_array($result);					
					$name = $row['name'];
					$quantity = $row['quantity'];
		
				}else{

		?>
		<p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
		<?php		
				}

				
				mysql_close($connection);
			} 
		?>
		<?php

		
			if( isset($_POST['edit']) ){

				
				$id = $_GET['id'];
				$quantity = $_POST['quantity'];
	
				
				$connection = mysql_connect($db_host,$db_user,$db_password);
				mysql_select_db($db_schema,$connection);
				mysql_set_charset('utf8',$connection);
	
				
				$query = "UPDATE inventory SET quantity='$quantity' WHERE id=$id";
				$result = mysql_query($query,$connection);
				
				if($result){

		?>
		<p class="done">El producto ha sido modificado del inventario</p>
		<?php	
				}else{
		
		?>
		<p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
		<?php		
				}
				
				mysql_close($connection);
			} 
		?>	
    <form action="" method="post" enctype="multipart/form-data" name="inventory-add-form" id="inventory-add-form">
		 <?php echo ("Producto: $name");?>
	  
	  <p>
		
        <label for="name">Cantidad</label>
        <input name="quantity" type="text" id="quantity" size="80" value="<?php echo $quantity; ?>" />
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
