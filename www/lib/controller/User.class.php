<?php

class controller_User extends sugoi_BaseController {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("controller.User::new");
		$__hx__spos = $GLOBALS['%s']->length;
		parent::__construct();
		$GLOBALS['%s']->pop();
	}}
	public function doLogin() {
		$GLOBALS['%s']->push("controller.User::doLogin");
		$__hx__spos = $GLOBALS['%s']->length;
		if(App::$current->user !== null) {
			throw new HException($this->Redirect("/"));
		}
		$form = sugoi_form_Form::fromObject(_hx_anonymous(array("email" => "", "pass" => "")));
		if($form->isValid()) {
			$pass = haxe_crypto_Md5::encode(_hx_string_or_null(App::$config->KEY) . _hx_string_or_null(controller_User_0($this, $form)));
			$email = null;
			{
				$s1 = $form->getValueOf("email");
				$email = trim($s1);
			}
			$user = db_User::$manager->unsafeObjects("SELECT * FROM User WHERE email = " . _hx_string_or_null(sys_db_Manager::quoteAny($email)) . _hx_string_or_null((" AND pass = " . _hx_string_or_null(sys_db_Manager::quoteAny($pass)))), true)->first();
			if($user === null) {
				throw new HException($this->Error("/user/login", "Invalid email or password"));
			}
			$user->ldate = Date::now();
			$user->update();
			App::$current->session->setUser($user);
			throw new HException($this->Ok("/", "Hello " . _hx_string_or_null($user->name) . " !"));
		}
		$this->view->form = $form;
		$GLOBALS['%s']->pop();
	}
	static function __meta__() { $args = func_get_args(); return call_user_func_array(self::$__meta__, $args); }
	static $__meta__;
	function __toString() { return 'controller.User'; }
}
controller_User::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("dispatchConfig" => (new _hx_array(array("oy4:filejy21:haxe.web.DispatchRule:0:1jy18:haxe.web.MatchRule:3:0y5:loginjR1:3:1jR1:1:1ahg"))))), "fields" => _hx_anonymous(array("doLogin" => _hx_anonymous(array("tpl" => (new _hx_array(array("user/login.mtt")))))))));
function controller_User_0(&$__hx__this, &$form) {
	{
		$s = $form->getValueOf("pass");
		return trim($s);
	}
}
