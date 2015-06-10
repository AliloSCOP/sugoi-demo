<?php

class sugoi_form_FormElement {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->active = true;
		$this->errors = new HList();
		$this->validators = new HList();
		$this->filters = new HList();
		$this->inited = false;
		$this->internal = false;
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
		if(null == $this->filters) throw new HException('null iterable');
		$__hx__it = $this->filters->iterator();
		while($__hx__it->hasNext()) {
			unset($f);
			$f = $__hx__it->next();
			$this->value = $f->filter($this->value);
		}
		return $this->value;
	}
	public function isValid() {
		$this->errors->clear();
		if(!$this->active) {
			return true;
		}
		if(_hx_equal($this->value, "") && $this->required || _hx_field($this, "value") === null && $this->required) {
			$this->errors->add("<span class=\"formErrorsField\">\"" . _hx_string_or_null((sugoi_form_FormElement_0($this))) . "\"</span> ne doit pas être vide.");
			return false;
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
						return false;
					}
				}
			}
			return true;
		}
		return true;
	}
	public function checkValid() {
		_hx_equal($this->value, "");
	}
	public function init() {
		$this->inited = true;
	}
	public function addValidator($validator) {
		$this->validators->add($validator);
	}
	public function addFilter($filter) {
		$this->filters->add($filter);
	}
	public function populate() {
		if(!$this->inited) {
			$this->init();
		}
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name);
		$v = App::$current->params->get($n);
		if($v !== null) {
			$this->value = $v;
		}
	}
	public function getErrors() {
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
		return $this->errors;
	}
	public function render() {
		if(!$this->inited) {
			$this->init();
		}
		return $this->value;
	}
	public function remove() {
		if($this->parentForm !== null) {
			return $this->parentForm->removeElement($this);
		}
		return false;
	}
	public function getFullRow() {
		$s = new StringBuf();
		if(sugoi_form_Form::$USE_TWITTER_BOOTSTRAP) {
			$s->add("<div class=\"form-group\">\x0A");
		}
		$s->add($this->getLabel());
		$s->add("<div class='col-sm-8'>" . _hx_string_or_null($this->render()) . "</div>");
		if(sugoi_form_Form::$USE_TWITTER_BOOTSTRAP) {
			$s->add("</div>\x0A");
		}
		return $s->b;
	}
	public function getType() {
		return Std::string(Type::getClass($this));
	}
	public function getLabelClasses() {
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
		return $css;
	}
	public function getLabel() {
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name);
		return "<label for=\"" . _hx_string_or_null($n) . "\" class=\"" . _hx_string_or_null($this->getLabelClasses()) . "\" id=\"" . _hx_string_or_null($n) . "__Label\">" . _hx_string_or_null($this->label) . _hx_string_or_null((sugoi_form_FormElement_1($this, $n))) . "</label>";
	}
	public function getClasses() {
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
		return trim($css);
	}
	public function getErrorClasses() {
		$css = "";
		if($this->required && $this->parentForm->isSubmitted()) {
			if(_hx_equal($this->value, "")) {
				$css .= " " . _hx_string_or_null($this->parentForm->requiredErrorClass);
			}
			if(!$this->isValid()) {
				$css .= " " . _hx_string_or_null($this->parentForm->invalidErrorClass);
			}
		}
		return trim($css);
	}
	public function safeString($s) {
		if($s === null) {
			return "";
		} else {
			return _hx_explode("\"", StringTools::htmlEscape(Std::string($s), null))->join("&quot;");
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
