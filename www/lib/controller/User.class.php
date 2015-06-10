<?php

class controller_User extends sugoi_BaseController {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->view->section = "users";
	}}
	public function doDefault() {
		$this->view->users = db_User::$manager->all(null);
	}
	public function doDelete($user) {
		if($user->isAdmin()) {
			throw new HException($this->Error("/user", "Can't delete an admin user"));
		}
		$user->lock();
		$user->delete();
		throw new HException($this->Ok("/user", "User deleted"));
	}
	public function doEdit($user) {
		$form = sugoi_form_Form::fromSpod($user);
		$form->getElement("pass")->value = "";
		if($form->isValid()) {
			$user->lock();
			$form->toSpod($user);
			$user->pass = haxe_crypto_Md5::encode(_hx_string_or_null(App::$config->KEY) . _hx_string_or_null($user->pass));
			$user->update();
			throw new HException($this->Ok("/user", "User edited successfully"));
		}
		$this->view->form = $form;
		$this->view->title = "Edit " . _hx_string_or_null($user->name);
	}
	public function doInsert() {
		$user = new db_User();
		$form = sugoi_form_Form::fromSpod($user);
		if($form->isValid()) {
			$form->toSpod($user);
			$user->pass = haxe_crypto_Md5::encode(_hx_string_or_null(App::$config->KEY) . _hx_string_or_null($user->pass));
			$user->insert();
			throw new HException($this->Ok("/user", "User inserted successfully"));
		}
		$this->view->form = $form;
		$this->view->title = "Insert a user";
	}
	public function doLogin() {
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
	}
	static function __meta__() { $args = func_get_args(); return call_user_func_array(self::$__meta__, $args); }
	static $__meta__;
	function __toString() { return 'controller.User'; }
}
controller_User::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("dispatchConfig" => (new _hx_array(array("oy4:editjy21:haxe.web.DispatchRule:3:1jR1:0:1jy18:haxe.web.MatchRule:7:2y7:db.Userfy6:deletejR1:0:1jR2:7:2R3fy5:loginjR1:3:1jR1:1:1ahy7:defaultjR1:3:1jR1:1:1ahy6:insertjR1:3:1jR1:1:1ahg"))))), "fields" => _hx_anonymous(array("doDefault" => _hx_anonymous(array("tpl" => (new _hx_array(array("user/default.mtt"))))), "doEdit" => _hx_anonymous(array("tpl" => (new _hx_array(array("form.mtt"))))), "doInsert" => _hx_anonymous(array("tpl" => (new _hx_array(array("form.mtt"))))), "doLogin" => _hx_anonymous(array("tpl" => (new _hx_array(array("user/login.mtt")))))))));
function controller_User_0(&$__hx__this, &$form) {
	{
		$s = $form->getValueOf("pass");
		return trim($s);
	}
}
