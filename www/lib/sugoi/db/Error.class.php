<?php

class sugoi_db_Error extends sys_db_Object {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public $id;
	public $date;
	public $ip;
	public $user;
	public $url;
	public $error;
	public function get_user() {
		return db_User::$manager->h__get($this, "user", "uid", false);
	}
	public function set_user($_v) {
		return db_User::$manager->h__set($this, "user", "uid", $_v);
	}
	public $uid;
	public function __getManager() {
		return sugoi_db_Error::$manager;
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
	static $__properties__ = array("set_user" => "set_user","get_user" => "get_user");
	function __toString() { return 'sugoi.db.Error'; }
}
sugoi_db_Error::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => (new _hx_array(array("oy4:namey5:Errory7:indexesahy9:relationsaoy6:moduley7:db.Usery4:lockfy4:propy4:usery4:typeR5y7:cascadefy6:isNullty3:keyy3:uidghy7:hfieldsby3:urloR0R15R11fy1:tjy17:sys.db.RecordType:13:0gy2:idoR0R18R11fR16jR17:0:0gy4:dateoR0R19R11fR16jR17:11:0gy5:erroroR0R20R11fR16jR17:15:0gy2:ipoR0R21R11fR16jR17:9:1i15gR13oR0R13R11tR16jR17:1:0ghR12aR18hy6:fieldsar7r9r13r5r11r15hg")))))));
sugoi_db_Error::$manager = new sys_db_Manager(_hx_qtype("sugoi.db.Error"));
