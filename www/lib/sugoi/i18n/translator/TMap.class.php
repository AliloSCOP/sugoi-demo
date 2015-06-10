<?php

class sugoi_i18n_translator_TMap implements sugoi_i18n_translator_ITranslator{
	public function __construct($arr, $lang) {
		if(!php_Boot::$skip_constructor) {
		$this->texts = null;
		$this->lang = $lang;
		$this->texts = $arr;
	}}
	public $texts;
	public $lang;
	public function _($key, $data = null) {
		if($key === null) {
			throw new HException("key is null");
		}
		$str = $this->texts->get($key);
		if($str === null) {
			App::log("key \"" . _hx_string_or_null($key) . "\" not found in " . _hx_string_or_null($this->texts->toString()));
			$str = $key;
		}
		if($data !== null) {
			$_g = 0;
			$_g1 = Reflect::fields($data);
			while($_g < $_g1->length) {
				$k = $_g1[$_g];
				++$_g;
				{
					$sub = "::" . _hx_string_or_null(_hx_substr($k, 1, null)) . "::";
					$by = Reflect::field($data, $k);
					if($sub === "") {
						$str = implode(str_split ($str), $by);
					} else {
						$str = str_replace($sub, $by, $str);
					}
					unset($sub,$by);
				}
				unset($k);
			}
		}
		return $str;
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	function __toString() { return 'sugoi.i18n.translator.TMap'; }
}
