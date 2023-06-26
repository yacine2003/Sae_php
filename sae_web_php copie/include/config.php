<?php
	define('INCLUDE_PATH', dirname(__FILE__));
	define('COMMON_PATH', INCLUDE_PATH.'/common');
	$root_url = substr($_SERVER['SCRIPT_NAME'], 0,strpos($_SERVER['SCRIPT_NAME'], 'sae_web_php')+11);
	
	include 'functions.php';
	include 'db_functions.php';
	include 'classes.php';

	$db_conn = start_db_connection();
	session_start();
	
?>