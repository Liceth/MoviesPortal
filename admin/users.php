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
<title>Buen Provecho</title>
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
			<li><a href="recipes.php" target="_self">Recetas</a></li>
			<li><a href="categories.php" target="_self">Categorias</a></li>
			<li><a href="users.php" target="_self" id="current">Usuarios</a></li>
			<li><a href="reports.php" target="_self">Reportes</a></li>
		</ul>
  </div>
  <div id="content">
	<form method="post" enctype="application/x-www-form-urlencoded" name="users-list-form" id="users-list-form">
      <p><a href="users-add.php" target="_self" class="button">Agregar</a></p>
      <input type="submit" name="users-delete" id="users-delete" value="Eliminar" />
			<?php
			
				/* 
				 *  If user press button delete
				 *	
				 */
			
				if( isset($_POST['users-delete']) ){
					
					/* 
					 *  Preparing part of query to delete data
					 *	
					 *	@var string $condition Part of Query with id of users that will be deleted
					 *	@var recordset $result Recordset
					 *
					 */
					
					$condition = "";
					
					foreach($_POST as $key => $value){			
						if($key != 'users-delete'){						
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
					
					$query = "DELETE FROM users WHERE $condition";
					$result = mysql_query($query,$connection);
					
					if($result){
					
						/* 
						 *  If result was true, the transaction was sucessful
						 *
						 */
				?>
				<p class="done">Lo(s) usuarios han sido eliminado(s)</p>
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
				
				$query = "SELECT id, name, lastname, email FROM users ORDER BY lastname ASC";
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
      <table width="870" border="0" align="center" cellpadding="5" cellspacing="0" id="users-list">
        <thead>
          <tr>
            <th width="16" scope="col">&nbsp;</th>
            <th width="16" scope="col">&nbsp;</th>
            <th scope="col">Apellido</th>
						<th scope="col">Nombre</th>
						<th scope="col">Correo electrónico</th>
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
            <td width="16"><input type="checkbox" name="users<?php echo $row['id']; ?>" id="users<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" /></td>
            <td width="16"><a href="users-edit.php?id=<?php echo $row['id']; ?>"><img src="img/icon-edit.gif" width="16" height="16" /></a></td>
            <td><?php echo $row['lastname']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>												
          </tr>
					<?php
  					}
					?>
        </tbody>
      </table>
			<?php
				}else{
			?>      
			<p class="warning">No hay ningun usuario creado (<a href="users-add.php">Agregar usuario</a>).</p>
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
