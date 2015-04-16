<?php

class haxe_web_Dispatch {
	public function __construct($url, $params) {
		if(!isset($this->onMeta)) $this->onMeta = array(new _hx_lambda(array(&$this, &$params, &$url), "haxe_web_Dispatch_0"), 'execute');
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("haxe.web.Dispatch::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->parts = _hx_explode("/", $url);
		if($this->parts[0] === "") {
			$this->parts->shift();
		}
		$this->params = $params;
		$GLOBALS['%s']->pop();
	}}
	public $parts;
	public $params;
	public $name;
	public $cfg;
	public $subDispatch;
	public function onMeta($v, $args) { return call_user_func_array($this->onMeta, array($v, $args)); }
	public $onMeta = null;
	public function resolveName($name) {
		$GLOBALS['%s']->push("haxe.web.Dispatch::resolveName");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return $name;
		}
		$GLOBALS['%s']->pop();
	}
	public function runtimeDispatch($cfg) {
		$GLOBALS['%s']->push("haxe.web.Dispatch::runtimeDispatch");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->name = $this->parts->shift();
		if($this->name === null) {
			$this->name = "default";
		}
		$this->name = $this->resolveName($this->name);
		$this->cfg = $cfg;
		$r = Reflect::field($cfg->rules, $this->name);
		if($r === null) {
			$r = Reflect::field($cfg->rules, "default");
			if($r === null) {
				throw new HException(haxe_web_DispatchError::DENotFound($this->name));
			}
			$this->parts->unshift($this->name);
			$this->name = "default";
		}
		$this->name = "do" . _hx_string_or_null(strtoupper(_hx_char_at($this->name, 0))) . _hx_string_or_null(_hx_substr($this->name, 1, null));
		$args = (new _hx_array(array()));
		$this->subDispatch = false;
		$this->loop($args, $r);
		if($this->parts->length > 0 && !$this->subDispatch) {
			if($this->parts->length === 1 && $this->parts[$this->parts->length - 1] === "") {
				$this->parts->pop();
			} else {
				throw new HException(haxe_web_DispatchError::$DETooManyValues);
			}
		}
		try {
			Reflect::callMethod($cfg->obj, Reflect::field($cfg->obj, $this->name), $args);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			if(($e = $_ex_) instanceof haxe_web_Redirect){
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				$this->runtimeDispatch($cfg);
			} else throw $__hx__e;;
		}
		$GLOBALS['%s']->pop();
	}
	public function match($v, $r, $opt) {
		$GLOBALS['%s']->push("haxe.web.Dispatch::match");
		$__hx__spos = $GLOBALS['%s']->length;
		switch($r->index) {
		case 0:{
			if($v === null) {
				throw new HException(haxe_web_DispatchError::$DEMissing);
			}
			if($opt && $v === "") {
				$GLOBALS['%s']->pop();
				return null;
			}
			$v1 = Std::parseInt($v);
			if($v1 === null) {
				throw new HException(haxe_web_DispatchError::$DEInvalidValue);
			}
			{
				$GLOBALS['%s']->pop();
				return $v1;
			}
		}break;
		case 2:{
			if($v === null) {
				throw new HException(haxe_web_DispatchError::$DEMissing);
			}
			if($opt && $v === "") {
				$GLOBALS['%s']->pop();
				return null;
			}
			$v2 = Std::parseFloat($v);
			if(Math::isNaN($v2)) {
				throw new HException(haxe_web_DispatchError::$DEInvalidValue);
			}
			{
				$GLOBALS['%s']->pop();
				return $v2;
			}
		}break;
		case 3:{
			if($v === null) {
				throw new HException(haxe_web_DispatchError::$DEMissing);
			}
			{
				$GLOBALS['%s']->pop();
				return $v;
			}
		}break;
		case 1:{
			$tmp = $v !== null && $v !== "0" && $v !== "false" && $v !== "null";
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		case 4:{
			if($v === null) {
				throw new HException(haxe_web_DispatchError::$DEMissing);
			}
			try {
				{
					$tmp = Date::fromString($v);
					$GLOBALS['%s']->pop();
					return $tmp;
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
					throw new HException(haxe_web_DispatchError::$DEInvalidValue);
				}
			}
		}break;
		case 5:{
			$e1 = _hx_deref($r)->params[0];
			{
				if($v === null) {
					throw new HException(haxe_web_DispatchError::$DEMissing);
				}
				if($opt && $v === "") {
					$GLOBALS['%s']->pop();
					return null;
				}
				if($v === "") {
					throw new HException(haxe_web_DispatchError::$DEMissing);
				}
				$en = Type::resolveEnum($e1);
				if($en === null) {
					throw new HException("assert");
				}
				$ev = null;
				if(_hx_char_code_at($v, 0) >= 48 && _hx_char_code_at($v, 0) <= 57) {
					$ev = Type::createEnumIndex($en, Std::parseInt($v), null);
				} else {
					$ev = Type::createEnum($en, $v, null);
				}
				{
					$GLOBALS['%s']->pop();
					return $ev;
				}
			}
		}break;
		case 6:{
			if($v !== null) {
				$this->parts->unshift($v);
			}
			$this->subDispatch = true;
			{
				$GLOBALS['%s']->pop();
				return $this;
			}
		}break;
		case 7:{
			$lock = _hx_deref($r)->params[1];
			$c = _hx_deref($r)->params[0];
			{
				if($v === null) {
					throw new HException(haxe_web_DispatchError::$DEMissing);
				}
				$v3 = Std::parseInt($v);
				if($v3 === null) {
					throw new HException(haxe_web_DispatchError::$DEInvalidValue);
				}
				$cl = Type::resolveClass($c);
				if($cl === null) {
					throw new HException("assert");
				}
				$o = null;
				$o = $cl->manager->unsafeGet($v3, $lock);
				if($o === null) {
					throw new HException(haxe_web_DispatchError::$DEInvalidValue);
				}
				{
					$GLOBALS['%s']->pop();
					return $o;
				}
			}
		}break;
		case 8:{
			$r1 = _hx_deref($r)->params[0];
			{
				if($v === null) {
					$GLOBALS['%s']->pop();
					return null;
				}
				{
					$tmp = $this->match($v, $r1, true);
					$GLOBALS['%s']->pop();
					return $tmp;
				}
			}
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	public function checkParams($params, $opt) {
		$GLOBALS['%s']->push("haxe.web.Dispatch::checkParams");
		$__hx__spos = $GLOBALS['%s']->length;
		$po = _hx_anonymous(array());
		{
			$_g = 0;
			while($_g < $params->length) {
				$p = $params[$_g];
				++$_g;
				$v = $this->params->get($p->name);
				if($v === null) {
					if($p->opt) {
						continue;
					}
					if($opt) {
						$GLOBALS['%s']->pop();
						return null;
					}
					throw new HException(haxe_web_DispatchError::DEMissingParam($p->name));
				}
				{
					$value = $this->match($v, $p->rule, $p->opt);
					$po->{$p->name} = $value;
					unset($value);
				}
				unset($v,$p);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return $po;
		}
		$GLOBALS['%s']->pop();
	}
	public function loop($args, $r) {
		$GLOBALS['%s']->push("haxe.web.Dispatch::loop");
		$__hx__spos = $GLOBALS['%s']->length;
		switch($r->index) {
		case 2:{
			$opt = _hx_deref($r)->params[2];
			$params = _hx_deref($r)->params[1];
			$r1 = _hx_deref($r)->params[0];
			{
				$this->loop($args, $r1);
				$args->push($this->checkParams($params, $opt));
			}
		}break;
		case 0:{
			$r2 = _hx_deref($r)->params[0];
			$args->push($this->match($this->parts->shift(), $r2, false));
		}break;
		case 1:{
			$rl = _hx_deref($r)->params[0];
			{
				$_g = 0;
				while($_g < $rl->length) {
					$r3 = $rl[$_g];
					++$_g;
					$args->push($this->match($this->parts->shift(), $r3, false));
					unset($r3);
				}
			}
		}break;
		case 3:{
			$r4 = _hx_deref($r)->params[0];
			{
				$this->loop($args, $r4);
				$c = Type::getClass($this->cfg->obj);
				$m = null;
				do {
					if($c === null) {
						throw new HException("assert");
					}
					$m = Reflect::field(haxe_rtti_Meta::getFields($c), $this->name);
					$c = Type::getSuperClass($c);
				} while($m === null);
				{
					$_g1 = 0;
					$_g11 = Reflect::fields($m);
					while($_g1 < $_g11->length) {
						$mv = $_g11[$_g1];
						++$_g1;
						$this->onMeta($mv, Reflect::field($m, $mv));
						unset($mv);
					}
				}
			}
		}break;
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
	static function extractConfig($obj) {
		$GLOBALS['%s']->push("haxe.web.Dispatch::extractConfig");
		$__hx__spos = $GLOBALS['%s']->length;
		$c = Type::getClass($obj);
		$dc = haxe_rtti_Meta::getType($c);
		$m = $dc->dispatchConfig[0];
		if(Std::is($m, _hx_qtype("String"))) {
			$m = haxe_Unserializer::run($m);
			$dc->dispatchConfig[0] = $m;
		}
		{
			$tmp = _hx_anonymous(array("obj" => $obj, "rules" => $m));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'haxe.web.Dispatch'; }
}
function haxe_web_Dispatch_0(&$__hx__this, &$params, &$url, $v, $args) {
	{
		$GLOBALS['%s']->push("haxe.web.Dispatch::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$GLOBALS['%s']->pop();
	}
}
