<?php
	$page = end(explode('/', $_SERVER["HTTP_REFERER"]));

	session_start ();
	session_unset ();
	session_destroy ();

	if($page == "upload.php"){
		header ('location: upload.php');
	} elseif ($page == "about.php") {
		header ('location: about.php');
	} else {
		header ('location: index.php');
	}
	
?>