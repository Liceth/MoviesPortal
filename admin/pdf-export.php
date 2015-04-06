<?php
$id = $_GET['id'];
$userid = $_GET['userid'];
$created = $_GET['created'];

include('class.ezpdf.php');


$pdf =& new Cezpdf('A4');
$pdf->selectFont('../fonts/Helvetica.afm');
$pdf->ezSetCmMargins(3.5,1,1.5,1.5);

$conexion = mysql_connect("localhost", "root", "");
mysql_select_db("moviesportal", $conexion);

$query="SELECT history.id as idfact,CONCAT(name,' ',lastname) as name, suscriptions.telephone as phone,suscriptions.email as email,suscriptions.address as address FROM suscriptions,history WHERE suscriptions.id = history.suscription_id AND history.id ='$id' AND history.created='$created'";

$resEmp = mysql_query($query, $conexion) or die(mysql_error());
$totEmp = mysql_num_rows($resEmp);

$row = mysql_fetch_array($resEmp);
	$idfact = $row['idfact'];
	$name = $row['name'];
	$phone = $row['phone'];
	$email = $row['email'];
	$address = $row[ 'address'];

	
$tablequery = "SELECT products.name as product,history.totalshop as total, genres.name as genre, shops.quantity as quantity, shops.totalprice as price FROM history,shops,products,genres,suscriptions WHERE shops.created = history.created AND history.created = '$created' AND history.suscription_id = '$userid' AND history.suscription_id = suscriptions.id AND shops.product_id = products.id AND products.genre_id = genres.id";	
$result = mysql_query($tablequery,$conexion) or die(mysql_error());

$totalquery = "SELECT history.totalshop as total FROM history,shops,products,genres,suscriptions WHERE shops.created = history.created AND history.created = '$created' AND history.suscription_id = '$userid' AND history.suscription_id = suscriptions.id AND shops.product_id = products.id AND products.genre_id = genres.id";	
$totalres = mysql_query($totalquery,$conexion) or die(mysql_error());

$rom = mysql_fetch_array($totalres);
	$total = $rom['total'];

$ixx = 0;
while($datatmp = mysql_fetch_assoc($result)) { 
	//$ixx = $ixx+1;
	$data[] = array_merge($datatmp, array('num'=>$ixx));
}

while($row = mysql_fetch_array($result))
{
	$data[] = $row;
}
$titles = array(
				'num'=>'<b>Num</b>',
				'product'=>'<b>Producto</b>',
				'genre'=>'<b>Género</b>',
				'quantity'=>'<b>Cantidad</b>',
				'price'=>'<b>Precio</b>'
				);
$options = array(
				'shadeCol'=>array(0.9,0.9,0.9),
				'xOrientation'=>'center',
				'width'=>500
			);

$pdf->ezImage('img/logo2.jpg', 0, 150, 'none', 'left');
$pdf->ezText("<b>Factura no. </b>$idfact",14);
$pdf->ezText("<b>Fecha: </b>$created",14);
$pdf->ezText("\n", 12);

$pdf->EzText("<b>Nombre: </b>$name",12);
$pdf->EzText("<b>Correo electrónico: </b> $email",12);
$pdf->EzText("<b>Teléfono: </b> $phone",12);
$pdf->EzText("<b>Dirección: </b> $address",12);

$pdf->ezText("\n\n\n", 10);
$pdf->ezTable($data, $titles, '', $options);

$pdf->ezText("\n\nTotal de compra: $total   ",12,array('justification'=>'right'));

mysql_close($conexion);
ob_end_clean();
$pdf->ezStream();


?>