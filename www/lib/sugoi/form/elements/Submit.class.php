<?php

class sugoi_form_elements_Submit extends sugoi_form_FormElement {
	public function __construct($name, $value) { if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->name = $name;
		$this->value = $value;
	}}
	public function isValid() {
		return true;
	}
	public function render() {
		if(sugoi_form_Form::$USE_TWITTER_BOOTSTRAP) {
			$this->cssClass = "btn btn-primary";
		}
		$s = "<input type=\"submit\" class=\"" . _hx_string_or_null($this->getClasses()) . "\" value=\"" . Std::string($this->value) . "\" " . _hx_string_or_null($this->attributes) . " name=\"" . _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name) . "\" id=\"" . _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name) . "\" />";
		return $s;
	}
	public function toString() {
		return $this->render();
	}
	public function getFullRow() {
		return "<div class='col-sm-4'></div><div class='col-sm-8'>" . _hx_string_or_null($this->render()) . "</div>";
	}
	public function populate() {
		parent::populate();
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name);
	}
	function __toString() { return $this->toString(); }
}
