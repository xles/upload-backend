<?
	session_start();
	echo "<center><h1>", $_SERVER['REMOTE_ADDR'], "</h1>";
	if($_SERVER['REMOTE_ADDR'] == "127.0.0.1") {
		echo "<table valign=\"top\">";
		$target_dir = "../";
		if ($handle = opendir($target_dir)) { 
			while (false !== ($file = readdir($handle))) {
				if ((filesize($target_dir.$file) == 0 || is_dir($file)) && $file != "." && $file != ".." ) {
					echo "<tr><td><a href=\"$target_dir$file\">$file</a></td>";
					echo "<td><b>< DIR ></b> ", dirsize($target_dir.$file, 0), "</td></tr>";
				} 
			} 
			closedir($handle); 
		}
		if ($handle = opendir($target_dir)) { 
			while (false !== ($file = readdir($handle))) {
				if (!is_dir($file) && $file != "." && $file != ".." && filesize($target_dir.$file) != 0) { 
					echo "<tr><td><a href=\"$target_dir$file\">$file</a></td>";
					echo "<td align=\"right\"><b>".file_size($target_dir.$file)."</b></td></tr>\n";
				}
			} 
			closedir($handle); 
		}
		echo "</table>";
	} else {
		echo "<center><h1>403</h1></center>";
	}

	function file_size($target_file) {
		if (filesize($target_file) < 1024) {
			$size = filesize($target_file)." B";
		}
		if (filesize($target_file) > 1024 && filesize($target_file) < 1024*1024) {
			$size = round(filesize($target_file)/1024, 1)." kB";
		}
		if (filesize($target_file) > 1024*1024 && filesize($target_file) < 1024*1024*1024) {
			$size = round(filesize($target_file)/1024/1024, 1)." MB";
		}
		if (filesize($target_file) > 1024*1024*1024 && filesize($target_file) < 1024*1024*1024*1024) {
			$size = round(filesize($target_file)/1024/1024/1024, 1)." GB";
		}
		return $size;
	}

	function dirsize($target_dir, $size) {
		$whole_dir = $size;
//p			$target_dir; 
		if ($handle = opendir($target_dir."/")) {
			while (false !== ($filen = readdir($handle))) { 
				if ($filen != "." && $filen != "..") {
					if(filesize($target_dir."/".$filen) == 0) {
						$whole_dir = dirsize($target_dir."/".$filen, $whole_dir);
						if(!is_dir($target_dir."/".$filen)) {
							$filen = str_replace("/","",$filen);
						}
					}
					$whole_dir += filesize($target_dir."/".$filen);
				}
			}
			closedir($handle);
			return $whole_dir; 
		}
	}
	
?>
