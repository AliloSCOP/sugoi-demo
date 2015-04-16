<?php

class php_Web {
	public function __construct(){}
	static function getParams() {
		$GLOBALS['%s']->push("php.Web::getParams");
		$__hx__spos = $GLOBALS['%s']->length;
		$a = array_merge($_GET, $_POST);
		if(get_magic_quotes_gpc()) {
			reset($a); while(list($k, $v) = each($a)) $a[$k] = stripslashes((string)$v);
		}
		{
			$tmp = php_Lib::hashOfAssociativeArray($a);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function getParamValues($param) {
		$GLOBALS['%s']->push("php.Web::getParamValues");
		$__hx__spos = $GLOBALS['%s']->length;
		$reg = new EReg("^" . _hx_string_or_null($param) . "(\\[|%5B)([0-9]*?)(\\]|%5D)=(.*?)\$", "");
		$res = new _hx_array(array());
		$explore = array(new _hx_lambda(array(&$param, &$reg, &$res), "php_Web_0"), 'execute');
		call_user_func_array($explore, array(php_Web_1($explore, $param, $reg, $res)));
		call_user_func_array($explore, array(php_Web::getPostData()));
		if($res->length === 0) {
			$post = php_Lib::hashOfAssociativeArray($_POST);
			$data1 = $post->get($param);
			$k = 0;
			$v = "";
			if(is_array($data1)) {
				 reset($data); while(list($k, $v) = each($data)) { 
				$res[$k] = $v;
				 } 
			}
		}
		if($res->length === 0) {
			$GLOBALS['%s']->pop();
			return null;
		}
		{
			$GLOBALS['%s']->pop();
			return $res;
		}
		$GLOBALS['%s']->pop();
	}
	static function getURI() {
		$GLOBALS['%s']->push("php.Web::getURI");
		$__hx__spos = $GLOBALS['%s']->length;
		$s = $_SERVER['REQUEST_URI'];
		{
			$tmp = _hx_array_get(_hx_explode("?", $s), 0);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function redirect($url) {
		$GLOBALS['%s']->push("php.Web::redirect");
		$__hx__spos = $GLOBALS['%s']->length;
		header("Location: " . _hx_string_or_null($url));
		$GLOBALS['%s']->pop();
	}
	static function getClientHeader($k) {
		$GLOBALS['%s']->push("php.Web::getClientHeader");
		$__hx__spos = $GLOBALS['%s']->length;
		$k1 = null;
		{
			$s = strtoupper($k);
			$k1 = str_replace("-", "_", $s);
		}
		if(null == php_Web::getClientHeaders()) throw new HException('null iterable');
		$__hx__it = php_Web::getClientHeaders()->iterator();
		while($__hx__it->hasNext()) {
			unset($i);
			$i = $__hx__it->next();
			if($i->header === $k1) {
				$tmp = $i->value;
				$GLOBALS['%s']->pop();
				return $tmp;
				unset($tmp);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	static $_client_headers;
	static function getClientHeaders() {
		$GLOBALS['%s']->push("php.Web::getClientHeaders");
		$__hx__spos = $GLOBALS['%s']->length;
		if(php_Web::$_client_headers === null) {
			php_Web::$_client_headers = new HList();
			$h = php_Lib::hashOfAssociativeArray($_SERVER);
			if(null == $h) throw new HException('null iterable');
			$__hx__it = $h->keys();
			while($__hx__it->hasNext()) {
				unset($k);
				$k = $__hx__it->next();
				if(_hx_substr($k, 0, 5) === "HTTP_") {
					php_Web::$_client_headers->add(_hx_anonymous(array("header" => _hx_substr($k, 5, null), "value" => $h->get($k))));
				} else {
					if(_hx_substr($k, 0, 8) === "CONTENT_") {
						php_Web::$_client_headers->add(_hx_anonymous(array("header" => $k, "value" => $h->get($k))));
					}
				}
			}
		}
		{
			$tmp = php_Web::$_client_headers;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function getParamsString() {
		$GLOBALS['%s']->push("php.Web::getParamsString");
		$__hx__spos = $GLOBALS['%s']->length;
		if(isset($_SERVER["QUERY_STRING"])) {
			$tmp = $_SERVER["QUERY_STRING"];
			$GLOBALS['%s']->pop();
			return $tmp;
		} else {
			$GLOBALS['%s']->pop();
			return "";
		}
		$GLOBALS['%s']->pop();
	}
	static function getPostData() {
		$GLOBALS['%s']->push("php.Web::getPostData");
		$__hx__spos = $GLOBALS['%s']->length;
		$h = fopen("php://input", "r");
		$bsize = 8192;
		$max = 32;
		$data = null;
		$counter = 0;
		while(!(feof($h) && $counter < $max)) {
			$data .= _hx_string_or_null(fread($h, $bsize));
			$counter++;
		}
		fclose($h);
		{
			$GLOBALS['%s']->pop();
			return $data;
		}
		$GLOBALS['%s']->pop();
	}
	static function getCookies() {
		$GLOBALS['%s']->push("php.Web::getCookies");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = php_Lib::hashOfAssociativeArray($_COOKIE);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function getMultipart($maxSize) {
		$GLOBALS['%s']->push("php.Web::getMultipart");
		$__hx__spos = $GLOBALS['%s']->length;
		$h = new haxe_ds_StringMap();
		$buf = null;
		$curname = null;
		php_Web::parseMultipart(array(new _hx_lambda(array(&$buf, &$curname, &$h, &$maxSize), "php_Web_2"), 'execute'), array(new _hx_lambda(array(&$buf, &$curname, &$h, &$maxSize), "php_Web_3"), 'execute'));
		if($curname !== null) {
			$h->set($curname, $buf->b);
		}
		{
			$tmp = $h;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function parseMultipart($onPart, $onData) {
		$GLOBALS['%s']->push("php.Web::parseMultipart");
		$__hx__spos = $GLOBALS['%s']->length;
		$a = $_POST;
		if(get_magic_quotes_gpc()) {
			reset($a); while(list($k, $v) = each($a)) $a[$k] = stripslashes((string)$v);
		}
		$post = php_Lib::hashOfAssociativeArray($a);
		if(null == $post) throw new HException('null iterable');
		$__hx__it = $post->keys();
		while($__hx__it->hasNext()) {
			unset($key);
			$key = $__hx__it->next();
			call_user_func_array($onPart, array($key, ""));
			$v = $post->get($key);
			call_user_func_array($onData, array(haxe_io_Bytes::ofString($v), 0, strlen($v)));
			unset($v);
		}
		if(!isset($_FILES)) {
			$GLOBALS['%s']->pop();
			return;
		}
		$parts = new _hx_array(array_keys($_FILES));
		{
			$_g = 0;
			while($_g < $parts->length) {
				$part = $parts[$_g];
				++$_g;
				$info = $_FILES[$part];
				$tmp = $info["tmp_name"];
				$file = $info["name"];
				$err = $info["error"];
				if($err > 0) {
					switch($err) {
					case 1:{
						throw new HException("The uploaded file exceeds the max size of " . _hx_string_or_null(ini_get("upload_max_filesize")));
					}break;
					case 2:{
						throw new HException("The uploaded file exceeds the max file size directive specified in the HTML form (max is" . _hx_string_or_null((_hx_string_or_null(ini_get("post_max_size")) . ")")));
					}break;
					case 3:{
						throw new HException("The uploaded file was only partially uploaded");
					}break;
					case 4:{
						continue 2;
					}break;
					case 6:{
						throw new HException("Missing a temporary folder");
					}break;
					case 7:{
						throw new HException("Failed to write file to disk");
					}break;
					case 8:{
						throw new HException("File upload stopped by extension");
					}break;
					}
				}
				call_user_func_array($onPart, array($part, $file));
				if("" !== $file) {
					$h = fopen($tmp, "r");
					$bsize = 8192;
					while(!feof($h)) {
						$buf = fread($h, $bsize);
						$size = strlen($buf);
						call_user_func_array($onData, array(haxe_io_Bytes::ofString($buf), 0, $size));
						unset($size,$buf);
					}
					fclose($h);
					unset($h,$bsize);
				}
				unset($tmp,$part,$info,$file,$err);
			}
		}
		$GLOBALS['%s']->pop();
	}
	static $isModNeko;
	function __toString() { return 'php.Web'; }
}
php_Web::$isModNeko = !php_Lib::isCli();
function php_Web_0(&$param, &$reg, &$res, $data) {
	{
		$GLOBALS['%s']->push("php.Web::getParamValues@66");
		$__hx__spos2 = $GLOBALS['%s']->length;
		if($data === null || strlen($data) === 0) {
			$GLOBALS['%s']->pop();
			return;
		}
		{
			$_g = 0;
			$_g1 = _hx_explode("&", $data);
			while($_g < $_g1->length) {
				$part = $_g1[$_g];
				++$_g;
				if($reg->match($part)) {
					$idx = $reg->matched(2);
					$val = null;
					{
						$s = $reg->matched(4);
						$val = urldecode($s);
						unset($s);
					}
					if($idx === "") {
						$res->push($val);
					} else {
						$res[Std::parseInt($idx)] = $val;
					}
					unset($val,$idx);
				}
				unset($part);
			}
		}
		$GLOBALS['%s']->pop();
	}
}
function php_Web_1(&$explore, &$param, &$reg, &$res) {
	{
		$s1 = php_Web::getParamsString();
		return str_replace(";", "&", $s1);
	}
}
function php_Web_2(&$buf, &$curname, &$h, &$maxSize, $p, $_) {
	{
		$GLOBALS['%s']->push("php.Web::getMultipart@299");
		$__hx__spos2 = $GLOBALS['%s']->length;
		if($curname !== null) {
			$h->set($curname, $buf->b);
		}
		$curname = $p;
		$buf = new StringBuf();
		$maxSize -= strlen($p);
		if($maxSize < 0) {
			throw new HException("Maximum size reached");
		}
		$GLOBALS['%s']->pop();
	}
}
function php_Web_3(&$buf, &$curname, &$h, &$maxSize, $str, $pos, $len) {
	{
		$GLOBALS['%s']->push("php.Web::getMultipart@307");
		$__hx__spos2 = $GLOBALS['%s']->length;
		$maxSize -= $len;
		if($maxSize < 0) {
			throw new HException("Maximum size reached");
		}
		{
			$s = $str->toString();
			$buf->b .= _hx_string_or_null(_hx_substr($s, $pos, $len));
		}
		$GLOBALS['%s']->pop();
	}
}
