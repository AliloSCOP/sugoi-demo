<?php

class sugoi_form_Validator {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->errors = new HList();
	}}
	public $errors;
	public function isValid($value) {
		$this->errors->clear();
		return true;
	}
	public function reset() {
		$this->errors->clear();
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
