<?php

class sys_db_Mysql {
	public function __construct(){}
	static function connect($params) {
		$GLOBALS['%s']->push("sys.db.Mysql::connect");
		$__hx__spos = $GLOBALS['%s']->length;
		$dsn = "mysql:";
		if($params->socket !== null) {
			$dsn .= "unix_socket=" . _hx_string_or_null($params->socket) . ";";
		} else {
			$dsn .= "host=" . _hx_string_or_null($params->host) . ";";
			if($params->port !== null) {
				$dsn .= "port=" . _hx_string_rec($params->port, "") . ";";
			}
		}
		$dsn .= "dbname=" . _hx_string_or_null($params->database);
		{
			$tmp = php_db_PDO::open($dsn, $params->user, $params->pass, null);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'sys.db.Mysql'; }
}
