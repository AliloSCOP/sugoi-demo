<?php

class sugoi_form_elements_Flags extends sugoi_form_FormElement {
	public function __construct($name, $label, $data, $value, $verticle = null, $labelRight = null) {
		if(!php_Boot::$skip_constructor) {
		if($labelRight === null) {
			$labelRight = true;
		}
		if($verticle === null) {
			$verticle = true;
		}
		parent::__construct();
		$this->name = $name;
		$this->label = $label;
		$this->data = $data;
		$this->value = $value;
		$this->verticle = $verticle;
		$this->labelRight = $labelRight;
		if($value === null) {
			$value = 0;
		}
		$this->checked = (new _hx_array(array()));
		$i = 0;
		{
			$_g = 0;
			while($_g < $data->length) {
				$f = $data[$_g];
				++$_g;
				$this->checked->push(($value & 1 << $i) !== 0);
				$i++;
				unset($f);
			}
		}
		$this->columns = 1;
	}}
	public $data;
	public $selectMessage;
	public $labelLeft;
	public $verticle;
	public $labelRight;
	public $checked;
	public $columns;
	public function populate() {
		$v = php_Web::getParamValues(_hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name));
		$this->value = 0;
		if($v !== null) {
			$val = 0;
			{
				$_g = 0;
				while($_g < $v->length) {
					$vv = $v[$_g];
					++$_g;
					{
						$v1 = null;
						{
							$index = Std::parseInt($vv);
							$v1 = Type::createEnumIndex(_hx_qtype("sugoi.form.elements.FakeFlag"), $index, null);
							unset($index);
						}
						$val |= 1 << $v1->index;
						unset($v1);
					}
					unset($vv);
				}
			}
			$this->value = $val;
		}
	}
	public function render() {
		$s = "";
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name);
		$tagCss = $this->getClasses();
		$labelCss = $this->getLabelClasses();
		$c = 0;
		$array = Lambda::harray($this->data);
		if($array !== null) {
			$rowsPerColumn = Math::ceil($array->length / $this->columns);
			$s = "<table><tr>";
			{
				$_g1 = 0;
				$_g = $this->columns;
				while($_g1 < $_g) {
					$i = $_g1++;
					$s .= "<td valign=\"top\">\x0A";
					$s .= "<table>\x0A";
					{
						$_g2 = 0;
						while($_g2 < $rowsPerColumn) {
							$j = $_g2++;
							if($c >= $array->length) {
								break;
							}
							$s .= "<tr>";
							$row = $array[$c];
							$checkbox = null;
							$checkbox = "<input type=\"checkbox\" class=\"" . _hx_string_or_null($tagCss) . "\" name=\"" . _hx_string_or_null($n) . "[]\" id=\"" . _hx_string_or_null($n) . _hx_string_rec($c, "") . "\" value=\"" . _hx_string_rec($c, "") . "\" " . _hx_string_or_null(((($this->checked[$c]) ? "checked" : ""))) . " ></input>\x0A";
							$label = null;
							$t = sugoi_form_Form::$translator;
							$label = "<label for=\"" . _hx_string_or_null($n) . _hx_string_rec($c, "") . "\" class=\"" . "" . "\" > " . _hx_string_or_null($t->_($row, null)) . "</label>\x0A";
							if($this->labelRight) {
								$s .= "<td style='vertical-align:middle;'>" . _hx_string_or_null($checkbox) . "</td>\x0A";
								$s .= "<td style='vertical-align:middle;'>" . _hx_string_or_null($label) . "</td>\x0A";
							} else {
								$s .= "<td style='vertical-align:middle;'>" . _hx_string_or_null($label) . "</td>\x0A";
								$s .= "<td style='vertical-align:middle;'>" . _hx_string_or_null($checkbox) . "</td>\x0A";
							}
							$s .= "</tr>";
							$c++;
							unset($t,$row,$label,$j,$checkbox);
						}
						unset($_g2);
					}
					$s .= "</table>";
					$s .= "</td>";
					unset($i);
				}
			}
			$s .= "</tr></table>\x0A";
		}
		return $s;
	}
	public function toString() {
		return $this->render();
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
