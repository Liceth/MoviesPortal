<?php


session_start();
 
require("includes/configuration.php");


if( isset($_SESSION['mp_logged']) ){
	//add_log("Se ha cerrado la sesión del usuario $_SESSION[bp_name] $_SESSION[bp_lastname]");
	session_destroy();
}

?>
<?php


if( isset($_POST['login']) ){

	
	$user = $_POST['user'];
	$password = md5($_POST['password']);

	
	$connection = mysql_connect($db_host,$db_user,$db_password);
	mysql_select_db($db_schema,$connection);
	mysql_set_charset('utf8',$connection);
	
	$query = "SELECT id, name, lastname, email FROM suscriptions WHERE user='$user' and password='$password'";			
	$result = mysql_query($query,$connection);
	
	if($result){
	 
		$num_rows = mysql_num_rows($result);
		
		if($num_rows > 0){

			
			$row = mysql_fetch_array($result);
			
			$_SESSION['mp_logged'] = true;
			$_SESSION['mp_id'] = $row['id'];
			$_SESSION['mp_name'] = $row['name'];
			$_SESSION['mp_lastname'] = $row['lastname'];
			$_SESSION['mp_email'] = $row['email'];
			
								
			header('Location: index.php');
			
		}

	}				
	
	mysql_close($connection);
} 
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>MoviesPortal(admin)</title>
<meta name="Robots" content="none" />
<link href="screen.css" rel="stylesheet" type="text/css" media="screen" />

</head>
<body>
<div id="login_container">

  <form action="" method="post" target="_self" id="form1" name="form1">
    <p align="center"><img src="../img/logo.png" alt="" width="183" height="69" /></p>
    <p>
      <label for="user">Nombre de usuario:</label>
      <br />
      <input name="user" type="text" id="user" />
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
	<p class="more">No eres usuario registrado?<a href="register.php"> Registrarse </a></p>
</div>
</body>
</html>
