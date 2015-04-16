<?php

class sugoi_BaseView {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.BaseView::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->_vcache = new haxe_ds_StringMap();
		$GLOBALS['%s']->pop();
	}}
	public $_vcache;
	public function init() {
		$GLOBALS['%s']->push("sugoi.BaseView::init");
		$__hx__spos = $GLOBALS['%s']->length;
		$app = App::$current;
		$this->user = $app->user;
		$this->session = $app->session;
		$this->LANG = App::$config->LANG;
		$this->HOST = App::$config->HOST;
		$this->DATA_HOST = App::$config->DATA_HOST;
		$this->DEBUG = App::$config->DEBUG;
		$this->NAME = App::$config->NAME;
		$this->isAdmin = $app->user !== null && $app->user->isAdmin();
		if(App::$config->SQL_LOG) {
			if($app->cnx === null) {
				$this->sqlLog = null;
			} else {
				$this->sqlLog = $app->cnx->log;
			}
		}
		$GLOBALS['%s']->pop();
	}
	public function getMessages() {
		$GLOBALS['%s']->push("sugoi.BaseView::getMessages");
		$__hx__spos = $GLOBALS['%s']->length;
		$session = App::$current->session;
		if($session === null) {
			$GLOBALS['%s']->pop();
			return null;
		}
		if($session->get_messages() === null) {
			$GLOBALS['%s']->pop();
			return null;
		}
		$n = $session->get_messages()->pop();
		if($n === null) {
			$GLOBALS['%s']->pop();
			return null;
		}
		{
			$tmp = _hx_anonymous(array("text" => $n->text, "error" => $n->error, "next" => $session->get_messages()->length > 0));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function urlEncode($str) {
		$GLOBALS['%s']->push("sugoi.BaseView::urlEncode");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = rawurlencode($str);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function escapeJS($str) {
		$GLOBALS['%s']->push("sugoi.BaseView::escapeJS");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = _hx_explode("\x0A", _hx_explode("\x0D", _hx_explode("'", _hx_explode("\\", $str)->join("\\\\"))->join("\\'"))->join("\\r"))->join("\\n");
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function getVariable($file) {
		$GLOBALS['%s']->push("sugoi.BaseView::getVariable");
		$__hx__spos = $GLOBALS['%s']->length;
		$v = $this->_vcache->get($file);
		if($v !== null) {
			$GLOBALS['%s']->pop();
			return $v;
		}
		if(App::$current->maintain) {
			$GLOBALS['%s']->pop();
			return "";
		}
		$v = sugoi_db_Variable::get($file);
		if($v === null) {
			$v = "";
		}
		$this->_vcache->set($file, $v);
		{
			$GLOBALS['%s']->pop();
			return $v;
		}
		$GLOBALS['%s']->pop();
	}
	public function getParam($p) {
		$GLOBALS['%s']->push("sugoi.BaseView::getParam");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = App::$current->params->get($p);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function file($id) {
		$GLOBALS['%s']->push("sugoi.BaseView::file");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = sugoi_db_File::makeSign($id);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public $__dynamics = array();
	public function __get($n) {
		if(isset($this->__dynamics[$n]))
			return $this->__dynamics[$n];
	}
	public function __set($n, $v) {
		$this->__dynamics[$n] = $v;
	}
	public function __call($n, $a) {
		if(isset($this->__dynamics[$n]) && is_callable($this->__dynamics[$n]))
			return call_user_func_array($this->__dynamics[$n], $a);
		if('toString' == $n)
			return $this->__toString();
		throw new HException("Unable to call <".$n.">");
	}
	function __toString() { return 'sugoi.BaseView'; }
}
