<?php
	require_once 'include/config.php';
	unset($_SESSION['user_id']);
	unset($_SESSION['user_type']);
	session_destroy();
	close_db_connection($db_conn);
	header("Location: index.php");
	exit();
?>