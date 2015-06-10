<?php

class Sys {
	public function __construct(){}
	static function hprint($v) {
		echo(Std::string($v));
	}
	static function println($v) {
		Sys::hprint($v);
		Sys::hprint("\x0A");
	}
	static function sleep($seconds) {
		usleep($seconds * 1000000);
		return;
	}
	static function setTimeLocale($loc) {
		return setlocale(LC_TIME, $loc) !== false;
	}
	static function systemName() {
		$s = php_uname("s");
		$p = null;
		if(($p = _hx_index_of($s, " ", null)) >= 0) {
			return _hx_substr($s, 0, $p);
		} else {
			return $s;
		}
	}
	static function time() {
		return microtime(true);
	}
	function __toString() { return 'Sys'; }
}
