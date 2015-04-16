<?php

class php_Lib {
	public function __construct(){}
	static function isCli() {
		$GLOBALS['%s']->push("php.Lib::isCli");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = (0 == strncasecmp(PHP_SAPI, 'cli', 3));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function hashOfAssociativeArray($arr) {
		$GLOBALS['%s']->push("php.Lib::hashOfAssociativeArray");
		$__hx__spos = $GLOBALS['%s']->length;
		$h = new haxe_ds_StringMap();
		$h->h = $arr;
		{
			$tmp = $h;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function rethrow($e) {
		$GLOBALS['%s']->push("php.Lib::rethrow");
		$__hx__spos = $GLOBALS['%s']->length;
		if(Std::is($e, _hx_qtype("php.Exception"))) {
			$__rtex__ = $e;
			throw $__rtex__;
		} else {
			throw new HException($e);
		}
		$GLOBALS['%s']->pop();
	}
	static function appendType($o, $path, $t) {
		$GLOBALS['%s']->push("php.Lib::appendType");
		$__hx__spos = $GLOBALS['%s']->length;
		$name = $path->shift();
		if($path->length === 0) {
			$o->$name = $t;
		} else {
			$so = null;
			if(isset($o->$name)) {
				$so = $o->$name;
			} else {
				$so = _hx_anonymous(array());
			}
			php_Lib::appendType($so, $path, $t);
			$o->$name = $so;
		}
		$GLOBALS['%s']->pop();
	}
	static function getClasses() {
		$GLOBALS['%s']->push("php.Lib::getClasses");
		$__hx__spos = $GLOBALS['%s']->length;
		$path = null;
		$o = _hx_anonymous(array());
		reset(php_Boot::$qtypes);
		while(($path = key(php_Boot::$qtypes)) !== null) {
			php_Lib::appendType($o, _hx_explode(".", $path), php_Boot::$qtypes[$path]);
			next(php_Boot::$qtypes);
		}
		{
			$GLOBALS['%s']->pop();
			return $o;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'php.Lib'; }
}
