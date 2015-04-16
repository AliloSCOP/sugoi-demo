<?php

class sugoi_db_Error extends sys_db_Object {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.db.Error::new");
		$__hx__spos = $GLOBALS['%s']->length;
		parent::__construct();
		$GLOBALS['%s']->pop();
	}}
	public $id;
	public $date;
	public $ip;
	public $user;
	public $url;
	public $error;
	public function get_user() {
		$GLOBALS['%s']->push("sugoi.db.Error::get_user");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = db_User::$manager->h__get($this, "user", "uid", false);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function set_user($_v) {
		$GLOBALS['%s']->push("sugoi.db.Error::set_user");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = db_User::$manager->h__set($this, "user", "uid", $_v);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public $uid;
	public function __getManager() {
		$GLOBALS['%s']->push("sugoi.db.Error::__getManager");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = sugoi_db_Error::$manager;
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
	static function __meta__() { $args = func_get_args(); return call_user_func_array(self::$__meta__, $args); }
	static $__meta__;
	static $manager;
	static $__properties__ = array("set_user" => "set_user","get_user" => "get_user");
	function __toString() { return 'sugoi.db.Error'; }
}
sugoi_db_Error::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => (new _hx_array(array("oy4:namey5:Errory7:indexesahy9:relationsaoy4:lockfy4:propy4:usery4:typey7:db.Usery7:cascadefy6:isNullty3:keyy3:uidghy7:hfieldsby3:urloR0R14R10fy1:tjy17:sys.db.RecordType:13:0gy2:idoR0R17R10fR15jR16:0:0gy4:dateoR0R18R10fR15jR16:11:0gy5:erroroR0R19R10fR15jR16:15:0gy2:ipoR0R20R10fR15jR16:9:1i15gR12oR0R12R10tR15jR16:1:0ghR11aR17hy6:fieldsar7r9r13r5r11r15hg")))))));
sugoi_db_Error::$manager = new sys_db_Manager(_hx_qtype("sugoi.db.Error"));
