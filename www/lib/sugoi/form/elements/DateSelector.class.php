<?php

class sugoi_form_elements_DateSelector extends sugoi_form_FormElement {
	public function __construct($name, $label, $value = null, $required = null, $validators = null, $attibutes = null) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.form.elements.DateSelector::new");
		$__hx__spos = $GLOBALS['%s']->length;
		if($attibutes === null) {
			$attibutes = "";
		}
		if($required === null) {
			$required = false;
		}
		parent::__construct();
		$this->name = $name;
		$this->label = $label;
		if($value !== null) {
			$this->datetime = Std::string($value);
			$this->value = $this->datetime;
		} else {
			$this->datetime = null;
			$this->value = null;
		}
		$this->mode = sugoi_form_elements_DateTimeMode::$date;
		$this->required = $required;
		$this->attributes = $attibutes;
		$this->maxOffset = null;
		$this->minOffset = null;
		$GLOBALS['%s']->pop();
	}}
	public $maxOffset;
	public $minOffset;
	public $datetime;
	public $mode;
	public function render() {
		$GLOBALS['%s']->push("sugoi.form.elements.DateSelector::render");
		$__hx__spos = $GLOBALS['%s']->length;
		if($this->datetime === null && _hx_field($this, "value") !== null) {
			$this->datetime = Std::string($this->value);
		}
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name);
		$sb = new StringBuf();
		$s = new StringBuf();
		$n_time = _hx_string_or_null($n) . "__time";
		$n_date = _hx_string_or_null($n) . "__date";
		$dtDate = _hx_substr($this->datetime, 0, 10);
		$dtHour = _hx_substr($this->datetime, 11, 2);
		$dtMin = _hx_substr($this->datetime, 14, 2);
		$dtSec = _hx_substr($this->datetime, 17, 2);
		if((is_object($_t = $this->mode) && !($_t instanceof Enum) ? $_t === sugoi_form_elements_DateTimeMode::$date : $_t == sugoi_form_elements_DateTimeMode::$date) || (is_object($_t2 = $this->mode) && !($_t2 instanceof Enum) ? $_t2 === sugoi_form_elements_DateTimeMode::$dateTime : $_t2 == sugoi_form_elements_DateTimeMode::$dateTime)) {
			$s->add("<input class=\"" . _hx_string_or_null($this->getClasses()) . "\" type=\"text\" name=\"" . _hx_string_or_null($n_date) . "\" id=\"" . _hx_string_or_null($n_date) . "\" value=\"" . _hx_string_or_null($dtDate) . "\" /> \x0A");
		}
		if((is_object($_t3 = $this->mode) && !($_t3 instanceof Enum) ? $_t3 === sugoi_form_elements_DateTimeMode::$time : $_t3 == sugoi_form_elements_DateTimeMode::$time) || (is_object($_t4 = $this->mode) && !($_t4 instanceof Enum) ? $_t4 === sugoi_form_elements_DateTimeMode::$dateTime : $_t4 == sugoi_form_elements_DateTimeMode::$dateTime)) {
			$s->add(" H: <select class=\"" . _hx_string_or_null($this->getClasses()) . "\" name=\"" . _hx_string_or_null($n_time) . "_hour\" id=\"" . _hx_string_or_null($n_time) . "_hour\"> \x0A");
			{
				$_g = 0;
				while($_g < 24) {
					$i = $_g++;
					$hour = null;
					if($i < 10) {
						$hour = "0" . Std::string($i);
					} else {
						$hour = Std::string($i);
					}
					if($hour === $dtHour) {
						$s->add("\x09\x09<option value=\"" . _hx_string_or_null($hour) . "\" selected=\"selected\">" . _hx_string_or_null($hour) . "</option> \x0A");
					} else {
						$s->add("\x09\x09<option value=\"" . _hx_string_or_null($hour) . "\">" . _hx_string_or_null($hour) . "</option> \x0A");
					}
					unset($i,$hour);
				}
			}
			$s->add("</select> \x0A");
			$s->add(" M: <select class=\"" . _hx_string_or_null($this->getClasses()) . "\" name=\"" . _hx_string_or_null($n_time) . "_min\" id=\"" . _hx_string_or_null($n_time) . "_min\"> \x0A");
			{
				$_g1 = 0;
				while($_g1 < 60) {
					$i1 = $_g1++;
					$minute = null;
					if($i1 < 10) {
						$minute = "0" . Std::string($i1);
					} else {
						$minute = Std::string($i1);
					}
					if($minute === $dtMin) {
						$s->add("\x09\x09<option value=\"" . _hx_string_or_null($minute) . "\" selected=\"selected\">" . _hx_string_or_null($minute) . "</option> \x0A");
					} else {
						$s->add("\x09\x09<option value=\"" . _hx_string_or_null($minute) . "\">" . _hx_string_or_null($minute) . "</option> \x0A");
					}
					unset($minute,$i1);
				}
			}
			$s->add("</select> \x0A");
			$s->add(" S: <select class=\"" . _hx_string_or_null($this->getClasses()) . "\" name=\"" . _hx_string_or_null($n_time) . "_sec\" id=\"" . _hx_string_or_null($n_time) . "_sec\"> \x0A");
			{
				$_g2 = 0;
				while($_g2 < 60) {
					$i2 = $_g2++;
					$second = null;
					if($i2 < 10) {
						$second = "0" . Std::string($i2);
					} else {
						$second = Std::string($i2);
					}
					if($second === $dtSec) {
						$s->add("\x09\x09<option value=\"" . _hx_string_or_null($second) . "\" selected=\"selected\">" . _hx_string_or_null($second) . "</option> \x0A");
					} else {
						$s->add("\x09\x09<option value=\"" . _hx_string_or_null($second) . "\">" . _hx_string_or_null($second) . "</option> \x0A");
					}
					unset($second,$i2);
				}
			}
			$s->add("</select> \x0A");
		}
		$s->add("<input type=\"hidden\" name=\"" . _hx_string_or_null($n) . "\" id=\"" . _hx_string_or_null($n) . "\" value=\"" . Std::string($this->value) . "\" /> \x0A");
		$s->add("<script type=\"text/javascript\">\x09\x09\x09\x0A");
		$s->add("\x09\x09\$(function() {\x09\x09\x09\x09\x09\x09\x09\x0A");
		$maxOffsetStr = null;
		if($this->minOffset !== null) {
			$maxOffsetStr = ", minDate: '-" . _hx_string_rec($this->minOffset, "") . "m'";
		} else {
			$maxOffsetStr = "";
		}
		$minOffsetStr = null;
		if($this->maxOffset !== null) {
			$minOffsetStr = ", maxDate: '+" . _hx_string_rec($this->maxOffset, "") . "m'";
		} else {
			$minOffsetStr = "";
		}
		$s->add("\x09\x09\x09\$(\"#" . _hx_string_or_null($n_date) . "\").datepicker({ clickInput:true, dateFormat: \"yy-mm-dd\" " . _hx_string_or_null($minOffsetStr) . _hx_string_or_null($maxOffsetStr) . " });\x09\x09\x0A");
		if((is_object($_t5 = $this->mode) && !($_t5 instanceof Enum) ? $_t5 === sugoi_form_elements_DateTimeMode::$date : $_t5 == sugoi_form_elements_DateTimeMode::$date) || (is_object($_t6 = $this->mode) && !($_t6 instanceof Enum) ? $_t6 === sugoi_form_elements_DateTimeMode::$dateTime : $_t6 == sugoi_form_elements_DateTimeMode::$dateTime)) {
			$s->add("\x09\x09\x09\$(\"#" . _hx_string_or_null($n_date) . "\").change( updateDateTime ); \x0A");
		}
		if((is_object($_t7 = $this->mode) && !($_t7 instanceof Enum) ? $_t7 === sugoi_form_elements_DateTimeMode::$time : $_t7 == sugoi_form_elements_DateTimeMode::$time) || (is_object($_t8 = $this->mode) && !($_t8 instanceof Enum) ? $_t8 === sugoi_form_elements_DateTimeMode::$dateTime : $_t8 == sugoi_form_elements_DateTimeMode::$dateTime)) {
			$s->add("\x09\x09\x09\$(\"#" . _hx_string_or_null($n_time) . "_hour\").change( updateDateTime ); \x0A");
			$s->add("\x09\x09\x09\$(\"#" . _hx_string_or_null($n_time) . "_min\").change( updateDateTime ); \x0A");
			$s->add("\x09\x09\x09\$(\"#" . _hx_string_or_null($n_time) . "_sec\").change( updateDateTime ); \x0A");
		}
		$s->add("\x09\x09}); \x09\x09\x09\x09\x09\x09\x09\x09\x09\x0A");
		$s->add("\x09\x09function updateDateTime() {\x0A");
		if((is_object($_t9 = $this->mode) && !($_t9 instanceof Enum) ? $_t9 === sugoi_form_elements_DateTimeMode::$time : $_t9 == sugoi_form_elements_DateTimeMode::$time)) {
			$s->add("\x09\x09\x09\$('#" . _hx_string_or_null($n) . "').val( \$('#" . _hx_string_or_null($n_time) . "_hour').val() + ':' + \$('#" . _hx_string_or_null($n_time) . "_min').val() + ':' + \$('#" . _hx_string_or_null($n_time) . "_sec').val() ); \x0A");
		} else {
			if((is_object($_t10 = $this->mode) && !($_t10 instanceof Enum) ? $_t10 === sugoi_form_elements_DateTimeMode::$date : $_t10 == sugoi_form_elements_DateTimeMode::$date)) {
				$s->add("\x09\x09\x09\$('#" . _hx_string_or_null($n) . "').val( \$('#" . _hx_string_or_null($n_date) . "').val() ); \x0A");
			} else {
				$s->add("\x09\x09\x09\$('#" . _hx_string_or_null($n) . "').val( \$('#" . _hx_string_or_null($n_date) . "').val() + ' ' + \$('#" . _hx_string_or_null($n_time) . "_hour').val() + ':' + \$('#" . _hx_string_or_null($n_time) . "_min').val() + ':' + \$('#" . _hx_string_or_null($n_time) . "_sec').val() ); \x0A");
			}
		}
		$s->add("\x09\x09}\x0A");
		$s->add("</script> \x09\x09\x09\x09\x09\x09\x09\x09\x09\x0A");
		{
			$tmp = $s->b;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function toString() {
		$GLOBALS['%s']->push("sugoi.form.elements.DateSelector::toString");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->render();
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function populate() {
		$GLOBALS['%s']->push("sugoi.form.elements.DateSelector::populate");
		$__hx__spos = $GLOBALS['%s']->length;
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name);
		$v = App::$current->params->get($n);
		if($v !== null) {
			$this->datetime = Std::string($v);
			$this->value = $v;
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
