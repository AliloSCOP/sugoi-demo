<?php

class haxe_web_MatchRule extends Enum {
	public static $MRBool;
	public static $MRDate;
	public static $MRDispatch;
	public static function MREnum($e) { return new haxe_web_MatchRule("MREnum", 5, array($e)); }
	public static $MRFloat;
	public static $MRInt;
	public static function MROpt($r) { return new haxe_web_MatchRule("MROpt", 8, array($r)); }
	public static function MRSpod($c, $lock) { return new haxe_web_MatchRule("MRSpod", 7, array($c, $lock)); }
	public static $MRString;
	public static $__constructors = array(1 => 'MRBool', 4 => 'MRDate', 6 => 'MRDispatch', 5 => 'MREnum', 2 => 'MRFloat', 0 => 'MRInt', 8 => 'MROpt', 7 => 'MRSpod', 3 => 'MRString');
	}
haxe_web_MatchRule::$MRBool = new haxe_web_MatchRule("MRBool", 1);
haxe_web_MatchRule::$MRDate = new haxe_web_MatchRule("MRDate", 4);
haxe_web_MatchRule::$MRDispatch = new haxe_web_MatchRule("MRDispatch", 6);
haxe_web_MatchRule::$MRFloat = new haxe_web_MatchRule("MRFloat", 2);
haxe_web_MatchRule::$MRInt = new haxe_web_MatchRule("MRInt", 0);
haxe_web_MatchRule::$MRString = new haxe_web_MatchRule("MRString", 3);