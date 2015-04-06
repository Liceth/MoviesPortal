<?php
function add_log($message){
	
	$ip = $_SERVER['REMOTE_ADDR'];
	$date = date("Y-m-d H:i:s");
	$filename = 'log-'.date('Y-m-d').'.txt';
	$path = 'logs/';
	
	$file = fopen($path.$filename,'a+');
	
	fwrite($file,"$ip - $date - $message \r\n");
	
	fclose($file);
}
?>