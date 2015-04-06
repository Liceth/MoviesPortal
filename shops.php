<?php 
session_start();
if( !isset($_SESSION['mp_logged']) ){	
	header('Location: login-user.php'); 
} 
?>

<?php

/* 
 *  Load configuration file
 *	
 */
 
require("/includes/configuration.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>MoviesPortal</title>
<meta name="Robots" content="none" />
<link href="admin/screen.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="container">
	<?php	include('/includes/suscription-info.php');
			$id = $_SESSION['mp_id'];
			$created = date("Y-m-d H:i:s");
	?>
  <div id="header">
    <h1><a href="index.php" target="_self"><img src="../img/logo.png" /></a></h1>
  </div>
  <div id="navcontainer">
    <ul>
				<li> <a href="index.php"> Inicio</a> </li>
				<li><a href="genres.php">Películas</a></li>
				<li><a href="#">Noticias</a></li>
				<li><a href="register.php">Contactos</a></li>
				<li><a href="#">Canales</a></li>
		</ul>
  </div>
  <div id="content">
	<form method="post" enctype="application/x-www-form-urlencoded" name="shops-list-form" id="shops-list-form">
      <input type="submit" name="shops-delete" id="shops-delete" value="Eliminar" />
	  <input type="submit" name="shops-clear" id="shops-clear" value="Vaciar" />
			<?php
				if( isset($_POST['shops-buy']) ){
					
					$connection = mysql_connect($db_host,$db_user,$db_password);
					mysql_select_db($db_schema,$connection);
					mysql_set_charset('utf8',$connection);
				
					$query = "SELECT shops.product_id as product,inventory.quantity as inventory, shops.quantity as shop FROM shops,inventory WHERE shops.product_id = inventory.product_id";
					$result = mysql_query($query,$connection);
					
					while($res = mysql_fetch_array($result))
					{
						$inventory = (int)$res['inventory'];
						$product = $res['product'];
						$shop = (int)$res['shop'];
						
						$newinventory = $inventory - $shop;
						
						$newquery = mysql_query("UPDATE inventory SET quantity ='$newinventory' WHERE product_id = $product",$connection);
					}
					
					$querytotal = "SELECT shops.id as id,products.name as product, genres.name as genre, shops.quantity as quantity,shops.totalprice as totalprice FROM genres,products,inventory,shops WHERE shops.suscription_id = $id AND products.id = shops.product_id AND genres.id = products.genre_id GROUP BY shops.id";
					$resultotal = mysql_query($querytotal,$connection);
					
					$temp2 = 0;
						
						while( $row = mysql_fetch_array($resultotal) ){
						$price2 = $row['totalprice'];
						$temp2 = $temp2 + $price2;}
					
					mysql_query("INSERT INTO history(suscription_id,totalshop,created) VALUES ('$id','$temp2','$created')",$connection);
					
				
					$query2 = "UPDATE shops SET bought = '1',created = '$created' WHERE suscription_id = $id AND bought = '0'";
					$result2 = mysql_query($query2,$connection);
					
					if($result2){
			
			?>
				<p class="done">Compra realizada. Se ha vaciado el carro de compras</p>
				<?php	
					}else{
	
				?>
				<p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
				<?php		
					}
							
					mysql_close($connection);
				} 
				?>						
			
			<?php
				if( isset($_POST['shops-clear']) ){
			
					
					$connection = mysql_connect($db_host,$db_user,$db_password);
					mysql_select_db($db_schema,$connection);
					mysql_set_charset('utf8',$connection);
				
									
					$query = "DELETE FROM shops WHERE suscription_id = $id";
					$result = mysql_query($query,$connection);
					
					if($result){
			
				?>
				<p class="done">Se ha vaciado el carro de compras</p>
				<?php	
					}else{
	
				?>
				<p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
				<?php		
					}
							
					mysql_close($connection);
				} 
			?>			
			<?php
				
				
				if( isset($_POST['shops-delete']) ){
			
					
					$condition = "";
					$condition2 = "";
					
					foreach($_POST as $key => $value){			
						if($key != 'shops-delete'){						
							$condition.="id=$value or ";						
						}												
					}
					
					$condition.="id=-1";	
					
					
					$connection = mysql_connect($db_host,$db_user,$db_password);
					mysql_select_db($db_schema,$connection);
					mysql_set_charset('utf8',$connection);
				
									
					$query = "DELETE FROM shops WHERE $condition";
					$result = mysql_query($query,$connection);
					
					if($result){
			
				?>
				<p class="done">Lo(s) producto(s) han sido eliminado(s) del carro de compras</p>
				<?php	
					}else{
	
				?>
				<p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
				<?php		
					}
							
					mysql_close($connection);
				} 
			?>			
			<?php
		
				
				$connection = mysql_connect($db_host,$db_user,$db_password);
				mysql_select_db($db_schema,$connection);
				mysql_set_charset('utf8',$connection);
				
				
				$query = "SELECT shops.id as id,products.name as product, genres.name as genre, shops.quantity as quantity,shops.totalprice as totalprice FROM genres,products,inventory,shops WHERE shops.suscription_id = $id AND products.id = shops.product_id AND genres.id = products.genre_id AND bought = '0' GROUP BY shops.id";
				$result = mysql_query($query,$connection);
			
				
				$num_rows = mysql_num_rows($result);
				if($num_rows > 0){
			
			?>      
      <table width="870" border="0" align="center" cellpadding="5" cellspacing="0" id="shops-list">
        <thead>
          <tr>
            <th width="16" scope="col">&nbsp;</th>
            <th width="16" scope="col">&nbsp;</th>
            <th scope="col">Producto</th>
			<th scope="col">Género</th>
			<th scope="col">Cantidad</th>
			<th scope="col">Precio</th>
          </tr>
        </thead>        
        <tbody>
					<?php
						$temp = 0;
						
						while( $row = mysql_fetch_array($result) ){
						$price = $row['totalprice'];
						$temp = $temp + $price;
						
					?>  
					<tr class="item_list">
            <td width="16"><input type="checkbox" name="shops<?php echo $row['id']; ?>" id="shops<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" /></td>
            <td width="16"></td>
			<td><?php echo $row['product']; ?></td>
			<td><?php echo $row['genre']; ?></td>
			<td><?php echo $row['quantity']; ?></td>
			<td><?php echo $row['totalprice']; ?></td>
					
          </tr>
					<?php
						}
						
					?> 
			<tr class ="item_list"><td width="16">
									</td><td width="16"></td> 
									<td ></td>
									<td ></td>
									<td><strong>Total</strong></td>
									<td><?php echo $temp;?></td>
			</tr>		
				
        </tbody>
      </table>
			<?php
				}else{
			?>      
			<p class="warning">No existe producto en el carro de compras(<a href="genres.php">Agregar producto</a>).</p>
			<?php
				}
							
				mysql_close($connection);
			?> 
				<input type="submit" name="shops-buy" id="shops-buy" value="Comprar" />
			
    </form>
  </div>
</div>
</body>
</html>
