<?php

class App extends sugoi_BaseApp {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("App::new");
		$__hx__spos = $GLOBALS['%s']->length;
		parent::__construct();
		$GLOBALS['%s']->pop();
	}}
	static $current = null;
	static $config;
	static function main() {
		$GLOBALS['%s']->push("App::main");
		$__hx__spos = $GLOBALS['%s']->length;
		sugoi_BaseApp::main();
		$GLOBALS['%s']->pop();
	}
	static function log($t) {
		$GLOBALS['%s']->push("App::log");
		$__hx__spos = $GLOBALS['%s']->length;
		if(App::$config->DEBUG) {}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'App'; }
}
App::$config = sugoi_BaseApp::$config;
