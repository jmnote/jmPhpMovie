<?php
function GET($param_name, $default='##DIE##') { 
	if( isset($_GET[$param_name]) ) return $_GET[$param_name];
	if( $default == '##DIE##' ) die();
	return $default;
}
function POST($param_name, $default='##DIE##') { 
	if( isset($_POST[$param_name]) ) return $_POST[$param_name];
	if( $default == '##DIE##' ) die();
	return $default;
}
function REQUEST($param_name, $default='##DIE##') { 
	if( isset($_REQUEST[$param_name]) ) return $_REQUEST[$param_name];
	if( $default == '##DIE##' ) die();
	return $default;
}
function goto_url($url, $seconds=0) { die("<meta http-equiv='REFRESH' content='$seconds;url=$url'>"); }
