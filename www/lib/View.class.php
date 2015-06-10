<?php

class View extends sugoi_BaseView {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	function __toString() { return 'View'; }
}
