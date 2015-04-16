<?php

class sugoi_Config {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.Config::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->PATH = _hx_string_or_null(dirname($_SERVER["SCRIPT_FILENAME"])) . "/" . "../";
		$this->xml = Xml::parse(sys_io_File::getContent(_hx_string_or_null($this->PATH) . "config.xml"))->firstElement();
		$this->LANG = $this->get("lang", null);
		$this->LANGS = _hx_explode(";", $this->get("langs", null));
		$this->TPL = _hx_string_or_null($this->PATH) . "lang/" . _hx_string_or_null($this->LANG) . "/tpl/";
		$this->TPL_TMP = _hx_string_or_null($this->PATH) . "lang/" . _hx_string_or_null($this->LANG) . "/tmp/";
		$this->DEBUG = $this->get("debug", "0") === "1";
		$this->HOST = $this->get("host", null);
		$this->NAME = $this->get("name", null);
		$this->KEY = $this->get("key", null);
		$this->DATA_HOST = $this->get("dataHost", "data." . _hx_string_or_null($this->HOST));
		$this->SQL_LOG = $this->getBool("sqllog", false);
		$GLOBALS['%s']->pop();
	}}
	public $PATH;
	public $xml;
	public $LANG;
	public $LANGS;
	public $TPL;
	public $TPL_TMP;
	public $DEBUG;
	public $HOST;
	public $NAME;
	public $KEY;
	public $DATA_HOST;
	public $SQL_LOG;
	public function defined($val) {
		$GLOBALS['%s']->push("sugoi.Config::defined");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->xml->get($val) !== null;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getBool($val, $def = null) {
		$GLOBALS['%s']->push("sugoi.Config::getBool");
		$__hx__spos = $GLOBALS['%s']->length;
		$v = $this->get($val, null);
		if($v === null) {
			$GLOBALS['%s']->pop();
			return $def;
		}
		{
			$tmp = $v === "1" || $v === "true";
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function get($val, $def = null) {
		$GLOBALS['%s']->push("sugoi.Config::get");
		$__hx__spos = $GLOBALS['%s']->length;
		$v = $this->xml->get($val);
		if($v === null) {
			$v = $def;
		}
		if($v === null) {
			throw new HException("Missing config attribute : " . _hx_string_or_null($val));
		}
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
	public function getInt($val, $def = null) {
		$GLOBALS['%s']->push("sugoi.Config::getInt");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = Std::parseInt($this->get($val, Std::string($def)));
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
	function __toString() { return 'sugoi.Config'; }
}
