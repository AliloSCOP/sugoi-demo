<?php

class sugoi_db_Session extends sys_db_Object {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->set_messages((new _hx_array(array())));
		$this->data = _hx_anonymous(array());
	}}
	public $sid;
	public $ip;
	public $lang;
	public $messages;
	public $lastTime;
	public $createTime;
	public $sdata;
	public $data;
	public $user;
	public function addMessage($text, $error = null) {
		if($error === null) {
			$error = false;
		}
		$this->get_messages()->push(_hx_anonymous(array("error" => $error, "text" => $text)));
	}
	public function setUser($u) {
		sugoi_db_Session::$manager->unsafeDelete("DELETE FROM Session WHERE " . _hx_string_or_null(sys_db_Manager::nullCompare("uid", sys_db_Manager::quoteAny($u->id), true)));
		$this->lang = $u->lang;
		$this->set_user($u);
		$this->update();
	}
	public function update() {
		$this->sdata = haxe_Serializer::run($this->data);
		$this->lastTime = Date::now();
		parent::update();
	}
	public $cache_messages;
	public $data_messages;
	public function get_messages() {
		if(_hx_field($this, "cache_messages") === null) {
			$this->cache_messages = _hx_anonymous(array("v" => sugoi_db_Session::$manager->doUnserialize("data_messages", $this->data_messages)));
			$this->{"data_messages"} = _hx_anonymous(array());
		}
		return $this->cache_messages->v;
	}
	public function set_messages($_v) {
		if(_hx_field($this, "cache_messages") === null) {
			$this->cache_messages = _hx_anonymous(array("v" => $_v));
			$this->data_messages = _hx_anonymous(array());
		} else {
			$this->cache_messages->v = $_v;
		}
		return $_v;
	}
	public function get_user() {
		return db_User::$manager->h__get($this, "user", "uid", false);
	}
	public function set_user($_v) {
		return db_User::$manager->h__set($this, "user", "uid", $_v);
	}
	public $uid;
	public function __getManager() {
		return sugoi_db_Session::$manager;
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
	static function get($sid) {
		if($sid === null) {
			return null;
		}
		$s = sugoi_db_Session::$manager->unsafeGet($sid, true);
		if($s === null) {
			return null;
		}
		try {
			$s->data = haxe_Unserializer::run($s->sdata);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$s->data = null;
			}
		}
		return $s;
	}
	static function init($sids) {
		{
			$_g = 0;
			while($_g < $sids->length) {
				$sid = $sids[$_g];
				++$_g;
				$s = sugoi_db_Session::get($sid);
				if($s !== null) {
					return $s;
				}
				unset($sid,$s);
			}
		}
		$ip = $_SERVER['REMOTE_ADDR'];
		$s1 = new sugoi_db_Session();
		$s1->ip = $ip;
		$s1->createTime = Date::now();
		$s1->lastTime = Date::now();
		$s1->sid = sugoi_db_Session::generateId();
		$count = 20;
		while(sugoi_db_Session_0($count, $ip, $s1, $sids)) {
			$s1->sid = sugoi_db_Session::generateId();
			if($count-- === 0) {
				$s1->insert();
				break;
			}
		}
		return $s1;
	}
	static $S = "abcdefjhijklmnopqrstuvwxyABCDEFJHIJKLMNOPQRSTUVWXYZ0123456789";
	static function generateId() {
		$id = "";
		{
			$_g = 0;
			while($_g < 32) {
				$x = $_g++;
				$id .= _hx_string_or_null(_hx_substr(sugoi_db_Session::$S, Std::random(strlen(sugoi_db_Session::$S)), 1));
				unset($x);
			}
		}
		return $id;
	}
	static function clean() {
		sugoi_db_Session::$manager->unsafeDelete("DELETE FROM Session WHERE lastTime<" . _hx_string_or_null(sys_db_Manager::quoteAny(sugoi_db_Session_1())));
	}
	static $manager;
	static $__properties__ = array("set_user" => "set_user","get_user" => "get_user","set_messages" => "set_messages","get_messages" => "get_messages");
	function __toString() { return 'sugoi.db.Session'; }
}
sugoi_db_Session::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => (new _hx_array(array("oy4:namey7:Sessiony7:indexesaoy4:keysay3:uidhy6:uniquetghy9:relationsaoy6:moduley7:db.Usery4:lockfy4:propy4:usery4:typeR8y7:cascadefy6:isNullty3:keyR4ghy7:hfieldsby8:messagesoR0R17R14fy1:tjy17:sys.db.RecordType:30:0gy10:createTimeoR0R20R14fR18jR19:11:0gy3:sidoR0R21R14fR18jR19:9:1i32gy4:langoR0R22R14fR18jR19:9:1i2gy5:sdataoR0R23R14fR18jR19:15:0gy2:ipoR0R24R14fR18jR19:9:1i15gy8:lastTimeoR0R25R14fR18r10gR4oR0R4R14tR18jR19:1:0ghR15aR21hy6:fieldsar11r17r13r7r19r9r15r20hg")))))));
sugoi_db_Session::$manager = new sys_db_Manager(_hx_qtype("sugoi.db.Session"));
function sugoi_db_Session_0(&$count, &$ip, &$s1, &$sids) {
	try {
		$s1->insert();
		return false;
	}catch(Exception $__hx__e) {
		$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
		$e = $_ex_;
		{
			return true;
		}
	}
}
function sugoi_db_Session_1() {
	{
		$d = Date::now();
		return Date::fromTime($d->getTime() + -2592000000.);
	}
}
