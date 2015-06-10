<?php

class sugoi_BaseController {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->app = App::$current;
		$this->view = $this->app->view;
	}}
	public $app;
	public $view;
	public function getParam($v) {
		return $this->app->params->get($v);
	}
	public function checkToken() {
		$token = haxe_crypto_Md5::encode(_hx_string_or_null($this->app->session->sid) . _hx_string_or_null(_hx_substr(App::$config->KEY, 0, 6)));
		$this->view->token = $token;
		return $this->app->params->get("token") === $token;
	}
	public function isAdmin() {
		return $this->app->user !== null && $this->app->user->isAdmin();
	}
	public function Redirect($url) {
		return sugoi_ControllerAction::RedirectAction($url);
	}
	public function Error($url, $text = null) {
		return sugoi_ControllerAction::ErrorAction($url, $text);
	}
	public function Ok($url, $text = null) {
		return sugoi_ControllerAction::OkAction($url, $text);
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
	function __toString() { return 'sugoi.BaseController'; }
}
