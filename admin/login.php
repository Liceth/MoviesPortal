<?php
/* 
 *  Initialize session variables
 *	
 */

session_start();

/* 
 *  Load configuration file
 *	
 */
 
require("../includes/configuration.php");
require("../includes/logs.php");

if( isset($_SESSION['bp_logged']) ){
	//add_log("Se ha cerrado la sesión del usuario $_SESSION[bp_name] $_SESSION[bp_lastname]");
	session_destroy();
}

?>
<?php
		
/* 
 *  If user press button add
 *	
 */

if( isset($_POST['login']) ){
	
	/* 
	 *  Sanatize variables
	 *
	 *	@var string $name Category name
	 *	@var date $created Category creation date
	 *	
	 */
	
	$email = $_POST['email'];
	$password = $_POST['password'];
	
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
	 */
	
	$query = "SELECT id, name, lastname, email FROM users WHERE email='$email' and password='$password'";			
	$result = mysql_query($query,$connection);
	
	if($result){
		
	/* 
	 *  If result was true the transaction was sucessful
	 *
	 */
	 
		$num_rows = mysql_num_rows($result);
		
		if($num_rows > 0){

	/* 
	 *  If at least one user match the conditions
	 *	Extract user information
	 *
	 */
			
			$row = mysql_fetch_array($result);
			
			$_SESSION['bp_logged'] = true;
			$_SESSION['bp_id'] = $row['id'];
			$_SESSION['bp_name'] = $row['name'];
			$_SESSION['bp_lastname'] = $row['lastname'];
			$_SESSION['bp_email'] = $row['email'];
			
			add_log("Se ha iniciado la sesión del usuario $_SESSION[bp_name] $_SESSION[bp_lastname]");
			
			header('Location: index.php');
			
		}

	}				
	
	mysql_close($connection);
} 
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>MoviesPortal(admin)</title>
<meta name="Robots" content="none" />
<link href="screen.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="login_container">
	<p class="done"> Inicio de sesión administrativo </p>

  <form action="" method="post" target="_self" id="form1" name="form1">
    <p align="center"><img src="../img/admin.png" alt="" width="64" height="64" /></p>
    <p>
      <label for="email">Nombre de usuario:</label>
      <br />
      <input name="email" type="text" id="email" />
    </p>
    <p>
      <label for="password">Contraseña:</label>
      <br />
      <input name="password" type="password" id="password" />
    </p>
    <p>
      <input type="submit" name="login" id="login" value="Iniciar sesion" />
    </p>
  </form>
</div>
</body>
</html>
