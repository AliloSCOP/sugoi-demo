<?php

class sugoi_form_elements_DateInput extends sugoi_form_elements_DateDropdowns {
	public function __construct($name, $label, $value = null, $required = null, $yearMin = null, $yearMax = null, $validators = null, $attibutes = null) {
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
		parent::__construct($name,$label,$value,$required,$yearMin,$yearMax,$validators,$attibutes);
		$t = sugoi_form_Form::$translator;
		$this->hourSelector = new sugoi_form_elements_Selectbox(_hx_string_or_null($name) . "_hour", $t->_("hour", null), sugoi_form_ListData::getDateElement(0, 23, null), Std::string($this->date->getHours()), true, "-", "title=\"Hour\"");
		$this->minuteSelector = new sugoi_form_elements_Selectbox(_hx_string_or_null($name) . "_minute", $t->_("minute", null), sugoi_form_ListData::getDateElement(0, 59, null), Std::string($this->date->getMinutes()), true, "-", "title=\"Minute\"");
		if(sugoi_form_Form::$USE_TWITTER_BOOTSTRAP) {
			$this->hourSelector->cssClass = "form-control";
			$this->minuteSelector->cssClass = "form-control";
		}
	}}
	public $hourSelector;
	public $minuteSelector;
	public function isValid() {
		return true;
	}
	public function render() {
		$this->hourSelector->parentForm = $this->parentForm;
		$this->minuteSelector->parentForm = $this->parentForm;
		$s = _hx_string_or_null(parent::render()) . " : ";
		if(!_hx_equal($this->value, "") && _hx_field($this, "value") !== null && !_hx_equal($this->value, "null")) {
			$v = $this->value;
			$this->hourSelector->value = $v->getHours();
			$this->minuteSelector->value = $v->getMinutes();
		}
		$s .= _hx_string_or_null($this->hourSelector->render()) . " h ";
		$s .= _hx_string_or_null($this->minuteSelector->render()) . " m ";
		return $s;
	}
	public function populate() {
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->hourSelector->name);
		$v = App::$current->params->get($n);
		$params = App::$current->params;
		if($v !== null) {
			$minute = Std::parseInt($params->get(_hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->minuteSelector->name)));
			$hour = Std::parseInt($params->get(_hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->hourSelector->name)));
			$day = Std::parseInt($params->get(_hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->daySelector->name)));
			$month = Std::parseInt($params->get(_hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->monthSelector->name)));
			$year = Std::parseInt($params->get(_hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->yearSelector->name)));
			$this->value = new Date($year, $month - 1, $day, $hour, $minute, 0);
		}
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
	function __toString() { return 'sugoi.form.elements.DateInput'; }
}
