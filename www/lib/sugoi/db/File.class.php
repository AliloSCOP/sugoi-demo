<?php

class sugoi_db_File extends sys_db_Object {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public $id;
	public $name;
	public $comment;
	public $data;
	public function toString() {
		return "#" . _hx_string_rec($this->id, "") . " " . _hx_string_or_null($this->name);
	}
	public function __getManager() {
		return sugoi_db_File::$manager;
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
		if($id === null) {
			return "";
		}
		$s = sugoi_db_File::$CACHE[$id];
		if($s !== null) {
			return $s;
		}
		$s = _hx_string_rec($id, "") . "_" . _hx_string_or_null(haxe_crypto_Md5::encode(_hx_string_rec($id, "") . _hx_string_or_null(App::$config->get("key", null))));
		sugoi_db_File::$CACHE[$id] = $s;
		return $s;
	}
	static function create($stringData, $fileName = null) {
		if($fileName === null) {
			$fileName = "";
		}
		$f = new sugoi_db_File();
		$f->name = $fileName;
		$f->data = _hx_deref(new haxe_io_StringInput($stringData))->readAll(null);
		$f->insert();
		return $f;
	}
	static $manager;
	function __toString() { return $this->toString(); }
}
sugoi_db_File::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => (new _hx_array(array("oy4:namey4:Filey7:indexesahy9:relationsahy7:hfieldsby2:idoR0R5y6:isNullfy1:tjy17:sys.db.RecordType:0:0gR0oR0R0R6fR7jR8:13:0gy7:commentoR0R9R6fR7r7gy4:dataoR0R10R6fR7jR8:18:0ghy3:keyaR5hy6:fieldsar4r6r8r9hg")))))));
sugoi_db_File::$CACHE = (new _hx_array(array()));
sugoi_db_File::$manager = new sys_db_Manager(_hx_qtype("sugoi.db.File"));
