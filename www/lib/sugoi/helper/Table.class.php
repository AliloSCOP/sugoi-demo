<?php

class sugoi_helper_Table {
	public function __construct($defaultCss = null) {
		if(!php_Boot::$skip_constructor) {
		if($defaultCss !== null) {
			$this->tableCSSClass = $defaultCss;
		}
	}}
	public $title;
	public $head;
	public $content;
	public $tableCSSClass;
	public function toString($param = null) {
		if($param !== null) {
			$this->setContent($param);
			return $this->go();
		} else {
			return "null";
		}
	}
	public function go() {
		$output = "";
		$output .= "<table " . _hx_string_or_null((sugoi_helper_Table_0($this, $output))) . ">";
		if($this->title !== null) {
			$length = 0;
			{
				$_g = 0;
				$_g1 = $this->content;
				while($_g < $_g1->length) {
					$row = $_g1[$_g];
					++$_g;
					{
						$_g2 = 0;
						while($_g2 < $row->length) {
							$cell = $row[$_g2];
							++$_g2;
							$length++;
							unset($cell);
						}
						unset($_g2);
					}
					break;
					unset($row);
				}
			}
			$output .= "<tr><th colspan='" . _hx_string_rec($length, "") . "'>" . _hx_string_or_null($this->title) . "</th></tr>";
		}
		if($this->head !== null) {
			$output .= "<tr>";
			{
				$_g3 = 0;
				$_g11 = $this->head;
				while($_g3 < $_g11->length) {
					$cell1 = $_g11[$_g3];
					++$_g3;
					$output .= "<th>" . _hx_string_or_null($cell1) . "</th>";
					unset($cell1);
				}
			}
			$output .= "</tr>";
		}
		{
			$_g4 = 0;
			$_g12 = $this->content;
			while($_g4 < $_g12->length) {
				$row1 = $_g12[$_g4];
				++$_g4;
				$output .= "<tr>";
				{
					$_g21 = 0;
					while($_g21 < $row1->length) {
						$cell2 = $row1[$_g21];
						++$_g21;
						$output .= "<td>" . Std::string($cell2) . "</td>";
						unset($cell2);
					}
					unset($_g21);
				}
				$output .= "</tr>";
				unset($row1);
			}
		}
		$output .= "</table>";
		return $output;
	}
	public function fromIterableToArray($iterable) {
		$out = (new _hx_array(array()));
		$iterable1 = $iterable;
		if(null == $iterable1) throw new HException('null iterable');
		$__hx__it = $iterable1->iterator();
		while($__hx__it->hasNext()) {
			unset($el);
			$el = $__hx__it->next();
			$out->push($el);
		}
		return $out;
	}
	public function fromReflectableToArray($reflectable) {
		$out = (new _hx_array(array()));
		{
			$_g = 0;
			$_g1 = Reflect::fields($reflectable);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				if(!Reflect::isFunction(Reflect::field($reflectable, $field)) && $field !== "__cache__" && $field !== "__lock") {
					$out->push(Reflect::field($reflectable, $field));
				}
				unset($field);
			}
		}
		return $out;
	}
	public function toArray($c) {
		if(_hx_field($c, "iterator") !== null) {
			return $this->fromIterableToArray($c);
		} else {
			return $this->fromReflectableToArray($c);
		}
	}
	public function setContent($c) {
		$this->head = (new _hx_array(array()));
		$this->content = (new _hx_array(array()));
		$row = (new _hx_array(array()));
		try {
			$_g = 0;
			$_g1 = $this->toArray($c);
			while($_g < $_g1->length) {
				$obj = $_g1[$_g];
				++$_g;
				$row = (new _hx_array(array()));
				{
					$_g2 = 0;
					$_g3 = $this->toArray($obj);
					while($_g2 < $_g3->length) {
						$prop = $_g3[$_g2];
						++$_g2;
						if($this->head->length === 0) {
							$_g4 = 0;
							$_g5 = Reflect::fields($obj);
							while($_g4 < $_g5->length) {
								$prop1 = $_g5[$_g4];
								++$_g4;
								if(!Reflect::isFunction(Reflect::field($obj, $prop1)) && $prop1 !== "__cache__") {
									$this->head->push($prop1);
								}
								unset($prop1);
							}
							unset($_g5,$_g4);
						}
						$row->push($prop);
						unset($prop);
					}
					unset($_g3,$_g2);
				}
				$this->content->push($row);
				unset($obj);
			}
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$this->content = (new _hx_array(array()));
				$this->head = (new _hx_array(array("field", "value")));
				{
					$_g6 = 0;
					$_g11 = Reflect::fields($c);
					while($_g6 < $_g11->length) {
						$field = $_g11[$_g6];
						++$_g6;
						$row1 = (new _hx_array(array()));
						if(!Reflect::isFunction(Reflect::field($c, $field)) && $field !== "__cache__" && $field !== "__lock") {
							$row1->push($field);
							$row1->push(Reflect::field($c, $field));
						}
						$this->content->push($row1);
						unset($row1,$field);
					}
				}
			}
		}
		return $this->content;
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
	function __toString() { return $this->toString(); }
}
function sugoi_helper_Table_0(&$__hx__this, &$output) {
	if($__hx__this->tableCSSClass !== null) {
		return "class=\"" . _hx_string_or_null($__hx__this->tableCSSClass) . "\"";
	} else {
		return "";
	}
}
