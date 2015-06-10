<?php

class App extends sugoi_BaseApp {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	static $current = null;
	static $config;
	static function main() {
		sugoi_BaseApp::main();
	}
	static function log($t) {
		if(App::$config->DEBUG) {}
	}
	function __toString() { return 'App'; }
}
App::$config = sugoi_BaseApp::$config;
