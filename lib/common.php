<?php
function trace($obj) {
	if( php_sapi_name() != 'cli' ) {
		echo '<xmp>';
		print_r($obj);
		echo '</xmp>';
		return;
	}
	if( is_bool($obj) ) {
		var_dump($obj);
		echo PHP_EOL;
		return;
	}
	if( is_string($obj) || is_numeric($obj) ) {
		echo $obj.PHP_EOL;
		return;
	}
	print_r($obj);
}

function utf8_substr($str, $start, $len=NULL) {
	if( $len == NULL ) $len = mb_strlen($str, 'UTF-8')-$start;
	return mb_substr($str, $start, $len, 'UTF-8');
}