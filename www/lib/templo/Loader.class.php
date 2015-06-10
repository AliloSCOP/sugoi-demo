<?php

class templo_Loader {
	public function __construct($file) {
		if(!php_Boot::$skip_constructor) {
		if(!templo_Loader::$OPTIMIZED) {
			$this->compileTemplate($file);
		}
		$this->templatename = $file;
		$this->file = $this->tmpFileId($file);
	}}
	public $file;
	public $templatename;
	public function execute($ctx) {
		if($ctx === null) {
			$ctx = _hx_anonymous(array());
		}
		$this->cache_macro_functions = new haxe_ds_StringMap();
		if(templo_Loader::$MACROS !== null && templo_Loader::$MACROS !== "") {
			$macrosfiles = _hx_explode(" ", templo_Loader::$MACROS);
			if(!templo_Loader::$OPTIMIZED) {
				$_g = 0;
				while($_g < $macrosfiles->length) {
					$mf = $macrosfiles[$_g];
					++$_g;
					$this->compileTemplate($mf);
					unset($mf);
				}
			}
			{
				$_g1 = 0;
				while($_g1 < $macrosfiles->length) {
					$mf1 = $macrosfiles[$_g1];
					++$_g1;
					require_once($this->tmpFileId($mf1));
					unset($mf1);
				}
			}
			$this->macrosprefixes = $this->getMacroPrefixes(_hx_deref((new _hx_array(array($this->templatename))))->concat($macrosfiles));
		} else {
			$this->macrosprefixes = $this->getMacroPrefixes((new _hx_array(array($this->templatename))));
		}
		$container = null;
		$this->bufferReset();
		$this->bufferCreate();
		require($this->file);
		return $this->bufferPop();
	}
	public $buf;
	public $b;
	public $content;
	public function bufferReset() {
		$this->b = (new _hx_array(array()));
		$this->content = null;
	}
	public function bufferCreate() {
		$len = $this->b->length;
		if($len > 0) {
			$this->b->a[$len - 1] .= _hx_string_or_null($this->buf);
			$this->buf = "";
		}
		$this->b->push("");
	}
	public function bufferPop() {
		$len = $this->b->length;
		$this->b->a[$len - 1] .= _hx_string_or_null($this->buf);
		$this->buf = "";
		return $this->b->pop();
	}
	public function includeTemplate($file, $container, $ctx) {
		$old_content = $this->content;
		$this->content = $this->bufferPop();
		if(!templo_Loader::$OPTIMIZED) {
			$this->compileTemplate($file);
		}
		require($this->tmpFileId($file));
		$this->content = $old_content;
	}
	public function tmpFileId($path) {
		if(_hx_char_at($path, 0) === "/") {
			$path = _hx_substr($path, 1, null);
		}
		$path = _hx_deref(new EReg("[/:\\\\]+", "g"))->replace($path, "__");
		return _hx_string_or_null(templo_Loader::$TMP_DIR) . _hx_string_or_null($path) . ".php";
	}
	public function getMacroPrefixes($paths) {
		$prefixes = (new _hx_array(array()));
		$re = new EReg("[/:.\\-]+", "g");
		{
			$_g = 0;
			while($_g < $paths->length) {
				$path = $paths[$_g];
				++$_g;
				if(_hx_char_at($path, 0) === "/") {
					$path = _hx_substr($path, 1, null);
				}
				$prefixes->push($re->replace($path, "__"));
				unset($path);
			}
		}
		return $prefixes;
	}
	public $cache_macro_functions;
	public $macrosprefixes;
	public function macroCall($name, $args) {
		if($this->cache_macro_functions->exists($name)) {
			return call_user_func_array($this->cache_macro_functions->get($name), $args);
		}
		{
			$_g = 0;
			$_g1 = $this->macrosprefixes;
			while($_g < $_g1->length) {
				$pre = $_g1[$_g];
				++$_g;
				$n = _hx_string_or_null($pre) . "_" . _hx_string_or_null($name);
				if(function_exists($n)) {
					$this->cache_macro_functions->set($name, $n);
					return call_user_func_array($n, $args);
				}
				unset($pre,$n);
			}
		}
		throw new HException("invalid macro call to " . _hx_string_or_null($name));
	}
	public function compileTemplate($path) {
		$tmpFile = $this->tmpFileId($path);
		if(file_exists($tmpFile)) {
			$macroStamp = null;
			if(templo_Loader::$MACROS !== null && file_exists(_hx_string_or_null(templo_Loader::$BASE_DIR) . _hx_string_or_null(templo_Loader::$MACROS))) {
				$macroStamp = sys_FileSystem::stat(_hx_string_or_null(templo_Loader::$BASE_DIR) . _hx_string_or_null(templo_Loader::$MACROS))->mtime->getTime();
			} else {
				$macroStamp = null;
			}
			$sourceStamp = sys_FileSystem::stat(_hx_string_or_null(templo_Loader::$BASE_DIR) . _hx_string_or_null($path))->mtime->getTime();
			$stamp = sys_FileSystem::stat($tmpFile)->mtime->getTime();
			if($stamp >= $sourceStamp && ($macroStamp === null || $macroStamp < $stamp)) {
				return;
			}
			@unlink($tmpFile);
		}
		$result = 0;
		$args = new _hx_array(array());
		$args->push("-php");
		if(templo_Loader::$MACROS !== null) {
			$args->push("-macros");
			$args->push(templo_Loader::$MACROS);
		}
		if(templo_Loader::$COMPACT) {
			$args->push("--compact");
		}
		$args->push("-cp");
		$args->push(templo_Loader::$BASE_DIR);
		$args->push("-output");
		$args->push(templo_Loader::$TMP_DIR);
		$args->push($path);
		$p = new sys_io_Process("temploc2", $args);
		$code = $p->exitCode();
		if($code !== 0) {
			throw new HException("Temploc compilation of " . _hx_string_or_null($path) . " failed : " . _hx_string_or_null($p->stderr->readAll(null)->toString()));
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
	static $BASE_DIR = "";
	static $TMP_DIR = "/tmp/";
	static $MACROS = "macros.mtt";
	static $OPTIMIZED = false;
	static $COMPACT = false;
	function __toString() { return 'templo.Loader'; }
}

function _hxtemplo_array_get($a, $i) {
	return $a[$i];
}

function _hxtemplo_substr($s, $p) {
	if(is_string($s)) {
		return _hx_substr($s, $p[0], count($p) > 1 ? $p[1] : null);
	} else {
		return call_user_func_array(array($s, 'substr'), $p);
	}
}

function _hxtemplo_charAt($s, $p) {
	if(is_string($s)) {
		return substr($s, $p[0], 1);
	} else {
		return call_user_func_array(array($s, 'charAt'), $p);
	}
}

function _hxtemplo_cca($s, $p) {
	if(is_string($s)) {
		return ord($s{$p[0]});
	} else {
		return call_user_func_array(array($s, 'cca'), $p);
	}
}

function _hxtemplo_charCodeAt($s, $p) {
	if(is_string($s)) {
		return _hx_char_code_at($s, $p[0]);
	} else {
		return call_user_func_array(array($s, 'charCodeAt'), $p);
	}
}

function _hxtemplo_indexOf($s, $p) {
	if(is_string($s)) {
		return _hx_index_of($s, $p[0]);
	} else {
		return call_user_func_array(array($s, 'indexOf'), $p);
	}
}

function _hxtemplo_lastIndexOf($s, $p) {
	if(is_string($s)) {
		return _hx_last_index_of($s, $p[0]);
	} else {
		return call_user_func_array(array($s, 'lastIndexOf'), $p);
	}
}

function _hxtemplo_length($v) {
	if(is_string($v)) {
		return strlen($v);
	} else {
		return $v->length;
	}
}

function _hxtemplo_split($s, $p) {
	if(is_string($s)) {
		return new _hx_array(explode($p[0], $s));
	} else {
		return call_user_func_array(array($s, 'split'), $p);
	}
}

function _hxtemplo_toLowerCase($s, $p) {
	if(is_string($s)) {
		return strtolower($s);
	} else {
		return call_user_func_array(array($s, 'toLowerCase'), $p);
	}
}

function _hxtemplo_toUpperCase($s, $p) {
	if(is_string($s)) {
		return strtoupper($s);
	} else {
		return call_user_func_array(array($s, 'toUpperCase'), $p);
	}
}

function _hxtemplo_toString($s, $p) {
	if(is_string($s)) {
		return $s;
	} else if(is_array($s)) {
		return '['.join(', ',$s).']';
	} else {
		return call_user_func_array(array($s, 'toString'), $p);
	}
}

//function _hxtemplo_is_true($v) { return $v || $v === ''; }
function _hxtemplo_is_true($v) { return $v !== 0 && $v !== null && $v !== false; }

function _hxtemplo_string($s) {
	if($s === true)
		return 'true';
	else if($s === false)
		return 'false';
	else if($s === 0)
		return '0';
	else if($s === null)
		return 'null';
	else if(is_array($s)) {
		return htmlspecialchars('['.join(', ',$s).']');
	} else if(is_object($s))
		if(method_exists($s, 'toString'))
			return htmlspecialchars($s->toString());
		else
			return htmlspecialchars(''.$s);
	else
		return htmlspecialchars($s);
}

function _hxtemplo_repeater($it) {
	if($it == null)
		//TODO: is this correct or it should return an error?
		return new _hxtemplo_repeater_decorator(new _hx_array(array()));
	else
		return new _hxtemplo_repeater_decorator($it);
}

function _hxtemplo_add($v1, $v2) {
	if(is_null($v1)) $v1 = 'null';
	if(is_null($v2)) $v2 = 'null';

	if(is_numeric($v1) && is_numeric($v2))
		return $v1+$v2;
	return $v1.$v2;
}

class _hxtemplo_repeater_decorator {
	var $it;
	var $index = -1;
	var $number = 0;
	var $odd = false;
	var $even = true;
	var $first = true;
	var $last = false;
	var $size = null;
	function __construct($it) {
		if(isset($it->length)) {
			$this->size = $it->length;
		} else if(method_exists($it, 'get_length')) {
			$this->size = $it->get_length();
		} else if(method_exists($it, 'size')) {
			$this->size = $it->size();
		}
		if(method_exists($it, 'iterator'))
			$this->it = $it->iterator();
		else
			$this->it = $it;
	}

	function hasNext() {
		return $this->it->hasNext();
	}

	function next() {
		$this->index++;
		$this->number++;
		$this->odd = !$this->odd;
		$this->even = !$this->even;
		$this->first = $this->index == 0;
		$this->last = $this->size == $this->number;
		return $this->it->next();
	}
}
;
