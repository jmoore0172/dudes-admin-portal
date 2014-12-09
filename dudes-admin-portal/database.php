<?php

define('APP_DB_DRIVER', 'mysql');

function db_connect() {
	try {
		$drivers = PDO::getAvailableDrivers();
		if (!in_array(APP_DB_DRIVER, $drivers)) {
			die("The PDO driver '".APP_DB_DRIVER."' is unavailable.");
		}
		switch(APP_DB_DRIVER) {
			# MySQL with PDO_MYSQL 
			case "mysql":
				$db = new PDO("mysql:host=".APP_DB_HOST.";dbname=".APP_DB_NAME, APP_DB_USER, APP_DB_PASS);
				break;
			# MS SQL Server and Sybase with PDO_DBLIB  
			case "mssql":
				$db = new PDO("mssql:host=".APP_DB_HOST.";dbname=".APP_DB_NAME.", ".APP_DB_USER.", ".APP_DB_PASS); 
				break;
			case "sybase":
				$db = new PDO("sybase:host=".APP_DB_HOST.";dbname=".APP_DB_NAME.", ".APP_DB_USER.", ".APP_DB_PASS);  
				break;
			# SQLite Database  
			case "sqlite":
				 $db = new PDO("sqlite:".APP_DB_SQLITE_PATH);
				break;
		} 
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
		return $db;
	}
	catch(PDOException $e) {
		db_error($e);
	}
}
function db_close() {
	global $app_db, $app_db_log;
	$app_db = NULL;
}
function db_query($sql, $data=NULL) {
	global $app_db, $app_db_queries, $app_db_log;
	// if (APP_ENABLE_DATABASE_LOGGING) {
	// 	// $start_time = current_microseconds();
	// 	// if (!isset($app_db_log)) {
	// 	// 	$app_db_log = get_log_time();
	// 	// }
	// 	// $app_db_log .= $sql.chr(10);
	// }
	try {
		if (!isset($app_db)) {
			$app_db = db_connect();
		}
		if (!isset($app_db_queries)) {
			$app_db_queries = 0;
		}
		$app_db_queries++;
		if (!isset($app_db)) {
            $err = 'Database connection failed.';
            error_notify_and_log('database', $err);
			die($err);
		}
		$statement = $app_db->prepare($sql);
		if (isset($data) && is_array($data) && !empty($data)) {
			//pass in values for SQL injection protection, using prepared statements
			$data_binding = array();
			foreach ($data as $key => $val) {
				$data_binding[":".$key] = $val;
			}
			$statement->execute($data_binding);
		} else {
			$statement->execute();
		}
		$output = NULL;
		if (strpos($sql, "SELECT") === 0) {
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$output = $statement->fetchAll();
		} elseif (strpos($sql, "INSERT") === 0) {
			$output = intval($app_db->lastInsertId());
		} elseif (strpos($sql, "UPDATE") === 0) {
			$output = $statement->rowCount();
		} elseif (strpos($sql, "DELETE") === 0) {
			$output = $statement->rowCount();
		} elseif (strpos($sql, "SHOW ") === 0) {
			$statement->setFetchMode(PDO::FETCH_NUM);
			$output = $statement->fetchAll();
		}
		// if (APP_ENABLE_DATABASE_LOGGING) {
		// 	$app_db_log .= time_since_rounded($start_time, 1).' microsecond duration'.chr(10);
		// }
		return $output;
	}
	catch(PDOException $e) {
		db_error($e, $sql, $data);
	}
}
function db_table_exists($table) {
	foreach (db_query("SHOW TABLES") as $item) {
		if ($item[0] == $table) {
			return true;
		}
	}
	return false;
}
function db_table_get_columns($table) {
	return db_query("SHOW COLUMNS FROM ".APP_DB_TABLE_PREFIX.$table);
}
function db_get_record_count($table) {
	$count = db_query("SELECT COUNT(*) FROM ".APP_DB_TABLE_PREFIX.$table);
	return intval($count[0]['COUNT(*)']);
}
function db_get_current_allowed_packet() {
	$current = db_query("SHOW VARIABLES LIKE 'max_allowed_packet'");
	$current = intval($current[0][1]);
	return $current;
}
function db_error($e, $sql="N/A", $data=NULL) {
	//error_notify_and_log("database", $e->getMessage(), $sql, $data);
}
?>