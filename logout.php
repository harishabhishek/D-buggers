<?php
	session_start();

	session_unset();
	session_destroy();
	
	session_id(-1);
	
	header('Location: index.html');
	exit();
?>