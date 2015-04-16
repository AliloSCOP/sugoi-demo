<?php

class controller_Main extends sugoi_BaseController {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("controller.Main::new");
		$__hx__spos = $GLOBALS['%s']->length;
		parent::__construct();
		$GLOBALS['%s']->pop();
	}}
	public function doDefault() {
		$GLOBALS['%s']->push("controller.Main::doDefault");
		$__hx__spos = $GLOBALS['%s']->length;
		$GLOBALS['%s']->pop();
	}
	public function doUser($d) {
		$GLOBALS['%s']->push("controller.Main::doUser");
		$__hx__spos = $GLOBALS['%s']->length;
		$d->runtimeDispatch(haxe_web_Dispatch::extractConfig(new controller_User()));
		$GLOBALS['%s']->pop();
	}
	public function doInstall() {
		$GLOBALS['%s']->push("controller.Main::doInstall");
		$__hx__spos = $GLOBALS['%s']->length;
		if(db_User::$manager->unsafeGet(1, true) === null) {
			$user = new db_User();
			$user->id = 1;
			$user->lang = "fr";
			$user->email = "admin@localhost";
			$user->name = "admin";
			$user->pass = haxe_crypto_Md5::encode(_hx_string_or_null(App::$config->KEY) . "admin");
			$user->insert();
			$this->app->session->setUser($user);
			throw new HException($this->Ok("/", "Admin user created sucessfully"));
		} else {
			throw new HException($this->Error("/", "Admin user already exists"));
		}
		$GLOBALS['%s']->pop();
	}
	public function doOkMessage() {
		$GLOBALS['%s']->push("controller.Main::doOkMessage");
		$__hx__spos = $GLOBALS['%s']->length;
		throw new HException($this->Ok("/", "Everything is allright !"));
		$GLOBALS['%s']->pop();
	}
	public function doErrorMessage() {
		$GLOBALS['%s']->push("controller.Main::doErrorMessage");
		$__hx__spos = $GLOBALS['%s']->length;
		throw new HException($this->Error("/", "Oops, something went wrong !"));
		$GLOBALS['%s']->pop();
	}
	public function doDb($d) {
		$GLOBALS['%s']->push("controller.Main::doDb");
		$__hx__spos = $GLOBALS['%s']->length;
		$d->parts = (new _hx_array(array()));
		sys_db_Admin::handler();
		$GLOBALS['%s']->pop();
	}
	static function __meta__() { $args = func_get_args(); return call_user_func_array(self::$__meta__, $args); }
	static $__meta__;
	function __toString() { return 'controller.Main'; }
}
controller_Main::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("dispatchConfig" => (new _hx_array(array("oy4:filejy21:haxe.web.DispatchRule:0:1jy18:haxe.web.MatchRule:3:0y9:okMessagejR1:1:1ahy12:errorMessagejR1:1:1ahy4:userjR1:0:1jR2:6:0y2:dbjR1:3:1jR1:0:1jR2:6:0y7:installjR1:1:1ahy7:defaultjR1:3:1jR1:1:1ahg"))))), "fields" => _hx_anonymous(array("doDefault" => _hx_anonymous(array("tpl" => (new _hx_array(array("home.mtt"))))), "doDb" => _hx_anonymous(array("admin" => null))))));
