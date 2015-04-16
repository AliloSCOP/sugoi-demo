<?php

class sys_io__Process_Stdin extends haxe_io_Output {
	public function __construct($p) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sys.io._Process.Stdin::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->p = $p;
		$this->buf = haxe_io_Bytes::alloc(1);
		$GLOBALS['%s']->pop();
	}}
	public $p;
	public $buf;
	public function close() {
		$GLOBALS['%s']->push("sys.io._Process.Stdin::close");
		$__hx__spos = $GLOBALS['%s']->length;
		parent::close();
		fclose($this->p);
		$GLOBALS['%s']->pop();
	}
	public function writeByte($c) {
		$GLOBALS['%s']->push("sys.io._Process.Stdin::writeByte");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->buf->b[0] = chr($c);
		$this->writeBytes($this->buf, 0, 1);
		$GLOBALS['%s']->pop();
	}
	public function writeBytes($b, $pos, $l) {
		$GLOBALS['%s']->push("sys.io._Process.Stdin::writeBytes");
		$__hx__spos = $GLOBALS['%s']->length;
		$s = $b->getString($pos, $l);
		if(feof($this->p)) {
			throw new HException(new haxe_io_Eof());
		}
		$r = fwrite($this->p, $s, $l);
		if(($r === false)) {
			throw new HException(haxe_io_Error::Custom("An error occurred"));
		}
		{
			$GLOBALS['%s']->pop();
			return $r;
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
	function __toString() { return 'sys.io._Process.Stdin'; }
}
