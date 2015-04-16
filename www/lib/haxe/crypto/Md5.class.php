<?php

class haxe_crypto_Md5 {
	public function __construct(){}
	static function encode($s) {
		$GLOBALS['%s']->push("haxe.crypto.Md5::encode");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = md5($s);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'haxe.crypto.Md5'; }
}
