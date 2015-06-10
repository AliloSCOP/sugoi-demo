<?php

class controller_Main extends sugoi_BaseController {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function doDefault() {
		$this->view->section = "home";
	}
	public function doUser($d) {
		$d->runtimeDispatch(haxe_web_Dispatch::extractConfig(new controller_User()));
	}
	public function doInstall() {
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
	}
	public function doOkMessage() {
		throw new HException($this->Ok("/", "Everything is allright !"));
	}
	public function doErrorMessage() {
		throw new HException($this->Error("/", "Oops, something went wrong !"));
	}
	public function doDb($d) {
		$d->parts = (new _hx_array(array()));
		sys_db_Admin::handler();
	}
	static function __meta__() { $args = func_get_args(); return call_user_func_array(self::$__meta__, $args); }
	static $__meta__;
	function __toString() { return 'controller.Main'; }
}
controller_Main::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("dispatchConfig" => (new _hx_array(array("oy9:okMessagejy21:haxe.web.DispatchRule:1:1ahy12:errorMessagejR1:1:1ahy4:userjR1:0:1jy18:haxe.web.MatchRule:6:0y2:dbjR1:3:1jR1:0:1jR4:6:0y7:installjR1:1:1ahy7:defaultjR1:3:1jR1:1:1ahg"))))), "fields" => _hx_anonymous(array("doDefault" => _hx_anonymous(array("tpl" => (new _hx_array(array("home.mtt"))))), "doDb" => _hx_anonymous(array("admin" => null))))));
