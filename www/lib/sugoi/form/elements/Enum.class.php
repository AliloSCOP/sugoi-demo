<?php

class sugoi_form_elements_Enum extends sugoi_form_FormElement {
	public function __construct($name, $label, $enumName, $value, $verticle = null, $labelRight = null) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.form.elements.Enum::new");
		$__hx__spos = $GLOBALS['%s']->length;
		if($labelRight === null) {
			$labelRight = true;
		}
		if($verticle === null) {
			$verticle = false;
		}
		parent::__construct();
		$this->name = $name;
		$this->label = $label;
		$this->enumName = $enumName;
		$this->value = $value;
		$this->verticle = $verticle;
		$this->labelRight = $labelRight;
		$this->columns = 1;
		$GLOBALS['%s']->pop();
	}}
	public $enumName;
	public $selectMessage;
	public $labelLeft;
	public $verticle;
	public $labelRight;
	public $checked;
	public $columns;
	public function populate() {
		$GLOBALS['%s']->push("sugoi.form.elements.Enum::populate");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->value = Std::parseInt(App::$current->params->get(_hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name)));
		$GLOBALS['%s']->pop();
	}
	public function render() {
		$GLOBALS['%s']->push("sugoi.form.elements.Enum::render");
		$__hx__spos = $GLOBALS['%s']->length;
		$s = "";
		$n = _hx_string_or_null($this->parentForm->name) . "_" . _hx_string_or_null($this->name);
		$tagCss = $this->getClasses();
		$labelCss = $this->getLabelClasses();
		$c = 0;
		$array = Type::allEnums(Type::resolveEnum($this->enumName));
		$rowsPerColumn = Math::ceil($array->length / $this->columns);
		$s = "<table style='margin-bottom:8px;'><tr>";
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
						$checkbox = "<input type=\"radio\" class=\"" . _hx_string_or_null($tagCss) . "\" name=\"" . _hx_string_or_null($n) . "\" id=\"" . _hx_string_or_null($n) . Std::string($row) . "\" value=\"" . _hx_string_rec(sugoi_form_elements_Enum_0($this, $_g, $_g1, $_g2, $array, $c, $checkbox, $i, $j, $labelCss, $n, $row, $rowsPerColumn, $s, $tagCss), "") . "\" " . _hx_string_or_null((((_hx_equal($this->value, sugoi_form_elements_Enum_1($this, $_g, $_g1, $_g2, $array, $c, $checkbox, $i, $j, $labelCss, $n, $row, $rowsPerColumn, $s, $tagCss))) ? "checked" : ""))) . " ></input>\x0A";
						$label = null;
						$t = sugoi_form_Form::$translator;
						$label = "<label for=\"" . _hx_string_or_null($n) . _hx_string_rec($c, "") . "\" class=\"" . _hx_string_or_null($labelCss) . "\" >" . _hx_string_or_null($t->_(Std::string($row), null)) . "</label>\x0A";
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
		{
			$GLOBALS['%s']->pop();
			return $s;
		}
		$GLOBALS['%s']->pop();
	}
	public function toString() {
		$GLOBALS['%s']->push("sugoi.form.elements.Enum::toString");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->render();
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
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
function sugoi_form_elements_Enum_0(&$__hx__this, &$_g, &$_g1, &$_g2, &$array, &$c, &$checkbox, &$i, &$j, &$labelCss, &$n, &$row, &$rowsPerColumn, &$s, &$tagCss) {
	{
		$e = $row;
		return $e->index;
	}
}
function sugoi_form_elements_Enum_1(&$__hx__this, &$_g, &$_g1, &$_g2, &$array, &$c, &$checkbox, &$i, &$j, &$labelCss, &$n, &$row, &$rowsPerColumn, &$s, &$tagCss) {
	{
		$e1 = $row;
		return $e1->index;
	}
}
