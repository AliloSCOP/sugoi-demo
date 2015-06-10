<?php

class sugoi_db_Variable extends sys_db_Object {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public $name;
	public $value;
	public function __getManager() {
		return sugoi_db_Variable::$manager;
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
	static function __meta__() { $args = func_get_args(); return call_user_func_array(self::$__meta__, $args); }
	static $__meta__;
	static function get($name) {
		$v = sugoi_db_Variable::$manager->unsafeGet($name, false);
		if($v === null) {
			return null;
		} else {
			return $v->value;
		}
	}
	static function set($name, $val) {
		$v = sugoi_db_Variable::$manager->unsafeGet($name, true);
		if($v === null) {
			$v = new sugoi_db_Variable();
			$v->name = $name;
			$v->value = Std::string($val);
			$v->insert();
		} else {
			$v->value = Std::string($val);
			$v->update();
		}
	}
	static function increment($name, $inc = null) {
		if($inc === null) {
			$inc = 1;
		}
		$v = sugoi_db_Variable::$manager->unsafeGet($name, true);
		if($v === null) {
			$v = new sugoi_db_Variable();
			$v->name = $name;
			$v->value = Std::string($inc);
			$v->insert();
		} else {
			$v->value = Std::string(Std::parseInt($v->value) + 1);
			$v->update();
		}
	}
	static function getInt($name) {
		$v = sugoi_db_Variable::$manager->unsafeGet($name, false);
		if($v === null) {
			return 0;
		} else {
			return Std::parseInt($v->value);
		}
	}
	static $manager;
	function __toString() { return 'sugoi.db.Variable'; }
}
sugoi_db_Variable::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => (new _hx_array(array("oy4:namey8:Variabley7:indexesahy9:relationsahy7:hfieldsbR0oR0R0y6:isNullfy1:tjy17:sys.db.RecordType:9:1i50gy5:valueoR0R8R5fR6jR7:9:1i50ghy3:keyaR0hy6:fieldsar4r6hg")))))));
sugoi_db_Variable::$manager = new sys_db_Manager(_hx_qtype("sugoi.db.Variable"));
