<?php
			
			if( isset($_SESSION['mp_logged']) )
			{
		?>
			<div id="user-info">
			Bienvenido, <strong><?php	echo $_SESSION['mp_name'] . ' ' . $_SESSION['mp_lastname']; ?></strong> (<a href="login-user.php" target="_self">Salir</a> - <a href="shops.php">Mis compras</a>)
			</div>
		<?php				
			}else
			{ 	
		?>
			<ul class="login">
				<li> <a class="reg" href="register.php">Register</a></li>
				<li> <a href="login-user.php">Login</a></li>
			</ul>
		<?php
			}
		?>
