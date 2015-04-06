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
			<li><a href="products.php" target="_self">Productos</a></li>
			<li><a href="genres.php" target="_self" id="current">Géneros</a></li>
			<li><a href="inventory.php" target="_self">Inventario</a></li>
			<li><a href="history.php" target="_self">Registro</a></li>
		</ul>
  </div>
  <div id="content">
	<form method="post" enctype="application/x-www-form-urlencoded" name="genres-list-form" id="genres-list-form">
      <p><a href="genres-add.php" target="_self" class="button2">Agregar</a></p>
      <input type="submit" name="genres-delete" id="genres-delete" value="Eliminar" />
			<?php
			
				/* 
				 *  If user press button delete
				 *	
				 */
			
				if( isset($_POST['genres-delete']) ){
					
					/* 
					 *  Preparing part of query to delete data
					 *	
					 *	@var string $condition Part of Query with id of genres that will be deleted
					 *	@var recordset $result Recordset
					 *
					 */
					
					$condition = "";
					$condition2 = "";
					
					foreach($_POST as $key => $value){			
						if($key != 'genres-delete'){						
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
					 
					$updatequery = "UPDATE products SET genre_id = '1' WHERE genre_$condition";
					$result = mysql_query($updatequery,$connection);
					
					$query = "DELETE FROM genres WHERE $condition";
					$result = mysql_query($query,$connection);
					
					if($result){
					
						/* 
						 *  If result was true, the transaction was sucessful
						 *
						 */
				?>
				<p class="done">Lo(s) géneros han sido eliminado(s)</p>
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
				
				$query = "SELECT genres.id as id, genres.name as name, COUNT(products.genre_id) as num FROM products,genres WHERE products.genre_id = genres.id GROUP BY genre_id";
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
      <table width="870" border="0" align="center" cellpadding="5" cellspacing="0" id="genres-list">
        <thead>
          <tr>
            <th width="16" scope="col">&nbsp;</th>
            <th width="16" scope="col">&nbsp;</th>
            <th scope="col">Nombre</th>
			<th scope="num">Cantidad</th>
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
						$info = $row['name'];
						
						if( strcmp($info,"Predeterminado") != 0)
						{
						
						
					?>  
					<tr class="item_list">
            <td width="16"><input type="checkbox" name="genres<?php echo $row['id']; ?>" id="genres<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" /></td>
            <td width="16"><a href="genres-edit.php?id=<?php echo $row['id']; ?>"><img src="img/icon-edit.gif" width="16" height="16" /></a></td>
            <td><?php echo $row['name']; ?></td>
			<td><?php echo $row['num']; ?></td>
          </tr>
					<?php
						}else
						{
					?> 
					<tr class="item_list">
						<td width="16"></td>
						<td width="16"></td>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['num']; ?></td>
					</tr>
					<?php	
						}
					}
					?>
        </tbody>
      </table>
			<?php
				}else{
			?>      
			<p class="warning">No hay ningún género creado (<a href="genres-add.php">Agregar género</a>).</p>
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
