<?php

class Type {
	public function __construct(){}
	static function getClass($o) {
		$GLOBALS['%s']->push("Type::getClass");
		$__hx__spos = $GLOBALS['%s']->length;
		if($o === null) {
			$GLOBALS['%s']->pop();
			return null;
		}
		if(is_array($o)) {
			if(count($o) === 2 && is_callable($o)) {
				$GLOBALS['%s']->pop();
				return null;
			}
			{
				$tmp = _hx_ttype("Array");
				$GLOBALS['%s']->pop();
				return $tmp;
			}
		}
		if(is_string($o)) {
			if(_hx_is_lambda($o)) {
				$GLOBALS['%s']->pop();
				return null;
			}
			{
				$tmp = _hx_ttype("String");
				$GLOBALS['%s']->pop();
				return $tmp;
			}
		}
		if(!is_object($o)) {
			$GLOBALS['%s']->pop();
			return null;
		}
		$c = get_class($o);
		if($c === false || $c === "_hx_anonymous" || is_subclass_of($c, "enum")) {
			$GLOBALS['%s']->pop();
			return null;
		} else {
			$tmp = _hx_ttype($c);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function getEnum($o) {
		$GLOBALS['%s']->push("Type::getEnum");
		$__hx__spos = $GLOBALS['%s']->length;
		if(!$o instanceof Enum) {
			$GLOBALS['%s']->pop();
			return null;
		} else {
			$tmp = _hx_ttype(get_class($o));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function getSuperClass($c) {
		$GLOBALS['%s']->push("Type::getSuperClass");
		$__hx__spos = $GLOBALS['%s']->length;
		$s = get_parent_class($c->__tname__);
		if($s === false) {
			$GLOBALS['%s']->pop();
			return null;
		} else {
			$tmp = _hx_ttype($s);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function getClassName($c) {
		$GLOBALS['%s']->push("Type::getClassName");
		$__hx__spos = $GLOBALS['%s']->length;
		if($c === null) {
			$GLOBALS['%s']->pop();
			return null;
		}
		{
			$tmp = $c->__qname__;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function getEnumName($e) {
		$GLOBALS['%s']->push("Type::getEnumName");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $e->__qname__;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function resolveClass($name) {
		$GLOBALS['%s']->push("Type::resolveClass");
		$__hx__spos = $GLOBALS['%s']->length;
		$c = _hx_qtype($name);
		if($c instanceof _hx_class || $c instanceof _hx_interface) {
			$GLOBALS['%s']->pop();
			return $c;
		} else {
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	static function resolveEnum($name) {
		$GLOBALS['%s']->push("Type::resolveEnum");
		$__hx__spos = $GLOBALS['%s']->length;
		$e = _hx_qtype($name);
		if($e instanceof _hx_enum) {
			$GLOBALS['%s']->pop();
			return $e;
		} else {
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	static function createEmptyInstance($cl) {
		$GLOBALS['%s']->push("Type::createEmptyInstance");
		$__hx__spos = $GLOBALS['%s']->length;
		if($cl->__qname__ === "Array") {
			$tmp = (new _hx_array(array()));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		if($cl->__qname__ === "String") {
			$GLOBALS['%s']->pop();
			return "";
		}
		try {
			php_Boot::$skip_constructor = true;
			$rfl = $cl->__rfl__();
			if($rfl === null) {
				$GLOBALS['%s']->pop();
				return null;
			}
			$m = $rfl->getConstructor();
			$nargs = $m->getNumberOfRequiredParameters();
			$i = null;
			if($nargs > 0) {
				$args = array_fill(0, $m->getNumberOfRequiredParameters(), null);
				$i = $rfl->newInstanceArgs($args);
			} else {
				$i = $rfl->newInstanceArgs(array());
			}
			php_Boot::$skip_constructor = false;
			{
				$GLOBALS['%s']->pop();
				return $i;
			}
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				php_Boot::$skip_constructor = false;
				throw new HException("Unable to instantiate " . Std::string($cl));
			}
		}
		{
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	static function createEnum($e, $constr, $params = null) {
		$GLOBALS['%s']->push("Type::createEnum");
		$__hx__spos = $GLOBALS['%s']->length;
		$f = Reflect::field($e, $constr);
		if($f === null) {
			throw new HException("No such constructor " . _hx_string_or_null($constr));
		}
		if(Reflect::isFunction($f)) {
			if($params === null) {
				throw new HException("Constructor " . _hx_string_or_null($constr) . " need parameters");
			}
			{
				$tmp = Reflect::callMethod($e, $f, $params);
				$GLOBALS['%s']->pop();
				return $tmp;
			}
		}
		if($params !== null && $params->length !== 0) {
			throw new HException("Constructor " . _hx_string_or_null($constr) . " does not need parameters");
		}
		{
			$GLOBALS['%s']->pop();
			return $f;
		}
		$GLOBALS['%s']->pop();
	}
	static function createEnumIndex($e, $index, $params = null) {
		$GLOBALS['%s']->push("Type::createEnumIndex");
		$__hx__spos = $GLOBALS['%s']->length;
		$c = _hx_array_get(Type::getEnumConstructs($e), $index);
		if($c === null) {
			throw new HException(_hx_string_rec($index, "") . " is not a valid enum constructor index");
		}
		{
			$tmp = Type::createEnum($e, $c, $params);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function getEnumConstructs($e) {
		$GLOBALS['%s']->push("Type::getEnumConstructs");
		$__hx__spos = $GLOBALS['%s']->length;
		if($e->__tname__ == 'Bool') {
			$tmp = (new _hx_array(array("true", "false")));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		if($e->__tname__ == 'Void') {
			$tmp = (new _hx_array(array()));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		{
			$tmp = new _hx_array($e->__constructors);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function typeof($v) {
		$GLOBALS['%s']->push("Type::typeof");
		$__hx__spos = $GLOBALS['%s']->length;
		if($v === null) {
			$tmp = ValueType::$TNull;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		if(is_array($v)) {
			if(is_callable($v)) {
				$tmp = ValueType::$TFunction;
				$GLOBALS['%s']->pop();
				return $tmp;
			}
			{
				$tmp = ValueType::TClass(_hx_qtype("Array"));
				$GLOBALS['%s']->pop();
				return $tmp;
			}
		}
		if(is_string($v)) {
			if(_hx_is_lambda($v)) {
				$tmp = ValueType::$TFunction;
				$GLOBALS['%s']->pop();
				return $tmp;
			}
			{
				$tmp = ValueType::TClass(_hx_qtype("String"));
				$GLOBALS['%s']->pop();
				return $tmp;
			}
		}
		if(is_bool($v)) {
			$tmp = ValueType::$TBool;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		if(is_int($v)) {
			$tmp = ValueType::$TInt;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		if(is_float($v)) {
			$tmp = ValueType::$TFloat;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		if($v instanceof _hx_anonymous) {
			$tmp = ValueType::$TObject;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		if($v instanceof _hx_enum) {
			$tmp = ValueType::$TObject;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		if($v instanceof _hx_class) {
			$tmp = ValueType::$TObject;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$c = _hx_ttype(get_class($v));
		if($c instanceof _hx_enum) {
			$tmp = ValueType::TEnum($c);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		if($c instanceof _hx_class) {
			$tmp = ValueType::TClass($c);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		{
			$tmp = ValueType::$TUnknown;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function enumEq($a, $b) {
		$GLOBALS['%s']->push("Type::enumEq");
		$__hx__spos = $GLOBALS['%s']->length;
		if((is_object($_t = $a) && !($_t instanceof Enum) ? $_t === $b : $_t == $b)) {
			$GLOBALS['%s']->pop();
			return true;
		}
		try {
			if(!_hx_equal($a->index, $b->index)) {
				$GLOBALS['%s']->pop();
				return false;
			}
			{
				$_g1 = 0;
				$_g = count($a->params);
				while($_g1 < $_g) {
					$i = $_g1++;
					if(Type::getEnum($a->params[$i]) !== null) {
						if(!Type::enumEq($a->params[$i], $b->params[$i])) {
							$GLOBALS['%s']->pop();
							return false;
						}
					} else {
						if(!_hx_equal($a->params[$i], $b->params[$i])) {
							$GLOBALS['%s']->pop();
							return false;
						}
					}
					unset($i);
				}
			}
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				{
					$GLOBALS['%s']->pop();
					return false;
				}
			}
		}
		{
			$GLOBALS['%s']->pop();
			return true;
		}
		$GLOBALS['%s']->pop();
	}
	static function allEnums($e) {
		$GLOBALS['%s']->push("Type::allEnums");
		$__hx__spos = $GLOBALS['%s']->length;
		$all = (new _hx_array(array()));
		{
			$_g = 0;
			$_g1 = Type::getEnumConstructs($e);
			while($_g < $_g1->length) {
				$c = $_g1[$_g];
				++$_g;
				$v = Reflect::field($e, $c);
				if(!Reflect::isFunction($v)) {
					$all->push($v);
				}
				unset($v,$c);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $all;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Type'; }
}
