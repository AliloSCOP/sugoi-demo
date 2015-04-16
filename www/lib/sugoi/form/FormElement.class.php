<?php

class sugoi_form_FormElement {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.form.FormElement::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->active = true;
		$this->errors = new HList();
		$this->validators = new HList();
		$this->filters = new HList();
		$this->inited = false;
		$this->internal = false;
		$GLOBALS['%s']->pop();
	}}
	public $parentForm;
	public $name;
	public $label;
	public $description;
	public $value;
	public $required;
	public $errors;
	public $attributes;
	public $active;
	public $cssClass;
	public $inited;
	public $internal;
	public $validators;
	public $filters;
	public function filter() {
		$GLOBALS['%s']->push("sugoi.form.FormElement::filter");
		$__hx__spos = $GLOBALS['%s']->length;
		if(null == $this->filters) throw new HException('null iterable');
		$__hx__it = $this->filters->iterator();
		while($__hx__it->hasNext()) {
			unset($f);
			$f = $__hx__it->next();
			$this->value = $f->filter($this->value);
		}
		{
			$tmp = $this->value;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function isValid() {
		$GLOBALS['%s']->push("sugoi.form.FormElement::isValid");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->errors->clear();
		if(!$this->active) {
			$GLOBALS['%s']->pop();
			return true;
		}
		if(_hx_equal($this->value, "") && $this->required || _hx_field($this, "value") === null && $this->required) {
			$this->errors->add("<span class=\"formErrorsField\">\"" . _hx_string_or_null((sugoi_form_FormElement_0($this))) . "\"</span> ne doit pas être vide.");
			{
				$GLOBALS['%s']->pop();
				return false;
			}
		}
		if(!_hx_equal($this->value, "") && _hx_field($this, "value") !== null) {
			if(!$this->validators->isEmpty()) {
				$pass = true;
				if(null == $this->validators) throw new HException('null iterable');
				$__hx__it = $this->validators->iterator();
				while($__hx__it->hasNext()) {
					unset($validator);
					$validator = $__hx__it->next();
					if(!$validator->isValid($this->value)) {
						$GLOBALS['%s']->pop();
						return false;
					}
				}
			}
			{
				$GLOBALS['%s']->pop();
				return true;
			}
		}
		{
			$GLOBALS['%s']->pop();
			return true;
		}
		$GLOBALS['%s']->pop();
	}
	public function checkValid() {
		$GLOBALS['%s']->push("sugoi.form.FormElement::checkValid");
		$__hx__spos = $GLOBALS['%s']->length;
		_hx_equal($this->value, "");
		$GLOBALS['%s']->pop();
	}
	public function init() {
		$GLOBALS['%s']->push("sugoi.form.FormElement::init");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->inited = true;
		$GLOBALS['%s']->pop();
	}
	public function addValidator($validator) {
		$GLOBALS['%s']->push("sugoi.form.FormElement::addValidator");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->validators->add($validator);
		$GLOBALS['%s']->pop();
	}
	public function addFilter($filter) {
		$GLOBALS['%s']->push("sugoi.form.FormElement::addFilter");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->filters->add($filter);
		$GLOBALS['%s']->pop();
	}
	public function populate() {
		$GLOBALS['%s']->push("sugoi.form.FormElement::populate");
		$__hx__spos = $GLOBALS['%s']->length;
		if(!$this->inited) {
			$this->init();
		}
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name);
		$v = App::$current->params->get($n);
		if($v !== null) {
			$this->value = $v;
		}
		$GLOBALS['%s']->pop();
	}
	public function getErrors() {
		$GLOBALS['%s']->push("sugoi.form.FormElement::getErrors");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->isValid();
		if(null == $this->validators) throw new HException('null iterable');
		$__hx__it = $this->validators->iterator();
		while($__hx__it->hasNext()) {
			unset($val);
			$val = $__hx__it->next();
			if(null == $val->errors) throw new HException('null iterable');
			$__hx__it2 = $val->errors->iterator();
			while($__hx__it2->hasNext()) {
				unset($err);
				$err = $__hx__it2->next();
				$this->errors->add("<span class=\"formErrorsField\">" . _hx_string_or_null($this->label) . "</span> : " . _hx_string_or_null($err));
			}
		}
		{
			$tmp = $this->errors;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function render() {
		$GLOBALS['%s']->push("sugoi.form.FormElement::render");
		$__hx__spos = $GLOBALS['%s']->length;
		if(!$this->inited) {
			$this->init();
		}
		{
			$tmp = $this->value;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function remove() {
		$GLOBALS['%s']->push("sugoi.form.FormElement::remove");
		$__hx__spos = $GLOBALS['%s']->length;
		if($this->parentForm !== null) {
			$tmp = $this->parentForm->removeElement($this);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		{
			$GLOBALS['%s']->pop();
			return false;
		}
		$GLOBALS['%s']->pop();
	}
	public function getFullRow() {
		$GLOBALS['%s']->push("sugoi.form.FormElement::getFullRow");
		$__hx__spos = $GLOBALS['%s']->length;
		$s = new StringBuf();
		if(sugoi_form_Form::$USE_TWITTER_BOOTSTRAP) {
			$s->add("<div class=\"form-group\">\x0A");
		}
		$s->add($this->getLabel());
		$s->add("<div class='col-sm-8'>" . _hx_string_or_null($this->render()) . "</div>");
		if(sugoi_form_Form::$USE_TWITTER_BOOTSTRAP) {
			$s->add("</div>\x0A");
		}
		{
			$tmp = $s->b;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getType() {
		$GLOBALS['%s']->push("sugoi.form.FormElement::getType");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = Std::string(Type::getClass($this));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getLabelClasses() {
		$GLOBALS['%s']->push("sugoi.form.FormElement::getLabelClasses");
		$__hx__spos = $GLOBALS['%s']->length;
		$css = "";
		if(sugoi_form_Form::$USE_TWITTER_BOOTSTRAP) {
			$css = "col-sm-4 control-label";
		}
		$requiredSet = false;
		if($this->required) {
			$css .= " " . _hx_string_or_null($this->parentForm->requiredClass);
			if($this->parentForm->isSubmitted() && $this->required && _hx_equal($this->value, "")) {
				$css .= " " . _hx_string_or_null($this->parentForm->requiredErrorClass);
				$requiredSet = true;
			}
		}
		if(!$requiredSet && $this->parentForm->isSubmitted() && !$this->isValid()) {
			$css .= " " . _hx_string_or_null($this->parentForm->invalidErrorClass);
		}
		{
			$GLOBALS['%s']->pop();
			return $css;
		}
		$GLOBALS['%s']->pop();
	}
	public function getLabel() {
		$GLOBALS['%s']->push("sugoi.form.FormElement::getLabel");
		$__hx__spos = $GLOBALS['%s']->length;
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name);
		{
			$tmp = "<label for=\"" . _hx_string_or_null($n) . "\" class=\"" . _hx_string_or_null($this->getLabelClasses()) . "\" id=\"" . _hx_string_or_null($n) . "__Label\">" . _hx_string_or_null($this->label) . _hx_string_or_null((sugoi_form_FormElement_1($this, $n))) . "</label>";
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getClasses() {
		$GLOBALS['%s']->push("sugoi.form.FormElement::getClasses");
		$__hx__spos = $GLOBALS['%s']->length;
		$css = null;
		if($this->cssClass !== null) {
			$css = $this->cssClass;
		} else {
			$css = $this->parentForm->defaultClass;
		}
		if($this->required && $this->parentForm->isSubmitted()) {
			if(_hx_equal($this->value, "")) {
				$css .= " " . _hx_string_or_null($this->parentForm->requiredErrorClass);
			}
			if(!$this->isValid()) {
				$css .= " " . _hx_string_or_null($this->parentForm->invalidErrorClass);
			}
		}
		if($css === null) {
			$css = "";
		}
		{
			$tmp = trim($css);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getErrorClasses() {
		$GLOBALS['%s']->push("sugoi.form.FormElement::getErrorClasses");
		$__hx__spos = $GLOBALS['%s']->length;
		$css = "";
		if($this->required && $this->parentForm->isSubmitted()) {
			if(_hx_equal($this->value, "")) {
				$css .= " " . _hx_string_or_null($this->parentForm->requiredErrorClass);
			}
			if(!$this->isValid()) {
				$css .= " " . _hx_string_or_null($this->parentForm->invalidErrorClass);
			}
		}
		{
			$tmp = trim($css);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function safeString($s) {
		$GLOBALS['%s']->push("sugoi.form.FormElement::safeString");
		$__hx__spos = $GLOBALS['%s']->length;
		if($s === null) {
			$GLOBALS['%s']->pop();
			return "";
		} else {
			$tmp = _hx_explode("\"", StringTools::htmlEscape(Std::string($s), null))->join("&quot;");
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
	function __toString() { return 'sugoi.form.FormElement'; }
}
function sugoi_form_FormElement_0(&$__hx__this) {
	if($__hx__this->label !== null && $__hx__this->label !== "") {
		return $__hx__this->label;
	} else {
		return $__hx__this->name;
	}
}
function sugoi_form_FormElement_1(&$__hx__this, &$n) {
	if($__hx__this->required) {
		return $__hx__this->parentForm->labelRequiredIndicator;
	} else {
		return "";
	}
}
