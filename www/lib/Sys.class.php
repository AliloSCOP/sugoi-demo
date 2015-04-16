<?php

class Sys {
	public function __construct(){}
	static function hprint($v) {
		$GLOBALS['%s']->push("Sys::print");
		$__hx__spos = $GLOBALS['%s']->length;
		echo(Std::string($v));
		$GLOBALS['%s']->pop();
	}
	static function println($v) {
		$GLOBALS['%s']->push("Sys::println");
		$__hx__spos = $GLOBALS['%s']->length;
		Sys::hprint($v);
		Sys::hprint("\x0A");
		$GLOBALS['%s']->pop();
	}
	static function sleep($seconds) {
		$GLOBALS['%s']->push("Sys::sleep");
		$__hx__spos = $GLOBALS['%s']->length;
		usleep($seconds * 1000000);
		{
			$GLOBALS['%s']->pop();
			return;
		}
		$GLOBALS['%s']->pop();
	}
	static function setTimeLocale($loc) {
		$GLOBALS['%s']->push("Sys::setTimeLocale");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = setlocale(LC_TIME, $loc) !== false;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function systemName() {
		$GLOBALS['%s']->push("Sys::systemName");
		$__hx__spos = $GLOBALS['%s']->length;
		$s = php_uname("s");
		$p = null;
		if(($p = _hx_index_of($s, " ", null)) >= 0) {
			$tmp = _hx_substr($s, 0, $p);
			$GLOBALS['%s']->pop();
			return $tmp;
		} else {
			$GLOBALS['%s']->pop();
			return $s;
		}
		$GLOBALS['%s']->pop();
	}
	static function time() {
		$GLOBALS['%s']->push("Sys::time");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = microtime(true);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Sys'; }
}
