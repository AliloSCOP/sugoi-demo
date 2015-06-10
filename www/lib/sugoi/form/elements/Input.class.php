<?php

class sugoi_form_elements_Input extends sugoi_form_FormElement {
	public function __construct($name, $label, $value = null, $required = null, $validators = null, $attributes = null, $disabled = null) {
		if(!php_Boot::$skip_constructor) {
		if($disabled === null) {
			$disabled = false;
		}
		if($attributes === null) {
			$attributes = "";
		}
		if($required === null) {
			$required = false;
		}
		parent::__construct();
		$this->name = $name;
		$this->label = $label;
		$this->value = $value;
		$this->required = $required;
		$this->attributes = $attributes;
		$this->password = false;
		$this->disabled = $disabled;
		$this->showLabelAsDefaultValue = false;
		$this->useSizeValues = false;
		$this->printRequired = false;
		if(sugoi_form_Form::$USE_TWITTER_BOOTSTRAP) {
			$this->cssClass = "form-control";
		}
		$this->width = 180;
	}}
	public $password;
	public $width;
	public $disabled;
	public $showLabelAsDefaultValue;
	public $useSizeValues;
	public $printRequired;
	public $formatter;
	public function render() {
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name);
		$tType = null;
		if($this->password) {
			$tType = "password";
		} else {
			$tType = "text";
		}
		if($this->showLabelAsDefaultValue && _hx_equal($this->value, $this->label)) {
			$this->addValidator(new sugoi_form_validators_BoolValidator(false, "Not valid"));
		}
		if((_hx_field($this, "value") === null || _hx_equal($this->value, "")) && $this->showLabelAsDefaultValue) {
			$this->value = $this->label;
		}
		$style = null;
		if($this->useSizeValues) {
			$style = "style=\"width:" . _hx_string_rec($this->width, "") . "px\"";
		} else {
			$style = "";
		}
		return "<input " . _hx_string_or_null($style) . " class=\"" . _hx_string_or_null($this->getClasses()) . "\" type=\"" . _hx_string_or_null($tType) . "\" name=\"" . _hx_string_or_null($n) . "\" id=\"" . _hx_string_or_null($n) . "\" value=\"" . _hx_string_or_null(sugoi_form_elements_Input_0($this, $n, $style, $tType)) . "\"  " . _hx_string_or_null($this->attributes) . " " . _hx_string_or_null(((($this->disabled) ? "disabled" : ""))) . "/>" . _hx_string_or_null(((($this->required && $this->parentForm->isSubmitted() && $this->printRequired) ? " required" : "")));
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
function sugoi_form_elements_Input_0(&$__hx__this, &$n, &$style, &$tType) {
	{
		$s = $__hx__this->value;
		if($s === null) {
			return "";
		} else {
			return _hx_explode("\"", StringTools::htmlEscape(Std::string($s), null))->join("&quot;");
		}
		unset($s);
	}
}
