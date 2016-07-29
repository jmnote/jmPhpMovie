<?php
$VCAP_SERVICES = json_decode($_ENV['VCAP_SERVICES'], true);
$DB_CREDENTIALS = $VCAP_SERVICES['devpack-db'][0]['credentials'];
$DB_hostname = $DB_CREDENTIALS['hostname'];
$DB_port = $DB_CREDENTIALS['port'];
$DB_name = $DB_CREDENTIALS['name'];
$DB_username = $DB_CREDENTIALS['username'];
$DB_password = $DB_CREDENTIALS['password'];

$pdh = new PDO("mysql:host=$DB_hostname;port=$DB_port;dbname=$DB_name",
	$DB_username, $DB_password,
	array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function query_error($func_name, $query, $params, $message) {
	trace("$func_name failed $message");
	trace($query);
	trace($params);
	exit;
}

function attach_params(&$stmt, $params) {
	foreach($params as $i => $value) {
		if($value === NULL) $stmt->bindValue($i+1, NULL, PDO::PARAM_NULL);
		else $stmt->bindValue($i+1, $value, PDO::PARAM_STR);
	}
}

function query() {
	global $pdh;
	$params = func_get_args();
	$query = array_shift($params);
	try {
		$stmt = $pdh->prepare($query);
		attach_params($stmt, $params);
		$stmt->execute();
	} catch (PDOException $e) {
		query_error(__FUNCTION__, $query, $params, $e->getMessage());
	}
}

function query_rows() {
	global $pdh;
	$params = func_get_args();
	$query = array_shift($params);
	try {
		$stmt = $pdh->prepare($query);
		attach_params($stmt, $params);
		$stmt->execute();
	} catch (PDOException $e) {
		query_error(__FUNCTION__, $query, $params, $e->getMessage());
	}
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function query_row() {
	global $pdh;
	$params = func_get_args();
	$query = array_shift($params);
	try {
		$stmt = $pdh->prepare($query);
		attach_params($stmt, $params);
		$stmt->execute();
	} catch (PDOException $e) {
		query_error(__FUNCTION__, $query, $params, $e->getMessage());
	}
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return isset($rows[0])? $rows[0]: false;
}

function query_fields() {
	global $pdh;
	$params = func_get_args();
	$query = array_shift($params);
	try {
		$stmt = $pdh->prepare($query);
		attach_params($stmt, $params);
		$stmt->execute();
	} catch (PDOException $e) {
		query_error(__FUNCTION__, $query, $params, $e->getMessage());
	}
	$arr = array();
	while($row = $stmt->fetch(PDO::FETCH_NUM)) $arr[] = $row[0];
	return $arr;
}

function query_field() {
	global $pdh;
	$params = func_get_args();
	$query = array_shift($params);
	try {
		$stmt = $pdh->prepare($query);
		attach_params($stmt, $params);
		$stmt->execute();
	} catch (PDOException $e) {
		query_error(__FUNCTION__, $query, $params, $e->getMessage());
	}
	$row = $stmt->fetch(PDO::FETCH_NUM);
	return isset($row[0])? $row[0]: false;
}

function exist_table($table_name) {
	return ( count($this->query_rows("SHOW TABLES LIKE '$table_name'")) > 0 );
}

function exist_field($table_name, $field_name) {
	return ( count(query_rows("SHOW COLUMNS FROM '$table_name' LIKE '$field_name'")) > 0 );
}

function get_last_id() {
	global $pdh;
	return $pdh->lastInsertId();
}