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
			<li><a href="products.php" target="_self">Productos</a></li>
			<li><a href="genres.php" target="_self" >Géneros</a></li>
			<li><a href="inventory.php" target="_self">Inventario</a></li>
			<li><a href="history.php" target="_self" id="current">Registro</a></li>
		</ul>
  </div>
  <div id="content">
	<form method="post" enctype="application/x-www-form-urlencoded" name="genres-list-form" id="genres-list-form">
			
			<?php
							
				$connection = mysql_connect($db_host,$db_user,$db_password);
				mysql_select_db($db_schema,$connection);
				mysql_set_charset('utf8',$connection);
							
				$query = "SELECT history.id as id,history.totalshop as price, history.created as created,suscriptions.id as userid,CONCAT(suscriptions.name,' ',suscriptions.lastname) as user FROM history,suscriptions WHERE suscriptions.id = history.suscription_id";
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
			<th scope="col">Usuario</th>
			<th scope="col">Precio</th>
			<th scope="col">Fecha</th>
			<th scope="col">&nbsp</th>
          </tr>
        </thead>        
        <tbody>
					<?php
								
						while( $row = mysql_fetch_array($result) ){
					

					?>  
					<tr class="item_list">
            <td width="16"></td>
            <td width="16"><?php echo $row['id']; ?></td>
            <td><?php echo $row['user']; ?></td>
			<td><?php echo $row['price']; ?></td>
			<td><?php echo $row['created']; ?></td>
			<td><a href="pdf-export.php?id=<?php echo $row['id'];?>&created=<?php echo $row['created'];?>&userid=<?php echo $row['userid'];?>">Detalles </a></td>
          </tr>
					<?php
					}
					?>
        </tbody>
      </table>
			<?php
				}else{
			?>      
			<p class="warning">No hay ningún histórico de compras.</p>
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
