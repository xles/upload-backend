<?php
	$filename = $_GET['file'];
	if(!empty($filename)) {
		$exts = array("pdf","doc","xls","ppt","jpg","jpeg","png","gif","zip","rar");
		$ext = strrchr($filename,".");
		if (file_exists($filename) && is_file($filename)) {
			$contentLength = filesize($filename);
			header ("Content-Type: application/octet-stream; name=" . $filename);
			header ("Content-Length: " . $contentLength); 
//    				header ("Content-Disposition: attachment; filename=poop.jpg"); 
			header ("Content-Disposition: attachment; filename=" . $filename); 
			readfile($filename);
		} else {
			echo "<b>This file does not exist!</b>";
		}
	} else {
		echo "<b>No file selected...</b>";
	}
    ?> 
