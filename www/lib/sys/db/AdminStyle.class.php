<?php

class sys_db_AdminStyle {
	public function __construct($t) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->table = $t;
		$GLOBALS['%s']->pop();
	}}
	public $isNull;
	public $value;
	public $isHeader;
	public $table;
	public function out($str, $params = null) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::out");
		$__hx__spos = $GLOBALS['%s']->length;
		if($params !== null) {
			$_g = 0;
			$_g1 = Reflect::fields($params);
			while($_g < $_g1->length) {
				$x = $_g1[$_g];
				++$_g;
				$str = _hx_explode("@" . _hx_string_or_null($x), $str)->join(Reflect::field($params, $x));
				unset($x);
			}
		}
		Sys::println($str);
		$GLOBALS['%s']->pop();
	}
	public function text($str, $title = null) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::text");
		$__hx__spos = $GLOBALS['%s']->length;
		$str = StringTools::htmlEscape($str, null);
		if($title !== null) {
			$str = "<span title=\"" . _hx_string_or_null(StringTools::htmlEscape($title, null)) . "\">" . _hx_string_or_null($str) . "</span>";
		}
		$this->out($str, null);
		$GLOBALS['%s']->pop();
	}
	public function begin($title) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::begin");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->out("<html><head><title>@title</title>", _hx_anonymous(array("title" => $title)));
		if(sys_db_AdminStyle::$CSS !== null) {
			$this->out(sys_db_AdminStyle::$CSS, null);
		}
		$this->out("<meta http-equiv=\"Content-Type\" content=\"text/html;charset=UTF-8\"/>", null);
		$this->out("\x0D\x0A\x09\x09\x09<script lang=\"text/javascript\">\x0D\x0A\x09\x09\x09\x09function updateLink(name,url,value) {\x0D\x0A\x09\x09\x09\x09\x09document.getElementById(name+\"__goto\").href = (value == \"\")?\"#\":(\"@base\" + url + value);\x0D\x0A\x09\x09\x09\x09}\x0D\x0A\x09\x09\x09\x09function updateImage(name,url,value) {\x0D\x0A\x09\x09\x09\x09\x09updateLink(name,url,value);\x0D\x0A\x09\x09\x09\x09\x09document.getElementById(name+\"__img\").src = \"" . _hx_string_or_null($this->getFileURL("::f::")) . "\".split(\"::f::\").join(value);\x0D\x0A\x09\x09\x09\x09}\x0D\x0A\x09\x09\x09</script>\x0D\x0A\x09\x09", _hx_anonymous(array("base" => sys_db_AdminStyle::$BASE_URL)));
		$this->out("</head><body>", null);
		$this->out("<h1>@title</h1><div class=\"main\">", _hx_anonymous(array("title" => $title)));
		$GLOBALS['%s']->pop();
	}
	public function end() {
		$GLOBALS['%s']->push("sys.db.AdminStyle::end");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->out("<div class=\"links\">", null);
		$this->out("<a href=\"/\">Exit</a> | <a href=\"@url\">Database</a>", _hx_anonymous(array("url" => sys_db_AdminStyle::$BASE_URL)));
		if($this->table !== null) {
			$this->out("| <a href=\"@url@table/search\">Search</a>", _hx_anonymous(array("url" => sys_db_AdminStyle::$BASE_URL, "table" => $this->table->className)));
		}
		if($this->table !== null) {
			$this->out("| <a href=\"@url@table/insert\">Insert</a>", _hx_anonymous(array("url" => sys_db_AdminStyle::$BASE_URL, "table" => $this->table->className)));
		}
		$this->out("</div></div>", null);
		$this->out(sys_db_AdminStyle::$HTML_BOTTOM, null);
		$this->out("</body></html>", null);
		$GLOBALS['%s']->pop();
	}
	public function beginList() {
		$GLOBALS['%s']->push("sys.db.AdminStyle::beginList");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->out("<ul>", null);
		$GLOBALS['%s']->pop();
	}
	public function endList() {
		$GLOBALS['%s']->push("sys.db.AdminStyle::endList");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->out("</ul>", null);
		$GLOBALS['%s']->pop();
	}
	public function beginItem() {
		$GLOBALS['%s']->push("sys.db.AdminStyle::beginItem");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->out("<li>", null);
		$GLOBALS['%s']->pop();
	}
	public function endItem() {
		$GLOBALS['%s']->push("sys.db.AdminStyle::endItem");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->out("</li>", null);
		$GLOBALS['%s']->pop();
	}
	public function redirect($url) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::redirect");
		$__hx__spos = $GLOBALS['%s']->length;
		php_Web::redirect(_hx_string_or_null(sys_db_AdminStyle::$BASE_URL) . _hx_string_or_null($url));
		$GLOBALS['%s']->pop();
	}
	public function link($url, $name) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::link");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->out("<a href=\"@url\">@name</a>", _hx_anonymous(array("url" => _hx_string_or_null(sys_db_AdminStyle::$BASE_URL) . _hx_string_or_null($url), "name" => $name)));
		$GLOBALS['%s']->pop();
	}
	public function linkConfirm($url, $name) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::linkConfirm");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->out("<a href=\"@url\" onclick=\"return confirm('Please confirm this action')\">@name</a>", _hx_anonymous(array("url" => _hx_string_or_null(sys_db_AdminStyle::$BASE_URL) . _hx_string_or_null($url), "name" => $name)));
		$GLOBALS['%s']->pop();
	}
	public function beginForm($url, $file = null, $id = null) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::beginForm");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->out("<form id=\"@id\" action=\"@url\" method=\"POST\"@enc>", _hx_anonymous(array("id" => $id, "url" => _hx_string_or_null(sys_db_AdminStyle::$BASE_URL) . _hx_string_or_null($url), "enc" => (($file) ? " enctype=\"multipart/form-data\"" : ""))));
		$this->beginTable(null);
		$GLOBALS['%s']->pop();
	}
	public function endForm() {
		$GLOBALS['%s']->push("sys.db.AdminStyle::endForm");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->endTable();
		$this->out("</form>", null);
		$GLOBALS['%s']->pop();
	}
	public function beginTable($css = null) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::beginTable");
		$__hx__spos = $GLOBALS['%s']->length;
		if($css !== null) {
			$this->out("<table class=\"@css\">", _hx_anonymous(array("css" => $css)));
		} else {
			$this->out("<table>", null);
		}
		$GLOBALS['%s']->pop();
	}
	public function endTable() {
		$GLOBALS['%s']->push("sys.db.AdminStyle::endTable");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->out("</table>", null);
		$GLOBALS['%s']->pop();
	}
	public function beginLine($isHeader = null, $css = null) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::beginLine");
		$__hx__spos = $GLOBALS['%s']->length;
		$str = "<tr";
		if($css !== null) {
			$str .= " class=\"" . _hx_string_or_null($css) . "\"";
		}
		$str .= ">";
		if($isHeader) {
			$str .= "<th>";
		} else {
			$str .= "<td>";
		}
		$this->out($str, null);
		$this->isHeader = $isHeader;
		$GLOBALS['%s']->pop();
	}
	public function nextRow($isHeader = null) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::nextRow");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->out(_hx_string_or_null(((($this->isHeader) ? "</th>" : "</td>"))) . _hx_string_or_null(((($isHeader) ? "<th>" : "<td>"))), null);
		$this->isHeader = $isHeader;
		$GLOBALS['%s']->pop();
	}
	public function endLine() {
		$GLOBALS['%s']->push("sys.db.AdminStyle::endLine");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->out(_hx_string_or_null(((($this->isHeader) ? "</th>" : "</td>"))) . "</tr>", null);
		$GLOBALS['%s']->pop();
	}
	public function addSubmit($name, $url = null, $confirm = null, $iname = null) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::addSubmit");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->beginLine(null, null);
		$this->nextRow(null);
		$this->out("<input type=\"submit\" class=\"button\" value=\"@name\"", _hx_anonymous(array("name" => $name)));
		if($iname !== null) {
			$this->out(" name=\"@name\"", _hx_anonymous(array("name" => $iname)));
		}
		if($url !== null) {
			$conf = null;
			if($confirm) {
				$conf = "if( confirm('Please confirm this action') )";
			} else {
				$conf = "";
			}
			$this->out(" onclick=\"@conf document.location = '@url'; return false\"", _hx_anonymous(array("conf" => $conf, "url" => _hx_string_or_null(sys_db_AdminStyle::$BASE_URL) . _hx_string_or_null($url))));
		} else {
			if($confirm) {
				$this->out(" onclick=\"return confirm('Please confirm this action');\"", null);
			}
		}
		$this->out("/>", null);
		$this->endLine();
		$GLOBALS['%s']->pop();
	}
	public function checkBox($name, $checked) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::checkBox");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->out("<input name=\"@name\" type=\"checkbox\" class=\"dcheck\"", _hx_anonymous(array("name" => $name)));
		if($checked) {
			$this->out(" checked=\"1\"", null);
		}
		$this->out("/>", null);
		$GLOBALS['%s']->pop();
	}
	public function input($name, $css, $options = null) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::input");
		$__hx__spos = $GLOBALS['%s']->length;
		if($options === null) {
			$options = _hx_anonymous(array());
		}
		$this->beginLine(true, null);
		$this->out($name, null);
		$this->nextRow(null);
		if($this->isNull) {
			$this->checkBox(_hx_string_or_null($name) . "__data", $this->value !== null);
		}
		$this->out("<input name=\"@name\" class=\"@css\"", _hx_anonymous(array("name" => $name, "css" => $css)));
		if(_hx_field($options, "size") !== null) {
			$this->out(" maxlength=\"@size\"", $options);
		}
		if($options->isCheck) {
			$this->out(" type=\"checkbox\"", null);
		}
		if($this->value !== null) {
			if($options->isCheck) {
				if(Std::string($this->value) !== "false") {
					$this->out(" checked=\"1\"", null);
				}
			} else {
				$this->out(" value=\"@v\"", _hx_anonymous(array("v" => _hx_explode("\"", Std::string($this->value))->join("&quot;"))));
			}
		}
		$this->out("/>", null);
		$this->endLine();
		$GLOBALS['%s']->pop();
	}
	public function getFileURL($v) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::getFileURL");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = "/file/" . _hx_string_or_null($v) . ".png";
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function inputText($name, $css, $noWrap = null) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::inputText");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->beginLine(true, null);
		$this->out($name, null);
		$this->nextRow(null);
		if($this->isNull) {
			$this->checkBox(_hx_string_or_null($name) . "__data", $this->value !== null);
		}
		$this->out("<textarea name=\"@name\" class=\"@css\"@noWrap>@value</textarea>", _hx_anonymous(array("noWrap" => (($noWrap) ? " wrap=\"off\"" : ""), "name" => $name, "css" => $css, "value" => (($this->value !== null) ? StringTools::htmlEscape($this->value, null) : ""))));
		$this->endLine();
		$GLOBALS['%s']->pop();
	}
	public function inputField($name, $type, $isNull, $value) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::inputField");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->isNull = $isNull;
		$this->value = $value;
		switch($type->index) {
		case 0:case 2:case 4:{
			$this->infoField($name, (($value === null) ? "#ID" : $value));
		}break;
		case 1:{
			$this->input($name, "dint", _hx_anonymous(array("size" => 10)));
		}break;
		case 5:{
			$this->input($name, "dbigint", _hx_anonymous(array("size" => 20)));
		}break;
		case 3:{
			$this->input($name, "duint", _hx_anonymous(array("size" => 10)));
		}break;
		case 24:{
			$this->input($name, "dtint", _hx_anonymous(array("size" => 4)));
		}break;
		case 25:case 26:case 27:case 28:case 29:{
			$this->input($name, "dint", _hx_anonymous(array("size" => 10)));
		}break;
		case 7:case 6:{
			$this->input($name, "dfloat", _hx_anonymous(array("size" => 10)));
		}break;
		case 8:{
			$this->input($name, "dbool", _hx_anonymous(array("isCheck" => true)));
		}break;
		case 9:{
			$n = _hx_deref($type)->params[0];
			$this->input($name, "dstring", _hx_anonymous(array("size" => $n)));
		}break;
		case 13:{
			$this->input($name, "dtinytext", null);
		}break;
		case 10:{
			if($value !== null) {
				try {
					$this->value = _hx_substr($value, 0, 10);
				}catch(Exception $__hx__e) {
					$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
					$e = $_ex_;
					{
						$GLOBALS['%e'] = (new _hx_array(array()));
						while($GLOBALS['%s']->length >= $__hx__spos) {
							$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
						}
						$GLOBALS['%s']->push($GLOBALS['%e'][0]);
						$this->value = "#INVALID";
					}
				}
			}
			$this->input($name, "ddate", _hx_anonymous(array("size" => 10)));
		}break;
		case 11:case 12:{
			if($value !== null) {
				try {
					$this->value = $value;
				}catch(Exception $__hx__e) {
					$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
					$e1 = $_ex_;
					{
						$GLOBALS['%e'] = (new _hx_array(array()));
						while($GLOBALS['%s']->length >= $__hx__spos) {
							$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
						}
						$GLOBALS['%s']->push($GLOBALS['%e'][0]);
						$this->value = "#INVALID";
					}
				}
			}
			$this->input($name, "ddatetime", _hx_anonymous(array("size" => 19)));
		}break;
		case 15:case 14:{
			$this->inputText($name, "dtext", null);
		}break;
		case 21:case 22:{
			$this->inputText($name, "dtext", true);
		}break;
		case 30:{
			$this->inputText($name, "dtext", true);
		}break;
		case 31:{
			$this->input($name, "dtint", _hx_anonymous(array("size" => 4)));
		}break;
		case 20:{
			$this->input($name, "denc", _hx_anonymous(array("size" => 6)));
		}break;
		case 23:{
			$fl = _hx_deref($type)->params[0];
			{
				$this->beginLine(true, null);
				$this->out($name, null);
				$this->nextRow(null);
				if($isNull) {
					$this->checkBox(_hx_string_or_null($name) . "__data", $value !== null);
				}
				$vint = Std::parseInt($value);
				if($vint === null) {
					$vint = 0;
				}
				$pos = 0;
				{
					$_g1 = 0;
					$_g = $fl->length;
					while($_g1 < $_g) {
						$i = $_g1++;
						$this->out("<input name=\"@name\" class=\"@css\"", _hx_anonymous(array("name" => _hx_string_or_null($name) . "_" . _hx_string_or_null($fl[$i]), "css" => "dbool")));
						$this->out(" type=\"checkbox\"", null);
						if(($vint & 1 << $i) !== 0) {
							$this->out(" checked=\"1\"", null);
						}
						$this->out("/>", null);
						$this->out($fl[$i], null);
						unset($i);
					}
				}
				$this->endLine();
			}
		}break;
		case 18:case 16:case 17:case 19:case 33:case 32:{
			throw new HException("NotSupported");
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	public function binField($name, $isNull, $value, $url) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::binField");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->beginLine(true, null);
		$this->out($name, null);
		$this->nextRow(null);
		if($isNull) {
			$this->checkBox(_hx_string_or_null($name) . "__data", $value !== null);
		}
		if($value !== null) {
			$this->text("[" . _hx_string_rec(strlen($value), "") . " bytes]", null);
		} else {
			if($url !== null) {
				$this->text("null", null);
			}
		}
		$this->out("<input type=\"file\" class=\"dfile\" name=\"@name\"/>", _hx_anonymous(array("name" => $name)));
		if($value !== null && $url !== null) {
			$this->link(call_user_func($url), "download");
		}
		$this->endLine();
		$GLOBALS['%s']->pop();
	}
	public function infoField($name, $value) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::infoField");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->beginLine(true, null);
		$this->out($name, null);
		$this->nextRow(null);
		$this->out($value, null);
		$this->endLine();
		$GLOBALS['%s']->pop();
	}
	public function choiceField($name, $values, $def, $link, $disabled = null, $isImage = null) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::choiceField");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->beginLine(true, null);
		$this->out($name, null);
		$this->nextRow(null);
		$infos = _hx_anonymous(array("func" => (($isImage) ? "updateImage" : "updateLink"), "name" => $name, "link" => $link, "size" => (($values !== null && $values->length > 15) ? 10 : 1), "dis" => (($disabled) ? "disabled=\"yes\"" : ""), "def" => (($def === "null") ? "" : $def)));
		if($values === null) {
			$this->out("<input id=\"@name\" name=\"@name\" class=\"dint\" value=\"@def\" @dis onchange=\"@func('@name','@link',this.value)\"/>", $infos);
		} else {
			$this->out("<select id=\"@name\" name=\"@name\" class=\"dselect\" size=\"@size\" @dis onchange=\"@func('@name','@link',this.value)\">", $infos);
			$this->out("<option value=\"\">---- none -----</option>", null);
			if(null == $values) throw new HException('null iterable');
			$__hx__it = $values->iterator();
			while($__hx__it->hasNext()) {
				unset($v);
				$v = $__hx__it->next();
				$this->out("<option value=\"@id\"@sel>@str</option>", _hx_anonymous(array("id" => $v->id, "str" => $v->str, "sel" => (($v->id === $def) ? " selected=\"yes\"" : ""))));
			}
			$this->out("</select>", null);
		}
		$this->out("<a id=\"@name__goto\" href=\"#\">goto</a>", _hx_anonymous(array("name" => $name)));
		if($isImage) {
			$this->out("<img class=\"dfile\" id=\"@name__img\" src=\"@file\"/>", _hx_anonymous(array("name" => $name, "file" => $this->getFileURL($def))));
		}
		$this->out("<script lang=\"text/javascript\">document.getElementById(\"@name\").onchange()</script>", _hx_anonymous(array("name" => $name)));
		$this->endLine();
		$GLOBALS['%s']->pop();
	}
	public function errorField($message) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::errorField");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->beginLine(true, null);
		$this->nextRow(null);
		$this->error($message);
		$this->endLine();
		$GLOBALS['%s']->pop();
	}
	public function error($message) {
		$GLOBALS['%s']->push("sys.db.AdminStyle::error");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->out("<div class=\"derror\">@msg</div>", _hx_anonymous(array("msg" => $message)));
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
	static $BASE_URL = "/db/";
	static $CSS;
	static $HTML_BOTTOM = "";
	function __toString() { return 'sys.db.AdminStyle'; }
}
sys_db_AdminStyle::$CSS = sys_db_AdminStyle_0();
function sys_db_AdminStyle_0() {
	{
		$file = "body {\x0D\x0A\x09margin\x09\x09\x09\x09: 0px;\x0D\x0A}\x0D\x0A\x0D\x0A.main {\x0D\x0A\x09padding\x09\x09\x09\x09: 10px;\x0D\x0A}\x0D\x0A\x0D\x0Ah1 {\x0D\x0A\x09color\x09\x09\x09\x09: white;\x0D\x0A\x09padding\x09\x09\x09\x09: 5px;\x0D\x0A\x09padding-left\x09\x09: 45px;\x0D\x0A\x09background-color\x09: #b32;\x0D\x0A//\x09background-image\x09: url(\"/img/db/disk.gif\");\x0D\x0A\x09background-image\x09: url(\"data:image/gif;base64,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%3D\");\x0D\x0A\x09background-position\x09: 0px 1px;\x0D\x0A\x09background-repeat\x09: no-repeat;\x0D\x0A}\x0D\x0A\x0D\x0Aa {\x0D\x0A\x09color\x09\x09\x09\x09: #b32;\x0D\x0A}\x0D\x0A\x0D\x0Aa:hover {\x0D\x0A\x09color\x09\x09\x09\x09: black;\x0D\x0A}\x0D\x0A\x0D\x0Ainput,\x0D\x0Atextarea,\x0D\x0Aselect,\x0D\x0Ainput.dfile {\x0D\x0A\x09border\x09\x09\x09\x09: 1px solid #bbb;\x0D\x0A}\x0D\x0A\x0D\x0Ainput.dint,\x0D\x0Ainput.duint,\x0D\x0Ainput.ddate,\x0D\x0Ainput.dfloat {\x0D\x0A\x09width\x09\x09\x09\x09: 80px;\x0D\x0A}\x0D\x0A\x0D\x0Aimg.dfile {\x0D\x0A\x09position\x09\x09\x09: absolute;\x0D\x0A\x09left\x09\x09\x09\x09: 800px;\x0D\x0A}\x0D\x0A\x0D\x0Ainput.button {\x0D\x0A\x09color\x09\x09\x09\x09: white;\x0D\x0A\x09font-weight\x09\x09\x09: bold;\x0D\x0A\x09min-width\x09\x09\x09: 100px;\x0D\x0A\x09background-color\x09: #b32;\x0D\x0A\x09cursor\x09\x09\x09\x09: pointer;\x0D\x0A\x09border\x09\x09\x09\x09: 0px;\x0D\x0A\x09-moz-border-radius\x09: 5px;\x0D\x0A}\x0D\x0A\x0D\x0Ainput.ddatetime {\x0D\x0A    width\x09\x09\x09\x09: 120px;\x0D\x0A}\x0D\x0A\x0D\x0Ainput.dstring {\x0D\x0A\x09width\x09\x09\x09\x09: 400px;\x0D\x0A}\x0D\x0A\x0D\x0Ainput.dtinytext {\x0D\x0A\x09width\x09\x09\x09\x09: 700px;\x0D\x0A}\x0D\x0A\x0D\x0Atextarea.dtext {\x0D\x0A\x09width\x09\x09\x09\x09: 700px;\x0D\x0A\x09height\x09\x09\x09\x09: 200px;\x0D\x0A}\x0D\x0A\x0D\x0Ainput:focus,\x0D\x0Atextarea:focus,\x0D\x0Aselect:focus {\x0D\x0A\x09background-color\x09: #f5f5f5;\x0D\x0A}\x0D\x0A\x0D\x0Aselect {\x0D\x0A\x09width\x09\x09\x09\x09: 300px;\x0D\x0A}\x0D\x0A\x0D\x0Ainput.button:hover {\x0D\x0A\x09background-color\x09: orange;\x0D\x0A}\x0D\x0A\x0D\x0Ainput.button:focus {\x0D\x0A\x09background-color\x09: orange;\x0D\x0A}\x0D\x0A\x0D\x0A.derror {\x0D\x0A\x09text-align\x09\x09\x09: center;\x0D\x0A\x09background-color\x09: #fee;\x0D\x0A}\x0D\x0A\x0D\x0Atable.results {\x0D\x0A\x09border-collapse\x09\x09: collapse;\x0D\x0A\x09border-spacing\x09\x09: 0px;\x0D\x0A\x09font-size\x09\x09\x09: 90%;\x0D\x0A\x09white-space\x09\x09\x09: nowrap;\x0D\x0A\x09margin-bottom\x09\x09: 20px;\x0D\x0A\x09td {\x0D\x0A\x09\x09padding\x09\x09\x09\x09: 1px;\x0D\x0A\x09\x09border-left\x09\x09\x09: 1px solid #bbb;\x0D\x0A\x09\x09border-right\x09\x09: 1px solid #bbb;\x0D\x0A\x09}\x0D\x0A\x09tr.header {\x0D\x0A\x09\x09background-color\x09: #b32;\x0D\x0A\x09\x09color\x09\x09\x09\x09: white;\x0D\x0A\x09\x09a {\x0D\x0A\x09\x09\x09color : white;\x0D\x0A\x09\x09\x09text-decoration : underline;\x0D\x0A\x09\x09}\x0D\x0A\x09}\x0D\x0A\x09tr {\x0D\x0A\x09\x09background-color\x09: white;\x0D\x0A\x09}\x0D\x0A\x09tr.odd {\x0D\x0A\x09\x09background-color\x09: #eee;\x0D\x0A\x09}\x0D\x0A\x09tr:hover td {\x0D\x0A\x09\x09background-color\x09: #fee;\x0D\x0A\x09}\x0D\x0A\x09tr.odd:hover td {\x0D\x0A\x09\x09background-color\x09: #ffd7d7;\x0D\x0A\x09}\x0D\x0A}\x0D\x0A\x0D\x0Adiv.links {\x0D\x0A\x09position\x09\x09\x09: absolute;\x0D\x0A\x09width\x09\x09\x09\x09: 100%;\x0D\x0A\x09height\x09\x09\x09\x09: 22px;\x0D\x0A\x09top\x09\x09\x09\x09\x09: 45px;\x0D\x0A\x09left\x09\x09\x09\x09: 0px;\x0D\x0A\x0D\x0A\x09font-size\x09\x09\x09: 0pt;\x0D\x0A\x09line-height\x09\x09\x09: 0pt;\x0D\x0A\x09color\x09\x09\x09\x09: #e82;\x0D\x0A\x09background-color\x09: #e82;\x0D\x0A}\x0D\x0A\x0D\x0Adiv.links a:first-child {\x0D\x0A\x09margin-left\x09\x09\x09: 2px;\x0D\x0A}\x0D\x0A\x0D\x0Adiv.links a {\x0D\x0A\x09padding-left\x09\x09: 8px;\x0D\x0A\x09padding-right\x09\x09: 8px;\x0D\x0A\x0D\x0A\x09font-family\x09\x09\x09: \"Trebuchet MS\";\x0D\x0A\x09font-weight\x09\x09\x09: bold;\x0D\x0A\x09font-size\x09\x09\x09: 12pt;\x0D\x0A\x09line-height\x09\x09\x09: 22px;\x0D\x0A\x09color\x09\x09\x09\x09: white;\x0D\x0A\x09font-variant\x09\x09: small-caps;\x0D\x0A\x09text-decoration\x09\x09: none;\x0D\x0A}\x0D\x0A\x0D\x0Adiv.links a:hover {\x0D\x0A\x09background-color\x09: black;\x0D\x0A}";
		if($file === null) {
			return null;
		} else {
			return "<style type=\"text/css\">" . _hx_string_or_null($file) . "</style>";
		}
		unset($file);
	}
}
