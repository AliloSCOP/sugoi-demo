<?php

class sugoi_BaseController {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.BaseController::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->app = App::$current;
		$this->view = $this->app->view;
		$GLOBALS['%s']->pop();
	}}
	public $app;
	public $view;
	public function getParam($v) {
		$GLOBALS['%s']->push("sugoi.BaseController::getParam");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->app->params->get($v);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function checkToken() {
		$GLOBALS['%s']->push("sugoi.BaseController::checkToken");
		$__hx__spos = $GLOBALS['%s']->length;
		$token = haxe_crypto_Md5::encode(_hx_string_or_null($this->app->session->sid) . _hx_string_or_null(_hx_substr(App::$config->KEY, 0, 6)));
		$this->view->token = $token;
		{
			$tmp = $this->app->params->get("token") === $token;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function isAdmin() {
		$GLOBALS['%s']->push("sugoi.BaseController::isAdmin");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->app->user !== null && $this->app->user->isAdmin();
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function Redirect($url) {
		$GLOBALS['%s']->push("sugoi.BaseController::Redirect");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = sugoi_ControllerAction::RedirectAction($url);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function Error($url, $text = null) {
		$GLOBALS['%s']->push("sugoi.BaseController::Error");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = sugoi_ControllerAction::ErrorAction($url, $text);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function Ok($url, $text = null) {
		$GLOBALS['%s']->push("sugoi.BaseController::Ok");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = sugoi_ControllerAction::OkAction($url, $text);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function doFile($fname) {
		$GLOBALS['%s']->push("sugoi.BaseController::doFile");
		$__hx__spos = $GLOBALS['%s']->length;
		$fid = Std::parseInt($fname);
		$f = sugoi_db_File::$manager->unsafeGet($fid, false);
		$ext = _hx_substr($fname, strlen($fname) - 4, null);
		if($f === null || $fname !== _hx_string_or_null(sugoi_db_File::makeSign($fid)) . _hx_string_or_null($ext)) {
			Sys::hprint("404 - File not found '" . _hx_string_or_null(StringTools::htmlEscape($fname, null)) . "'");
			{
				$GLOBALS['%s']->pop();
				return;
			}
		}
		$path = null;
		$ch = null;
		try {
			$path = _hx_string_or_null(dirname($_SERVER["SCRIPT_FILENAME"])) . "/" . "/file/" . _hx_string_or_null(sugoi_db_File::makeSign($f->id)) . _hx_string_or_null($ext);
			$ch = sys_io_File::write($path, true);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				Sys::sleep(0.1);
				php_Web::redirect(_hx_string_or_null(php_Web::getURI()) . "?retry=1");
				{
					$GLOBALS['%s']->pop();
					return;
				}
			}
		}
		$ch->write($f->data);
		$ch->close();
		try {
			$s = sys_FileSystem::stat(_hx_string_or_null(dirname($_SERVER["SCRIPT_FILENAME"])) . "/" . "index.n");
			$mtime = $s->mtime->toString();
			$p = new sys_io_Process("touch", (new _hx_array(array("-m", "-d", $mtime, $path))));
			$p->exitCode();
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e1 = $_ex_;
			{
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
			}
		}
		php_Web::redirect(_hx_string_or_null(php_Web::getURI()) . "?reload=1");
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
	function __toString() { return 'sugoi.BaseController'; }
}
