<?php

class sugoi_form_elements_DateTimeMode extends Enum {
	public static $date;
	public static $dateTime;
	public static $time;
	public static $__constructors = array(0 => 'date', 2 => 'dateTime', 1 => 'time');
	}
sugoi_form_elements_DateTimeMode::$date = new sugoi_form_elements_DateTimeMode("date", 0);
sugoi_form_elements_DateTimeMode::$dateTime = new sugoi_form_elements_DateTimeMode("dateTime", 2);
sugoi_form_elements_DateTimeMode::$time = new sugoi_form_elements_DateTimeMode("time", 1);
