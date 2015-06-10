<?php

class sugoi_form_elements_DatePicker extends sugoi_form_FormElement {
	public function __construct($name, $label, $_value = null, $required = null, $yearMin = null, $yearMax = null, $validators = null, $attibutes = null) {
		if(!php_Boot::$skip_constructor) {
		if($attibutes === null) {
			$attibutes = "";
		}
		if($yearMin === null) {
			$yearMin = 1950;
		}
		if($required === null) {
			$required = false;
		}
		parent::__construct();
		$this->name = $name;
		$this->label = $label;
		$this->format = "LLLL";
		if($_value === null) {
			$this->value = Date::now();
			$this->date = Date::now();
		} else {
			$this->value = $_value;
			$this->date = $_value;
		}
		$this->required = $required;
		$this->attributes = $attibutes;
		$this->yearMin = $yearMin;
		$this->yearMax = $yearMax;
		$this->maxOffset = null;
		$this->minOffset = null;
		$day = "";
		$month = "";
		$year = "";
		if($this->date !== null) {
			$day = "" . _hx_string_rec($this->date->getDate(), "");
			$month = "" . _hx_string_rec(($this->date->getMonth() + 1), "");
			$year = "" . _hx_string_rec($this->date->getFullYear(), "");
		}
	}}
	public $maxOffset;
	public $minOffset;
	public $date;
	public $yearMin;
	public $yearMax;
	public $daySelector;
	public $monthSelector;
	public $yearSelector;
	public $format;
	public function populate() {
		$d = App::$current->params->get(_hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name));
		$this->value = $this->date = Date::fromTime(Std::parseFloat($d));
	}
	public function isValid() {
		return true;
	}
	public function render() {
		parent::render();
		$defaultDate = _hx_string_rec($this->date->getMonth() + 1, "") . "/" . _hx_string_rec($this->date->getDate(), "") . "/" . _hx_string_rec($this->date->getFullYear(), "") . " " . _hx_string_rec($this->date->getHours(), "") . ":" . _hx_string_rec($this->date->getMinutes(), "");
		return "<!--<div class='form-group'>-->\x0D\x0A\x09\x09\x09\x09<div class='input-group date' id='datetimepicker-" . _hx_string_or_null($this->name) . "'>       \x0D\x0A\x09\x09\x09\x09\x09<span class='input-group-addon'>\x0D\x0A\x09\x09\x09\x09\x09\x09<span class='glyphicon glyphicon-calendar'></span>\x0D\x0A\x09\x09\x09\x09\x09</span>\x0D\x0A\x09\x09\x09\x09\x09<input type='text' class='form-control' />\x0D\x0A\x09\x09\x09\x09</div>\x0D\x0A\x09\x09\x09<!--</div>-->\x0D\x0A\x09\x09\x09<input type='hidden' name='" . _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name) . "' id='datetimepickerdata-" . _hx_string_or_null($this->name) . "' value='" . _hx_string_rec($this->date->getTime(), "") . "'/>\x0D\x0A\x09\x09\x09<script type='text/javascript'>\x0D\x0A\x09\x09\x09\x09\$(function () {\x0D\x0A\x09\x09\x09\x09\x09\$('#datetimepicker-" . _hx_string_or_null($this->name) . "').datetimepicker(\x0D\x0A\x09\x09\x09\x09\x09\x09{\x0D\x0A\x09\x09\x09\x09\x09\x09\x09locale:'fr',\x0D\x0A\x09\x09\x09\x09\x09\x09\x09format:'" . _hx_string_or_null($this->format) . "',\x0D\x0A\x09\x09\x09\x09\x09\x09\x09defaultDate:'" . _hx_string_or_null($defaultDate) . "'\x0D\x0A\x09\x09\x09\x09\x09\x09}\x0D\x0A\x09\x09\x09\x09\x09);\x0D\x0A\x09\x09\x09\x09\x09//stores the date as timestamp in a hidden input element\x09\x0D\x0A\x09\x09\x09\x09\x09\$('#datetimepicker-" . _hx_string_or_null($this->name) . "').on('dp.change',function(e){\x0D\x0A\x09\x09\x09\x09\x09\x09var d = \$('#datetimepicker-" . _hx_string_or_null($this->name) . "').data('DateTimePicker').date()._d;\x0D\x0A\x09\x09\x09\x09\x09\x09\$('#datetimepickerdata-" . _hx_string_or_null($this->name) . "').val( d.getTime());\x0D\x0A\x09\x09\x09\x09\x09});\x0D\x0A\x09\x09\x09\x09});\x0D\x0A\x09\x09\x09</script>";
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
	function __toString() { return 'sugoi.form.elements.DatePicker'; }
}
