<?php

class sys_io__Process_Stdout extends haxe_io_Input {
	public function __construct($p) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sys.io._Process.Stdout::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->p = $p;
		$this->buf = haxe_io_Bytes::alloc(1);
		$GLOBALS['%s']->pop();
	}}
	public $p;
	public $buf;
	public function readByte() {
		$GLOBALS['%s']->push("sys.io._Process.Stdout::readByte");
		$__hx__spos = $GLOBALS['%s']->length;
		if($this->readBytes($this->buf, 0, 1) === 0) {
			throw new HException(haxe_io_Error::$Blocked);
		}
		{
			$tmp = ord($this->buf->b[0]);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function readBytes($str, $pos, $l) {
		$GLOBALS['%s']->push("sys.io._Process.Stdout::readBytes");
		$__hx__spos = $GLOBALS['%s']->length;
		if(feof($this->p)) {
			throw new HException(new haxe_io_Eof());
		}
		$r = fread($this->p, $l);
		if(($r === "")) {
			throw new HException(new haxe_io_Eof());
		}
		if(($r === false)) {
			throw new HException(haxe_io_Error::Custom("An error occurred"));
		}
		$b = haxe_io_Bytes::ofString($r);
		$str->blit($pos, $b, 0, strlen($r));
		{
			$tmp = strlen($r);
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
	function __toString() { return 'sys.io._Process.Stdout'; }
}
