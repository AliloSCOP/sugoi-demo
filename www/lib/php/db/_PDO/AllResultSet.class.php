<?php

class php_db__PDO_AllResultSet extends php_db__PDO_BaseResultSet {
	public function __construct($pdo, $typeStrategy) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("php.db._PDO.AllResultSet::new");
		$__hx__spos = $GLOBALS['%s']->length;
		parent::__construct($pdo,$typeStrategy);
		$this->all = $pdo->fetchAll(PDO::FETCH_NUM);
		$this->pos = 0;
		$this->_length = count($this->all);
		$GLOBALS['%s']->pop();
	}}
	public $all;
	public $pos;
	public $_length;
	public function getResult($index) {
		$GLOBALS['%s']->push("php.db._PDO.AllResultSet::getResult");
		$__hx__spos = $GLOBALS['%s']->length;
		if(isset($this->all[0]) && isset($this->all[0][$index])) {
			$tmp = $this->all[0][$index];
			$GLOBALS['%s']->pop();
			return $tmp;
		} else {
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	public function hasNext() {
		$GLOBALS['%s']->push("php.db._PDO.AllResultSet::hasNext");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->pos < $this->_length;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function get_length() {
		$GLOBALS['%s']->push("php.db._PDO.AllResultSet::get_length");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->_length;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function nextRow() {
		$GLOBALS['%s']->push("php.db._PDO.AllResultSet::nextRow");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->all[$this->pos++];
			$GLOBALS['%s']->pop();
			return $tmp;
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
	function __toString() { return 'php.db._PDO.AllResultSet'; }
}
