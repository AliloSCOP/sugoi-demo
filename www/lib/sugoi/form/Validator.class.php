<?php

class sugoi_form_Validator {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.form.Validator::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->errors = new HList();
		$GLOBALS['%s']->pop();
	}}
	public $errors;
	public function isValid($value) {
		$GLOBALS['%s']->push("sugoi.form.Validator::isValid");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->errors->clear();
		{
			$GLOBALS['%s']->pop();
			return true;
		}
		$GLOBALS['%s']->pop();
	}
	public function reset() {
		$GLOBALS['%s']->push("sugoi.form.Validator::reset");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->errors->clear();
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
	function __toString() { return 'sugoi.form.Validator'; }
}
