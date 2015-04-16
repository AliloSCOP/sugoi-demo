<?php

class sugoi_form_FormMethod extends Enum {
	public static $GET;
	public static $POST;
	public static $__constructors = array(0 => 'GET', 1 => 'POST');
	}
sugoi_form_FormMethod::$GET = new sugoi_form_FormMethod("GET", 0);
sugoi_form_FormMethod::$POST = new sugoi_form_FormMethod("POST", 1);
