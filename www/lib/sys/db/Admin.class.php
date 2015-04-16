<?php

class sys_db_Admin {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sys.db.Admin::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->maxInstanceCount = 100;
		$this->maxUploadSize = 1000000;
		$this->allowDrop = false;
		$this->countCache = new haxe_ds_StringMap();
		$this->default_rights = _hx_anonymous(array("can" => _hx_anonymous(array("insert" => true, "delete" => true, "modify" => true, "truncate" => false)), "invisible" => (new _hx_array(array())), "readOnly" => (new _hx_array(array()))));
		$GLOBALS['%s']->pop();
	}}
	public $style;
	public $hasSyncAction;
	public $countCache;
	public $allowDrop;
	public $default_rights;
	public $maxUploadSize;
	public $maxInstanceCount;
	public function execute($sql) {
		$GLOBALS['%s']->push("sys.db.Admin::execute");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = sys_db_Manager::$cnx->request($sql);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function request($t, $sql) {
		$GLOBALS['%s']->push("sys.db.Admin::request");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = sys_db_Manager::$cnx->request($sql);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function boolResult($sql) {
		$GLOBALS['%s']->push("sys.db.Admin::boolResult");
		$__hx__spos = $GLOBALS['%s']->length;
		try {
			$this->execute($sql);
			{
				$GLOBALS['%s']->pop();
				return true;
			}
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				{
					$GLOBALS['%s']->pop();
					return false;
				}
			}
		}
		$GLOBALS['%s']->pop();
	}
	public function getTables() {
		$GLOBALS['%s']->push("sys.db.Admin::getTables");
		$__hx__spos = $GLOBALS['%s']->length;
		$tables = new _hx_array(array());
		$classes = php_Lib::getClasses();
		$this->crawl($tables, $classes);
		$tables->sort(array(new _hx_lambda(array(&$classes, &$tables), "sys_db_Admin_0"), 'execute'));
		{
			$GLOBALS['%s']->pop();
			return $tables;
		}
		$GLOBALS['%s']->pop();
	}
	public function has($a, $v) {
		$GLOBALS['%s']->push("sys.db.Admin::has");
		$__hx__spos = $GLOBALS['%s']->length;
		if(null == $a) throw new HException('null iterable');
		$__hx__it = $a->iterator();
		while($__hx__it->hasNext()) {
			unset($x);
			$x = $__hx__it->next();
			if((is_object($_t = $x) && !($_t instanceof Enum) ? $_t === $v : $_t == $v)) {
				$GLOBALS['%s']->pop();
				return true;
			}
			unset($_t);
		}
		{
			$GLOBALS['%s']->pop();
			return false;
		}
		$GLOBALS['%s']->pop();
	}
	public function crawl($tables, $classes) {
		$GLOBALS['%s']->push("sys.db.Admin::crawl");
		$__hx__spos = $GLOBALS['%s']->length;
		$_g = 0;
		$_g1 = Reflect::fields($classes);
		while($_g < $_g1->length) {
			$cname = $_g1[$_g];
			++$_g;
			$v = Reflect::field($classes, $cname);
			$c = _hx_char_at($cname, 0);
			if((strcmp($c, "a")>= 0) && (strcmp($c, "z")<= 0)) {
				$this->crawl($tables, $v);
				continue;
			}
			if(haxe_rtti_Meta::getType($v)->rtti === null) {
				continue;
			}
			$s = Type::getSuperClass($v);
			while($s !== null) {
				if((is_object($_t = $s) && !($_t instanceof Enum) ? $_t === _hx_qtype("sys.db.Object") : $_t == _hx_qtype("sys.db.Object"))) {
					$tables->push(new sys_db_TableInfos(Type::getClassName($v)));
					break;
				}
				$s = Type::getSuperClass($s);
				unset($_t);
			}
			unset($v,$s,$cname,$c);
		}
		$GLOBALS['%s']->pop();
	}
	public function index($errorMsg = null) {
		$GLOBALS['%s']->push("sys.db.Admin::index");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->style->begin("Tables");
		$this->style->beginForm("doSync", null, null);
		$this->style->beginTable(null);
		$sync = false;
		$allTables = new HList();
		$rq = $this->execute(sys_db_TableInfos::allTablesRequest());
		$__hx__it = $rq;
		while($__hx__it->hasNext()) {
			unset($r);
			$r = $__hx__it->next();
			$allTables->add($rq->getResult(0));
		}
		$windows = Sys::systemName() === "Windows";
		{
			$_g = 0;
			$_g1 = $this->getTables();
			while($_g < $_g1->length) {
				$t = $_g1[$_g];
				++$_g;
				$rights = $this->getRights($this->createInstance($t), null);
				$this->style->beginLine(true, null);
				$this->style->text($t->name, null);
				$this->style->nextRow(null);
				if(!$this->boolResult($t->existsRequest())) {
					$this->style->linkConfirm(_hx_string_or_null($t->className) . "/doCreate", "create");
					$this->style->text("Table is Missing !", null);
				} else {
					if($this->needSync($t)) {
						$sync = true;
					}
					if($rights->can->insert) {
						$this->style->link(_hx_string_or_null($t->className) . "/insert", "insert");
					}
					$this->style->nextRow(null);
					$this->style->link(_hx_string_or_null($t->className) . "/search", "search");
					if($rights->can->truncate) {
						$this->style->linkConfirm(_hx_string_or_null($t->className) . "/doCleanup", "cleanup");
					}
					if($this->allowDrop) {
						$this->style->nextRow(null);
						$this->style->linkConfirm(_hx_string_or_null($t->className) . "/doDrop", "drop");
					}
				}
				$this->style->endLine();
				$allTables->remove($t->name);
				if($windows || sys_db_TableInfos::$OLD_COMPAT) {
					$allTables->remove(strtolower($t->name));
				}
				unset($t,$rights);
			}
		}
		$this->style->endTable();
		if($sync) {
			$this->style->addSubmit("Synchronize Database", null, true, null);
		}
		$this->style->endForm();
		if(!$allTables->isEmpty()) {
			$this->style->beginList();
			if(null == $allTables) throw new HException('null iterable');
			$__hx__it = $allTables->iterator();
			while($__hx__it->hasNext()) {
				unset($t1);
				$t1 = $__hx__it->next();
				if($t1 === "ForumSearch") {
					continue;
				}
				$this->style->beginItem();
				$this->style->text("Table " . _hx_string_or_null($t1) . " does not have any matching object", null);
				$this->style->endItem();
			}
			$this->style->endList();
		}
		if($errorMsg !== null) {
			$this->style->error($errorMsg);
		}
		$this->style->end();
		$GLOBALS['%s']->pop();
	}
	public function isBinary($t) {
		$GLOBALS['%s']->push("sys.db.Admin::isBinary");
		$__hx__spos = $GLOBALS['%s']->length;
		switch($t->index) {
		case 18:case 16:case 17:case 19:{
			$GLOBALS['%s']->pop();
			return true;
		}break;
		default:{
			$GLOBALS['%s']->pop();
			return false;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	public function canDisplay($m) {
		$GLOBALS['%s']->push("sys.db.Admin::canDisplay");
		$__hx__spos = $GLOBALS['%s']->length;
		$c = $this->countCache->get($m->table_name);
		if($c !== null) {
			$GLOBALS['%s']->pop();
			return $c;
		}
		$c = $this->execute(sys_db_TableInfos::countRequest($m, $this->maxInstanceCount))->get_length() < $this->maxInstanceCount;
		$this->countCache->set($m->table_name, $c);
		{
			$GLOBALS['%s']->pop();
			return $c;
		}
		$GLOBALS['%s']->pop();
	}
	public function inputField($table, $f, $id, $readonly, $defval = null, $rawValue = null) {
		$GLOBALS['%s']->push("sys.db.Admin::inputField");
		$__hx__spos = $GLOBALS['%s']->length;
		$prim = $this->has($table->primary, $f->name);
		$insert = $id === null;
		{
			$_g = 0;
			$_g1 = $table->relations;
			while($_g < $_g1->length) {
				$r = $_g1[$_g];
				++$_g;
				if($r->key === $f->name) {
					$values = null;
					if($this->canDisplay($r->manager) || $r->className === "db.File") {
						$values = $r->manager->all(false)->map(array(new _hx_lambda(array(&$_g, &$_g1, &$defval, &$f, &$id, &$insert, &$prim, &$r, &$rawValue, &$readonly, &$table, &$values), "sys_db_Admin_1"), 'execute'));
					}
					$cname = null;
					if(_hx_substr($r->className, 0, 3) === "db.") {
						$cname = _hx_substr($r->className, 3, null);
					} else {
						$cname = $r->className;
					}
					$this->style->choiceField($r->prop, $values, Std::string($defval), _hx_string_or_null($cname) . "/edit/", !$insert && ($prim || $readonly), $r->className === "db.File");
					{
						$GLOBALS['%s']->pop();
						return;
					}
					unset($values,$cname);
				}
				unset($r);
			}
		}
		if($defval !== null && !$rawValue) {
			$_g2 = $f->type;
			switch($_g2->index) {
			case 20:{
				$defval = Std::parseInt(Std::string($defval));
				$defval = sys_db_Id::decode($defval);
			}break;
			case 21:{
				$defval = _hx_deref(new sys_db_Serialized($defval))->escape();
			}break;
			case 22:{
				throw new HException("no NekoSerialized in php");
			}break;
			case 30:{
				$str = _hx_string_call($defval, "toString", array());
				$defval = _hx_deref(new sys_db_Serialized($str))->escape();
			}break;
			default:{}break;
			}
		}
		if($this->isBinary($f->type)) {
			$this->style->binField($f->name, $table->nulls->exists($f->name), $defval, sys_db_Admin_2($this, $defval, $f, $id, $insert, $prim, $rawValue, $readonly, $table));
		} else {
			if($insert && $readonly) {
				$GLOBALS['%s']->pop();
				return;
			} else {
				if(!$insert && ($prim || $readonly)) {
					$this->style->infoField($f->name, $defval);
				} else {
					$this->style->inputField($f->name, $f->type, $table->nulls->exists($f->name), $defval);
				}
			}
		}
		$GLOBALS['%s']->pop();
	}
	public function insert($table, $params = null, $error = null, $errorMsg = null) {
		$GLOBALS['%s']->push("sys.db.Admin::insert");
		$__hx__spos = $GLOBALS['%s']->length;
		$binary = false;
		if(null == $table->fields) throw new HException('null iterable');
		$__hx__it = $table->fields->iterator();
		while($__hx__it->hasNext()) {
			unset($f);
			$f = $__hx__it->next();
			if($this->isBinary($f->type)) {
				$binary = true;
				break;
			}
		}
		$this->style->begin("Insert new " . _hx_string_or_null($table->name));
		$this->style->beginForm(_hx_string_or_null($table->className) . "/doInsert", $binary, $table->name);
		$rights = $this->getRights(null, $table);
		if(null == $table->fields) throw new HException('null iterable');
		$__hx__it = $table->fields->iterator();
		while($__hx__it->hasNext()) {
			unset($f1);
			$f1 = $__hx__it->next();
			if($f1->name === $error) {
				$this->style->errorField((($errorMsg === null) ? "Invalid format" : $errorMsg));
				$errorMsg = null;
			}
			if($this->has($rights->invisible, $f1->name)) {
				continue;
			}
			$readonly = $this->has($rights->readOnly, $f1->name);
			$this->inputField($table, $f1, null, $readonly, (($params === null) ? null : $params->get($f1->name)), $params !== null);
			unset($readonly);
		}
		$this->style->addSubmit("Insert", null, null, null);
		$this->style->addSubmit("Insert New", null, false, "__new");
		$this->style->endForm();
		if($errorMsg !== null) {
			$this->style->error($errorMsg);
		}
		$this->style->end();
		$GLOBALS['%s']->pop();
	}
	public function updateField($fname, $v, $ftype) {
		$GLOBALS['%s']->push("sys.db.Admin::updateField");
		$__hx__spos = $GLOBALS['%s']->length;
		switch($ftype->index) {
		case 0:case 2:case 4:{
			$GLOBALS['%s']->pop();
			return null;
		}break;
		case 10:{
			$d = null;
			if($v === "NOW" || $v === "NOW()") {
				$d = Date::now();
			} else {
				try {
					$d = Date::fromString($v);
				}catch(Exception $__hx__e) {
					$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
					$e = $_ex_;
					{
						$GLOBALS['%e'] = (new _hx_array(array()));
						while($GLOBALS['%s']->length >= $__hx__spos) {
							$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
						}
						$GLOBALS['%s']->push($GLOBALS['%e'][0]);
						$d = null;
					}
				}
			}
			if($d === null) {
				$GLOBALS['%s']->pop();
				return null;
			}
			try {
				$d->toString();
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e1 = $_ex_;
				{
					$GLOBALS['%e'] = (new _hx_array(array()));
					while($GLOBALS['%s']->length >= $__hx__spos) {
						$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
					}
					$GLOBALS['%s']->push($GLOBALS['%e'][0]);
					{
						$GLOBALS['%s']->pop();
						return null;
					}
				}
			}
			{
				$GLOBALS['%s']->pop();
				return $d;
			}
		}break;
		case 11:case 12:{
			$d1 = null;
			if($v === "NOW" || $v === "NOW()") {
				$d1 = Date::now();
			} else {
				try {
					$d1 = Date::fromString($v);
				}catch(Exception $__hx__e) {
					$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
					$e2 = $_ex_;
					{
						$GLOBALS['%e'] = (new _hx_array(array()));
						while($GLOBALS['%s']->length >= $__hx__spos) {
							$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
						}
						$GLOBALS['%s']->push($GLOBALS['%e'][0]);
						$d1 = null;
					}
				}
			}
			if($d1 === null) {
				$GLOBALS['%s']->pop();
				return null;
			}
			try {
				$d1->toString();
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e3 = $_ex_;
				{
					$GLOBALS['%e'] = (new _hx_array(array()));
					while($GLOBALS['%s']->length >= $__hx__spos) {
						$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
					}
					$GLOBALS['%s']->push($GLOBALS['%e'][0]);
					{
						$GLOBALS['%s']->pop();
						return null;
					}
				}
			}
			{
				$GLOBALS['%s']->pop();
				return $d1;
			}
		}break;
		case 1:{
			if($v === "") {
				$GLOBALS['%s']->pop();
				return 0;
			}
			{
				$tmp = Std::parseInt($v);
				$GLOBALS['%s']->pop();
				return $tmp;
			}
		}break;
		case 3:case 23:{
			if($v === "") {
				$GLOBALS['%s']->pop();
				return 0;
			}
			$i = Std::parseInt($v);
			if($i < 0) {
				$GLOBALS['%s']->pop();
				return null;
			}
			{
				$GLOBALS['%s']->pop();
				return $i;
			}
		}break;
		case 24:{
			if($v === "") {
				$GLOBALS['%s']->pop();
				return 0;
			}
			$i1 = Std::parseInt($v);
			if($i1 < -128 || $i1 > 127) {
				$GLOBALS['%s']->pop();
				return null;
			}
			{
				$GLOBALS['%s']->pop();
				return $i1;
			}
		}break;
		case 25:{
			if($v === "") {
				$GLOBALS['%s']->pop();
				return 0;
			}
			$i2 = Std::parseInt($v);
			if($i2 < 0 || $i2 > 255) {
				$GLOBALS['%s']->pop();
				return null;
			}
			{
				$GLOBALS['%s']->pop();
				return $i2;
			}
		}break;
		case 26:{
			if($v === "") {
				$GLOBALS['%s']->pop();
				return 0;
			}
			$i3 = Std::parseInt($v);
			if($i3 < -32768 || $i3 > 32767) {
				$GLOBALS['%s']->pop();
				return null;
			}
			{
				$GLOBALS['%s']->pop();
				return $i3;
			}
		}break;
		case 27:{
			if($v === "") {
				$GLOBALS['%s']->pop();
				return 0;
			}
			$i4 = Std::parseInt($v);
			if($i4 < 0 || $i4 > 65535) {
				$GLOBALS['%s']->pop();
				return null;
			}
			{
				$GLOBALS['%s']->pop();
				return $i4;
			}
		}break;
		case 28:{
			if($v === "") {
				$GLOBALS['%s']->pop();
				return 0;
			}
			$i5 = Std::parseInt($v);
			if($i5 < -8388608 || $i5 > 8388607) {
				$GLOBALS['%s']->pop();
				return null;
			}
			{
				$GLOBALS['%s']->pop();
				return $i5;
			}
		}break;
		case 29:{
			if($v === "") {
				$GLOBALS['%s']->pop();
				return 0;
			}
			$i6 = Std::parseInt($v);
			if($i6 < 0 || $i6 > 16777215) {
				$GLOBALS['%s']->pop();
				return null;
			}
			{
				$GLOBALS['%s']->pop();
				return $i6;
			}
		}break;
		case 5:{
			if($v === "") {
				$GLOBALS['%s']->pop();
				return 0;
			}
			$i7 = Std::parseFloat($v);
			if($i7 === null || !_hx_equal(_hx_mod($i7, 1), 0) || $i7 < -9.2233720368547758e+018 || $i7 > 9223372036854775807.0) {
				$GLOBALS['%s']->pop();
				return null;
			}
			{
				$GLOBALS['%s']->pop();
				return $i7;
			}
		}break;
		case 7:case 6:{
			if($v === "") {
				$GLOBALS['%s']->pop();
				return 0;
			}
			$fl = Std::parseFloat($v);
			if(Math::isNaN($fl)) {
				$GLOBALS['%s']->pop();
				return null;
			}
			{
				$GLOBALS['%s']->pop();
				return $fl;
			}
		}break;
		case 9:{
			$n = _hx_deref($ftype)->params[0];
			{
				if(strlen($v) > $n) {
					$GLOBALS['%s']->pop();
					return null;
				}
				{
					$GLOBALS['%s']->pop();
					return $v;
				}
			}
		}break;
		case 13:{
			if(strlen($v) > 255) {
				$GLOBALS['%s']->pop();
				return null;
			}
			{
				$GLOBALS['%s']->pop();
				return $v;
			}
		}break;
		case 14:case 16:{
			if(strlen($v) > 65535) {
				$GLOBALS['%s']->pop();
				return null;
			}
			{
				$GLOBALS['%s']->pop();
				return $v;
			}
		}break;
		case 15:case 18:{
			if(strlen($v) > 16777215) {
				$GLOBALS['%s']->pop();
				return null;
			}
			{
				$GLOBALS['%s']->pop();
				return $v;
			}
		}break;
		case 19:{
			$n1 = _hx_deref($ftype)->params[0];
			{
				if(strlen($v) > $n1) {
					$GLOBALS['%s']->pop();
					return null;
				}
				{
					$GLOBALS['%s']->pop();
					return $v;
				}
			}
		}break;
		case 17:{
			$GLOBALS['%s']->pop();
			return $v;
		}break;
		case 8:{
			$tmp = $v === "true";
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		case 20:{
			if($v === "") {
				$GLOBALS['%s']->pop();
				return null;
			}
			try {
				{
					$tmp = sys_db_Id::encode($v);
					$GLOBALS['%s']->pop();
					return $tmp;
				}
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e4 = $_ex_;
				{
					$GLOBALS['%e'] = (new _hx_array(array()));
					while($GLOBALS['%s']->length >= $__hx__spos) {
						$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
					}
					$GLOBALS['%s']->push($GLOBALS['%e'][0]);
					{
						$GLOBALS['%s']->pop();
						return null;
					}
				}
			}
		}break;
		case 21:{
			$tmp = _hx_deref(new sys_db_Serialized($v))->encode();
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		case 22:{
			throw new HException("no nekoSerialized in php");
		}break;
		case 30:{
			$s = _hx_deref(new sys_db_Serialized($v))->encode();
			if(strlen($s) > 16777215) {
				$GLOBALS['%s']->pop();
				return null;
			}
			{
				$tmp = haxe_io_Bytes::ofString($s);
				$GLOBALS['%s']->pop();
				return $tmp;
			}
		}break;
		case 31:{
			$e5 = _hx_deref($ftype)->params[0];
			{
				if($v === "") {
					$GLOBALS['%s']->pop();
					return 0;
				}
				$i8 = Std::parseInt($v);
				$ev = Type::resolveEnum($e5);
				if($i8 < 0 || $ev !== null && $i8 >= Type::getEnumConstructs($ev)->length) {
					$GLOBALS['%s']->pop();
					return null;
				}
				{
					$GLOBALS['%s']->pop();
					return $i8;
				}
			}
		}break;
		case 33:case 32:{
			throw new HException("assert");
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	public function createInstance($table) {
		$GLOBALS['%s']->push("sys.db.Admin::createInstance");
		$__hx__spos = $GLOBALS['%s']->length;
		$c = Type::createEmptyInstance($table->cl);
		$c->__init_object();
		{
			$GLOBALS['%s']->pop();
			return $c;
		}
		$GLOBALS['%s']->pop();
	}
	public function getRights($t = null, $table = null) {
		$GLOBALS['%s']->push("sys.db.Admin::getRights");
		$__hx__spos = $GLOBALS['%s']->length;
		if($t === null) {
			$t = $this->createInstance($table);
		}
		if(_hx_field($t, "dbRights") === null) {
			$tmp = $this->default_rights;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$r = $t->dbRights();
		if($r === null) {
			$tmp = $this->default_rights;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		if(_hx_field($r, "can") === null) {
			$r->can = $this->default_rights->can;
		}
		{
			$GLOBALS['%s']->pop();
			return $r;
		}
		$GLOBALS['%s']->pop();
	}
	public function getSInfos($t) {
		$GLOBALS['%s']->push("sys.db.Admin::getSInfos");
		$__hx__spos = $GLOBALS['%s']->length;
		if(_hx_field($t, "dbSearch") === null) {
			$GLOBALS['%s']->pop();
			return null;
		}
		{
			$tmp = $t->dbSearch();
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function doInsert($table, $params) {
		$GLOBALS['%s']->push("sys.db.Admin::doInsert");
		$__hx__spos = $GLOBALS['%s']->length;
		$inst = $this->createInstance($table);
		$this->updateParams($table, $params);
		if(null == $table->fields) throw new HException('null iterable');
		$__hx__it = $table->fields->iterator();
		while($__hx__it->hasNext()) {
			unset($f);
			$f = $__hx__it->next();
			$v = $params->get($f->name);
			if($v === null) {
				if($table->nulls->exists($f->name)) {
					$inst->{$f->name} = null;
				} else {
					$_g = 0;
					$_g1 = $table->relations;
					while($_g < $_g1->length) {
						$r = $_g1[$_g];
						++$_g;
						if($f->name === $r->key) {
							$this->insert($table, $params, $f->name, null);
							{
								$GLOBALS['%s']->pop();
								return;
							}
						}
						unset($r);
					}
					unset($_g1,$_g);
				}
				continue;
			}
			$msg = null;
			$v1 = null;
			try {
				$v1 = $this->updateField($f->name, $v, $f->type);
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				if(is_string($err = $_ex_)){
					$GLOBALS['%e'] = (new _hx_array(array()));
					while($GLOBALS['%s']->length >= $__hx__spos) {
						$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
					}
					$GLOBALS['%s']->push($GLOBALS['%e'][0]);
					$msg = $err;
					$v1 = null;
				} else throw $__hx__e;;
			}
			if($v1 === null) {
				$this->insert($table, $params, $f->name, $msg);
				{
					$GLOBALS['%s']->pop();
					return;
				}
			}
			$inst->{$f->name} = $v1;
			unset($v1,$v,$msg,$err);
		}
		if($table->primary->length === 1 && _hx_equal(Reflect::field($inst, $table->primary->first()), 0)) {
			Reflect::deleteField($inst, $table->primary->first());
		}
		try {
			if(!$this->getRights($inst, null)->can->insert) {
				throw new HException("Can't insert");
			}
			$inst->insert();
			sys_db_Admin::log("Inserted " . _hx_string_or_null($table->name) . " " . _hx_string_or_null($table->identifier($inst)));
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				$this->insert($table, $params, null, Std::string($e));
				{
					$GLOBALS['%s']->pop();
					return;
				}
			}
		}
		if($params->exists("__new")) {
			$this->insert($table, $params, null, null);
			{
				$GLOBALS['%s']->pop();
				return;
			}
		}
		$this->style->redirect(_hx_string_or_null($table->className) . "/edit/" . _hx_string_or_null($table->identifier($inst)));
		$GLOBALS['%s']->pop();
	}
	public function doCreate($table) {
		$GLOBALS['%s']->push("sys.db.Admin::doCreate");
		$__hx__spos = $GLOBALS['%s']->length;
		try {
			$this->execute($table->createRequest(false));
			$this->style->redirect("");
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				$this->index(Std::string($e));
			}
		}
		$GLOBALS['%s']->pop();
	}
	public function doDrop($table) {
		$GLOBALS['%s']->push("sys.db.Admin::doDrop");
		$__hx__spos = $GLOBALS['%s']->length;
		if(!$this->allowDrop) {
			throw new HException("Drop not allowed");
		}
		$this->execute($table->dropRequest());
		$this->style->redirect("");
		$GLOBALS['%s']->pop();
	}
	public function doCleanup($table) {
		$GLOBALS['%s']->push("sys.db.Admin::doCleanup");
		$__hx__spos = $GLOBALS['%s']->length;
		if(!$this->getRights(null, $table)->can->truncate) {
			throw new HException("Can't cleanup");
		}
		$this->execute($table->truncateRequest());
		$this->style->redirect("");
		$GLOBALS['%s']->pop();
	}
	public function edit($table, $id, $params = null, $error = null, $errorMsg = null) {
		$GLOBALS['%s']->push("sys.db.Admin::edit");
		$__hx__spos = $GLOBALS['%s']->length;
		$obj = $table->fromIdentifier($id);
		$objStr = null;
		try {
			$objStr = Std::string($obj);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				$objStr = "#" . _hx_string_or_null($id);
			}
		}
		$this->style->begin("Edit " . _hx_string_or_null($table->name) . " " . _hx_string_or_null($objStr));
		if($obj === null) {
			$this->style->error("This object does not exists");
			$this->style->end();
			{
				$GLOBALS['%s']->pop();
				return;
			}
		}
		$binary = false;
		if(null == $table->fields) throw new HException('null iterable');
		$__hx__it = $table->fields->iterator();
		while($__hx__it->hasNext()) {
			unset($f);
			$f = $__hx__it->next();
			if($this->isBinary($f->type)) {
				$binary = true;
				break;
			}
		}
		$this->style->beginForm(_hx_string_or_null($table->className) . "/doEdit/" . _hx_string_or_null($id), $binary, $table->name);
		$rights = $this->getRights($obj, null);
		$hasBinary = false;
		if(null == $table->fields) throw new HException('null iterable');
		$__hx__it = $table->fields->iterator();
		while($__hx__it->hasNext()) {
			unset($f1);
			$f1 = $__hx__it->next();
			if($f1->name === $error) {
				$this->style->errorField((($errorMsg === null) ? "Invalid format" : $errorMsg));
				$errorMsg = null;
			}
			if($this->has($rights->invisible, $f1->name)) {
				continue;
			}
			$readonly = $this->has($rights->readOnly, $f1->name);
			$this->inputField($table, $f1, $id, $readonly, (($params === null) ? Reflect::field($obj, $f1->name) : $params->get($f1->name)), $params !== null);
			if(!$readonly && $this->isBinary($f1->type)) {
				$hasBinary = true;
			}
			unset($readonly);
		}
		if($rights->can->modify) {
			$this->style->addSubmit("Modify", null, null, null);
			if($hasBinary) {
				$this->style->addSubmit("Upload", null, null, "__upload");
			}
		}
		$this->style->addSubmit("Cancel", _hx_string_or_null($table->className) . "/edit/" . _hx_string_or_null($id), null, null);
		if($rights->can->delete) {
			$this->style->addSubmit("Delete", _hx_string_or_null($table->className) . "/doDelete/" . _hx_string_or_null($id), true, null);
		}
		$this->style->endForm();
		if($errorMsg !== null) {
			$this->style->error($errorMsg);
		}
		$this->style->end();
		$GLOBALS['%s']->pop();
	}
	public function doEdit($table, $id, $params) {
		$GLOBALS['%s']->push("sys.db.Admin::doEdit");
		$__hx__spos = $GLOBALS['%s']->length;
		$inst = $table->fromIdentifier($id);
		if($inst === null) {
			$this->style->redirect(_hx_string_or_null($table->className) . "/edit/" . _hx_string_or_null($id));
			{
				$GLOBALS['%s']->pop();
				return;
			}
		}
		$this->updateParams($table, $params);
		$rights = $this->getRights($inst, null);
		$binaries = new HList();
		if(null == $table->fields) throw new HException('null iterable');
		$__hx__it = $table->fields->iterator();
		while($__hx__it->hasNext()) {
			unset($f);
			$f = $__hx__it->next();
			if($this->has($rights->readOnly, $f->name) || $this->has($rights->invisible, $f->name)) {
				continue;
			}
			$v = $params->get($f->name);
			if($v === null) {
				if($table->nulls->exists($f->name)) {
					$inst->{$f->name} = null;
				}
				continue;
			}
			$msg = null;
			$v1 = null;
			try {
				$v1 = $this->updateField($f->name, $v, $f->type);
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$err = $_ex_;
				{
					$GLOBALS['%e'] = (new _hx_array(array()));
					while($GLOBALS['%s']->length >= $__hx__spos) {
						$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
					}
					$GLOBALS['%s']->push($GLOBALS['%e'][0]);
					$msg = $err;
					$v1 = null;
				}
			}
			if($v1 === null) {
				if($table->primary !== null) {
					if(null == $table->primary) throw new HException('null iterable');
					$__hx__it2 = $table->primary->iterator();
					while($__hx__it2->hasNext()) {
						unset($p);
						$p = $__hx__it2->next();
						$value = Reflect::field($inst, $p);
						$params->set($p, $value);
						unset($value);
					}
				}
				{
					$_g = 0;
					$_g1 = $rights->readOnly;
					while($_g < $_g1->length) {
						$f1 = $_g1[$_g];
						++$_g;
						$value1 = Reflect::field($inst, $f1);
						$params->set($f1, $value1);
						unset($value1,$f1);
					}
					unset($_g1,$_g);
				}
				$this->edit($table, $id, $params, $f->name, $msg);
				{
					$GLOBALS['%s']->pop();
					return;
				}
			}
			$bin = $this->isBinary($f->type);
			if(Std::is($v1, _hx_qtype("String")) && $v1 === "" && $bin) {
				continue;
			}
			$inst->{$f->name} = $v1;
			if($bin) {
				$binaries->add(_hx_anonymous(array("name" => $f->name, "value" => $v1)));
			}
			unset($v1,$v,$msg,$err,$bin);
		}
		try {
			if(!$rights->can->modify) {
				throw new HException("Can't modify");
			}
			if($params->exists("__upload")) {
				$this->request($table, $table->updateFields($inst, $binaries));
			} else {
				$inst->update();
				sys_db_Admin::log("Updated " . _hx_string_or_null($table->name) . " " . _hx_string_or_null($table->identifier($inst)));
			}
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				$this->edit($table, $id, $params, null, Std::string($e));
				{
					$GLOBALS['%s']->pop();
					return;
				}
			}
		}
		$this->style->redirect(_hx_string_or_null($table->className) . "/edit/" . _hx_string_or_null($table->identifier($inst)));
		$GLOBALS['%s']->pop();
	}
	public function updateParams($table, $params) {
		$GLOBALS['%s']->push("sys.db.Admin::updateParams");
		$__hx__spos = $GLOBALS['%s']->length;
		$tmp = php_Web::getMultipart($this->maxUploadSize);
		if(null == $tmp) throw new HException('null iterable');
		$__hx__it = $tmp->keys();
		while($__hx__it->hasNext()) {
			unset($k);
			$k = $__hx__it->next();
			$value = $tmp->get($k);
			$params->set($k, $value);
			unset($value);
		}
		{
			$_g = 0;
			$_g1 = $table->relations;
			while($_g < $_g1->length) {
				$r = $_g1[$_g];
				++$_g;
				$p = $params->get($r->prop);
				$params->remove($r->prop);
				if($p === null || $p === "") {
					continue;
				}
				$params->set($r->key, $p);
				$params->remove(_hx_string_or_null($r->prop) . "__data");
				$params->set(_hx_string_or_null($r->key) . "__data", "on");
				unset($r,$p);
			}
		}
		if(null == $table->fields) throw new HException('null iterable');
		$__hx__it = $table->fields->iterator();
		while($__hx__it->hasNext()) {
			unset($f);
			$f = $__hx__it->next();
			{
				$_g2 = $f->type;
				switch($_g2->index) {
				case 23:{
					$flags = _hx_deref($_g2)->params[0];
					{
						$vint = 0;
						{
							$_g21 = 0;
							$_g11 = $flags->length;
							while($_g21 < $_g11) {
								$i = $_g21++;
								if($params->exists(_hx_string_or_null($f->name) . "_" . _hx_string_or_null($flags[$i]))) {
									$vint |= 1 << $i;
								}
								unset($i);
							}
						}
						if($table->nulls->exists($f->name) && !$params->exists(_hx_string_or_null($f->name) . "__data") && $vint === 0) {
							$params->remove($f->name);
							continue 2;
						}
						$params->set($f->name, Std::string($vint));
						$params->set(_hx_string_or_null($f->name) . "__data", "true");
					}
				}break;
				default:{}break;
				}
				unset($_g2);
			}
			if($table->nulls->exists($f->name) && !$params->exists(_hx_string_or_null($f->name) . "__data") && ($params->get($f->name) === "" || $params->get($f->name) === null)) {
				$params->remove($f->name);
				continue;
			}
			if((is_object($_t = $f->type) && !($_t instanceof Enum) ? $_t === sys_db_RecordType::$DBool : $_t == sys_db_RecordType::$DBool)) {
				$v = $params->exists($f->name);
				$params->set($f->name, (($v) ? "true" : "false"));
				unset($v);
			}
			unset($_t);
		}
		$GLOBALS['%s']->pop();
	}
	public function doDelete($table, $id) {
		$GLOBALS['%s']->push("sys.db.Admin::doDelete");
		$__hx__spos = $GLOBALS['%s']->length;
		$inst = $table->fromIdentifier($id);
		if($inst === null) {
			$this->style->redirect(_hx_string_or_null($table->className) . "/edit/" . _hx_string_or_null($id));
			{
				$GLOBALS['%s']->pop();
				return;
			}
		}
		if(!$this->getRights($inst, null)->can->delete) {
			$this->edit($table, $id, null, null, "Can't Delete");
			{
				$GLOBALS['%s']->pop();
				return;
			}
		}
		$inst->delete();
		sys_db_Admin::log("Deleted " . _hx_string_or_null($table->name) . " " . _hx_string_or_null($id));
		$this->style->redirect("");
		$GLOBALS['%s']->pop();
	}
	public function doDownload($table, $id, $field) {
		$GLOBALS['%s']->push("sys.db.Admin::doDownload");
		$__hx__spos = $GLOBALS['%s']->length;
		$inst = $table->fromIdentifier($id);
		if($inst === null) {
			$this->style->redirect(_hx_string_or_null($table->className) . "/edit/" . _hx_string_or_null($id));
			{
				$GLOBALS['%s']->pop();
				return;
			}
		}
		$rights = $this->getRights($inst, null);
		$f = $table->hfields->get($field);
		$data = Reflect::field($inst, $field);
		if($this->has($rights->invisible, $field) || $data === null || !$this->isBinary($f)) {
			$this->edit($table, $id, null, null, "Can't Download data");
			{
				$GLOBALS['%s']->pop();
				return;
			}
		}
		header("Content-Type" . ": " . "text/binary");
		header("Content-Length" . ": " . Std::string(strlen($data)));
		Sys::hprint($data);
		$GLOBALS['%s']->pop();
	}
	public function search($table, $params) {
		$GLOBALS['%s']->push("sys.db.Admin::search");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->style->begin("Search " . _hx_string_or_null($table->name));
		$pagesize = 30;
		$page = Std::parseInt($params->get("__p"));
		$order = $params->get("__o");
		if($page === null) {
			$page = 0;
		}
		$params->remove("__p");
		$params->remove("__o");
		$paramsStr = "";
		if(null == $params) throw new HException('null iterable');
		$__hx__it = $params->keys();
		while($__hx__it->hasNext()) {
			unset($p);
			$p = $__hx__it->next();
			$v = $params->get($p);
			$paramsStr .= _hx_string_or_null($p) . "=" . _hx_string_or_null(rawurlencode($v)) . ";";
			unset($v);
		}
		if(null == $table->fields) throw new HException('null iterable');
		$__hx__it = $table->fields->iterator();
		while($__hx__it->hasNext()) {
			unset($f);
			$f = $__hx__it->next();
			{
				$_g = $f->type;
				switch($_g->index) {
				case 8:case 9:case 13:case 15:case 14:case 23:{
					$table->nulls->set($f->name, true);
				}break;
				default:{}break;
				}
				unset($_g);
			}
		}
		$this->updateParams($table, $params);
		if(null == $table->fields) throw new HException('null iterable');
		$__hx__it = $table->fields->iterator();
		while($__hx__it->hasNext()) {
			unset($f1);
			$f1 = $__hx__it->next();
			if(!$table->nulls->exists($f1->name) && $params->get($f1->name) === "") {
				$params->remove($f1->name);
			}
		}
		$rights = $this->getRights(null, $table);
		{
			$_g1 = 0;
			$_g11 = $rights->invisible;
			while($_g1 < $_g11->length) {
				$f2 = $_g11[$_g1];
				++$_g1;
				$params->remove($f2);
				unset($f2);
			}
		}
		$results = $table->fromSearch($params, $order, $page * $pagesize, $pagesize + 1);
		$hasNext = false;
		if($results->length > $pagesize) {
			$results->remove($results->last());
			$hasNext = true;
		}
		$sinfos = $this->getSInfos($this->createInstance($table));
		$fields = null;
		if($sinfos !== null && $sinfos->fields !== null) {
			$fields = $sinfos->fields;
		} else {
			$fields = new _hx_array(array());
			if(null == $table->fields) throw new HException('null iterable');
			$__hx__it = $table->fields->iterator();
			while($__hx__it->hasNext()) {
				unset($f3);
				$f3 = $__hx__it->next();
				$bad = false;
				{
					$_g2 = 0;
					$_g12 = $table->relations;
					while($_g2 < $_g12->length) {
						$r = $_g12[$_g2];
						++$_g2;
						if($r->key === $f3->name && $r->className === "db.File") {
							$bad = true;
							break;
						}
						unset($r);
					}
					unset($_g2,$_g12);
				}
				if($bad) {
					continue;
				}
				$fields->push($f3->name);
				unset($bad);
			}
		}
		$this->style->beginForm(_hx_string_or_null($table->className) . "/search", null, $table->name);
		{
			$_g3 = 0;
			while($_g3 < $fields->length) {
				$f4 = $fields[$_g3];
				++$_g3;
				$t = $table->hfields->get($f4);
				if($t === null) {
					continue;
				}
				$t1 = null;
				switch($t->index) {
				case 0:case 2:{
					$t1 = sys_db_RecordType::$DInt;
				}break;
				case 4:{
					$t1 = sys_db_RecordType::$DFloat;
				}break;
				case 15:case 14:{
					$t1 = sys_db_RecordType::$DTinyText;
				}break;
				default:{
					$t1 = $t;
				}break;
				}
				$this->inputField($table, _hx_anonymous(array("name" => $f4, "type" => $t1)), null, false, (($params === null) ? null : $params->get($f4)), null);
				unset($t1,$t,$f4);
			}
		}
		$this->style->addSubmit("Search", null, null, null);
		$this->style->endForm();
		$this->style->beginTable("results");
		$this->style->beginLine(true, "header");
		$this->style->text("actions", null);
		if($sinfos !== null && $sinfos->names !== null) {
			$_g4 = 0;
			$_g13 = $sinfos->names;
			while($_g4 < $_g13->length) {
				$f5 = $_g13[$_g4];
				++$_g4;
				$this->style->nextRow(true);
				if($table->hfields->exists($f5)) {
					$cur = $order === $f5;
					$curNeg = $order === "-" . _hx_string_or_null($f5);
					$this->style->link(_hx_string_or_null($table->className) . "/search?" . _hx_string_or_null($paramsStr) . "__o=" . _hx_string_or_null((sys_db_Admin_3($this, $_g13, $_g4, $cur, $curNeg, $f5, $fields, $hasNext, $order, $page, $pagesize, $params, $paramsStr, $results, $rights, $sinfos, $table))), _hx_string_or_null(((($cur) ? "+" : (($curNeg) ? "-" : "")))) . _hx_string_or_null($f5));
					unset($curNeg,$cur);
				} else {
					$this->style->text($f5, null);
				}
				unset($f5);
			}
		} else {
			if(null == $table->fields) throw new HException('null iterable');
			$__hx__it = $table->fields->iterator();
			while($__hx__it->hasNext()) {
				unset($f6);
				$f6 = $__hx__it->next();
				if($this->has($rights->invisible, $f6->name)) {
					continue;
				}
				$this->style->nextRow(true);
				$cur1 = $order === $f6->name;
				$curNeg1 = $order === "-" . _hx_string_or_null($f6->name);
				$this->style->link(_hx_string_or_null($table->className) . "/search?" . _hx_string_or_null($paramsStr) . "__o=" . _hx_string_or_null((sys_db_Admin_4($this, $cur1, $curNeg1, $f6, $fields, $hasNext, $order, $page, $pagesize, $params, $paramsStr, $results, $rights, $sinfos, $table))), _hx_string_or_null(((($cur1) ? "+" : (($curNeg1) ? "-" : "")))) . _hx_string_or_null($f6->name));
				unset($curNeg1,$cur1);
			}
		}
		$this->style->endLine();
		$odd = false;
		if(null == $results) throw new HException('null iterable');
		$__hx__it = $results->iterator();
		while($__hx__it->hasNext()) {
			unset($r1);
			$r1 = $__hx__it->next();
			$k = $table->fields->iterator();
			$this->style->beginLine(null, (($odd) ? "odd" : null));
			$this->style->link(_hx_string_or_null($table->className) . "/edit/" . _hx_string_or_null($table->identifier($r1)), "Edit");
			$odd = !$odd;
			if($sinfos !== null && $sinfos->names !== null) {
				$rinfos = $this->getSInfos($r1);
				{
					$_g5 = 0;
					$_g14 = $rinfos->values;
					while($_g5 < $_g14->length) {
						$v1 = $_g14[$_g5];
						++$_g5;
						$this->style->nextRow(false);
						$this->style->text(Std::string($v1), null);
						unset($v1);
					}
					unset($_g5,$_g14);
				}
				unset($rinfos);
			} else {
				$rinst = $this->getRights($r1, null);
				$__hx__it2 = $k;
				while($__hx__it2->hasNext()) {
					unset($f7);
					$f7 = $__hx__it2->next();
					if($this->has($rights->invisible, $f7->name)) {
						continue;
					}
					$data = Reflect::field($r1, $f7->name);
					$str = null;
					try {
						$str = Std::string($data);
					}catch(Exception $__hx__e) {
						$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
						$e = $_ex_;
						{
							$GLOBALS['%e'] = (new _hx_array(array()));
							while($GLOBALS['%s']->length >= $__hx__spos) {
								$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
							}
							$GLOBALS['%s']->push($GLOBALS['%e'][0]);
							if(!Std::is($data, _hx_qtype("Date"))) {
								php_Lib::rethrow($e);
							}
							$str = "#INVALID";
						}
					}
					if(strlen($str) >= 20) {
						$str = _hx_string_or_null(_hx_substr($str, 0, 17)) . "...";
					}
					$this->style->nextRow(false);
					if($this->has($rinst->invisible, $f7->name)) {
						$this->style->text("???", null);
					} else {
						if($data === null) {
							$this->style->text($str, null);
						} else {
							{
								$_g6 = $f7->type;
								switch($_g6->index) {
								case 20:{
									$this->style->text(sys_db_Id::decode($data), $str);
								}break;
								case 10:{
									$this->style->text(_hx_substr($str, 0, 10), null);
								}break;
								case 23:{
									$flags = _hx_deref($_g6)->params[0];
									{
										$fl = (new _hx_array(array()));
										{
											$_g21 = 0;
											$_g15 = $flags->length;
											while($_g21 < $_g15) {
												$i = $_g21++;
												if(($data & 1 << $i) !== 0) {
													$fl->push($flags[$i]);
												}
												unset($i);
											}
										}
										$str = $fl->join(",");
										if(strlen($str) >= 20) {
											$this->style->text(_hx_string_or_null(_hx_substr($str, 0, 17)) . "...", _hx_string_or_null($fl->join(",")) . " (" . _hx_string_rec($data, "") . ")");
										} else {
											$this->style->text($str, "(" . _hx_string_rec($data, "") . ")");
										}
									}
								}break;
								default:{
									$this->style->text($str, null);
								}break;
								}
								unset($_g6);
							}
						}
					}
					unset($str,$e,$data);
				}
				unset($rinst);
			}
			$this->style->endLine();
			unset($k);
		}
		$this->style->endTable();
		if($order !== null) {
			$paramsStr .= "__o=" . _hx_string_or_null($order) . ";";
		}
		if($page > 0) {
			$this->style->link(_hx_string_or_null($table->className) . "/search?" . _hx_string_or_null($paramsStr) . "__p=" . _hx_string_rec(($page - 1), ""), "Previous");
		} else {
			$this->style->text("Previous", null);
		}
		$this->style->text(" | ", null);
		if($hasNext) {
			$this->style->link(_hx_string_or_null($table->className) . "/search?" . _hx_string_or_null($paramsStr) . "__p=" . _hx_string_rec(($page + 1), ""), "Next");
		} else {
			$this->style->text("Next", null);
		}
		$this->style->end();
		$GLOBALS['%s']->pop();
	}
	public function syncAction($t, $act, $text, $def = null) {
		$GLOBALS['%s']->push("sys.db.Admin::syncAction");
		$__hx__spos = $GLOBALS['%s']->length;
		if(!$this->hasSyncAction) {
			$this->style->beginList();
			$this->hasSyncAction = true;
		}
		$this->style->beginItem();
		$this->style->checkBox(_hx_string_or_null($t->className) . "@" . _hx_string_or_null($act->join("@")), (($def === null) ? true : $def));
		$this->style->text($text, null);
		$this->style->endItem();
		$GLOBALS['%s']->pop();
	}
	public function doSync($params) {
		$GLOBALS['%s']->push("sys.db.Admin::doSync");
		$__hx__spos = $GLOBALS['%s']->length;
		$order = (new _hx_array(array("create", "add", "reldel", "idxdel", "update", "remove", "rename", "idxadd", "reladd")));
		$cmd = new _hx_array(array());
		if(null == $params) throw new HException('null iterable');
		$__hx__it = $params->keys();
		while($__hx__it->hasNext()) {
			unset($p);
			$p = $__hx__it->next();
			if(!_hx_deref(new EReg("[A-Za-z0-9_@]*", ""))->match($p)) {
				throw new HException("Invalid command " . _hx_string_or_null($p));
			}
			$cmd->push(_hx_explode("@", $p));
		}
		$cmd->sort(array(new _hx_lambda(array(&$cmd, &$order, &$params), "sys_db_Admin_5"), 'execute'));
		{
			$_g2 = 0;
			while($_g2 < $cmd->length) {
				$data = $cmd[$_g2];
				++$_g2;
				$tname = $data->shift();
				$tname = _hx_explode("_", $tname)->join(".");
				$table = new sys_db_TableInfos($tname);
				$act = $data->shift();
				$field = $data->shift();
				try {
					switch($act) {
					case "create":{
						$this->execute($table->createRequest(false));
					}break;
					case "add":{
						$this->execute($table->addFieldRequest($field));
					}break;
					case "update":{
						$this->execute($table->updateFieldRequest($field));
					}break;
					case "remove":{
						$this->execute($table->removeFieldRequest($field));
					}break;
					case "rename":{
						$this->execute($table->renameFieldRequest($field, $data->shift()));
					}break;
					case "reladd":{
						$this->execute($table->addRelationRequest($field, $data->shift()));
					}break;
					case "reldel":{
						$this->execute($table->deleteRelationRequest($field));
					}break;
					case "idxadd":{
						$this->execute($table->addIndexRequest($data, $field === "true"));
					}break;
					case "idxdel":{
						$this->execute($table->deleteIndexRequest($field));
					}break;
					default:{
						throw new HException("Unknown action " . _hx_string_or_null($act));
					}break;
					}
				}catch(Exception $__hx__e) {
					$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
					$e = $_ex_;
					{
						$GLOBALS['%e'] = (new _hx_array(array()));
						while($GLOBALS['%s']->length >= $__hx__spos) {
							$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
						}
						$GLOBALS['%s']->push($GLOBALS['%e'][0]);
						$this->index(Std::string($e));
						{
							$GLOBALS['%s']->pop();
							return;
						}
					}
				}
				unset($tname,$table,$field,$e,$data,$act);
			}
		}
		$this->style->redirect("");
		$GLOBALS['%s']->pop();
	}
	public function indexId($i) {
		$GLOBALS['%s']->push("sys.db.Admin::indexId");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = Std::string($i->unique) . "@" . _hx_string_or_null($i->keys->join("@"));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function needSync($t) {
		$GLOBALS['%s']->push("sys.db.Admin::needSync");
		$__hx__spos = $GLOBALS['%s']->length;
		$desc = $this->execute($t->descriptionRequest())->getResult(1);
		$inf = sys_db_TableInfos::fromDescription($desc);
		$renames = new haxe_ds_StringMap();
		$this->hasSyncAction = false;
		if(null == $t->fields) throw new HException('null iterable');
		$__hx__it = $t->fields->iterator();
		while($__hx__it->hasNext()) {
			unset($f);
			$f = $__hx__it->next();
			$t2 = $inf->fields->get($f->name);
			if($t2 === null) {
				$rename = false;
				if(null == $inf->fields) throw new HException('null iterable');
				$__hx__it2 = $inf->fields->keys();
				while($__hx__it2->hasNext()) {
					unset($n);
					$n = $__hx__it2->next();
					if(!$t->hfields->exists($n) && Type::enumEq($inf->fields->get($n), $f->type) && (is_object($_t = $inf->nulls->get($n)) && !($_t instanceof Enum) ? $_t === $t->nulls->get($f->name) : $_t == $t->nulls->get($f->name))) {
						$rename = true;
						$renames->set($n, true);
						$this->syncAction($t, (new _hx_array(array("rename", $n, $f->name))), "Rename field " . _hx_string_or_null($n) . " to " . _hx_string_or_null($f->name), null);
						break;
					}
					unset($_t);
				}
				$this->syncAction($t, (new _hx_array(array("add", $f->name))), "Add field " . _hx_string_or_null($f->name), !$rename);
				unset($rename);
			} else {
				$inf->fields->remove($f->name);
				$isnull = $inf->nulls->get($f->name);
				$changed = false;
				$txt = "Change " . _hx_string_or_null($f->name) . " : ";
				if(!Type::enumEq($f->type, $t2) && !sys_db_TableInfos::sameDBStorage($t2, $f->type)) {
					$changed = true;
					$txt .= " S" . _hx_string_or_null(_hx_substr(Std::string($t2), 1, null)) . " becomes S" . _hx_string_or_null(_hx_substr(Std::string($f->type), 1, null));
				}
				if($isnull !== $t->nulls->get($f->name)) {
					if($changed) {
						$txt .= " and";
					} else {
						$changed = true;
					}
					if($isnull) {
						$txt .= " can't be NULL";
					} else {
						$txt .= " can be NULL";
					}
				}
				if($changed) {
					$this->syncAction($t, (new _hx_array(array("update", $f->name))), $txt, null);
				}
				unset($txt,$isnull,$changed);
			}
			unset($t2);
		}
		if(null == $inf->fields) throw new HException('null iterable');
		$__hx__it = $inf->fields->keys();
		while($__hx__it->hasNext()) {
			unset($f1);
			$f1 = $__hx__it->next();
			$this->syncAction($t, (new _hx_array(array("remove", $f1))), "Remove field " . _hx_string_or_null($f1), !$renames->exists($f1));
		}
		{
			$_g = 0;
			$_g1 = $t->relations;
			while($_g < $_g1->length) {
				$r = $_g1[$_g];
				++$_g;
				if(!$t->isRelationActive($r)) {
					continue;
				}
				$tname = sys_db_TableInfos::unescape($r->manager->table_name);
				$found = false;
				$setnull = $t->nulls->get($r->key);
				if($setnull && $r->cascade === true) {
					$setnull = null;
				}
				{
					$_g2 = 0;
					$_g3 = $inf->relations;
					while($_g2 < $_g3->length) {
						$r2 = $_g3[$_g2];
						++$_g2;
						if((_hx_string_or_null($t->name) . "_" . _hx_string_or_null($r->prop) === $r2->name || sys_db_TableInfos::$OLD_COMPAT) && $r->key === $r2->key && strtolower($tname) === strtolower($r2->table) && $r->manager->table_keys->length === 1 && $r->manager->table_keys[0] === $r2->id && $r2->setnull === $setnull) {
							$found = true;
							$inf->relations->remove($r2);
							break;
						}
						unset($r2);
					}
					unset($_g3,$_g2);
				}
				if(!$found) {
					$this->syncAction($t, (new _hx_array(array("reladd", $r->key, $r->prop))), "Add Relation " . _hx_string_or_null($r->prop) . "(" . _hx_string_or_null($r->key) . ") on " . _hx_string_or_null($tname) . "(" . _hx_string_or_null($r->manager->table_keys[0]) . ")" . _hx_string_or_null(((($setnull) ? " set-null" : ""))), null);
				}
				unset($tname,$setnull,$r,$found);
			}
		}
		{
			$_g4 = 0;
			$_g11 = $inf->relations;
			while($_g4 < $_g11->length) {
				$r1 = $_g11[$_g4];
				++$_g4;
				$this->syncAction($t, (new _hx_array(array("reldel", $r1->name))), "Remove Relation " . _hx_string_or_null($r1->name) . "(" . _hx_string_or_null($r1->key) . ") on " . _hx_string_or_null($r1->table) . "(" . _hx_string_or_null($r1->id) . ")" . _hx_string_or_null(((($r1->setnull) ? " set-null" : ""))), null);
				unset($r1);
			}
		}
		$hidx = new haxe_ds_StringMap();
		if(null == $t->indexes) throw new HException('null iterable');
		$__hx__it = $t->indexes->iterator();
		while($__hx__it->hasNext()) {
			unset($i);
			$i = $__hx__it->next();
			$key = $this->indexId($i);
			$hidx->set($key, $i);
			unset($key);
		}
		$used = new HList();
		{
			$_g5 = 0;
			$_g12 = $t->relations;
			while($_g5 < $_g12->length) {
				$r3 = $_g12[$_g5];
				++$_g5;
				$found1 = null;
				if(null == $t->indexes) throw new HException('null iterable');
				$__hx__it = $t->indexes->iterator();
				while($__hx__it->hasNext()) {
					unset($i1);
					$i1 = $__hx__it->next();
					if($i1->keys->first() === $r3->key && ($found1 === null || $found1->keys->length < $i1->keys->length)) {
						$found1 = $i1;
					}
				}
				if($found1 === null) {
					if($t->primary->first() === $r3->key) {
						continue;
					}
					$found1 = _hx_anonymous(array("keys" => Lambda::hlist((new _hx_array(array($r3->key)))), "unique" => false));
				}
				{
					$key1 = $this->indexId($found1);
					$hidx->remove($key1);
					unset($key1);
				}
				if(null == $inf->indexes) throw new HException('null iterable');
				$__hx__it = $inf->indexes->iterator();
				while($__hx__it->hasNext()) {
					unset($i2);
					$i2 = $__hx__it->next();
					if($i2->keys->join("#") === $found1->keys->join("#") && (is_object($_t = $i2->unique) && !($_t instanceof Enum) ? $_t === $found1->unique : $_t == $found1->unique)) {
						$used->add($i2);
						$found1 = null;
						break;
					}
					unset($_t);
				}
				if($found1 !== null) {
					$key2 = $this->indexId($found1);
					$hidx->set($key2, $found1);
					unset($key2);
				}
				unset($r3,$found1);
			}
		}
		if(null == $used) throw new HException('null iterable');
		$__hx__it = $used->iterator();
		while($__hx__it->hasNext()) {
			unset($i3);
			$i3 = $__hx__it->next();
			$inf->indexes->remove($i3->name);
		}
		if(null == $inf->indexes) throw new HException('null iterable');
		$__hx__it = $inf->indexes->keys();
		while($__hx__it->hasNext()) {
			unset($iname);
			$iname = $__hx__it->next();
			$i4 = $inf->indexes->get($iname);
			if(!sys_db_Admin_6($this, $desc, $hidx, $i4, $iname, $inf, $renames, $t, $used)) {
				$this->syncAction($t, (new _hx_array(array("idxdel", $iname))), "Remove " . _hx_string_or_null(((($i4->unique) ? "Unique " : ""))) . "Index " . _hx_string_or_null($iname) . " (" . _hx_string_or_null($i4->keys->join(",")) . ")", null);
			}
			unset($i4);
		}
		if(null == $hidx) throw new HException('null iterable');
		$__hx__it = $hidx->iterator();
		while($__hx__it->hasNext()) {
			unset($i5);
			$i5 = $__hx__it->next();
			$this->syncAction($t, (new _hx_array(array("idxadd", $this->indexId($i5)))), "Add " . _hx_string_or_null(((($i5->unique) ? "Unique " : ""))) . "Index (" . _hx_string_or_null($i5->keys->join(",")) . ")", null);
		}
		if((is_object($_t = ($inf->primary === null)) && !($_t instanceof Enum) ? $_t !== ($t->primary === null) : $_t != ($t->primary === null)) || $inf->primary !== null && $inf->primary->join("-") !== $t->primary->join("-")) {
			$this->style->text("PRIMARY KEY CHANGED !", null);
			$this->hasSyncAction = true;
		}
		if($this->hasSyncAction) {
			$this->style->endList();
		}
		{
			$tmp = $this->hasSyncAction;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function process($url = null) {
		$GLOBALS['%s']->push("sys.db.Admin::process");
		$__hx__spos = $GLOBALS['%s']->length;
		if($url === null) {
			$url = _hx_explode("/", php_Web::getURI());
			$url->shift();
			$url->shift();
			if($url[0] === "index.n") {
				$url->shift();
			}
		}
		if($url->length === 0) {
			$url->push("");
		}
		$params = php_Web::getParams();
		{
			$_g = $url[0];
			switch($_g) {
			case "":{
				$this->style = new sys_db_AdminStyle(null);
				$this->index(null);
				{
					$GLOBALS['%s']->pop();
					return;
				}
			}break;
			case "doSync":{
				$this->style = new sys_db_AdminStyle(null);
				$this->doSync($params);
				{
					$GLOBALS['%s']->pop();
					return;
				}
			}break;
			}
		}
		$table = new sys_db_TableInfos($url->shift());
		$this->style = new sys_db_AdminStyle($table);
		$act = $url->shift();
		switch($act) {
		case "insert":{
			$this->insert($table, $params, null, null);
		}break;
		case "doInsert":{
			$this->doInsert($table, $params);
		}break;
		case "edit":{
			$this->edit($table, $url->join("/"), null, null, null);
		}break;
		case "doEdit":{
			$this->doEdit($table, $url->join("/"), $params);
		}break;
		case "doCreate":{
			$this->doCreate($table);
		}break;
		case "doDrop":{
			$this->doDrop($table);
		}break;
		case "doCleanup":{
			$this->doCleanup($table);
		}break;
		case "doDelete":{
			$this->doDelete($table, $url->join("/"));
		}break;
		case "doDownload":{
			$this->doDownload($table, $url->shift(), $url->shift());
		}break;
		case "search":{
			$this->search($table, $params);
		}break;
		default:{
			throw new HException("Unknown action " . _hx_string_or_null($act));
		}break;
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
	static function log($msg) {
		$GLOBALS['%s']->push("sys.db.Admin::log");
		$__hx__spos = $GLOBALS['%s']->length;
		$GLOBALS['%s']->pop();
	}
	static function handler() {
		$GLOBALS['%s']->push("sys.db.Admin::handler");
		$__hx__spos = $GLOBALS['%s']->length;
		sys_db_Manager::initialize();
		try {
			_hx_deref(new sys_db_Admin())->process(null);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				sys_db_Manager::$cnx->rollback();
				Sys::hprint("<pre>");
				Sys::hprint(Std::string($e));
				Sys::hprint(haxe_CallStack::toString(haxe_CallStack::exceptionStack()));
				Sys::hprint("</pre>");
			}
		}
		$GLOBALS['%s']->pop();
	}
	static function initializeDatabase($initIndexes = null, $initRelations = null) {
		$GLOBALS['%s']->push("sys.db.Admin::initializeDatabase");
		$__hx__spos = $GLOBALS['%s']->length;
		if($initRelations === null) {
			$initRelations = true;
		}
		if($initIndexes === null) {
			$initIndexes = true;
		}
		$a = new sys_db_Admin();
		$tables = $a->getTables();
		{
			$_g = 0;
			while($_g < $tables->length) {
				$t = $tables[$_g];
				++$_g;
				$a->execute($t->createRequest(false));
				unset($t);
			}
		}
		{
			$_g1 = 0;
			while($_g1 < $tables->length) {
				$t1 = $tables[$_g1];
				++$_g1;
				if($initIndexes) {
					if(null == $t1->indexes) throw new HException('null iterable');
					$__hx__it = $t1->indexes->iterator();
					while($__hx__it->hasNext()) {
						unset($i);
						$i = $__hx__it->next();
						$a->execute($t1->addIndexRequest(Lambda::harray($i->keys), $i->unique));
					}
				}
				if($initRelations) {
					$_g11 = 0;
					$_g2 = $t1->relations;
					while($_g11 < $_g2->length) {
						$r = $_g2[$_g11];
						++$_g11;
						$a->execute($t1->addRelationRequest($r->key, $r->prop));
						unset($r);
					}
					unset($_g2,$_g11);
				}
				unset($t1);
			}
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'sys.db.Admin'; }
}
function sys_db_Admin_0(&$classes, &$tables, $t1, $t2) {
	{
		$GLOBALS['%s']->push("sys.db.Admin::getTables@93");
		$__hx__spos2 = $GLOBALS['%s']->length;
		if((strcmp($t1->name, $t2->name)> 0)) {
			$GLOBALS['%s']->pop();
			return 1;
		} else {
			if((strcmp($t1->name, $t2->name)< 0)) {
				$GLOBALS['%s']->pop();
				return -1;
			} else {
				$GLOBALS['%s']->pop();
				return 0;
			}
		}
		$GLOBALS['%s']->pop();
	}
}
function sys_db_Admin_1(&$_g, &$_g1, &$defval, &$f, &$id, &$insert, &$prim, &$r, &$rawValue, &$readonly, &$table, &$values, $d) {
	{
		$GLOBALS['%s']->push("sys.db.Admin::inputField@205");
		$__hx__spos2 = $GLOBALS['%s']->length;
		{
			$tmp = _hx_anonymous(array("id" => Std::string(Reflect::field($d, $r->manager->table_keys[0])), "str" => $d->toString()));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function sys_db_Admin_2(&$__hx__this, &$defval, &$f, &$id, &$insert, &$prim, &$rawValue, &$readonly, &$table) {
	if($insert) {
		return null;
	} else {
		return array(new _hx_lambda(array(&$defval, &$f, &$id, &$insert, &$prim, &$rawValue, &$readonly, &$table), "sys_db_Admin_7"), 'execute');
	}
}
function sys_db_Admin_3(&$__hx__this, &$_g13, &$_g4, &$cur, &$curNeg, &$f5, &$fields, &$hasNext, &$order, &$page, &$pagesize, &$params, &$paramsStr, &$results, &$rights, &$sinfos, &$table) {
	if($cur) {
		return "-" . _hx_string_or_null($f5);
	} else {
		return $f5;
	}
}
function sys_db_Admin_4(&$__hx__this, &$cur1, &$curNeg1, &$f6, &$fields, &$hasNext, &$order, &$page, &$pagesize, &$params, &$paramsStr, &$results, &$rights, &$sinfos, &$table) {
	if($cur1) {
		return "-" . _hx_string_or_null($f6->name);
	} else {
		return $f6->name;
	}
}
function sys_db_Admin_5(&$cmd, &$order, &$params, $c1, $c2) {
	{
		$GLOBALS['%s']->push("sys.db.Admin::doSync@864");
		$__hx__spos2 = $GLOBALS['%s']->length;
		$p1 = 0;
		$p2 = 0;
		{
			$_g1 = 0;
			$_g = $order->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if($order[$i] === $c1[1]) {
					$p1 = $i;
				} else {
					if($order[$i] === $c2[1]) {
						$p2 = $i;
					}
				}
				unset($i);
			}
		}
		{
			$tmp = $p1 - $p2;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function sys_db_Admin_6(&$__hx__this, &$desc, &$hidx, &$i4, &$iname, &$inf, &$renames, &$t, &$used) {
	{
		$key3 = $__hx__this->indexId($i4);
		return $hidx->remove($key3);
	}
}
function sys_db_Admin_7(&$defval, &$f, &$id, &$insert, &$prim, &$rawValue, &$readonly, &$table) {
	{
		$GLOBALS['%s']->push("sys.db.Admin::initializeDatabase@243");
		$__hx__spos2 = $GLOBALS['%s']->length;
		{
			$tmp = _hx_string_or_null($table->name) . "/doDownload/" . _hx_string_or_null($id) . "/" . _hx_string_or_null($f->name);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
