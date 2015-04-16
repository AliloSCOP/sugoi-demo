<?php

class sys_db_Serialized {
	public function __construct($v) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sys.db.Serialized::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->value = $v;
		$this->pos = 0;
		$this->tabs = 0;
		$GLOBALS['%s']->pop();
	}}
	public $value;
	public $pos;
	public $buf;
	public $shash;
	public $scount;
	public $scache;
	public $useEnumIndex;
	public $cur;
	public $tabs;
	public function encode() {
		$GLOBALS['%s']->push("sys.db.Serialized::encode");
		$__hx__spos = $GLOBALS['%s']->length;
		throw new HException("You can't edit this without -lib hscript");
		{
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	public function quote($s, $r = null) {
		$GLOBALS['%s']->push("sys.db.Serialized::quote");
		$__hx__spos = $GLOBALS['%s']->length;
		if($r !== null && $r->match($s)) {
			$GLOBALS['%s']->pop();
			return $s;
		}
		{
			$tmp = "'" . _hx_string_or_null(_hx_explode("\x09", _hx_explode("\x0D", _hx_explode("\x0A", _hx_explode("'", _hx_explode("\\", $s)->join("\\\\"))->join("\\'"))->join("\\n"))->join("\\r"))->join("\\t")) . "'";
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function escape() {
		$GLOBALS['%s']->push("sys.db.Serialized::escape");
		$__hx__spos = $GLOBALS['%s']->length;
		if($this->value === "") {
			$GLOBALS['%s']->pop();
			return "empty()";
		}
		$this->buf = new StringBuf();
		$this->scache = new _hx_array(array());
		try {
			$this->loop();
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			if(($e = $_ex_) instanceof sys_db__Serialized_Errors){
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				$this->pos = -1;
			} else throw $__hx__e;;
		}
		if($this->pos !== strlen($this->value)) {
			$tmp = "invalid(" . _hx_string_or_null($this->quote($this->value, null)) . ")";
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$str = $this->buf->b;
		if($this->useEnumIndex) {
			$str = "indexes(" . _hx_string_or_null($str) . ")";
		}
		{
			$GLOBALS['%s']->pop();
			return $str;
		}
		$GLOBALS['%s']->pop();
	}
	public function get($pos) {
		$GLOBALS['%s']->push("sys.db.Serialized::get");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = _hx_char_code_at($this->value, $pos);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function readDigits() {
		$GLOBALS['%s']->push("sys.db.Serialized::readDigits");
		$__hx__spos = $GLOBALS['%s']->length;
		$k = 0;
		$s = false;
		$fpos = $this->pos;
		while(true) {
			$c = _hx_char_code_at($this->value, $this->pos);
			if($c === null) {
				break;
			}
			if($c === 45) {
				if($this->pos !== $fpos) {
					break;
				}
				$s = true;
				$this->pos++;
				continue;
			}
			if($c < 48 || $c > 57) {
				break;
			}
			$k = $k * 10 + ($c - 48);
			$this->pos++;
			unset($c);
		}
		if($s) {
			$k *= -1;
		}
		{
			$GLOBALS['%s']->pop();
			return $k;
		}
		$GLOBALS['%s']->pop();
	}
	public function loop() {
		$GLOBALS['%s']->push("sys.db.Serialized::loop");
		$__hx__spos = $GLOBALS['%s']->length;
		$_g = null;
		{
			$pos = $this->pos++;
			$_g = _hx_char_code_at($this->value, $pos);
		}
		if($_g !== null) {
			switch($_g) {
			case 110:{
				$this->buf->add(null);
			}break;
			case 105:{
				$this->buf->add($this->readDigits());
			}break;
			case 122:{
				$this->buf->add(0);
			}break;
			case 116:{
				$this->buf->add(true);
			}break;
			case 102:{
				$this->buf->add(false);
			}break;
			case 107:{
				$this->buf->add("NaN");
			}break;
			case 112:{
				$this->buf->add("Inf");
			}break;
			case 109:{
				$this->buf->add("NegInf");
			}break;
			case 100:{
				$p1 = $this->pos;
				while(true) {
					$c = _hx_char_code_at($this->value, $this->pos);
					if($c >= 43 && $c < 58 || $c === 101 || $c === 69) {
						$this->pos++;
					} else {
						break;
					}
					unset($c);
				}
				$this->buf->add(_hx_substr($this->value, $p1, $this->pos - $p1));
			}break;
			case 97:{
				$this->open("[", ", ", null);
				while(true) {
					$c1 = _hx_char_code_at($this->value, $this->pos);
					if($c1 === 104) {
						$this->pos++;
						break;
					}
					if($c1 === 117) {
						$this->pos++;
						{
							$_g2 = 0;
							$_g1 = $this->readDigits() - 1;
							while($_g2 < $_g1) {
								$i = $_g2++;
								$this->buf->add("null");
								$this->next();
								unset($i);
							}
							unset($_g2,$_g1);
						}
						$this->buf->add("null");
					} else {
						$this->loop();
					}
					$this->next();
					unset($c1);
				}
				$this->close("]", null);
			}break;
			case 121:case 82:{
				$this->pos--;
				$this->buf->add($this->quote($this->readString(), null));
			}break;
			case 108:{
				$this->open("list(", ", ", null);
				while(_hx_char_code_at($this->value, $this->pos) !== 104) {
					$this->loop();
					$this->next();
				}
				$this->close(")", null);
				$this->pos++;
			}break;
			case 118:{
				$this->buf->add("date(");
				$this->buf->add($this->quote(_hx_substr($this->value, $this->pos, 19), null));
				$this->buf->add(")");
				$this->pos += 19;
			}break;
			case 120:{
				$this->buf->add("error(");
				$this->loop();
				$this->buf->add(")");
			}break;
			case 111:{
				$this->loopObj(103);
			}break;
			case 98:{
				$this->buf->add("hash(");
				$this->loopObj(104);
				$this->buf->add(")");
			}break;
			case 113:{
				$this->buf->add("inthash(");
				$this->open("{", ", ", " ");
				$c2 = null;
				{
					$pos1 = $this->pos++;
					$c2 = _hx_char_code_at($this->value, $pos1);
				}
				while($c2 === 58) {
					$this->buf->add("'" . _hx_string_rec($this->readDigits(), "") . "'");
					$this->buf->add(" : ");
					$this->loop();
					{
						$pos2 = $this->pos++;
						$c2 = _hx_char_code_at($this->value, $pos2);
						unset($pos2);
					}
					$this->next();
				}
				if($c2 !== 104) {
					throw new HException(sys_db__Serialized_Errors::$Invalid);
				}
				$this->close("}", " ");
				$this->buf->add(")");
			}break;
			case 115:{
				$len = $this->readDigits();
				if(sys_db_Serialized_0($this, $_g, $len) !== 58 || strlen($this->value) - $this->pos < $len) {
					throw new HException(sys_db__Serialized_Errors::$Invalid);
				}
				$this->buf->add("bytes(");
				$this->buf->add($this->quote(_hx_substr($this->value, $this->pos, $len), null));
				$this->buf->add(")");
				$this->pos += $len;
			}break;
			case 119:{
				$this->buf->add($this->quote($this->readString(), sys_db_Serialized::$clname));
				$constr = $this->readString();
				if(sys_db_Serialized::$ident->match($constr)) {
					$this->buf->add("." . _hx_string_or_null($constr));
				} else {
					$this->buf->add("[" . _hx_string_or_null($this->quote($constr, null)) . "]");
				}
				if(sys_db_Serialized_1($this, $_g, $constr) !== 58) {
					throw new HException(sys_db__Serialized_Errors::$Invalid);
				}
				$nargs = $this->readDigits();
				if($nargs > 0) {
					$this->buf->add("(");
					{
						$_g11 = 0;
						while($_g11 < $nargs) {
							$i1 = $_g11++;
							if($i1 > 0) {
								$this->buf->add(", ");
							}
							$this->loop();
							unset($i1);
						}
					}
					$this->buf->add(")");
				}
			}break;
			case 106:{
				$cl = $this->readString();
				$this->buf->add($this->quote($cl, sys_db_Serialized::$clname));
				if(sys_db_Serialized_2($this, $_g, $cl) !== 58) {
					throw new HException(sys_db__Serialized_Errors::$Invalid);
				}
				$index = $this->readDigits();
				$e = Type::resolveEnum($cl);
				if($e === null) {
					$this->buf->add("[" . _hx_string_rec($index, "") . "]");
				} else {
					$this->useEnumIndex = true;
					$this->buf->add("." . _hx_string_or_null(_hx_array_get(Type::getEnumConstructs($e), $index)));
				}
				if(sys_db_Serialized_3($this, $_g, $cl, $e, $index) !== 58) {
					throw new HException(sys_db__Serialized_Errors::$Invalid);
				}
				$nargs1 = $this->readDigits();
				if($nargs1 > 0) {
					$this->buf->add("(");
					{
						$_g12 = 0;
						while($_g12 < $nargs1) {
							$i2 = $_g12++;
							if($i2 > 0) {
								$this->buf->add(", ");
							}
							$this->loop();
							unset($i2);
						}
					}
					$this->buf->add(")");
				}
			}break;
			case 99:{
				$this->buf->add("new ");
				$cl1 = $this->readString();
				if(sys_db_Serialized::$clname->match($cl1)) {
					$this->buf->add(_hx_string_or_null($cl1) . "(");
				} else {
					$this->buf->add("class(");
					$this->buf->add($this->quote($cl1, null));
					$this->buf->add(",");
				}
				$this->loopObj(103);
				$this->buf->add(")");
			}break;
			case 67:{
				$this->open("new custom(", ", ", null);
				$this->buf->add($this->quote($this->readString(), sys_db_Serialized::$clname));
				$this->next();
				while(_hx_char_code_at($this->value, $this->pos) !== 103) {
					$this->loop();
					$this->next();
				}
				$this->close(")", null);
				$this->pos++;
			}break;
			case 114:{
				$this->buf->add("ref(" . _hx_string_rec($this->readDigits(), "") . ")");
			}break;
			default:{
				throw new HException(sys_db__Serialized_Errors::$Invalid);
			}break;
			}
		} else {
			throw new HException(sys_db__Serialized_Errors::$Invalid);
		}
		$GLOBALS['%s']->pop();
	}
	public function readString() {
		$GLOBALS['%s']->push("sys.db.Serialized::readString");
		$__hx__spos = $GLOBALS['%s']->length;
		$_g = _hx_char_code_at($this->value, $this->pos++);
		if($_g !== null) {
			switch($_g) {
			case 121:{
				$len = $this->readDigits();
				if(sys_db_Serialized_4($this, $_g, $len) !== 58 || strlen($this->value) - $this->pos < $len) {
					throw new HException(sys_db__Serialized_Errors::$Invalid);
				}
				$s = _hx_substr($this->value, $this->pos, $len);
				$this->pos += $len;
				$s = urldecode($s);
				$this->scache->push($s);
				{
					$GLOBALS['%s']->pop();
					return $s;
				}
			}break;
			case 82:{
				$n = $this->readDigits();
				if($n < 0 || $n >= $this->scache->length) {
					throw new HException("Invalid string reference");
				}
				{
					$tmp = $this->scache[$n];
					$GLOBALS['%s']->pop();
					return $tmp;
				}
			}break;
			default:{
				throw new HException(sys_db__Serialized_Errors::$Invalid);
			}break;
			}
		} else {
			throw new HException(sys_db__Serialized_Errors::$Invalid);
		}
		$GLOBALS['%s']->pop();
	}
	public function loopObj($eof) {
		$GLOBALS['%s']->push("sys.db.Serialized::loopObj");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->open("{", ", ", " ");
		while(true) {
			if($this->pos >= strlen($this->value)) {
				throw new HException(sys_db__Serialized_Errors::$Invalid);
			}
			if(_hx_char_code_at($this->value, $this->pos) === $eof) {
				break;
			}
			$this->buf->add($this->quote($this->readString(), sys_db_Serialized::$ident));
			$this->buf->add(" : ");
			$this->loop();
			$this->next();
		}
		$this->close("}", " ");
		$this->pos++;
		$GLOBALS['%s']->pop();
	}
	public function open($str, $sep, $prefix = null) {
		$GLOBALS['%s']->push("sys.db.Serialized::open");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->buf->add($str);
		$this->tabs++;
		$this->cur = _hx_anonymous(array("old" => $this->cur, "sep" => $sep, "prefix" => $prefix, "lines" => (new _hx_array(array())), "buf" => $this->buf, "totalSize" => 0, "maxSize" => 0));
		$this->buf = new StringBuf();
		$GLOBALS['%s']->pop();
	}
	public function next() {
		$GLOBALS['%s']->push("sys.db.Serialized::next");
		$__hx__spos = $GLOBALS['%s']->length;
		$line = $this->buf->b;
		if(strlen($line) > $this->cur->maxSize) {
			$this->cur->maxSize = strlen($line);
		}
		$this->cur->totalSize += strlen($line);
		$this->cur->lines->push($line);
		$this->buf = new StringBuf();
		$GLOBALS['%s']->pop();
	}
	public function close($end, $postfix = null) {
		$GLOBALS['%s']->push("sys.db.Serialized::close");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->buf = $this->cur->buf;
		$t = "\x0A";
		{
			$_g1 = 0;
			$_g = $this->tabs - 1;
			while($_g1 < $_g) {
				$i = $_g1++;
				$t .= _hx_string_or_null(sys_db_Serialized::$IDENT);
				unset($i);
			}
		}
		if(strlen($t) + $this->cur->totalSize > 80 && $this->cur->maxSize > 10) {
			$first = true;
			{
				$_g2 = 0;
				$_g11 = $this->cur->lines;
				while($_g2 < $_g11->length) {
					$line = $_g11[$_g2];
					++$_g2;
					if($first) {
						$first = false;
					} else {
						$this->buf->add($this->cur->sep);
					}
					$this->buf->add(_hx_string_or_null($t) . _hx_string_or_null(sys_db_Serialized::$IDENT) . _hx_string_or_null($line));
					unset($line);
				}
			}
			$this->buf->add($t);
			$this->buf->add($end);
		} else {
			if($this->cur->prefix !== null && $this->cur->lines->length > 0) {
				$this->buf->add($this->cur->prefix);
			}
			$first1 = true;
			{
				$_g3 = 0;
				$_g12 = $this->cur->lines;
				while($_g3 < $_g12->length) {
					$line1 = $_g12[$_g3];
					++$_g3;
					if($first1) {
						$first1 = false;
					} else {
						$this->buf->add($this->cur->sep);
					}
					$this->buf->add($line1);
					unset($line1);
				}
			}
			if(!$first1 && $postfix !== null) {
				$this->buf->add($postfix);
			}
			$this->buf->add($end);
		}
		$this->cur = $this->cur->old;
		$this->tabs--;
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
	static $IDENT = "  ";
	static $ident;
	static $clname;
	static $BASE64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789%:";
	function __toString() { return 'sys.db.Serialized'; }
}
sys_db_Serialized::$ident = new EReg("^[A-Za-z_][A-Za-z0-9_]*\$", "");
sys_db_Serialized::$clname = new EReg("^[A-Za-z_][A-Z.a-z0-9_]*\$", "");
function sys_db_Serialized_0(&$__hx__this, &$_g, &$len) {
	{
		$pos3 = $__hx__this->pos++;
		return _hx_char_code_at($__hx__this->value, $pos3);
	}
}
function sys_db_Serialized_1(&$__hx__this, &$_g, &$constr) {
	{
		$pos4 = $__hx__this->pos++;
		return _hx_char_code_at($__hx__this->value, $pos4);
	}
}
function sys_db_Serialized_2(&$__hx__this, &$_g, &$cl) {
	{
		$pos5 = $__hx__this->pos++;
		return _hx_char_code_at($__hx__this->value, $pos5);
	}
}
function sys_db_Serialized_3(&$__hx__this, &$_g, &$cl, &$e, &$index) {
	{
		$pos6 = $__hx__this->pos++;
		return _hx_char_code_at($__hx__this->value, $pos6);
	}
}
function sys_db_Serialized_4(&$__hx__this, &$_g, &$len) {
	{
		$pos = $__hx__this->pos++;
		return _hx_char_code_at($__hx__this->value, $pos);
	}
}
