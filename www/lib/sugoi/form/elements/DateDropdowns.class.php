<?php

class sugoi_form_elements_DateDropdowns extends sugoi_form_FormElement {
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
		$t = sugoi_form_Form::$translator;
		$this->daySelector = new sugoi_form_elements_Selectbox(_hx_string_or_null($name) . "_day", $t->_("day", null), sugoi_form_ListData::getDays(null), $day, true, null, null);
		$this->monthSelector = new sugoi_form_elements_Selectbox(_hx_string_or_null($name) . "_month", $t->_("month", null), sugoi_form_elements_DateDropdowns_0($this, $_value, $attibutes, $day, $label, $month, $name, $required, $t, $validators, $year, $yearMax, $yearMin), $month, true, null, null);
		$this->yearSelector = new sugoi_form_elements_Selectbox(_hx_string_or_null($name) . "_year", $t->_("year", null), sugoi_form_ListData::getYears(Date::now()->getFullYear() - 3, Date::now()->getFullYear() + 3, true), $year, true, null, null);
		$this->daySelector->internal = $this->monthSelector->internal = $this->yearSelector->internal = true;
	}}
	public $maxOffset;
	public $minOffset;
	public $date;
	public $yearMin;
	public $yearMax;
	public $daySelector;
	public $monthSelector;
	public $yearSelector;
	public function shortLabels() {
		$this->daySelector->nullMessage = "-D-";
		$this->monthSelector->nullMessage = "-M-";
		$this->yearSelector->nullMessage = "-Y-";
		{
			$input = sugoi_form_ListData::$months_short;
			$out = (new _hx_array(array()));
			$c = 1;
			{
				$_g = 0;
				while($_g < $input->length) {
					$i = $input[$_g];
					++$_g;
					$out->push(_hx_anonymous(array("key" => Std::string($c), "value" => $i)));
					$c++;
					unset($i);
				}
			}
			$this->monthSelector->data = $out;
		}
	}
	public function init() {
		parent::init();
		$this->parentForm->addElement($this->daySelector, null, null);
		$this->parentForm->addElement($this->monthSelector, null, null);
		$this->parentForm->addElement($this->yearSelector, null, null);
	}
	public function populate() {
		$day = Std::parseInt(App::$current->params->get(_hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->daySelector->name)));
		$month = Std::parseInt(App::$current->params->get(_hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->monthSelector->name)));
		$year = Std::parseInt(App::$current->params->get(_hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->yearSelector->name)));
		if($day !== null && $month !== null && $year !== null) {
			$this->value = new Date($year, $month - 1, $day, 0, 0, 0);
		} else {
			$this->value = null;
		}
	}
	public function isValid() {
		return true;
	}
	public function render() {
		parent::render();
		if(!_hx_equal($this->value, "") && _hx_field($this, "value") !== null && !_hx_equal($this->value, "null")) {
			try {
				$v = $this->value;
				$this->daySelector->value = $v->getDate();
				$this->monthSelector->value = $v->getMonth() + 1;
				$this->yearSelector->value = $v->getFullYear();
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e = $_ex_;
				{}
			}
		}
		return "<div class=\"row\">\x0D\x0A\x09\x09  <div class=\"col-xs-2\">" . _hx_string_or_null($this->daySelector->render()) . "</div>\x0D\x0A\x09\x09  <div class=\"col-xs-6\">" . _hx_string_or_null($this->monthSelector->render()) . "</div>\x0D\x0A\x09\x09  <div class=\"col-xs-4\">" . _hx_string_or_null($this->yearSelector->render()) . "</div>\x0D\x0A\x09\x09</div>";
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
	function __toString() { return 'sugoi.form.elements.DateDropdowns'; }
}
function sugoi_form_elements_DateDropdowns_0(&$__hx__this, &$_value, &$attibutes, &$day, &$label, &$month, &$name, &$required, &$t, &$validators, &$year, &$yearMax, &$yearMin) {
	{
		$input = sugoi_form_ListData::$months;
		$out = (new _hx_array(array()));
		$c = 1;
		{
			$_g = 0;
			while($_g < $input->length) {
				$i = $input[$_g];
				++$_g;
				$out->push(_hx_anonymous(array("key" => Std::string($c), "value" => $i)));
				$c++;
				unset($i);
			}
		}
		return $out;
	}
}
