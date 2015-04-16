<?php

class View extends sugoi_BaseView {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("View::new");
		$__hx__spos = $GLOBALS['%s']->length;
		parent::__construct();
		$GLOBALS['%s']->pop();
	}}
	function __toString() { return 'View'; }
}
