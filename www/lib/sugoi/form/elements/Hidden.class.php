<?php

class sugoi_form_elements_Hidden extends sugoi_form_FormElement {
	public function __construct($name, $value = null, $required = null, $display = null, $attributes = null) {
		if(!php_Boot::$skip_constructor) {
		if($attributes === null) {
			$attributes = "";
		}
		if($display === null) {
			$display = false;
		}
		if($required === null) {
			$required = false;
		}
		parent::__construct();
		$this->name = $name;
		$this->value = $value;
		$this->required = $required;
		$this->display = $display;
		$this->attributes = $attributes;
	}}
	public $display;
	public function render() {
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name);
		$type = null;
		if($this->display) {
			$type = "text";
		} else {
			$type = "hidden";
		}
		return "<input type=\"" . _hx_string_or_null($type) . "\" name=\"" . _hx_string_or_null($n) . "\" id=\"" . _hx_string_or_null($n) . "\" value=\"" . Std::string($this->value) . "\"/>";
	}
	public function getFullRow() {
		return $this->render();
	}
	public function toString() {
		return $this->render();
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
	function __toString() { return $this->toString(); }
}
