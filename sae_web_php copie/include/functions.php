<?php
	function url_for($url){
		global $root_url;
		return $root_url.'/'.$url;
	}
?>