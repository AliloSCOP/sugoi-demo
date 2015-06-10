<?php

class sugoi_form_elements_Checkbox extends sugoi_form_FormElement {
	public function __construct($name, $label, $checked = null, $required = null, $attibutes = null) { if(!php_Boot::$skip_constructor) {
		if($attibutes === null) {
			$attibutes = "";
		}
		if($required === null) {
			$required = false;
		}
		if($checked === null) {
			$checked = false;
		}
		parent::__construct();
		$this->name = $name;
		$this->label = $label;
		if($checked) {
			$this->value = "1";
		} else {
			$this->value = "0";
		}
		$this->required = $required;
		$this->attributes = $attibutes;
	}}
	public function render() {
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name);
		$checkedStr = null;
		if(_hx_equal($this->value, "1")) {
			$checkedStr = "checked";
		} else {
			$checkedStr = "";
		}
		return "<input type=\"checkbox\" id=\"" . _hx_string_or_null($n) . "\" name=\"" . _hx_string_or_null($n) . "\" class=\"" . _hx_string_or_null($this->getClasses()) . "\" value=\"" . Std::string($this->value) . "\" " . _hx_string_or_null($checkedStr) . " />";
	}
	public function toString() {
		return $this->render();
	}
	public function populate() {
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name);
		$v = null;
		if(App::$current->params->exists($n)) {
			$v = "1";
		} else {
			$v = "0";
		}
		if($this->parentForm->isSubmitted()) {
			if($v !== null) {
				$this->value = $v;
			}
		}
	}
	public function isValid() {
		$this->errors->clear();
		if($this->required && _hx_equal($this->value, "0")) {
			$this->errors->add("Please check '" . _hx_string_or_null((sugoi_form_elements_Checkbox_0($this))) . "'");
			return false;
		}
		return true;
	}
	function __toString() { return $this->toString(); }
}
function sugoi_form_elements_Checkbox_0(&$__hx__this) {
	if($__hx__this->label !== null && $__hx__this->label !== "") {
		return $__hx__this->label;
	} else {
		return $__hx__this->name;
	}
}
