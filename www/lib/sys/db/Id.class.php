<?php

class sys_db_Id {
	public function __construct(){}
	static function encode($id) {
		$GLOBALS['%s']->push("sys.db.Id::encode");
		$__hx__spos = $GLOBALS['%s']->length;
		$l = strlen($id);
		if($l > 6) {
			throw new HException("Invalid identifier '" . _hx_string_or_null($id) . "'");
		}
		$k = 0;
		$p = $l;
		while($p > 0) {
			$c = _hx_char_code_at($id, --$p) - 96;
			if($c < 1 || $c > 26) {
				$c = $c + 96 - 48;
				if($c >= 1 && $c <= 5) {
					$c += 26;
				} else {
					throw new HException("Invalid character " . _hx_string_rec(_hx_char_code_at($id, $p), "") . " in " . _hx_string_or_null($id));
				}
			}
			$k <<= 5;
			$k += $c;
			unset($c);
		}
		{
			$GLOBALS['%s']->pop();
			return $k;
		}
		$GLOBALS['%s']->pop();
	}
	static function decode($id) {
		$GLOBALS['%s']->push("sys.db.Id::decode");
		$__hx__spos = $GLOBALS['%s']->length;
		$s = new StringBuf();
		if($id < 1) {
			if($id === 0) {
				$GLOBALS['%s']->pop();
				return "";
			}
			throw new HException("Invalid ID " . _hx_string_rec($id, ""));
		}
		while($id > 0) {
			$k = $id & 31;
			if($k < 27) {
				$s->b .= _hx_string_or_null(chr($k + 96));
			} else {
				$s->b .= _hx_string_or_null(chr($k + 22));
			}
			$id >>= 5;
			unset($k);
		}
		{
			$tmp = $s->b;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'sys.db.Id'; }
}
