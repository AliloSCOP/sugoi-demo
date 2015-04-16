<?php

class sugoi_ControllerAction extends Enum {
	public static function ErrorAction($url, $text = null) { return new sugoi_ControllerAction("ErrorAction", 1, array($url, $text)); }
	public static function OkAction($url, $text = null) { return new sugoi_ControllerAction("OkAction", 2, array($url, $text)); }
	public static function RedirectAction($url) { return new sugoi_ControllerAction("RedirectAction", 0, array($url)); }
	public static $__constructors = array(1 => 'ErrorAction', 2 => 'OkAction', 0 => 'RedirectAction');
	}
