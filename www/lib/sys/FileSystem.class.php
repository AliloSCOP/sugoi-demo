<?php

class sys_FileSystem {
	public function __construct(){}
	static function stat($path) {
		$GLOBALS['%s']->push("sys.FileSystem::stat");
		$__hx__spos = $GLOBALS['%s']->length;
		$fp = fopen($path, "r"); $fstat = fstat($fp); fclose($fp);;
		{
			$tmp = _hx_anonymous(array("gid" => $fstat['gid'], "uid" => $fstat['uid'], "atime" => Date::fromTime($fstat['atime'] * 1000), "mtime" => Date::fromTime($fstat['mtime'] * 1000), "ctime" => Date::fromTime($fstat['ctime'] * 1000), "dev" => $fstat['dev'], "ino" => $fstat['ino'], "nlink" => $fstat['nlink'], "rdev" => $fstat['rdev'], "size" => $fstat['size'], "mode" => $fstat['mode']));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'sys.FileSystem'; }
}
