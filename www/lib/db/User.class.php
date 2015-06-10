<?php

class db_User extends sys_db_Object {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public $id;
	public $name;
	public $email;
	public $pass;
	public $lang;
	public $ldate;
	public function toString() {
		return $this->name;
	}
	public function isAdmin() {
		return $this->id === 1;
	}
	public function __getManager() {
		return db_User::$manager;
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
	static $manager;
	function __toString() { return $this->toString(); }
}
db_User::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => (new _hx_array(array("oy4:namey4:Usery7:indexesahy9:relationsahy7:hfieldsby2:idoR0R5y6:isNullfy1:tjy17:sys.db.RecordType:0:0gR0oR0R0R6fR7jR8:9:1i64gy5:ldateoR0R9R6fR7jR8:11:0gy4:passoR0R10R6fR7jR8:9:1i128gy4:langoR0R11R6fR7jR8:9:1i2gy5:emailoR0R12R6fR7jR8:9:1i128ghy3:keyaR5hy6:fieldsar4r6r14r10r12r8hg")))))));
db_User::$manager = new sys_db_Manager(_hx_qtype("db.User"));
