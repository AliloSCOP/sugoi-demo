<?php

class sugoi_form_FieldSet {
	public function __construct($name = null, $label = null, $visible = null) {
		if(!php_Boot::$skip_constructor) {
		if($visible === null) {
			$visible = true;
		}
		if($label === null) {
			$label = "";
		}
		if($name === null) {
			$name = "";
		}
		$this->name = $name;
		$this->label = $label;
		$this->visible = $visible;
		$this->elements = (new _hx_array(array()));
	}}
	public $name;
	public $form;
	public $label;
	public $visible;
	public $elements;
	public function getOpenTag() {
		return "<fieldset id=\"" . _hx_string_or_null($this->form->name) . "_" . _hx_string_or_null($this->name) . "\" name=\"" . _hx_string_or_null($this->form->name) . "_" . _hx_string_or_null($this->name) . "\" class=\"" . _hx_string_or_null(((($this->visible) ? "" : "fieldsetNoDisplay"))) . "\" ><legend>" . _hx_string_or_null($this->label) . "</legend>";
	}
	public function getCloseTag() {
		return "</fieldset>";
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
	function __toString() { return 'sugoi.form.FieldSet'; }
}
