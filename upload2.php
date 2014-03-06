<?php
session_start();
error_reporting(0);
include "conn.php";

$id = $_SESSION['upload_user'];
$lis = mysql_db_query($mysql_database, "SELECT * FROM members WHERE user = '$id'");  
$ra = mysql_fetch_array ($lis);
$ext = explode(";", $ra[5]);

$max_file_size = "33554432";

$target_dir = $_SESSION['upload_user']."/";

$_FILES['userfile']['name'] = strtolower($_FILES['userfile']['name']);

$_FILES['userfile']['name'] = str_replace(' ', '_', $_FILES['userfile']['name']);

$_FILES['userfile']['name'] = str_replace('$', '_', $_FILES['userfile']['name']);

$_FILES['userfile']['name'] = str_replace('å', 'a', $_FILES['userfile']['name']);
$_FILES['userfile']['name'] = str_replace('ä', 'a', $_FILES['userfile']['name']);
$_FILES['userfile']['name'] = str_replace('ö', 'o', $_FILES['userfile']['name']);
$_FILES['userfile']['name'] = str_replace('ü', 'u', $_FILES['userfile']['name']);

$file_name = $_FILES['userfile']['name'];
$file_name = strrchr($file_name, ".");

if(!in_array($file_name,$ext))
{
	$error = "Du kan inte ladda upp en fil med det filformatet. De som stöds är ";
	foreach( $ext as $exts ){
	$error .= "$exts ";
	}
	die ("$error");
}
$string = $_FILES['userfile']['name'];
$string1 = str_replace(strrchr($string, "."), "", $string);
$string2 = str_replace(strrchr($string, "("), "", $string1);
$i = 1;
if(file_exists($target_dir.$string)) {
	while(file_exists($target_dir.$string2."(".$i.")".$file_name)) {
		$i++;
	}
	$_FILES['userfile']['name'] = $string2."(".$i.")".$file_name;
}

$file_size = $_FILES['userfile']['size'];
if($file_size > $max_file_size) {
	die ("Filen är för stor, max storleken är ".($max_file_size/1024)." kB");
}
if (isset($_POST['submit']) && is_uploaded_file($_FILES['userfile']['tmp_name'])) {
   move_uploaded_file($_FILES['userfile']['tmp_name'], $target_dir.$_FILES['userfile']['name']);
	$user = $_SESSION['upload_user'];
	$date = date('Y\-m\-d G\:i\:s');
	$ip = $_SERVER['REMOTE_ADDR'];
	$file = $_FILES['userfile']['name'];
	
	$sql = "INSERT INTO uploads(user, date, IP, file) 
			VALUES('$user', '$date', '$ip', '$file')"; 
	mysql_query($sql); 

	header ("Location: index.php");
}
?>
