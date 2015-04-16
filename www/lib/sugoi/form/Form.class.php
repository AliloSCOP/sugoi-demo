<?php

class sugoi_form_Form {
	public function __construct($name, $action = null, $method = null) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.form.Form::new");
		$__hx__spos = $GLOBALS['%s']->length;
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
		$this->wymEditorCount = 0;
		$this->submittedButtonName = null;
		$this->addElement(new sugoi_form_elements_CSRFProtection(), null, null);
		$GLOBALS['%s']->pop();
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
	public $submittedButtonName;
	public $wymEditorCount;
	public function addElement($element, $index = null, $fieldSetKey = null) {
		$GLOBALS['%s']->push("sugoi.form.Form::addElement");
		$__hx__spos = $GLOBALS['%s']->length;
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
		{
			$GLOBALS['%s']->pop();
			return $element;
		}
		$GLOBALS['%s']->pop();
	}
	public function removeElement($element) {
		$GLOBALS['%s']->push("sugoi.form.Form::removeElement");
		$__hx__spos = $GLOBALS['%s']->length;
		if($this->elements->remove($element)) {
			$element->parentForm = null;
			if(null == $this->fieldsets) throw new HException('null iterable');
			$__hx__it = $this->fieldsets->iterator();
			while($__hx__it->hasNext()) {
				unset($fs);
				$fs = $__hx__it->next();
				$fs->elements->remove($element);
			}
			{
				$GLOBALS['%s']->pop();
				return true;
			}
		}
		{
			$GLOBALS['%s']->pop();
			return false;
		}
		$GLOBALS['%s']->pop();
	}
	public function setSubmitButton($el) {
		$GLOBALS['%s']->push("sugoi.form.Form::setSubmitButton");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->submitButton = $el;
		$this->submitButton->parentForm = $this;
		{
			$GLOBALS['%s']->pop();
			return $el;
		}
		$GLOBALS['%s']->pop();
	}
	public function addFieldset($fieldSetKey, $fieldSet) {
		$GLOBALS['%s']->push("sugoi.form.Form::addFieldset");
		$__hx__spos = $GLOBALS['%s']->length;
		$fieldSet->form = $this;
		$this->fieldsets->set($fieldSetKey, $fieldSet);
		$GLOBALS['%s']->pop();
	}
	public function getFieldsets() {
		$GLOBALS['%s']->push("sugoi.form.Form::getFieldsets");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->fieldsets;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getLabel($elementName) {
		$GLOBALS['%s']->push("sugoi.form.Form::getLabel");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->getElement($elementName)->getLabel();
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getElement($name) {
		$GLOBALS['%s']->push("sugoi.form.Form::getElement");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$_g = 0;
			$_g1 = $this->elements;
			while($_g < $_g1->length) {
				$element = $_g1[$_g];
				++$_g;
				if($element->name === $name) {
					$GLOBALS['%s']->pop();
					return $element;
				}
				unset($element);
			}
		}
		throw new HException("Cannot access Form Element: '" . _hx_string_or_null($name) . "'");
		{
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	public function removeElementByName($name) {
		$GLOBALS['%s']->push("sugoi.form.Form::removeElementByName");
		$__hx__spos = $GLOBALS['%s']->length;
		$e = $this->getElement($name);
		if($e !== null) {
			$this->removeElement($e);
		}
		$GLOBALS['%s']->pop();
	}
	public function getValueOf($elementName) {
		$GLOBALS['%s']->push("sugoi.form.Form::getValueOf");
		$__hx__spos = $GLOBALS['%s']->length;
		$s = $this->getElement($elementName)->value;
		{
			$tmp = trim($s);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getElementTyped($name, $type) {
		$GLOBALS['%s']->push("sugoi.form.Form::getElementTyped");
		$__hx__spos = $GLOBALS['%s']->length;
		$o = $this->getElement($name);
		{
			$GLOBALS['%s']->pop();
			return $o;
		}
		$GLOBALS['%s']->pop();
	}
	public function getData() {
		$GLOBALS['%s']->push("sugoi.form.Form::getData");
		$__hx__spos = $GLOBALS['%s']->length;
		$data = _hx_anonymous(array());
		{
			$_g = 0;
			$_g1 = $this->getElements();
			while($_g < $_g1->length) {
				$element = $_g1[$_g];
				++$_g;
				$data->{$element->name} = $element->value;
				if(Std::is($element, _hx_qtype("sugoi.form.elements.DateSelector"))) {
					$ds = null;
					$ds = $element;
					unset($ds);
				}
				unset($element);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $data;
		}
		$GLOBALS['%s']->pop();
	}
	public function populateElements($custom = null) {
		$GLOBALS['%s']->push("sugoi.form.Form::populateElements");
		$__hx__spos = $GLOBALS['%s']->length;
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
		$GLOBALS['%s']->pop();
	}
	public function toSpod($obj) {
		$GLOBALS['%s']->push("sugoi.form.Form::toSpod");
		$__hx__spos = $GLOBALS['%s']->length;
		if(!$this->isValid()) {
			throw new HException("submitted form should be valid");
		}
		$data = $this->getData();
		$id = Std::parseInt(Reflect::field($data, "id"));
		if($id === 0) {
			$id = null;
		}
		if($id !== null) {
			$obj->lock();
		}
		{
			$_g = 0;
			$_g1 = Reflect::fields($data);
			while($_g < $_g1->length) {
				$f = $_g1[$_g];
				++$_g;
				if($this->getElement($f) === null) {
					throw new HException("field '" . _hx_string_or_null($f) . "' was not in the original form");
				}
				$v = Reflect::field($data, $f);
				if($v !== null && $f !== "id") {
					if(Std::is($v, _hx_qtype("String"))) {
						$v = trim($v);
						if($v === "") {
							$v = null;
						}
					}
					$obj->{$f} = $v;
				}
				unset($v,$f);
			}
		}
		$GLOBALS['%s']->pop();
	}
	public function clearData() {
		$GLOBALS['%s']->push("sugoi.form.Form::clearData");
		$__hx__spos = $GLOBALS['%s']->length;
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
		$GLOBALS['%s']->pop();
	}
	public function getOpenTag() {
		$GLOBALS['%s']->push("sugoi.form.Form::getOpenTag");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = "<form id=\"" . _hx_string_or_null($this->id) . "\" class=\"" . _hx_string_or_null((((sugoi_form_Form::$USE_TWITTER_BOOTSTRAP) ? "form-horizontal" : ""))) . "\" name=\"" . _hx_string_or_null($this->name) . "\" method=\"" . Std::string($this->method) . "\" action=\"" . _hx_string_or_null($this->action) . "\" " . _hx_string_or_null(((($this->multipart) ? "enctype=\"multipart/form-data\"" : ""))) . " >";
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getCloseTag() {
		$GLOBALS['%s']->push("sugoi.form.Form::getCloseTag");
		$__hx__spos = $GLOBALS['%s']->length;
		$s = new StringBuf();
		$s->add("<div style=\"clear:both; height:0px;\">&nbsp;</div>");
		$s->add("<input type=\"hidden\" name=\"" . _hx_string_or_null($this->name) . "_formSubmitted\" value=\"true\" /></form>");
		{
			$tmp = $s->b;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function isValid() {
		$GLOBALS['%s']->push("sugoi.form.Form::isValid");
		$__hx__spos = $GLOBALS['%s']->length;
		if(!$this->isSubmitted()) {
			$GLOBALS['%s']->pop();
			return false;
		}
		$this->populateElements(null);
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
		{
			$GLOBALS['%s']->pop();
			return $valid;
		}
		$GLOBALS['%s']->pop();
	}
	public function checkToken() {
		$GLOBALS['%s']->push("sugoi.form.Form::checkToken");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->isValid();
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function addError($error) {
		$GLOBALS['%s']->push("sugoi.form.Form::addError");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->extraErrors->add($error);
		$GLOBALS['%s']->pop();
	}
	public function getErrorsList() {
		$GLOBALS['%s']->push("sugoi.form.Form::getErrorsList");
		$__hx__spos = $GLOBALS['%s']->length;
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
		{
			$GLOBALS['%s']->pop();
			return $errors;
		}
		$GLOBALS['%s']->pop();
	}
	public function getElements() {
		$GLOBALS['%s']->push("sugoi.form.Form::getElements");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->elements;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function isSubmitted() {
		$GLOBALS['%s']->push("sugoi.form.Form::isSubmitted");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = App::$current->params->get(_hx_string_or_null($this->name) . "_formSubmitted") === "true";
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getSubmittedValue() {
		$GLOBALS['%s']->push("sugoi.form.Form::getSubmittedValue");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = App::$current->params->get(_hx_string_or_null($this->name) . "_formSubmitted");
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getErrors() {
		$GLOBALS['%s']->push("sugoi.form.Form::getErrors");
		$__hx__spos = $GLOBALS['%s']->length;
		if(!$this->isSubmitted()) {
			$GLOBALS['%s']->pop();
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
		{
			$tmp = $s->b;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function toString() {
		$GLOBALS['%s']->push("sugoi.form.Form::toString");
		$__hx__spos = $GLOBALS['%s']->length;
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
			$this->submitButton = new sugoi_form_elements_Submit("submit", "OK");
			$this->submitButton->parentForm = $this;
		}
		$s->add($this->submitButton->getFullRow());
		$s->add($this->getCloseTag());
		{
			$tmp = $s->b;
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
	static $translator;
	static $USE_TWITTER_BOOTSTRAP = true;
	static function fromObject($obj) {
		$GLOBALS['%s']->push("sugoi.form.Form::fromObject");
		$__hx__spos = $GLOBALS['%s']->length;
		$form = new sugoi_form_Form("fromObj", null, null);
		{
			$_g = 0;
			$_g1 = Reflect::fields($obj);
			while($_g < $_g1->length) {
				$f = $_g1[$_g];
				++$_g;
				$form->addElement(new sugoi_form_elements_Input($f, $f, Reflect::field($obj, $f), null, null, null, null), null, null);
				unset($f);
			}
		}
		$form->populateElements($obj);
		{
			$GLOBALS['%s']->pop();
			return $form;
		}
		$GLOBALS['%s']->pop();
	}
	static function fromSpod($obj) {
		$GLOBALS['%s']->push("sugoi.form.Form::fromSpod");
		$__hx__spos = $GLOBALS['%s']->length;
		$name = "";
		try {
			$name = $obj->toString();
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				$name = Type::getClassName(Type::getClass($obj));
			}
		}
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
			$e1 = null;
			$v = Reflect::field($obj, $f->name);
			$rl = Lambda::filter($ti->relations, array(new _hx_lambda(array(&$e, &$e1, &$f, &$form, &$name, &$obj, &$t, &$ti, &$v), "sugoi_form_Form_0"), 'execute'));
			$isNull = $ti->nulls->get($f->name);
			if($rl->length > 0) {
				$r1 = $rl->first();
				$objects = new HList();
				$meta = haxe_rtti_Meta::getFields(Type::getClass($obj));
				$objMeta = Reflect::field($meta, $r1->prop);
				if($objMeta !== null && _hx_field($objMeta, "formPopulate") !== null) {
					$objects = Reflect::callMethod($obj, Reflect::field($obj, Std::string($objMeta->formPopulate[0])), (new _hx_array(array())));
				} else {
					$objects = $r1->manager->all(false)->map(array(new _hx_lambda(array(&$e, &$e1, &$f, &$form, &$isNull, &$meta, &$name, &$obj, &$objMeta, &$objects, &$r1, &$rl, &$t, &$ti, &$v), "sugoi_form_Form_1"), 'execute'));
				}
				$e1 = new sugoi_form_elements_Selectbox($f->name, $t->_($r1->prop, null), Lambda::harray($objects), $v, !$isNull, null, null);
				unset($r1,$objects,$objMeta,$meta);
			} else {
				{
					$_g = $f->type;
					switch($_g->index) {
					case 1:{
						$e1 = new sugoi_form_elements_Input($f->name, $t->_($f->name, null), $v, !$isNull, null, null, null);
					}break;
					case 0:case 2:{
						$e1 = new sugoi_form_elements_Hidden($t->_($f->name, null), $v, null, null, null);
					}break;
					case 20:{
						$e1 = new sugoi_form_elements_Input($f->name, $t->_($f->name, null), $v, null, null, null, null);
					}break;
					case 23:{
						$auto = _hx_deref($_g)->params[1];
						$fl = _hx_deref($_g)->params[0];
						$e1 = new sugoi_form_elements_Flags($f->name, $t->_($f->name, null), Lambda::harray($fl), Std::parseInt($v), false, null);
					}break;
					case 24:case 3:case 6:case 7:{
						$e1 = new sugoi_form_elements_Input($f->name, $t->_($f->name, null), $v, null, null, null, null);
					}break;
					case 8:{
						$e1 = new sugoi_form_elements_Checkbox($f->name, $t->_($f->name, null), Std::string($v) === "true", null, null);
					}break;
					case 9:{
						$n = _hx_deref($_g)->params[0];
						$e1 = new sugoi_form_elements_Input($f->name, $t->_($f->name, null), $v, !$isNull, null, "lenght=" . _hx_string_rec($n, ""), null);
					}break;
					case 13:case 14:case 15:case 21:{
						$e1 = new sugoi_form_elements_TextArea($f->name, $t->_($f->name, null), $v, !$isNull, null, null);
					}break;
					case 12:case 11:{
						$d1 = Date::now();
						try {
							$d1 = Date::fromString(Std::string($v));
						}catch(Exception $__hx__e) {
							$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
							$e2 = $_ex_;
							{
								$GLOBALS['%e'] = (new _hx_array(array()));
								while($GLOBALS['%s']->length >= $__hx__spos) {
									$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
								}
								$GLOBALS['%s']->push($GLOBALS['%e'][0]);
							}
						}
						$e1 = new sugoi_form_elements_DateInput($f->name, $t->_($f->name, null), $d1, null, null, null, null, null);
					}break;
					case 10:{
						$d2 = Date::now();
						try {
							$d2 = Date::fromString(Std::string($v));
						}catch(Exception $__hx__e) {
							$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
							$e3 = $_ex_;
							{
								$GLOBALS['%e'] = (new _hx_array(array()));
								while($GLOBALS['%s']->length >= $__hx__spos) {
									$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
								}
								$GLOBALS['%s']->push($GLOBALS['%e'][0]);
							}
						}
						$e1 = new sugoi_form_elements_DateDropdowns($f->name, $t->_($f->name, null), $d2, null, null, null, null, null);
					}break;
					case 31:{
						$name1 = _hx_deref($_g)->params[0];
						$e1 = new sugoi_form_elements_Enum($f->name, $t->_($f->name, null), $name1, Std::parseInt($v), null, null);
					}break;
					default:{
						$e1 = new sugoi_form_elements_Input($f->name, $t->_($f->name, null), "unknown field type : " . Std::string($f->type) . ", value : " . _hx_string_or_null($v), null, null, null, null);
					}break;
					}
					unset($_g);
				}
			}
			$form->addElement($e1, null, null);
			unset($v,$rl,$isNull,$e1);
		}
		{
			$GLOBALS['%s']->pop();
			return $form;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return $this->toString(); }
}
function sugoi_form_Form_0(&$e, &$e1, &$f, &$form, &$name, &$obj, &$t, &$ti, &$v, $r) {
	{
		$GLOBALS['%s']->push("sugoi.form.Form::fromSpod@286");
		$__hx__spos2 = $GLOBALS['%s']->length;
		{
			$tmp = $r->key === $f->name;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function sugoi_form_Form_1(&$e, &$e1, &$f, &$form, &$isNull, &$meta, &$name, &$obj, &$objMeta, &$objects, &$r1, &$rl, &$t, &$ti, &$v, $d) {
	{
		$GLOBALS['%s']->push("sugoi.form.Form::fromSpod@302");
		$__hx__spos2 = $GLOBALS['%s']->length;
		{
			$tmp = _hx_anonymous(array("key" => Std::string(Reflect::field($d, $r1->manager->table_keys[0])), "value" => $d->toString()));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
