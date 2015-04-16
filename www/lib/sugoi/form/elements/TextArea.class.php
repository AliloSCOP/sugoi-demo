<?php

class sugoi_form_elements_TextArea extends sugoi_form_elements_Input {
	public function __construct($name, $label, $value = null, $required = null, $validators = null, $attributes = null) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.form.elements.TextArea::new");
		$__hx__spos = $GLOBALS['%s']->length;
		if($required === null) {
			$required = false;
		}
		parent::__construct($name,$label,$value,$required,$validators,$attributes,null);
		$this->width = 300;
		$this->height = 50;
		$GLOBALS['%s']->pop();
	}}
	public $height;
	public function render() {
		$GLOBALS['%s']->push("sugoi.form.elements.TextArea::render");
		$__hx__spos = $GLOBALS['%s']->length;
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name);
		if($this->showLabelAsDefaultValue && _hx_equal($this->value, $this->label)) {
			$this->addValidator(new sugoi_form_validators_BoolValidator(false, "Not valid"));
		}
		if((_hx_field($this, "value") === null || _hx_equal($this->value, "")) && $this->showLabelAsDefaultValue) {
			$this->value = $this->label;
		}
		$s = "";
		if($this->required && $this->parentForm->isSubmitted() && $this->printRequired) {
			$s .= "required<br />";
		}
		$style = null;
		if($this->useSizeValues) {
			$style = "style=\"width:" . _hx_string_rec($this->width, "") . "px; height:" . _hx_string_rec($this->height, "") . "px;\"";
		} else {
			$style = "";
		}
		$s .= "<textarea " . _hx_string_or_null($style) . " class=\"" . _hx_string_or_null($this->getClasses()) . "\" name=\"" . _hx_string_or_null($n) . "\" id=\"" . _hx_string_or_null($n) . "\" " . _hx_string_or_null($this->attributes) . " >" . _hx_string_or_null(sugoi_form_elements_TextArea_0($this, $n, $s, $style)) . "</textarea>";
		{
			$GLOBALS['%s']->pop();
			return $s;
		}
		$GLOBALS['%s']->pop();
	}
	public function toString() {
		$GLOBALS['%s']->push("sugoi.form.elements.TextArea::toString");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->render();
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
	function __toString() { return $this->toString(); }
}
function sugoi_form_elements_TextArea_0(&$__hx__this, &$n, &$s, &$style) {
	{
		$s1 = $__hx__this->value;
		if($s1 === null) {
			return "";
		} else {
			return _hx_explode("\"", StringTools::htmlEscape(Std::string($s1), null))->join("&quot;");
		}
		unset($s1);
	}
}
