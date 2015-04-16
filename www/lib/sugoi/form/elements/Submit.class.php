<?php

class sugoi_form_elements_Submit extends sugoi_form_FormElement {
	public function __construct($name, $value) { if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.form.elements.Submit::new");
		$__hx__spos = $GLOBALS['%s']->length;
		parent::__construct();
		$this->name = $name;
		$this->value = $value;
		$GLOBALS['%s']->pop();
	}}
	public function isValid() {
		$GLOBALS['%s']->push("sugoi.form.elements.Submit::isValid");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return true;
		}
		$GLOBALS['%s']->pop();
	}
	public function render() {
		$GLOBALS['%s']->push("sugoi.form.elements.Submit::render");
		$__hx__spos = $GLOBALS['%s']->length;
		if(sugoi_form_Form::$USE_TWITTER_BOOTSTRAP) {
			$this->cssClass = "btn btn-primary";
		}
		$s = "<input type=\"submit\" class=\"" . _hx_string_or_null($this->getClasses()) . "\" value=\"" . Std::string($this->value) . "\" " . _hx_string_or_null($this->attributes) . " name=\"" . _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name) . "\" id=\"" . _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name) . "\" />";
		{
			$GLOBALS['%s']->pop();
			return $s;
		}
		$GLOBALS['%s']->pop();
	}
	public function toString() {
		$GLOBALS['%s']->push("sugoi.form.elements.Submit::toString");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->render();
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getFullRow() {
		$GLOBALS['%s']->push("sugoi.form.elements.Submit::getFullRow");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = "<div class='col-sm-4'></div><div class='col-sm-8'>" . _hx_string_or_null($this->render()) . "</div>";
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function populate() {
		$GLOBALS['%s']->push("sugoi.form.elements.Submit::populate");
		$__hx__spos = $GLOBALS['%s']->length;
		parent::populate();
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name);
		$GLOBALS['%s']->pop();
	}
	function __toString() { return $this->toString(); }
}
