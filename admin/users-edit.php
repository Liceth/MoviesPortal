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
    <h2>Editar usuario</h2>
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
				
				$query = "SELECT name, lastname, email FROM users WHERE id=$id";			
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
					$lastname = $row['lastname'];
					$email = $row['email'];
		
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
				$lastname = $_POST['lastname'];
				$email = $_POST['email'];
				$password = $_POST['password'];
				$modified = date("Y-m-d H:i:s");
				
				if($password != '') $password="password='".md5($password)."', ";
				
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
				
				$query = "UPDATE users SET name='$name',lastname='$lastname',email='$email',$password modified='$modified' WHERE id=$id";
				$result = mysql_query($query,$connection);
				
				if($result){
					
				/* 
				 *  If result was true the transaction was sucessful
				 *
				 */
		?>
		<p class="done">El usuario ha sido editado</p>
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
        <input name="name" type="text" id="name" size="80" value="<?php echo $name; ?>" />
      </p>
			<p>
        <label for="lastname">Apellido:</label>
        <input name="lastname" type="text" id="lastname" size="80" value="<?php echo $lastname; ?>" />
      </p>
			<p>
        <label for="email">Correo electrónico:</label>
        <input name="email" type="text" id="email" size="80" value="<?php echo $email; ?>" />
      </p>
			<p>
        <label for="password">Contraseña:</label>
        <input name="password" type="password" id="password" size="80" />
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
