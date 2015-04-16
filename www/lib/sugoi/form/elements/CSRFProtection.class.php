<?php

class sugoi_form_elements_CSRFProtection extends sugoi_form_FormElement {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.form.elements.CSRFProtection::new");
		$__hx__spos = $GLOBALS['%s']->length;
		parent::__construct();
		$this->value = haxe_crypto_Md5::encode(_hx_string_or_null(App::$current->session->sid) . _hx_string_or_null(_hx_substr(App::$config->KEY, 0, 5)));
		$this->name = "token";
		$GLOBALS['%s']->pop();
	}}
	public function isValid() {
		$GLOBALS['%s']->push("sugoi.form.elements.CSRFProtection::isValid");
		$__hx__spos = $GLOBALS['%s']->length;
		$valid = null;
		$valid = _hx_equal(sugoi_form_elements_CSRFProtection_0($this, $valid), $this->value);
		if(!$valid) {
			$this->errors->add("Bad CSRFProtection token");
		}
		{
			$GLOBALS['%s']->pop();
			return $valid;
		}
		$GLOBALS['%s']->pop();
	}
	public function getFullRow() {
		$GLOBALS['%s']->push("sugoi.form.elements.CSRFProtection::getFullRow");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->render();
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function render() {
		$GLOBALS['%s']->push("sugoi.form.elements.CSRFProtection::render");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = "<input type=\"hidden\" value=\"" . Std::string($this->value) . "\" " . _hx_string_or_null($this->attributes) . " name=\"" . _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name) . "\" id=\"" . _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name) . "\" />";
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'sugoi.form.elements.CSRFProtection'; }
}
function sugoi_form_elements_CSRFProtection_0(&$__hx__this, &$valid) {
	{
		$this1 = php_Web::getParams();
		return $this1->get(_hx_string_or_null($__hx__this->parentForm->name) . "_" . _hx_string_or_null($__hx__this->name));
	}
}
