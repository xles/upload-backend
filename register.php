<?php 
session_start();
if (!isset($_SESSION['upload_user'])){ 
	echo"403";
} else {
	include "conn.php";
	if($_GET['pass'] == "change") {
		echo "<form action=\"register.php?pass=confirm\" method=\"post\">";
		echo "<table><tr><td>Gammalt lösenord:</td>";
		echo "<td><input type=\"password\" name=\"oldpw\"></td>";
		echo "</tr><tr><td>Nytt lösenord:</td>";
		echo "<td><input type=\"password\" name=\"newpw\"></td>";
		echo "</tr><tr><td>Bekräfta lösenord:</td>";
		echo "<td><input type=\"password\" name=\"verify\"></td></tr>";
		echo "<tr><td><input type=\"submit\" name=\"submit\" value=\"Registrera\"></td></tr>";
		echo "</form></table>";
	}
	if ($_GET['pass'] == "confirm") {
		$oldpw = md5($_POST['oldpw']);
		if(!empty($oldpw)) {
			$id = $_SESSION['upload_user'];
			$list = mysql_db_query($mysql_database, "SELECT * FROM members WHERE user = '$id'");  
			$rad = mysql_fetch_array ($list);
			if ($oldpw == $rad[2]) {
				if($_POST['newpw'] == $_POST['verify']) {
					$pass = md5($_POST['newpw']);
				} else {
					$pass = $rad[2];
				}
			} else {
				$pass = $rad[2];
			}
			$del = "UPDATE members SET pass = '$pass' WHERE user = '$id'";
			mysql_query($del) or die("Det gick inte att radera från databasen!");
			header("Location: index.php");
		} else {
			echo "please fill in your old password!";
		}
	}
	if ($_GET['mode'] == "reg") {
		if (isset($_POST['submit'])){ 
			$user = $_POST['user']; 
			$pass = md5("password"); 
			$email = $_POST['email'];
			foreach( $_POST['filetype'] as $filetypes ){
				$types .= $filetypes.";";
			}
			$sql = "INSERT INTO members(user, pass, email, types) 
					VALUES('$user', '$pass', '$email', '$types')"; 
			mysql_query($sql); 
			mkdir($user."/");
			header("Location: index.php"); 
			exit;      
		} 
	}
	if ($_GET['mode'] == "quick") {
			$user = $_GET['user']; 
			$pass = md5("password"); 
			$email = $_GET['email'];
			$types = $_GET['types'];
			$sql = "INSERT INTO members(user, pass, email, types) 
					VALUES('$user', '$pass', '$email', '$types')"; 
			mysql_query($sql); 
			mkdir($user."/");
			$types = str_replace(";", " ", $types);
			$msg = "Your account is now created!\nUsername: ".$user."\nPassword: password\nI recomend you to change this ASAP\nEmail: ".$email."\nFiletypes: \n".$types."\n";
			mail($email,"Requested upload account, account information",$msg);
			echo"kontot är nu skapat";     
	}
	if ($_GET['mode'] == "set") {
	?>
	<form action="register.php?mode=reg" method="post">
	<table style="margin-left: 10px;">
		<tr>
			<td width="120">Användarnamn:</td>
			<td><input type="text" name="user" value="<? $user ?>"></td>
		</tr>
		<tr>
			<td>E-mail adress:</td>
			<td><input type="text" name="email"></td>
		</tr>
		<tr>
			<td colspan="2">Filetypes:</td>
		</tr>
		<tr>
			<td valign="top"><input type="checkbox" name="filetype['.bat']" value=".bat">.bat<br>
				<input type="checkbox" name="filetype['.com']" value=".com">.com<br>
				<input type="checkbox" name="filetype['.dll']" value=".dll">.dll<br>
				<input type="checkbox" name="filetype['.exe']" value=".exe">.exe<br>
				<input type="checkbox" name="filetype['.htm']" value=".htm">.htm<br>
				<input type="checkbox" name="filetype['.html']" value=".html">.html<br>
				<input type="checkbox" name="filetype['.ini']" value=".ini">.ini<br>
				<input type="checkbox" name="filetype['.js']" value=".js">.js<br>
				<input type="checkbox" name="filetype['.lnk']" value=".lnk">.lnk<br>
				<input type="checkbox" name="filetype['.mrc']" value=".mrc">.mrc<br>
				<input type="checkbox" name="filetype['.pif']" value=".pif">.pif<br>
				<input type="checkbox" name="filetype['.pl']" value=".pl">.pl<br>
				<input type="checkbox" name="filetype['.scr']" value=".scr">.scr<br>
				<input type="checkbox" name="filetype['.shs']" value=".shs">.shs<br>
				<input type="checkbox" name="filetype['.vbs']" value=".vbs">.vbs<br>
				<input type="checkbox" name="filetype['.avi']" value=".avi">.avi<br>
				<input type="checkbox" name="filetype['.bin']" value=".bin">.bin<br>
				<input type="checkbox" name="filetype['.bmp']" value=".bmp">.bmp<br>
				<input type="checkbox" name="filetype['.conf']" value=".conf">.conf<br>
				</td><td valign="top">
				<input type="checkbox" name="filetype['.cue']" value=".cue">.cue<br>
				<input type="checkbox" name="filetype['.exe']" value=".exe">.exe<br>
				<input type="checkbox" name="filetype['.gif']" value=".gif">.gif<br>
				<input type="checkbox" name="filetype['.jpg']" value=".jpg">.jpg<br>
				<input type="checkbox" name="filetype['.jpeg']" value=".jpeg">.jpeg<br>
				<input type="checkbox" name="filetype['.log']" value=".log">.log<br>
				<input type="checkbox" name="filetype['.mid']" value=".mid">.mid<br>
				<input type="checkbox" name="filetype['.mp3']" value=".mp3">.mp3<br>
				<input type="checkbox" name="filetype['.mpeg']" value=".mpeg">.mpeg<br>
				<input type="checkbox" name="filetype['.mpg']" value=".mpg">.mpg<br>
				<input type="checkbox" name="filetype['.ogg']" value=".ogg">.ogg<br>
				<input type="checkbox" name="filetype['.pdf']" value=".pdf">.pdf<br>
				<input type="checkbox" name="filetype['.php']" value=".php">.php<br>
				<input type="checkbox" name="filetype['.png']" value=".png">.png<br>
				<input type="checkbox" name="filetype['.txt']" value=".txt">.txt<br>
				<input type="checkbox" name="filetype['.wav']" value=".wav">.wav<br>
				<input type="checkbox" name="filetype['.wma']" value=".wma">.wma<br>
				<input type="checkbox" name="filetype['.wmv']" value=".wmv">.wmv<br>
				<input type="checkbox" name="filetype['.zip']" value=".zip">.zip<br></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Registrera"></td>
		</tr>
	</table>
	<? 
	}
}
?>