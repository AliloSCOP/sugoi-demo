<?php

class sugoi_BaseView {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->_vcache = new haxe_ds_StringMap();
	}}
	public $_vcache;
	public function init() {
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
	}
	public function getMessages() {
		$session = App::$current->session;
		if($session === null) {
			return null;
		}
		if($session->get_messages() === null) {
			return null;
		}
		$n = $session->get_messages()->pop();
		if($n === null) {
			return null;
		}
		return _hx_anonymous(array("text" => $n->text, "error" => $n->error, "next" => $session->get_messages()->length > 0));
	}
	public function urlEncode($str) {
		return rawurlencode($str);
	}
	public function escapeJS($str) {
		return _hx_explode("\x0A", _hx_explode("\x0D", _hx_explode("'", _hx_explode("\\", $str)->join("\\\\"))->join("\\'"))->join("\\r"))->join("\\n");
	}
	public function getVariable($file) {
		$v = $this->_vcache->get($file);
		if($v !== null) {
			return $v;
		}
		if(App::$current->maintain) {
			return "";
		}
		$v = sugoi_db_Variable::get($file);
		if($v === null) {
			$v = "";
		}
		$this->_vcache->set($file, $v);
		return $v;
	}
	public function getParam($p) {
		return App::$current->params->get($p);
	}
	public function table($data) {
		return _hx_deref(new sugoi_helper_Table("table"))->toString($data);
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
