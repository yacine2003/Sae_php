<?php
	define('hostname', 'localhost');
	define('db_user', 'root');
	define('db_pass', 'Yacine2003$');
	define('db_name', 'sae_web_php');

	function start_db_connection(){
		$db_conn = new mysqli(hostname,db_user,db_pass,db_name);
		if ($db_conn->connect_error) {
			echo "Error database connection: ".$db_conn->connect_error." Error no.: ".$db_conn->connect_errno;
			die();
		}
		return $db_conn;
	}

	function close_db_connection($db_conn){
		$db_conn->close();
	}
?>