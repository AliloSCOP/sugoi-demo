<?php

class php_db__PDO_PDOConnection implements sys_db_Connection{
	public function __construct($dsn, $user = null, $password = null, $options = null) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("php.db._PDO.PDOConnection::new");
		$__hx__spos = $GLOBALS['%s']->length;
		if(null === $options) {
			$this->pdo = new PDO($dsn, $user, $password);
		} else {
			$arr = array();
			{
				$_g = 0;
				$_g1 = Reflect::fields($options);
				while($_g < $_g1->length) {
					$key = $_g1[$_g];
					++$_g;
					$arr[$key] = Reflect::field($options, $key);
					unset($key);
				}
			}
			$this->pdo = new PDO($dsn, $user, $password, $arr);
		}
		$this->dbname = _hx_explode(":", $dsn)->shift();
		{
			$_g2 = strtolower($this->dbname);
			switch($_g2) {
			case "sqlite":{
				$this->dbname = "SQLite";
			}break;
			case "mysql":{
				$this->dbname = "MySQL";
			}break;
			}
		}
		$GLOBALS['%s']->pop();
	}}
	public $pdo;
	public $dbname;
	public function close() {
		$GLOBALS['%s']->push("php.db._PDO.PDOConnection::close");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->pdo = null;
		unset($this->pdo);
		$GLOBALS['%s']->pop();
	}
	public function request($s) {
		$GLOBALS['%s']->push("php.db._PDO.PDOConnection::request");
		$__hx__spos = $GLOBALS['%s']->length;
		$result = $this->pdo->query($s, PDO::PARAM_STR);
		if(($result === false)) {
			$info = null;
			{
				$a = $this->pdo->errorInfo();
				$info = new _hx_array($a);
			}
			throw new HException("Error while executing " . _hx_string_or_null($s) . " (" . Std::string($info[2]) . ")");
		}
		$db = strtolower($this->dbname);
		switch($db) {
		case "sqlite":{
			$tmp = new php_db__PDO_AllResultSet($result, new php_db__PDO_DBNativeStrategy($db));
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		default:{
			$tmp = new php_db__PDO_PDOResultSet($result, new php_db__PDO_PHPNativeStrategy());
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	public function escape($s) {
		$GLOBALS['%s']->push("php.db._PDO.PDOConnection::escape");
		$__hx__spos = $GLOBALS['%s']->length;
		$output = $this->pdo->quote($s, null);
		if(strlen($output) > 2) {
			$tmp = _hx_substr($output, 1, strlen($output) - 2);
			$GLOBALS['%s']->pop();
			return $tmp;
		} else {
			$GLOBALS['%s']->pop();
			return $output;
		}
		$GLOBALS['%s']->pop();
	}
	public function quote($s) {
		$GLOBALS['%s']->push("php.db._PDO.PDOConnection::quote");
		$__hx__spos = $GLOBALS['%s']->length;
		if(_hx_index_of($s, "\x00", null) >= 0) {
			$tmp = "x'" . _hx_string_or_null($this->base16_encode($s)) . "'";
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		{
			$tmp = $this->pdo->quote($s, null);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function addValue($s, $v) {
		$GLOBALS['%s']->push("php.db._PDO.PDOConnection::addValue");
		$__hx__spos = $GLOBALS['%s']->length;
		if(is_int($v) || is_null($v)) {
			$s->add($v);
		} else {
			if(is_bool($v)) {
				$s->add((($v) ? 1 : 0));
			} else {
				$s->add($this->quote(Std::string($v)));
			}
		}
		$GLOBALS['%s']->pop();
	}
	public function lastInsertId() {
		$GLOBALS['%s']->push("php.db._PDO.PDOConnection::lastInsertId");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = Std::parseInt($this->pdo->lastInsertId(null));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function dbName() {
		$GLOBALS['%s']->push("php.db._PDO.PDOConnection::dbName");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->dbname;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function startTransaction() {
		$GLOBALS['%s']->push("php.db._PDO.PDOConnection::startTransaction");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->pdo->beginTransaction();
		$GLOBALS['%s']->pop();
	}
	public function commit() {
		$GLOBALS['%s']->push("php.db._PDO.PDOConnection::commit");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->pdo->commit();
		$GLOBALS['%s']->pop();
	}
	public function rollback() {
		$GLOBALS['%s']->push("php.db._PDO.PDOConnection::rollback");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->pdo->rollBack();
		$GLOBALS['%s']->pop();
	}
	public function base16_encode($str) {
		$GLOBALS['%s']->push("php.db._PDO.PDOConnection::base16_encode");
		$__hx__spos = $GLOBALS['%s']->length;
		$str = unpack("H" . _hx_string_rec(2 * strlen($str), ""), $str);
		$str = chunk_split($str[1]);
		{
			$GLOBALS['%s']->pop();
			return $str;
		}
		$GLOBALS['%s']->pop();
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	function __toString() { return 'php.db._PDO.PDOConnection'; }
}
