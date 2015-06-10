<?php

class sugoi_BaseApp {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		if(sugoi_BaseApp::$config === null) {
			$this->loadConfig();
		}
		$this->cookieName = "sid";
		$this->cookieDomain = "." . _hx_string_or_null(App::$config->HOST);
	}}
	public $cnx;
	public $template;
	public $maintain;
	public $session;
	public $view;
	public $user;
	public $params;
	public $cookieName;
	public $cookieDomain;
	public function loadConfig() {
		App::$config = sugoi_BaseApp::$config = new sugoi_Config();
	}
	public function loadTemplate($t) {
		templo_Loader::$OPTIMIZED = App::$config->DEBUG === false;
		templo_Loader::$BASE_DIR = App::$config->TPL;
		templo_Loader::$TMP_DIR = App::$config->TPL_TMP;
		if($t === null) {
			return null;
		}
		return new templo_Loader($t);
	}
	public function setTemplate($t) {
		if($t === null) {
			$this->template = null;
		} else {
			$this->template = $this->loadTemplate($t);
		}
	}
	public function initLang($lang) {
		if(!Lambda::has(App::$config->LANGS, $lang)) {
			return false;
		}
		$this->session->lang = $lang;
		if($lang === App::$config->LANG) {
			return false;
		}
		App::$config->LANG = $lang;
		$path = _hx_string_or_null(dirname($_SERVER["SCRIPT_FILENAME"])) . "/" . "../lang/" . _hx_string_or_null($lang) . "/";
		App::$config->TPL = _hx_string_or_null($path) . "tpl/";
		App::$config->TPL_TMP = _hx_string_or_null($path) . "tmp/";
		$this->initLocale();
		return true;
	}
	public function initLocale() {
		if(!Sys::setTimeLocale("en_US.UTF-8")) {
			Sys::setTimeLocale("en");
		}
	}
	public function saveAndClose() {
		if($this->cnx === null) {
			return;
		}
		if($this->session->sid !== null) {
			$this->session->update();
		}
		$this->cnx->commit();
		$this->cnx->close();
		$this->cnx->close = array(new _hx_lambda(array(), "sugoi_BaseApp_0"), 'execute');
		$this->cnx->request = array(new _hx_lambda(array(), "sugoi_BaseApp_1"), 'execute');
	}
	public function executeTemplate($save = null) {
		$this->view->init();
		$result = $this->template->execute($this->view);
		if($save) {
			$this->saveAndClose();
		}
		if(_hx_substr($result, 0, 4) === "null") {
			$result = _hx_substr($result, 4, null);
		}
		Sys::hprint($result);
	}
	public function onMeta($m, $args) {
		switch($m) {
		case "tpl":{
			$this->setTemplate($args[0]);
		}break;
		case "logged":{
			if($this->user === null) {
				throw new HException(sugoi_ControllerAction::RedirectAction("/"));
			}
		}break;
		case "admin":{
			if($this->user === null || !$this->user->isAdmin()) {
				throw new HException(sugoi_ControllerAction::RedirectAction("/"));
			}
		}break;
		default:{}break;
		}
	}
	public function detectLang() {
		$l = php_Web::getClientHeader("Accept-Language");
		if($l !== null) {
			$_g = 0;
			$_g1 = _hx_explode(",", $l);
			while($_g < $_g1->length) {
				$l1 = $_g1[$_g];
				++$_g;
				$l1 = _hx_array_get(_hx_explode(";", $l1), 0);
				$l1 = _hx_array_get(_hx_explode("-", $l1), 0);
				$l1 = trim($l1);
				{
					$_g2 = 0;
					$_g3 = App::$config->LANGS;
					while($_g2 < $_g3->length) {
						$a = $_g3[$_g2];
						++$_g2;
						if($a === $l1) {
							return $a;
						}
						unset($a);
					}
					unset($_g3,$_g2);
				}
				unset($l1);
			}
		}
		return App::$config->LANGS[App::$config->LANGS->length - 1];
	}
	public function setupLang() {
		if($this->session->lang === null) {
			if($this->user === null) {
				$this->session->lang = $this->detectLang();
			} else {
				$this->session->lang = $this->user->lang;
			}
		}
		$lang = $this->params->get("lang");
		if($lang !== null && Lambda::has(App::$config->LANGS, $lang)) {
			$this->session->lang = $lang;
		}
		$this->initLang($this->session->lang);
	}
	public function rollback() {
		if($this->cnx !== null) {
			$this->cnx->rollback();
		}
		sys_db_Manager::cleanup();
		if($this->user !== null && $this->session !== null) {
			$this->user = $this->session->get_user();
		}
	}
	public function setCookie($oldCookie) {
		if($this->session !== null && $this->session->sid !== null && $this->session->sid !== $oldCookie) {
			header("Set-Cookie" . ": " . _hx_string_or_null((_hx_string_or_null($this->cookieName) . "=" . _hx_string_or_null($this->session->sid) . "; path=/;")));
		}
	}
	public function mainLoop() {
		$this->params = php_Web::getParams();
		$sids = (new _hx_array(array()));
		$cookieSid = null;
		{
			$this1 = php_Web::getCookies();
			$cookieSid = $this1->get($this->cookieName);
		}
		if($this->params->exists("sid")) {
			$sids->push($this->params->get("sid"));
		}
		if($cookieSid !== null) {
			$sids->push($cookieSid);
		}
		$this->session = sugoi_db_Session::init($sids);
		$this->maintain = sugoi_db_Variable::getInt("maintain") !== 0;
		$this->user = $this->session->get_user();
		$this->setupLang();
		if($this->maintain && ($this->user !== null && $this->user->isAdmin())) {
			$this->maintain = false;
		}
		$this->setCookie($cookieSid);
		if($this->maintain) {
			$this->setTemplate("maintain.mtt");
			$this->executeTemplate(null);
			return;
		}
		try {
			$url = php_Web::getURI();
			if(StringTools::endsWith($url, "/index.n")) {
				$url = _hx_substr($url, 0, -8);
			}
			$d = new haxe_web_Dispatch($url, $this->params);
			$d->onMeta = (isset($this->onMeta) ? $this->onMeta: array($this, "onMeta"));
			$d->runtimeDispatch(haxe_web_Dispatch::extractConfig(new controller_Main()));
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			if(($e = $_ex_) instanceof haxe_web_DispatchError){
				if(App::$config->DEBUG) {
					php_Lib::rethrow($e);
				}
				$this->cnx->rollback();
				php_Web::redirect("/");
				return;
			}
			else if(($e1 = $_ex_) instanceof sugoi_ControllerAction){
				switch($e1->index) {
				case 0:{
					$url1 = _hx_deref($e1)->params[0];
					{
						php_Web::redirect($url1);
						$this->template = null;
					}
				}break;
				case 1:{
					$text = _hx_deref($e1)->params[1];
					$url2 = _hx_deref($e1)->params[0];
					{
						if($text === null) {
							$text = $url2;
							$url2 = php_Web::getURI();
						}
						php_Web::redirect($url2);
						$error = null;
						switch($e1->index) {
						case 1:{
							$error = true;
						}break;
						default:{
							$error = false;
						}break;
						}
						if($error) {
							$this->rollback();
						}
						if($error) {
							$this->session->addMessage($text, true);
						} else {
							$this->session->addMessage($text, null);
						}
						$this->template = null;
					}
				}break;
				case 2:{
					$text1 = _hx_deref($e1)->params[1];
					$url3 = _hx_deref($e1)->params[0];
					{
						if($text1 === null) {
							$text1 = $url3;
							$url3 = php_Web::getURI();
						}
						php_Web::redirect($url3);
						$error1 = null;
						switch($e1->index) {
						case 1:{
							$error1 = true;
						}break;
						default:{
							$error1 = false;
						}break;
						}
						if($error1) {
							$this->rollback();
						}
						if($error1) {
							$this->session->addMessage($text1, true);
						} else {
							$this->session->addMessage($text1, null);
						}
						$this->template = null;
					}
				}break;
				}
			} else throw $__hx__e;;
		}
		if($this->template === null) {
			$this->saveAndClose();
		} else {
			$this->executeTemplate(true);
		}
	}
	public function logError($e, $stack = null) {
		$stack1 = null;
		if($stack !== null) {
			$stack1 = $stack;
		} else {
			$stack1 = haxe_CallStack::toString(haxe_CallStack::exceptionStack());
		}
		$message = new StringBuf();
		$message->add(Std::string($e));
		$message->add("\x0A");
		$message->add($stack1);
		$message->add("\x0A");
		$e1 = new sugoi_db_Error();
		$e1->url = php_Web::getURI();
		$e1->ip = $_SERVER['REMOTE_ADDR'];
		$e1->set_user(sugoi_BaseApp_2($this, $e, $e1, $message, $stack, $stack1));
		$e1->date = Date::now();
		$e1->error = $message->b;
		$e1->insert();
	}
	public function errorHandler($e) {
		throw new HException($e);
		return;
		try {
			$stack = haxe_CallStack::toString(haxe_CallStack::exceptionStack());
			if($this->cnx !== null) {
				$this->cnx->rollback();
				$this->logError($e, $stack);
			}
			$this->maintain = true;
			$this->view = new View();
			$this->view->message = Std::string($e);
			if(App::$config->DEBUG || $this->user !== null && $this->user->isAdmin()) {
				$this->view->stack = $stack;
			}
			$this->setTemplate("error.mtt");
			$this->executeTemplate(false);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e1 = $_ex_;
			{
				Sys::hprint("<pre>");
				Sys::println("Error : " . _hx_string_or_null(sugoi_BaseApp_3($this, $e, $e1)));
				Sys::println(haxe_CallStack::toString(haxe_CallStack::exceptionStack()));
				try {
					if($this->cnx !== null) {
						sugoi_db_Error::$manager->unsafeGet(0, false);
					}
				}catch(Exception $__hx__e) {
					$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
					$e3 = $_ex_;
					{
						Sys::println("Initializing Database...");
						sys_db_Admin::initializeDatabase(null, null);
						Sys::println("Done");
					}
				}
				Sys::hprint("</pre>");
			}
		}
	}
	public function init() {
		$this->maintain = App::$config->getBool("maintain", null);
		if($this->maintain) {
			$this->view = new View();
			$this->setTemplate("maintain.mtt");
			$this->executeTemplate(false);
			return false;
		}
		try {
			$dbstr = App::$config->get("database", null);
			$dbreg = new EReg("([^:]+)://([^:]+):([^@]*?)@([^:]+)(:[0-9]+)?/(.*?)\$", "");
			if(!$dbreg->match($dbstr)) {
				throw new HException("Configuration requires a valid database attribute, format is : mysql://user:password@host:port/dbname");
			}
			$port = $dbreg->matched(5);
			$dbparams = _hx_anonymous(array("user" => $dbreg->matched(2), "pass" => $dbreg->matched(3), "host" => $dbreg->matched(4), "port" => (($port === null) ? 3306 : Std::parseInt(_hx_substr($port, 1, null))), "database" => $dbreg->matched(6), "socket" => null));
			$this->cnx = sys_db_Mysql::connect($dbparams);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$this->errorHandler($e);
				return false;
			}
		}
		if(App::$config->SQL_LOG) {
			$this->cnx = new sugoi_tools_DebugConnection($this->cnx);
		}
		return true;
	}
	public function cloneApp() {
		$app = new App();
		$bapp = $app;
		$bapp->cnx = $this->cnx;
		$bapp->view = new View();
		App::$current = $app;
		$bapp->mainLoop();
	}
	public function run() {
		sys_db_Transaction::main($this->cnx, (isset($this->cloneApp) ? $this->cloneApp: array($this, "cloneApp")), null);
		App::$current = null;
	}
	public function sendHeaders() {
		header("Cache-Control" . ": " . "no-store, no-cache, must-revalidate");
		header("Pragma" . ": " . "no-cache");
		header("Expires" . ": " . "-1");
		header("P3P" . ": " . "CP=\"ALL DSP COR NID CURa OUR STP PUR\"");
		header("Content-Type" . ": " . "text/html; Charset=UTF-8");
		header("Expires" . ": " . "Mon, 26 Jul 1997 05:00:00 GMT");
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
	static $config;
	static function main() {
		App::$current = new App();
		$a = App::$current;
		$a->sendHeaders();
		if(!$a->init()) {
			$a = null;
			return;
		}
		$a->run();
		$a = null;
	}
	function __toString() { return 'sugoi.BaseApp'; }
}
function sugoi_BaseApp_0() {
	{}
}
function sugoi_BaseApp_1($s) {
	{
		return null;
	}
}
function sugoi_BaseApp_2(&$__hx__this, &$e, &$e1, &$message, &$stack, &$stack1) {
	if($__hx__this->user !== null) {
		return $__hx__this->user;
	}
}
function sugoi_BaseApp_3(&$__hx__this, &$e, &$e1) {
	try {
		return Std::string($e1);
	}catch(Exception $__hx__e) {
		$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
		$e2 = $_ex_;
		{
			return "???";
		}
	}
}
