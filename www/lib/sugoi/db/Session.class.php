<?php

class sugoi_db_Session extends sys_db_Object {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.db.Session::new");
		$__hx__spos = $GLOBALS['%s']->length;
		parent::__construct();
		$this->set_messages((new _hx_array(array())));
		$this->data = _hx_anonymous(array());
		$GLOBALS['%s']->pop();
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
		$GLOBALS['%s']->push("sugoi.db.Session::addMessage");
		$__hx__spos = $GLOBALS['%s']->length;
		if($error === null) {
			$error = false;
		}
		$this->get_messages()->push(_hx_anonymous(array("error" => $error, "text" => $text)));
		$GLOBALS['%s']->pop();
	}
	public function setUser($u) {
		$GLOBALS['%s']->push("sugoi.db.Session::setUser");
		$__hx__spos = $GLOBALS['%s']->length;
		if(!_hx_equal($this->uid, $u->id)) {
			sugoi_db_Session::$manager->unsafeDelete("DELETE FROM Session WHERE (uid <=> " . _hx_string_or_null(sys_db_Manager::quoteAny($u->id)) . ")");
		}
		$this->lang = $u->lang;
		$this->set_user($u);
		$GLOBALS['%s']->pop();
	}
	public function update() {
		$GLOBALS['%s']->push("sugoi.db.Session::update");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->sdata = haxe_Serializer::run($this->data);
		$this->lastTime = Date::now();
		parent::update();
		$GLOBALS['%s']->pop();
	}
	public $cache_messages;
	public $data_messages;
	public function get_messages() {
		$GLOBALS['%s']->push("sugoi.db.Session::get_messages");
		$__hx__spos = $GLOBALS['%s']->length;
		if(_hx_field($this, "cache_messages") === null) {
			$this->cache_messages = _hx_anonymous(array("v" => sugoi_db_Session::$manager->doUnserialize("data_messages", $this->data_messages)));
			$this->{"data_messages"} = _hx_anonymous(array());
		}
		{
			$tmp = $this->cache_messages->v;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function set_messages($_v) {
		$GLOBALS['%s']->push("sugoi.db.Session::set_messages");
		$__hx__spos = $GLOBALS['%s']->length;
		if(_hx_field($this, "cache_messages") === null) {
			$this->cache_messages = _hx_anonymous(array("v" => $_v));
			$this->data_messages = _hx_anonymous(array());
		} else {
			$this->cache_messages->v = $_v;
		}
		{
			$GLOBALS['%s']->pop();
			return $_v;
		}
		$GLOBALS['%s']->pop();
	}
	public function get_user() {
		$GLOBALS['%s']->push("sugoi.db.Session::get_user");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = db_User::$manager->h__get($this, "user", "uid", false);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function set_user($_v) {
		$GLOBALS['%s']->push("sugoi.db.Session::set_user");
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
		$GLOBALS['%s']->push("sugoi.db.Session::__getManager");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = sugoi_db_Session::$manager;
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
	static function get($sid) {
		$GLOBALS['%s']->push("sugoi.db.Session::get");
		$__hx__spos = $GLOBALS['%s']->length;
		if($sid === null) {
			$GLOBALS['%s']->pop();
			return null;
		}
		$s = sugoi_db_Session::$manager->unsafeGet($sid, true);
		if($s === null) {
			$GLOBALS['%s']->pop();
			return null;
		}
		try {
			$s->data = haxe_Unserializer::run($s->sdata);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				$s->data = null;
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $s;
		}
		$GLOBALS['%s']->pop();
	}
	static function init($sids) {
		$GLOBALS['%s']->push("sugoi.db.Session::init");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$_g = 0;
			while($_g < $sids->length) {
				$sid = $sids[$_g];
				++$_g;
				$s = sugoi_db_Session::get($sid);
				if($s !== null) {
					$GLOBALS['%s']->pop();
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
		{
			$GLOBALS['%s']->pop();
			return $s1;
		}
		$GLOBALS['%s']->pop();
	}
	static $S = "abcdefjhijklmnopqrstuvwxyABCDEFJHIJKLMNOPQRSTUVWXYZ0123456789";
	static function generateId() {
		$GLOBALS['%s']->push("sugoi.db.Session::generateId");
		$__hx__spos = $GLOBALS['%s']->length;
		$id = "";
		{
			$_g = 0;
			while($_g < 32) {
				$x = $_g++;
				$id .= _hx_string_or_null(_hx_substr(sugoi_db_Session::$S, Std::random(strlen(sugoi_db_Session::$S)), 1));
				unset($x);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $id;
		}
		$GLOBALS['%s']->pop();
	}
	static function clean() {
		$GLOBALS['%s']->push("sugoi.db.Session::clean");
		$__hx__spos = $GLOBALS['%s']->length;
		sugoi_db_Session::$manager->unsafeDelete("DELETE FROM Session WHERE lastTime<" . _hx_string_or_null(sys_db_Manager::quoteAny(sugoi_db_Session_1())));
		$GLOBALS['%s']->pop();
	}
	static $manager;
	static $__properties__ = array("set_user" => "set_user","get_user" => "get_user","set_messages" => "set_messages","get_messages" => "get_messages");
	function __toString() { return 'sugoi.db.Session'; }
}
sugoi_db_Session::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => (new _hx_array(array("oy4:namey7:Sessiony7:indexesaoy4:keysay3:uidhy6:uniquetghy9:relationsaoy4:lockfy4:propy4:usery4:typey7:db.Usery7:cascadefy6:isNullty3:keyR4ghy7:hfieldsby8:messagesoR0R16R13fy1:tjy17:sys.db.RecordType:30:0gy10:createTimeoR0R19R13fR17jR18:11:0gy3:sidoR0R20R13fR17jR18:9:1i32gy4:langoR0R21R13fR17jR18:9:1i2gy5:sdataoR0R22R13fR17jR18:15:0gy2:ipoR0R23R13fR17jR18:9:1i15gy8:lastTimeoR0R24R13fR17r10gR4oR0R4R13tR17jR18:1:0ghR14aR20hy6:fieldsar11r17r13r7r19r9r15r20hg")))))));
sugoi_db_Session::$manager = new sys_db_Manager(_hx_qtype("sugoi.db.Session"));
function sugoi_db_Session_0(&$count, &$ip, &$s1, &$sids) {
	try {
		$s1->insert();
		return false;
	}catch(Exception $__hx__e) {
		$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
		$e = $_ex_;
		{
			$GLOBALS['%e'] = (new _hx_array(array()));
			while($GLOBALS['%s']->length >= $__hx__spos) {
				$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
			}
			$GLOBALS['%s']->push($GLOBALS['%e'][0]);
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
