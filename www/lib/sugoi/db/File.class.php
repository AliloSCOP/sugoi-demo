<?php

class sugoi_db_File extends sys_db_Object {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.db.File::new");
		$__hx__spos = $GLOBALS['%s']->length;
		parent::__construct();
		$GLOBALS['%s']->pop();
	}}
	public $id;
	public $name;
	public $comment;
	public $data;
	public function toString() {
		$GLOBALS['%s']->push("sugoi.db.File::toString");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = "#" . _hx_string_rec($this->id, "") . " " . _hx_string_or_null($this->name);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function __getManager() {
		$GLOBALS['%s']->push("sugoi.db.File::__getManager");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = sugoi_db_File::$manager;
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
	static $CACHE;
	static function makeSign($id) {
		$GLOBALS['%s']->push("sugoi.db.File::makeSign");
		$__hx__spos = $GLOBALS['%s']->length;
		if($id === null) {
			$GLOBALS['%s']->pop();
			return "";
		}
		$s = sugoi_db_File::$CACHE[$id];
		if($s !== null) {
			$GLOBALS['%s']->pop();
			return $s;
		}
		$s = _hx_string_rec($id, "") . "_" . _hx_string_or_null(haxe_crypto_Md5::encode(_hx_string_rec($id, "") . _hx_string_or_null(App::$config->get("key", null))));
		sugoi_db_File::$CACHE[$id] = $s;
		{
			$GLOBALS['%s']->pop();
			return $s;
		}
		$GLOBALS['%s']->pop();
	}
	static function create($stringData, $fileName = null) {
		$GLOBALS['%s']->push("sugoi.db.File::create");
		$__hx__spos = $GLOBALS['%s']->length;
		if($fileName === null) {
			$fileName = "";
		}
		$f = new sugoi_db_File();
		$f->name = $fileName;
		$f->data = _hx_deref(new haxe_io_StringInput($stringData))->readAll(null);
		$f->insert();
		{
			$GLOBALS['%s']->pop();
			return $f;
		}
		$GLOBALS['%s']->pop();
	}
	static $manager;
	function __toString() { return $this->toString(); }
}
sugoi_db_File::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => (new _hx_array(array("oy4:namey4:Filey7:indexesahy9:relationsahy7:hfieldsby2:idoR0R5y6:isNullfy1:tjy17:sys.db.RecordType:0:0gR0oR0R0R6fR7jR8:13:0gy7:commentoR0R9R6fR7r7gy4:dataoR0R10R6fR7jR8:18:0ghy3:keyaR5hy6:fieldsar4r6r8r9hg")))))));
sugoi_db_File::$CACHE = (new _hx_array(array()));
sugoi_db_File::$manager = new sys_db_Manager(_hx_qtype("sugoi.db.File"));
