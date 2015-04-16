<?php

class haxe_io_Output {
	public function __construct(){}
	public function writeByte($c) {
		$GLOBALS['%s']->push("haxe.io.Output::writeByte");
		$__hx__spos = $GLOBALS['%s']->length;
		throw new HException("Not implemented");
		$GLOBALS['%s']->pop();
	}
	public function writeBytes($s, $pos, $len) {
		$GLOBALS['%s']->push("haxe.io.Output::writeBytes");
		$__hx__spos = $GLOBALS['%s']->length;
		$k = $len;
		$b = $s->b;
		if($pos < 0 || $len < 0 || $pos + $len > $s->length) {
			throw new HException(haxe_io_Error::$OutsideBounds);
		}
		while($k > 0) {
			$this->writeByte(ord($b[$pos]));
			$pos++;
			$k--;
		}
		{
			$GLOBALS['%s']->pop();
			return $len;
		}
		$GLOBALS['%s']->pop();
	}
	public function close() {
		$GLOBALS['%s']->push("haxe.io.Output::close");
		$__hx__spos = $GLOBALS['%s']->length;
		$GLOBALS['%s']->pop();
	}
	public function write($s) {
		$GLOBALS['%s']->push("haxe.io.Output::write");
		$__hx__spos = $GLOBALS['%s']->length;
		$l = $s->length;
		$p = 0;
		while($l > 0) {
			$k = $this->writeBytes($s, $p, $l);
			if($k === 0) {
				throw new HException(haxe_io_Error::$Blocked);
			}
			$p += $k;
			$l -= $k;
			unset($k);
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'haxe.io.Output'; }
}
