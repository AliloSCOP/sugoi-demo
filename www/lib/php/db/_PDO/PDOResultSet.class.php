<?php

class php_db__PDO_PDOResultSet extends php_db__PDO_BaseResultSet {
	public function __construct($pdo, $typeStrategy) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("php.db._PDO.PDOResultSet::new");
		$__hx__spos = $GLOBALS['%s']->length;
		parent::__construct($pdo,$typeStrategy);
		$GLOBALS['%s']->pop();
	}}
	public $cache;
	public function getResult($index) {
		$GLOBALS['%s']->push("php.db._PDO.PDOResultSet::getResult");
		$__hx__spos = $GLOBALS['%s']->length;
		if(!$this->hasNext()) {
			$GLOBALS['%s']->pop();
			return null;
		}
		{
			$tmp = $this->cache[$index];
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function hasNext() {
		$GLOBALS['%s']->push("php.db._PDO.PDOResultSet::hasNext");
		$__hx__spos = $GLOBALS['%s']->length;
		if((null === $this->cache)) {
			$this->cacheRow();
		}
		{
			$tmp = $this->cache;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function get_length() {
		$GLOBALS['%s']->push("php.db._PDO.PDOResultSet::get_length");
		$__hx__spos = $GLOBALS['%s']->length;
		if(($this->pdo === false)) {
			$GLOBALS['%s']->pop();
			return 0;
		}
		{
			$tmp = $this->pdo->rowCount();
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function cacheRow() {
		$GLOBALS['%s']->push("php.db._PDO.PDOResultSet::cacheRow");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->cache = $this->pdo->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT, null);
		$GLOBALS['%s']->pop();
	}
	public function nextRow() {
		$GLOBALS['%s']->push("php.db._PDO.PDOResultSet::nextRow");
		$__hx__spos = $GLOBALS['%s']->length;
		if(!$this->hasNext()) {
			$GLOBALS['%s']->pop();
			return null;
		} else {
			$v = $this->cache;
			$this->cache = null;
			{
				$GLOBALS['%s']->pop();
				return $v;
			}
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
	static $__properties__ = array("get_length" => "get_length");
	function __toString() { return 'php.db._PDO.PDOResultSet'; }
}
