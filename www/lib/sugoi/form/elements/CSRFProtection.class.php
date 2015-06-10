<?php

class sugoi_form_elements_CSRFProtection extends sugoi_form_FormElement {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->value = haxe_crypto_Md5::encode(_hx_string_or_null(App::$current->session->sid) . _hx_string_or_null(_hx_substr(App::$config->KEY, 0, 5)));
		$this->name = "token";
	}}
	public function isValid() {
		$valid = null;
		$valid = _hx_equal(sugoi_form_elements_CSRFProtection_0($this, $valid), $this->value);
		if(!$valid) {
			$this->errors->add("Bad CSRFProtection token");
		}
		return $valid;
	}
	public function getFullRow() {
		return $this->render();
	}
	public function render() {
		return "<input type=\"hidden\" value=\"" . Std::string($this->value) . "\" " . _hx_string_or_null($this->attributes) . " name=\"" . _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name) . "\" id=\"" . _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name) . "\" />";
	}
	function __toString() { return 'sugoi.form.elements.CSRFProtection'; }
}
function sugoi_form_elements_CSRFProtection_0(&$__hx__this, &$valid) {
	{
		$this1 = php_Web::getParams();
		return $this1->get(_hx_string_or_null($__hx__this->parentForm->name) . "_" . _hx_string_or_null($__hx__this->name));
	}
}
