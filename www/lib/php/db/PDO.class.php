<?php

class php_db_PDO {
	public function __construct(){}
	static function open($dsn, $user = null, $password = null, $options = null) {
		$GLOBALS['%s']->push("php.db.PDO::open");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = new php_db__PDO_PDOConnection($dsn, $user, $password, $options);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'php.db.PDO'; }
}