<?php

class sugoi_form_validators_BoolValidator extends sugoi_form_Validator {
	public function __construct($valid, $error = null) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.form.validators.BoolValidator::new");
		$__hx__spos = $GLOBALS['%s']->length;
		parent::__construct();
		$this->valid = $valid;
		if($error !== null) {
			$this->errorNotValid = $error;
		} else {
			$this->errorNotValid = "Not valid.";
		}
		$GLOBALS['%s']->pop();
	}}
	public $errorNotValid;
	public $valid;
	public function isValid($value) {
		$GLOBALS['%s']->push("sugoi.form.validators.BoolValidator::isValid");
		$__hx__spos = $GLOBALS['%s']->length;
		if(!$this->valid) {
			$this->errors->push($this->errorNotValid);
		}
		{
			$tmp = $this->valid;
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
	function __toString() { return 'sugoi.form.validators.BoolValidator'; }
}
