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
	<form method="post" enctype="application/x-www-form-urlencoded" name="products-list-form" id="products-list-form">
      <p><a href="products-add.php" target="_self" class="button2">Agregar</a></p>
      <input type="submit" name="products-delete" id="products-delete" value="Eliminar" />
      <input type="submit" name="products-activate" id="products-activate" value="Publicar" />
      <input type="submit" name="products-deactivate" id="products-deactivate" value="Dar de baja" />
      <?php
				if(isset($_POST['products-activate']))
				{
					$condition = "";
					$modified = date("Y-m-d H:i:s");
					foreach($_POST as $key => $value){			
						if($key != 'products-activate'){						
							$condition.="id=$value or ";						
						}												
					}
					
					$condition.="id=-1";	
					
					$connection = mysql_connect($db_host,$db_user,$db_password);
					mysql_select_db($db_schema,$connection);
					mysql_set_charset('utf8',$connection);
					
					$query = "UPDATE products SET publics = '1',modified = '$modified' WHERE $condition";
					$result = mysql_query($query,$connection);
					
					if($result){
					
				?>
				<p class="done">El producto(s) ha sido público(s)</p>
				<?php	
					}else{
				?>
				<p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
				<?php		
					}
									
					mysql_close($connection);
				}

				if(isset($_POST['products-deactivate']))
				{
					$condition = "";
					
					foreach($_POST as $key => $value){			
						if($key != 'products-deactivate'){						
							$condition.="id=$value or ";						
						}												
					}
					
					$condition.="id=-1";	
					
					$connection = mysql_connect($db_host,$db_user,$db_password);
					mysql_select_db($db_schema,$connection);
					mysql_set_charset('utf8',$connection);
					$modified = date("Y-m-d H:i:s");
					
					$query = "UPDATE products SET publics = '0',modified = '$modified' WHERE $condition";
					$result = mysql_query($query,$connection);
					
					if($result){
					
				?>
				<p class="done">El producto(s) ha sido dado de baja(s)</p>
				<?php	
					}else{
				?>
				<p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
				<?php		
					}
									
					mysql_close($connection);
				}
							
				
				
			
				if( isset($_POST['products-delete']) ){
					
					/* 
					 *  Preparing part of query to delete data
					 *	
					 *	@var string $condition Part of Query with id of products that will be deleted
					 *	@var recordset $result Recordset
					 *
					 */
					
					$condition = "";
					
					foreach($_POST as $key => $value){			
						if($key != 'products-delete'){						
							$condition.="id=$value or ";						
						}												
					}
					
					$condition.="id=-1";				
					
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
					 *  Preparing query to delete data
					 *	Save result of the transaction in the result variable 
					 *	
					 *	@var string $query Query
					 *	@var recordset $result Recordset
					 *
					 */
					
					$query = "DELETE FROM products WHERE publics='0' AND $condition";
					$result = mysql_query($query,$connection);
					
					if($result){
					
						/* 
						 *  If result was true, the transaction was sucessful
						 *
						 */
				?>
				<p class="done">El producto(s) ha sido eliminado(s)</p>
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
				 *  Connect to MySQL Server
				 *	Select the default schema
				 *	Set charset connection between PHP and MySQL Server
				 *	
				 */
				
				$connection = mysql_connect($db_host,$db_user,$db_password);
				mysql_select_db($db_schema,$connection);
				mysql_set_charset('utf8',$connection);
				
				/* 
				 *  Preparing query to select data
				 *	Save result of the transaction in the result variable 
				 *	
				 *	@var string $query Query
				 *	@var recordset $result Recordset
				 *
				 */
				
				$query = "SELECT products.id as id, products.name as name, genres.name as genre,products.publics as public,products.onsale as onsale,products.visited as visited FROM products,genres WHERE products.genre_id = genres.id";
				$result = mysql_query($query,$connection);
				
				/* 
				 *  Count the number of records retrieved from the schema
				 *	
				 *	@var int $num_rows Number of records in the recordset
				 *	
				 */
				
				$num_rows = mysql_num_rows($result);
				if($num_rows > 0){
					
				/* 
				 *  If there is at least one record in the table draw
				 *	
				 */
			?>
			<table width="870" border="0" align="center" cellpadding="5" cellspacing="0" id="products-list">
        <thead>
          <tr>
            <th width="16" scope="col">&nbsp;</th>
            <th width="16" scope="col">&nbsp;</th>
            <th scope="col">Nombre</th>
            <th scope="col">Género</th>
			<th scope="col">Público&nbsp;</th>
			<th scope="col">Promoción&nbsp;</th>
			<th scope="col">Visitas&nbsp;</th>
          </tr>
        </thead>        
        <tbody>
					<?php
					
					 /* 
				 	  * In each cycle a record is stored in the row variable
				 	  *
						*	@var record $row Current record from Recordset
						*	
				    */
					
						while( $row = mysql_fetch_array($result) ){
					?>
          <tr class="item_list">
           <td width="16"><input type="checkbox" name="products<?php echo $row['id']; ?>" id="products<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" /></td>
            <td width="16"><a href="products-edit.php?id=<?php echo $row['id']; ?>"><img src="img/icon-edit.png" width="16" height="16" /></a></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['genre']; ?></td>
			<?php
				$public = $row['public'];
				if($public == "1")
				{?>
				<td width="16"><img src="img/icon_check.png" width="16" height="16" /></td>
				<?php
				}
				else
				{
			?>
				<td width="16"><img src="img/icon_cancel.png" width="16" height="16" /></td>
				<?php
				}
				?>
				
			<?php
				$onsale = $row['onsale'];
				if($onsale == "1")
				{?>
				<td width="16"><img src="img/icon_check.png" width="16" height="16" /></td>
				<?php
				}
				else
				{
			?>
				<td width="16"><img src="img/icon_cancel.png" width="16" height="16" /></td>
				<?php
				}
				?>
				<td width="16"><?php echo $row['visited'];?></td>
          </tr>
					<?php
  					}
					?>
        </tbody>
      </table>
			<?php
				}else{
			?>      
			<p class="warning">No hay ningún producto creado (<a href="productos-add.php">Agregar producto</a>).</p>
			<?php
				}
				
				/* 
				 *  Close connection with MySQL Server
				 *
				 */
				
				mysql_close($connection);
			?>       
    </form>
  </div>
</div>
</body>
</html>
