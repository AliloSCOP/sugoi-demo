<?php

class sugoi_form_ListData {
	public function __construct(){}
	static function getDateElement($low, $high, $labels = null) {
		$data = (new _hx_array(array()));
		if($labels !== null) {
			$_g1 = $low;
			$_g = $high + 1;
			while($_g1 < $_g) {
				$i = $_g1++;
				$data->push(_hx_anonymous(array("key" => Std::string($i), "value" => $labels[$i - 1])));
				unset($i);
			}
		} else {
			$_g11 = $low;
			$_g2 = $high + 1;
			while($_g11 < $_g2) {
				$i1 = $_g11++;
				$n = Std::string($i1);
				$data->push(_hx_anonymous(array("key" => $n, "value" => sugoi_form_ListData_0($_g11, $_g2, $data, $high, $i1, $labels, $low, $n))));
				unset($n,$i1);
			}
		}
		return $data;
	}
	static function getMinutes() {
		$data = (new _hx_array(array()));
		{
			$_g = 0;
			while($_g < 12) {
				$i = $_g++;
				$x = $i * 5;
				$data->push(_hx_anonymous(array("key" => Std::string($x), "value" => Std::string(sugoi_form_ListData_1($_g, $data, $i, $x)))));
				unset($x,$i);
			}
		}
		return $data;
	}
	static function fromArray($arr) {
		$data = (new _hx_array(array()));
		{
			$_g = 0;
			while($_g < $arr->length) {
				$a = $arr[$_g];
				++$_g;
				$data->push(_hx_anonymous(array("key" => Std::string($a), "value" => Std::string($a))));
				unset($a);
			}
		}
		return $data;
	}
	static function getDays($reverse = null) {
		if($reverse === null) {
			$reverse = true;
		}
		$data = (new _hx_array(array()));
		{
			$_g1 = 1;
			$_g = 32;
			while($_g1 < $_g) {
				$i = $_g1++;
				$n = Std::string($i);
				$data->push(_hx_anonymous(array("key" => Std::string($n), "value" => Std::string($n))));
				unset($n,$i);
			}
		}
		return $data;
	}
	static $months_short;
	static $months;
	static function getMonths($short = null) {
		if($short === null) {
			$short = false;
		}
		$input = null;
		if($short) {
			$input = sugoi_form_ListData::$months_short;
		} else {
			$input = sugoi_form_ListData::$months;
		}
		$out = (new _hx_array(array()));
		$c = 1;
		{
			$_g = 0;
			while($_g < $input->length) {
				$i = $input[$_g];
				++$_g;
				$out->push(_hx_anonymous(array("key" => Std::string($c), "value" => $i)));
				$c++;
				unset($i);
			}
		}
		return $out;
	}
	static function getYears($from, $to, $reverse = null) {
		if($reverse === null) {
			$reverse = true;
		}
		$data = (new _hx_array(array()));
		if($reverse) {
			$_g1 = 0;
			$_g = $to - $from + 1;
			while($_g1 < $_g) {
				$i = $_g1++;
				$n = $to - $i;
				$data->push(_hx_anonymous(array("key" => Std::string($n), "value" => Std::string($n))));
				unset($n,$i);
			}
		} else {
			$_g11 = 0;
			$_g2 = $to - $from + 1;
			while($_g11 < $_g2) {
				$i1 = $_g11++;
				$n1 = $from + $i1;
				$data->push(_hx_anonymous(array("key" => Std::string($n1), "value" => Std::string($n1))));
				unset($n1,$i1);
			}
		}
		return $data;
	}
	static function hashToList($hash, $startCounter = null) {
		if($startCounter === null) {
			$startCounter = 0;
		}
		$data = new HList();
		if(null == $hash) throw new HException('null iterable');
		$__hx__it = $hash->keys();
		while($__hx__it->hasNext()) {
			unset($key);
			$key = $__hx__it->next();
			$data->add(_hx_anonymous(array("key" => $key, "value" => $hash->get($key))));
		}
		return $data;
	}
	static function arrayToList($array, $startCounter = null) {
		if($startCounter === null) {
			$startCounter = 0;
		}
		$data = new HList();
		$c = $startCounter;
		{
			$_g = 0;
			while($_g < $array->length) {
				$v = $array[$_g];
				++$_g;
				$data->add(_hx_anonymous(array("key" => $c, "value" => $v)));
				$c++;
				unset($v);
			}
		}
		return $data;
	}
	static function flatArraytoList($array) {
		$data = new HList();
		{
			$_g = 0;
			while($_g < $array->length) {
				$i = $array[$_g];
				++$_g;
				$data->add(_hx_anonymous(array("key" => $i, "value" => $i)));
				unset($i);
			}
		}
		return $data;
	}
	function __toString() { return 'sugoi.form.ListData'; }
}
sugoi_form_ListData::$months_short = (new _hx_array(array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec")));
sugoi_form_ListData::$months = (new _hx_array(array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre")));
function sugoi_form_ListData_0(&$_g11, &$_g2, &$data, &$high, &$i1, &$labels, &$low, &$n) {
	if($i1 < 10) {
		return "0" . _hx_string_or_null($n);
	} else {
		return $n;
	}
}
function sugoi_form_ListData_1(&$_g, &$data, &$i, &$x) {
	if($x < 10) {
		return "0" . _hx_string_rec($x, "");
	} else {
		return $x;
	}
}
