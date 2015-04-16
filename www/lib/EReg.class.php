<?php

class EReg {
	public function __construct($r, $opt) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("EReg::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->pattern = $r;
		$a = _hx_explode("g", $opt);
		$this->{"global"} = $a->length > 1;
		if($this->{"global"}) {
			$opt = $a->join("");
		}
		$this->options = $opt;
		$this->re = '"' . str_replace('"','\\"',$r) . '"' . $opt;
		$GLOBALS['%s']->pop();
	}}
	public $last;
	public $global;
	public $pattern;
	public $options;
	public $re;
	public $matches;
	public function match($s) {
		$GLOBALS['%s']->push("EReg::match");
		$__hx__spos = $GLOBALS['%s']->length;
		$p = preg_match($this->re, $s, $this->matches, PREG_OFFSET_CAPTURE);
		if($p > 0) {
			$this->last = $s;
		} else {
			$this->last = null;
		}
		{
			$tmp = $p > 0;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function matched($n) {
		$GLOBALS['%s']->push("EReg::matched");
		$__hx__spos = $GLOBALS['%s']->length;
		if($this->matches === null || $n < 0) {
			throw new HException("EReg::matched");
		}
		if($n >= count($this->matches)) {
			$GLOBALS['%s']->pop();
			return null;
		}
		if($this->matches[$n][1] < 0) {
			$GLOBALS['%s']->pop();
			return null;
		}
		{
			$tmp = $this->matches[$n][0];
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function matchedRight() {
		$GLOBALS['%s']->push("EReg::matchedRight");
		$__hx__spos = $GLOBALS['%s']->length;
		if(count($this->matches) === 0) {
			throw new HException("No string matched");
		}
		$x = $this->matches[0][1] + strlen($this->matches[0][0]);
		{
			$tmp = _hx_substr($this->last, $x, null);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function replace($s, $by) {
		$GLOBALS['%s']->push("EReg::replace");
		$__hx__spos = $GLOBALS['%s']->length;
		$by = str_replace("\\\$", "\\\\\$", $by);
		$by = str_replace("\$\$", "\\\$", $by);
		if(!preg_match('/\\([^?].+?\\)/', $this->re)) $by = preg_replace('/\$(\d+)/', '\\\$\1', $by);
		{
			$tmp = preg_replace($this->re, $by, $s, (($this->{"global"}) ? -1 : 1));
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
	function __toString() { return 'EReg'; }
}
