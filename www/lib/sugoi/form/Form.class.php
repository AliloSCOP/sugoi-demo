<?php

class sugoi_form_Form {
	public function __construct($name, $action = null, $method = null) {
		if(!php_Boot::$skip_constructor) {
		$this->requiredClass = "formRequired";
		$this->requiredErrorClass = "formRequiredError";
		$this->invalidErrorClass = "formInvalidError";
		$this->labelRequiredIndicator = " *";
		$this->forcePopulate = true;
		$this->multipart = false;
		$this->id = $this->name = $name;
		if($action === null) {
			$this->action = php_Web::getURI();
		} else {
			$this->action = $action;
		}
		if($method === null) {
			$this->method = sugoi_form_FormMethod::$POST;
		} else {
			$this->method = $method;
		}
		$this->elements = new _hx_array(array());
		$this->extraErrors = new HList();
		$this->fieldsets = new haxe_ds_StringMap();
		$this->addFieldset("__default", new sugoi_form_FieldSet("__default", "Default", false));
		$this->addElement(new sugoi_form_elements_CSRFProtection(), null, null);
	}}
	public $id;
	public $name;
	public $action;
	public $method;
	public $elements;
	public $fieldsets;
	public $forcePopulate;
	public $submitButton;
	public $extraErrors;
	public $requiredClass;
	public $requiredErrorClass;
	public $invalidErrorClass;
	public $labelRequiredIndicator;
	public $defaultClass;
	public $multipart;
	public $submitButtonLabel;
	public function addElement($element, $index = null, $fieldSetKey = null) {
		if($fieldSetKey === null) {
			$fieldSetKey = "__default";
		}
		$element->parentForm = $this;
		if($index !== null) {
			$out = $this->elements->slice(0, $index);
			$out = $out->concat((new _hx_array(array($element))));
			$out = $out->concat($this->elements->slice($index, null));
			$this->elements = $out;
		} else {
			$this->elements->push($element);
		}
		if($fieldSetKey !== null) {
			if(!$this->fieldsets->exists($fieldSetKey)) {
				throw new HException("No fieldset '" . _hx_string_or_null($fieldSetKey) . "' exists in '" . _hx_string_or_null($this->name) . "' form.");
			}
			$this->fieldsets->get($fieldSetKey)->elements->push($element);
		}
		return $element;
	}
	public function removeElement($element) {
		if($this->elements->remove($element)) {
			$element->parentForm = null;
			if(null == $this->fieldsets) throw new HException('null iterable');
			$__hx__it = $this->fieldsets->iterator();
			while($__hx__it->hasNext()) {
				unset($fs);
				$fs = $__hx__it->next();
				$fs->elements->remove($element);
			}
			return true;
		}
		return false;
	}
	public function setSubmitButton($el) {
		$this->submitButton = $el;
		$this->submitButton->parentForm = $this;
		return $el;
	}
	public function addFieldset($fieldSetKey, $fieldSet) {
		$fieldSet->form = $this;
		$this->fieldsets->set($fieldSetKey, $fieldSet);
	}
	public function getFieldsets() {
		return $this->fieldsets;
	}
	public function getLabel($elementName) {
		return $this->getElement($elementName)->getLabel();
	}
	public function getElement($name) {
		if($name === null || $name === "") {
			throw new HException("Element name is null");
		}
		{
			$_g = 0;
			$_g1 = $this->elements;
			while($_g < $_g1->length) {
				$element = $_g1[$_g];
				++$_g;
				if($element->name === $name) {
					return $element;
				}
				unset($element);
			}
		}
		throw new HException("Cannot access form element: '" . _hx_string_or_null($name) . "'");
		return null;
	}
	public function removeElementByName($name) {
		$e = $this->getElement($name);
		if($e !== null) {
			$this->removeElement($e);
		}
	}
	public function getValueOf($elementName) {
		$s = $this->getElement($elementName)->value;
		return trim($s);
	}
	public function getElementTyped($name, $type) {
		$o = $this->getElement($name);
		return $o;
	}
	public function getData() {
		$data = new haxe_ds_StringMap();
		{
			$_g = 0;
			$_g1 = $this->getElements();
			while($_g < $_g1->length) {
				$element = $_g1[$_g];
				++$_g;
				if(Std::is($element->value, _hx_qtype("String"))) {
					$val = null;
					{
						$s = $element->value;
						$val = trim($s);
						unset($s);
					}
					if($val === "") {
						$val = null;
					}
					$data->set($element->name, $val);
					unset($val);
				} else {
					$value = $element->value;
					$data->set($element->name, $value);
					unset($value);
				}
				unset($element);
			}
		}
		return $data;
	}
	public function populate($custom = null) {
		if($custom !== null) {
			$_g = 0;
			$_g1 = $this->getElements();
			while($_g < $_g1->length) {
				$element = $_g1[$_g];
				++$_g;
				$n = $element->name;
				$v = Reflect::field($custom, $n);
				if($v !== null) {
					$element->value = $v;
				}
				unset($v,$n,$element);
			}
		} else {
			$element1 = null;
			{
				$_g2 = 0;
				$_g11 = $this->getElements();
				while($_g2 < $_g11->length) {
					$element2 = $_g11[$_g2];
					++$_g2;
					$element2->populate();
					unset($element2);
				}
			}
		}
	}
	public function toSpod($obj) {
		if(!$this->isValid()) {
			throw new HException("submitted form should be valid");
		}
		$data = $this->getData();
		$id = Std::parseInt($data->get("id"));
		if($id === 0) {
			$id = null;
		}
		if($id !== null) {
			$obj->lock();
		}
		if(null == $data) throw new HException('null iterable');
		$__hx__it = $data->keys();
		while($__hx__it->hasNext()) {
			unset($f);
			$f = $__hx__it->next();
			if($this->getElement($f) === null) {
				throw new HException("field '" . _hx_string_or_null($f) . "' was not in the original form");
			}
			$v = $data->get($f);
			if($v !== null && $f !== "id") {
				if(Std::is($v, _hx_qtype("String"))) {
					{
						$s = $v;
						$v = trim($s);
						unset($s);
					}
					if(_hx_equal($v, "")) {
						$v = null;
					}
				}
				$obj->{$f} = $v;
			}
			unset($v);
		}
	}
	public function clearData() {
		$element = null;
		{
			$_g = 0;
			$_g1 = $this->getElements();
			while($_g < $_g1->length) {
				$element1 = $_g1[$_g];
				++$_g;
				$element1->value = null;
				unset($element1);
			}
		}
	}
	public function getOpenTag() {
		return "<form id=\"" . _hx_string_or_null($this->id) . "\" class=\"" . _hx_string_or_null((((sugoi_form_Form::$USE_TWITTER_BOOTSTRAP) ? "form-horizontal" : ""))) . "\" name=\"" . _hx_string_or_null($this->name) . "\" method=\"" . Std::string($this->method) . "\" action=\"" . _hx_string_or_null($this->action) . "\" " . _hx_string_or_null(((($this->multipart) ? "enctype=\"multipart/form-data\"" : ""))) . " >";
	}
	public function getCloseTag() {
		$s = new StringBuf();
		$s->add("<div style=\"clear:both; height:0px;\">&nbsp;</div>");
		$s->add("<input type=\"hidden\" name=\"" . _hx_string_or_null($this->name) . "_formSubmitted\" value=\"true\" /></form>");
		return $s->b;
	}
	public function isValid() {
		if(!$this->isSubmitted()) {
			return false;
		}
		$this->populate(null);
		$valid = true;
		{
			$_g = 0;
			$_g1 = $this->getElements();
			while($_g < $_g1->length) {
				$element = $_g1[$_g];
				++$_g;
				$element->filter();
				if(!$element->isValid()) {
					$valid = false;
				}
				unset($element);
			}
		}
		if($this->extraErrors->length > 0) {
			$valid = false;
		}
		return $valid;
	}
	public function checkToken() {
		return $this->isValid();
	}
	public function addError($error) {
		$this->extraErrors->add($error);
	}
	public function getErrorsList() {
		$this->isValid();
		$errors = new HList();
		if(null == $this->extraErrors) throw new HException('null iterable');
		$__hx__it = $this->extraErrors->iterator();
		while($__hx__it->hasNext()) {
			unset($e);
			$e = $__hx__it->next();
			$errors->add($e);
		}
		{
			$_g = 0;
			$_g1 = $this->getElements();
			while($_g < $_g1->length) {
				$element = $_g1[$_g];
				++$_g;
				if(null == $element->getErrors()) throw new HException('null iterable');
				$__hx__it = $element->getErrors()->iterator();
				while($__hx__it->hasNext()) {
					unset($error);
					$error = $__hx__it->next();
					$errors->add($error);
				}
				unset($element);
			}
		}
		return $errors;
	}
	public function getElements() {
		return $this->elements;
	}
	public function isSubmitted() {
		return App::$current->params->get(_hx_string_or_null($this->name) . "_formSubmitted") === "true";
	}
	public function getSubmittedValue() {
		return App::$current->params->get(_hx_string_or_null($this->name) . "_formSubmitted");
	}
	public function getErrors() {
		if(!$this->isSubmitted()) {
			return "";
		}
		$s = new StringBuf();
		$errors = $this->getErrorsList();
		if($errors->length > 0) {
			if(sugoi_form_Form::$USE_TWITTER_BOOTSTRAP) {
				$s->add("<div class=\"alert alert-danger\">");
			}
			$s->add("<ul class=\"formErrors\" >");
			if(null == $errors) throw new HException('null iterable');
			$__hx__it = $errors->iterator();
			while($__hx__it->hasNext()) {
				unset($error);
				$error = $__hx__it->next();
				$s->add("<li>" . _hx_string_or_null($error) . "</li>");
			}
			$s->add("</ul>");
			if(sugoi_form_Form::$USE_TWITTER_BOOTSTRAP) {
				$s->add("</div>");
			}
		}
		return $s->b;
	}
	public function toString() {
		$s = new StringBuf();
		$s->add($this->getOpenTag());
		if($this->isSubmitted()) {
			$s->add($this->getErrors());
		}
		{
			$_g = 0;
			$_g1 = $this->getElements();
			while($_g < $_g1->length) {
				$element = $_g1[$_g];
				++$_g;
				if($element !== $this->submitButton && $element->internal === false) {
					$s->add("\x09" . _hx_string_or_null($element->getFullRow()) . "\x0A");
				}
				unset($element);
			}
		}
		if($this->submitButton !== null) {
			$this->submitButton->parentForm = $this;
		} else {
			$this->submitButton = new sugoi_form_elements_Submit("submit", sugoi_form_Form_0($this, $s));
			$this->submitButton->parentForm = $this;
		}
		$s->add($this->submitButton->getFullRow());
		$s->add($this->getCloseTag());
		return $s->b;
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
	static $translator;
	static $USE_TWITTER_BOOTSTRAP = true;
	static $USE_DATEPICKER = true;
	static function fromObject($obj) {
		$form = new sugoi_form_Form("fromObj", null, null);
		{
			$_g = 0;
			$_g1 = Reflect::fields($obj);
			while($_g < $_g1->length) {
				$f = $_g1[$_g];
				++$_g;
				$val = null;
				{
					$s = Reflect::field($obj, $f);
					$val = trim($s);
					unset($s);
				}
				if($val === "") {
					$val = null;
				}
				$form->addElement(new sugoi_form_elements_Input($f, $f, $val, null, null, null, null), null, null);
				unset($val,$f);
			}
		}
		$form->populate($obj);
		return $form;
	}
	static function fromSpod($obj) {
		$name = Type::getClassName(Type::getClass($obj));
		$form = new sugoi_form_Form("form" . _hx_string_or_null(haxe_crypto_Md5::encode($name)), null, null);
		$ti = new sys_db_TableInfos(Type::getClassName(Type::getClass($obj)));
		$t = sugoi_form_Form::$translator;
		if($t === null) {
			$t = sugoi_form_Form::$translator = new sugoi_i18n_translator_TMap(new haxe_ds_StringMap(), App::$current->session->lang);
		}
		if(null == $ti->fields) throw new HException('null iterable');
		$__hx__it = $ti->fields->iterator();
		while($__hx__it->hasNext()) {
			unset($f);
			$f = $__hx__it->next();
			$e = null;
			$v = Reflect::field($obj, $f->name);
			$rl = Lambda::filter($ti->relations, array(new _hx_lambda(array(&$e, &$f, &$form, &$name, &$obj, &$t, &$ti, &$v), "sugoi_form_Form_1"), 'execute'));
			$isNull = $ti->nulls->get($f->name);
			if($rl->length > 0) {
				$r1 = $rl->first();
				$objects = new HList();
				$meta = haxe_rtti_Meta::getFields(Type::getClass($obj));
				$objMeta = Reflect::field($meta, $r1->prop);
				if($objMeta !== null && _hx_field($objMeta, "formPopulate") !== null) {
					$objects = Reflect::callMethod($obj, Reflect::field($obj, Std::string($objMeta->formPopulate[0])), (new _hx_array(array())));
				} else {
					$objects = $r1->manager->all(false)->map(array(new _hx_lambda(array(&$e, &$f, &$form, &$isNull, &$meta, &$name, &$obj, &$objMeta, &$objects, &$r1, &$rl, &$t, &$ti, &$v), "sugoi_form_Form_2"), 'execute'));
				}
				$e = new sugoi_form_elements_Selectbox($f->name, $t->_($r1->prop, null), Lambda::harray($objects), $v, !$isNull, null, null);
				unset($r1,$objects,$objMeta,$meta);
			} else {
				{
					$_g = $f->type;
					switch($_g->index) {
					case 1:{
						$e = new sugoi_form_elements_Input($f->name, $t->_($f->name, null), $v, !$isNull, null, null, null);
					}break;
					case 0:case 2:{
						$e = new sugoi_form_elements_Hidden($t->_($f->name, null), $v, null, null, null);
					}break;
					case 20:{
						$e = new sugoi_form_elements_Input($f->name, $t->_($f->name, null), $v, null, null, null, null);
					}break;
					case 23:{
						$auto = _hx_deref($_g)->params[1];
						$fl = _hx_deref($_g)->params[0];
						$e = new sugoi_form_elements_Flags($f->name, $t->_($f->name, null), Lambda::harray($fl), Std::parseInt($v), false, null);
					}break;
					case 24:case 3:case 6:case 7:{
						$e = new sugoi_form_elements_Input($f->name, $t->_($f->name, null), $v, null, null, null, null);
					}break;
					case 8:{
						$e = new sugoi_form_elements_Checkbox($f->name, $t->_($f->name, null), Std::string($v) === "true", null, null);
					}break;
					case 9:{
						$n = _hx_deref($_g)->params[0];
						$e = new sugoi_form_elements_Input($f->name, $t->_($f->name, null), $v, !$isNull, null, "lenght=" . _hx_string_rec($n, ""), null);
					}break;
					case 13:case 14:case 15:case 21:{
						$e = new sugoi_form_elements_TextArea($f->name, $t->_($f->name, null), $v, !$isNull, null, null);
					}break;
					case 12:case 11:{
						$d1 = Date::now();
						try {
							$d1 = Date::fromString(Std::string($v));
						}catch(Exception $__hx__e) {
							$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
							$e1 = $_ex_;
							{}
						}
						if(sugoi_form_Form::$USE_DATEPICKER) {
							$e = new sugoi_form_elements_DatePicker($f->name, $t->_($f->name, null), $d1, null, null, null, null, null);
							$e->format = "LLLL";
						} else {
							$e = new sugoi_form_elements_DateInput($f->name, $t->_($f->name, null), $d1, null, null, null, null, null);
						}
					}break;
					case 10:{
						$d2 = Date::now();
						try {
							$d2 = Date::fromString(Std::string($v));
						}catch(Exception $__hx__e) {
							$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
							$e2 = $_ex_;
							{}
						}
						if(sugoi_form_Form::$USE_DATEPICKER) {
							$e = new sugoi_form_elements_DatePicker($f->name, $t->_($f->name, null), $d2, null, null, null, null, null);
							$e->format = "LL";
						} else {
							$e = new sugoi_form_elements_DateDropdowns($f->name, $t->_($f->name, null), $d2, null, null, null, null, null);
						}
					}break;
					case 31:{
						$name1 = _hx_deref($_g)->params[0];
						$e = new sugoi_form_elements_Enum($f->name, $t->_($f->name, null), $name1, Std::parseInt($v), null, null);
					}break;
					default:{
						$e = new sugoi_form_elements_Input($f->name, $t->_($f->name, null), "unknown field type : " . Std::string($f->type) . ", value : " . _hx_string_or_null($v), null, null, null, null);
					}break;
					}
					unset($_g);
				}
			}
			$form->addElement($e, null, null);
			unset($v,$rl,$isNull,$e);
		}
		return $form;
	}
	function __toString() { return $this->toString(); }
}
function sugoi_form_Form_0(&$__hx__this, &$s) {
	if($__hx__this->submitButtonLabel !== null) {
		return $__hx__this->submitButtonLabel;
	} else {
		return "OK";
	}
}
function sugoi_form_Form_1(&$e, &$f, &$form, &$name, &$obj, &$t, &$ti, &$v, $r) {
	{
		return $r->key === $f->name;
	}
}
function sugoi_form_Form_2(&$e, &$f, &$form, &$isNull, &$meta, &$name, &$obj, &$objMeta, &$objects, &$r1, &$rl, &$t, &$ti, &$v, $d) {
	{
		return _hx_anonymous(array("key" => Std::string(Reflect::field($d, $r1->manager->table_keys[0])), "value" => $d->toString()));
	}
}
