<?php

class StringTools {
	public function __construct(){}
	static function htmlEscape($s, $quotes = null) {
		$GLOBALS['%s']->push("StringTools::htmlEscape");
		$__hx__spos = $GLOBALS['%s']->length;
		$s = _hx_explode(">", _hx_explode("<", _hx_explode("&", $s)->join("&amp;"))->join("&lt;"))->join("&gt;");
		if($quotes) {
			$tmp = _hx_explode("'", _hx_explode("\"", $s)->join("&quot;"))->join("&#039;");
			$GLOBALS['%s']->pop();
			return $tmp;
		} else {
			$GLOBALS['%s']->pop();
			return $s;
		}
		$GLOBALS['%s']->pop();
	}
	static function startsWith($s, $start) {
		$GLOBALS['%s']->push("StringTools::startsWith");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = strlen($s) >= strlen($start) && _hx_substr($s, 0, strlen($start)) === $start;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function endsWith($s, $end) {
		$GLOBALS['%s']->push("StringTools::endsWith");
		$__hx__spos = $GLOBALS['%s']->length;
		$elen = strlen($end);
		$slen = strlen($s);
		{
			$tmp = $slen >= $elen && _hx_substr($s, $slen - $elen, $elen) === $end;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'StringTools'; }
}
