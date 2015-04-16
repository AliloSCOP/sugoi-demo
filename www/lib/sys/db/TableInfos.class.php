<?php

class sys_db_TableInfos {
	public function __construct($cname) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sys.db.TableInfos::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->hfields = new haxe_ds_StringMap();
		$this->fields = new HList();
		$this->nulls = new haxe_ds_StringMap();
		$this->cl = Type::resolveClass("db." . _hx_string_or_null($cname));
		if($this->cl === null) {
			$this->cl = Type::resolveClass($cname);
		} else {
			$cname = "db." . _hx_string_or_null($cname);
		}
		if($this->cl === null) {
			throw new HException("Class not found : " . _hx_string_or_null($cname));
		}
		$this->manager = $this->cl->manager;
		if($this->manager === null) {
			throw new HException("No static manager for " . _hx_string_or_null($cname));
		}
		$this->className = $cname;
		if(_hx_substr($this->className, 0, 3) === "db.") {
			$this->className = _hx_substr($this->className, 3, null);
		}
		$a = _hx_explode(".", $cname);
		$this->name = $a->pop();
		$this->processClass();
		$GLOBALS['%s']->pop();
	}}
	public $primary;
	public $cl;
	public $name;
	public $className;
	public $hfields;
	public $fields;
	public $nulls;
	public $relations;
	public $indexes;
	public $manager;
	public function processClass() {
		$GLOBALS['%s']->push("sys.db.TableInfos::processClass");
		$__hx__spos = $GLOBALS['%s']->length;
		$rtti = haxe_rtti_Meta::getType($this->cl)->rtti;
		if($rtti === null) {
			throw new HException("Class " . _hx_string_or_null($this->name) . " does not have RTTI");
		}
		$infos = haxe_Unserializer::run($rtti[0]);
		$this->name = $infos->name;
		$this->primary = Lambda::hlist($infos->key);
		{
			$_g = 0;
			$_g1 = $infos->fields;
			while($_g < $_g1->length) {
				$f = $_g1[$_g];
				++$_g;
				$this->fields->add(_hx_anonymous(array("name" => $f->name, "type" => $f->t)));
				$this->hfields->set($f->name, $f->t);
				if($f->isNull) {
					$this->nulls->set($f->name, true);
				}
				unset($f);
			}
		}
		$this->relations = new _hx_array(array());
		{
			$_g2 = 0;
			$_g11 = $infos->relations;
			while($_g2 < $_g11->length) {
				$r = $_g11[$_g2];
				++$_g2;
				$t = Type::resolveClass($r->type);
				if($t === null) {
					throw new HException("Missing type " . _hx_string_or_null($r->type) . " for relation " . _hx_string_or_null($this->name) . "." . _hx_string_or_null($r->prop));
				}
				$manager = Reflect::field($t, "manager");
				if($manager === null) {
					throw new HException(_hx_string_or_null($r->type) . " does not have a static field manager");
				}
				$this->relations->push(_hx_anonymous(array("prop" => $r->prop, "key" => $r->key, "lock" => $r->lock, "manager" => $manager, "className" => Type::getClassName($manager->dbClass()), "cascade" => $r->cascade)));
				unset($t,$r,$manager);
			}
		}
		$this->indexes = new HList();
		{
			$_g3 = 0;
			$_g12 = $infos->indexes;
			while($_g3 < $_g12->length) {
				$i = $_g12[$_g3];
				++$_g3;
				$this->indexes->push(_hx_anonymous(array("keys" => Lambda::hlist($i->keys), "unique" => $i->unique)));
				unset($i);
			}
		}
		$GLOBALS['%s']->pop();
	}
	public function escape($name) {
		$GLOBALS['%s']->push("sys.db.TableInfos::escape");
		$__hx__spos = $GLOBALS['%s']->length;
		$m = $this->manager;
		{
			$tmp = $m->quoteField($name);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function isRelationActive($r) {
		$GLOBALS['%s']->push("sys.db.TableInfos::isRelationActive");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return true;
		}
		$GLOBALS['%s']->pop();
	}
	public function createRequest($full) {
		$GLOBALS['%s']->push("sys.db.TableInfos::createRequest");
		$__hx__spos = $GLOBALS['%s']->length;
		$str = "CREATE TABLE " . _hx_string_or_null($this->escape($this->name)) . " (\x0A";
		$keys = $this->fields->iterator();
		$__hx__it = $keys;
		while($__hx__it->hasNext()) {
			unset($f);
			$f = $__hx__it->next();
			$str .= _hx_string_or_null($this->escape($f->name)) . " " . _hx_string_or_null($this->fieldInfos($f));
			if($keys->hasNext()) {
				$str .= ",";
			}
			$str .= "\x0A";
		}
		if($this->primary !== null) {
			$str .= ", PRIMARY KEY (" . _hx_string_or_null($this->primary->map((isset($this->escape) ? $this->escape: array($this, "escape")))->join(",")) . ")\x0A";
		}
		if($full) {
			{
				$_g = 0;
				$_g1 = $this->relations;
				while($_g < $_g1->length) {
					$r = $_g1[$_g];
					++$_g;
					if($this->isRelationActive($r)) {
						$str .= ", " . _hx_string_or_null($this->relationInfos($r));
					}
					unset($r);
				}
			}
			if(null == $this->indexes) throw new HException('null iterable');
			$__hx__it = $this->indexes->iterator();
			while($__hx__it->hasNext()) {
				unset($i);
				$i = $__hx__it->next();
				$str .= ", " . _hx_string_or_null(((($i->unique) ? "UNIQUE " : ""))) . "KEY " . _hx_string_or_null($this->escape(_hx_string_or_null($this->name) . "_" . _hx_string_or_null($i->keys->join("_")))) . "(" . _hx_string_or_null($i->keys->map((isset($this->escape) ? $this->escape: array($this, "escape")))->join(",")) . ")\x0A";
			}
		}
		$str .= ")";
		if(sys_db_TableInfos::$ENGINE !== null) {
			$str .= " ENGINE=" . _hx_string_or_null(sys_db_TableInfos::$ENGINE);
		}
		{
			$GLOBALS['%s']->pop();
			return $str;
		}
		$GLOBALS['%s']->pop();
	}
	public function relationInfos($r) {
		$GLOBALS['%s']->push("sys.db.TableInfos::relationInfos");
		$__hx__spos = $GLOBALS['%s']->length;
		if($r->manager->table_keys->length !== 1) {
			throw new HException("Relation on a multiple-keys table");
		}
		$rq = "CONSTRAINT " . _hx_string_or_null($this->escape(_hx_string_or_null($this->name) . "_" . _hx_string_or_null($r->prop))) . " FOREIGN KEY (" . _hx_string_or_null($this->escape($r->key)) . ") REFERENCES " . _hx_string_or_null($this->escape($r->manager->table_name)) . "(" . _hx_string_or_null($this->escape($r->manager->table_keys[0])) . ") ";
		$rq .= "ON DELETE " . _hx_string_or_null(((($this->nulls->get($r->key) && $r->cascade !== true) ? "SET NULL" : "CASCADE"))) . "\x0A";
		{
			$GLOBALS['%s']->pop();
			return $rq;
		}
		$GLOBALS['%s']->pop();
	}
	public function fieldInfos($f) {
		$GLOBALS['%s']->push("sys.db.TableInfos::fieldInfos");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = _hx_string_or_null(sys_db_TableInfos_0($this, $f)) . _hx_string_or_null(((($this->nulls->exists($f->name)) ? "" : " NOT NULL")));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function dropRequest() {
		$GLOBALS['%s']->push("sys.db.TableInfos::dropRequest");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = "DROP TABLE " . _hx_string_or_null($this->escape($this->name));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function truncateRequest() {
		$GLOBALS['%s']->push("sys.db.TableInfos::truncateRequest");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = "TRUNCATE TABLE " . _hx_string_or_null($this->escape($this->name));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function descriptionRequest() {
		$GLOBALS['%s']->push("sys.db.TableInfos::descriptionRequest");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = "SHOW CREATE TABLE " . _hx_string_or_null($this->escape($this->name));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function existsRequest() {
		$GLOBALS['%s']->push("sys.db.TableInfos::existsRequest");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = "SELECT * FROM " . _hx_string_or_null($this->escape($this->name)) . " LIMIT 0";
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function addFieldRequest($fname) {
		$GLOBALS['%s']->push("sys.db.TableInfos::addFieldRequest");
		$__hx__spos = $GLOBALS['%s']->length;
		$ftype = $this->hfields->get($fname);
		if($ftype === null) {
			throw new HException("No field " . _hx_string_or_null($fname));
		}
		$rq = "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " ADD ";
		{
			$tmp = _hx_string_or_null($rq) . _hx_string_or_null($this->escape($fname)) . " " . _hx_string_or_null($this->fieldInfos(_hx_anonymous(array("name" => $fname, "type" => $ftype))));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function removeFieldRequest($fname) {
		$GLOBALS['%s']->push("sys.db.TableInfos::removeFieldRequest");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " DROP " . _hx_string_or_null($this->escape($fname));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function renameFieldRequest($old, $newname) {
		$GLOBALS['%s']->push("sys.db.TableInfos::renameFieldRequest");
		$__hx__spos = $GLOBALS['%s']->length;
		$ftype = $this->hfields->get($newname);
		if($ftype === null) {
			throw new HException("No field " . _hx_string_or_null($newname));
		}
		$rq = "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " CHANGE " . _hx_string_or_null($this->escape($old)) . " ";
		{
			$tmp = _hx_string_or_null($rq) . _hx_string_or_null($this->escape($newname)) . " " . _hx_string_or_null($this->fieldInfos(_hx_anonymous(array("name" => $newname, "type" => $ftype))));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function updateFieldRequest($fname) {
		$GLOBALS['%s']->push("sys.db.TableInfos::updateFieldRequest");
		$__hx__spos = $GLOBALS['%s']->length;
		$ftype = $this->hfields->get($fname);
		if($ftype === null) {
			throw new HException("No field " . _hx_string_or_null($fname));
		}
		$rq = "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " MODIFY ";
		{
			$tmp = _hx_string_or_null($rq) . _hx_string_or_null($this->escape($fname)) . " " . _hx_string_or_null($this->fieldInfos(_hx_anonymous(array("name" => $fname, "type" => $ftype))));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function addRelationRequest($key, $prop) {
		$GLOBALS['%s']->push("sys.db.TableInfos::addRelationRequest");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$_g = 0;
			$_g1 = $this->relations;
			while($_g < $_g1->length) {
				$r = $_g1[$_g];
				++$_g;
				if($r->key === $key && $r->prop === $prop) {
					$tmp = "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " ADD " . _hx_string_or_null($this->relationInfos($r));
					$GLOBALS['%s']->pop();
					return $tmp;
					unset($tmp);
				}
				unset($r);
			}
		}
		throw new HException("No such relation : " . _hx_string_or_null($prop) . "(" . _hx_string_or_null($key) . ")");
		$GLOBALS['%s']->pop();
	}
	public function deleteRelationRequest($rel) {
		$GLOBALS['%s']->push("sys.db.TableInfos::deleteRelationRequest");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " DROP FOREIGN KEY " . _hx_string_or_null($this->escape($rel));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function indexName($idx) {
		$GLOBALS['%s']->push("sys.db.TableInfos::indexName");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = _hx_string_or_null($this->name) . "_" . _hx_string_or_null($idx->join("_"));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function addIndexRequest($idx, $unique) {
		$GLOBALS['%s']->push("sys.db.TableInfos::addIndexRequest");
		$__hx__spos = $GLOBALS['%s']->length;
		$eidx = new _hx_array(array());
		{
			$_g = 0;
			while($_g < $idx->length) {
				$i = $idx[$_g];
				++$_g;
				$k = $this->escape($i);
				$f = $this->hfields->get($i);
				if($f !== null) {
					switch($f->index) {
					case 13:case 14:case 15:case 16:case 17:case 18:{
						$k .= "(4)";
					}break;
					default:{}break;
					}
				}
				$eidx->push($k);
				unset($k,$i,$f);
			}
		}
		{
			$tmp = "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " ADD " . _hx_string_or_null(((($unique) ? "UNIQUE " : ""))) . "INDEX " . _hx_string_or_null($this->escape($this->indexName($idx))) . "(" . _hx_string_or_null($eidx->join(",")) . ")";
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function deleteIndexRequest($idx) {
		$GLOBALS['%s']->push("sys.db.TableInfos::deleteIndexRequest");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " DROP INDEX " . _hx_string_or_null($this->escape($idx));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function updateFields($o, $fields) {
		$GLOBALS['%s']->push("sys.db.TableInfos::updateFields");
		$__hx__spos = $GLOBALS['%s']->length;
		$me = $this;
		$s = new StringBuf();
		$s->add("UPDATE ");
		$s->add($this->escape($this->name));
		$s->add(" SET ");
		$first = true;
		if(null == $fields) throw new HException('null iterable');
		$__hx__it = $fields->iterator();
		while($__hx__it->hasNext()) {
			unset($f);
			$f = $__hx__it->next();
			if($first) {
				$first = false;
			} else {
				$s->add(", ");
			}
			$s->add($this->escape($f->name));
			$s->add(" = ");
			sys_db_Manager::$cnx->addValue($s, $f->value);
		}
		$s->add(" WHERE ");
		$m = $this->manager;
		$m->addKeys($s, $o);
		{
			$tmp = $s->b;
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function identifier($o) {
		$GLOBALS['%s']->push("sys.db.TableInfos::identifier");
		$__hx__spos = $GLOBALS['%s']->length;
		if($this->primary === null) {
			throw new HException("No primary key");
		}
		{
			$tmp = $this->primary->map(array(new _hx_lambda(array(&$o), "sys_db_TableInfos_1"), 'execute'))->join("@");
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function fromIdentifier($id) {
		$GLOBALS['%s']->push("sys.db.TableInfos::fromIdentifier");
		$__hx__spos = $GLOBALS['%s']->length;
		$ids = _hx_explode("@", $id);
		if($this->primary === null) {
			throw new HException("No primary key");
		}
		if($ids->length !== $this->primary->length) {
			throw new HException("Invalid identifier");
		}
		$keys = _hx_anonymous(array());
		if(null == $this->primary) throw new HException('null iterable');
		$__hx__it = $this->primary->iterator();
		while($__hx__it->hasNext()) {
			unset($p);
			$p = $__hx__it->next();
			$value = $this->makeNativeValue($this->hfields->get($p), _hx_explode("~", $ids->shift())->join("."));
			$keys->{$p} = $value;
			unset($value);
		}
		{
			$tmp = $this->manager->unsafeGetWithKeys($keys, null);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function makeNativeValue($t, $v) {
		$GLOBALS['%s']->push("sys.db.TableInfos::makeNativeValue");
		$__hx__spos = $GLOBALS['%s']->length;
		switch($t->index) {
		case 1:case 3:case 0:case 2:case 20:case 23:case 24:{
			$tmp = Std::parseInt($v);
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		case 25:case 26:case 27:case 29:case 28:{
			$tmp = Std::parseInt($v);
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		case 7:case 6:case 5:case 4:{
			$tmp = Std::parseFloat($v);
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		case 10:case 11:case 12:{
			$tmp = Date::fromString($v);
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		case 8:{
			$tmp = $v === "true";
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		case 15:case 9:case 14:case 13:case 18:case 16:case 17:case 21:case 22:case 19:{
			$tmp = $v;
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		case 30:{
			$tmp = $v;
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		case 31:{
			$tmp = $v;
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		case 33:case 32:{
			throw new HException("assert");
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	public function fromSearch($params, $order, $pos, $count) {
		$GLOBALS['%s']->push("sys.db.TableInfos::fromSearch");
		$__hx__spos = $GLOBALS['%s']->length;
		$rop = new EReg("^([<>]=?)(.+)\$", "");
		$cond = "TRUE";
		$m = $this->manager;
		if(null == $params) throw new HException('null iterable');
		$__hx__it = $params->keys();
		while($__hx__it->hasNext()) {
			unset($p);
			$p = $__hx__it->next();
			$f = $this->hfields->get($p);
			$v = $params->get($p);
			if($f === null) {
				continue;
			}
			$cond .= " AND " . _hx_string_or_null($this->escape($p));
			if($v === null || $v === "NULL") {
				$cond .= " IS NULL";
			} else {
				switch($f->index) {
				case 20:{
					$cond .= " = " . _hx_string_rec(sys_db_TableInfos_2($this, $cond, $count, $f, $m, $order, $p, $params, $pos, $rop, $v), "");
				}break;
				case 9:case 13:case 14:case 15:{
					$cond .= " LIKE " . _hx_string_or_null($m->quote($v));
				}break;
				case 8:{
					$cond .= " = " . _hx_string_rec(((($v === "true") ? 1 : 0)), "");
				}break;
				case 0:case 2:case 1:case 3:case 6:case 7:case 10:case 11:case 5:case 4:{
					if($rop->match($v)) {
						$cond .= " " . _hx_string_or_null($rop->matched(1)) . " " . _hx_string_or_null($m->quote($rop->matched(2)));
					} else {
						$cond .= " = " . _hx_string_or_null($m->quote($v));
					}
				}break;
				default:{
					$cond .= " = " . _hx_string_or_null($m->quote($v));
				}break;
				}
			}
			unset($v,$f);
		}
		if($order !== null) {
			if(_hx_char_at($order, 0) === "-") {
				$cond .= " ORDER BY " . _hx_string_or_null($this->escape(_hx_substr($order, 1, null))) . " DESC";
			} else {
				$cond .= " ORDER BY " . _hx_string_or_null($this->escape($order));
			}
		}
		$sql = "SELECT * FROM " . _hx_string_or_null($this->escape($this->name)) . " WHERE " . _hx_string_or_null($cond) . " LIMIT " . _hx_string_rec($pos, "") . "," . _hx_string_rec($count, "");
		{
			$tmp = $this->manager->unsafeObjects($sql, false);
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
	static $ENGINE = "InnoDB";
	static $OLD_COMPAT = false;
	static function unescape($field) {
		$GLOBALS['%s']->push("sys.db.TableInfos::unescape");
		$__hx__spos = $GLOBALS['%s']->length;
		if(strlen($field) > 1 && _hx_char_at($field, 0) === "`" && _hx_char_at($field, strlen($field) - 1) === "`") {
			$tmp = _hx_substr($field, 1, strlen($field) - 2);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		{
			$GLOBALS['%s']->pop();
			return $field;
		}
		$GLOBALS['%s']->pop();
	}
	static function countRequest($m, $max) {
		$GLOBALS['%s']->push("sys.db.TableInfos::countRequest");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = "SELECT " . _hx_string_or_null($m->quoteField($m->table_keys[0])) . " FROM " . _hx_string_or_null($m->quoteField($m->table_name)) . " LIMIT " . _hx_string_rec($max, "");
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function fromTypeDescription($desc) {
		$GLOBALS['%s']->push("sys.db.TableInfos::fromTypeDescription");
		$__hx__spos = $GLOBALS['%s']->length;
		$fdesc = _hx_explode(" ", strtoupper($desc));
		$ftype = $fdesc->shift();
		$tparam = new EReg("^([A-Za-z]+)\\(([0-9]+)\\)\$", "");
		$param = null;
		if($tparam->match($ftype)) {
			$ftype = $tparam->matched(1);
			$param = Std::parseInt($tparam->matched(2));
		}
		$nullable = true;
		$t = null;
		switch($ftype) {
		case "VARCHAR":case "CHAR":{
			if($param === null) {
				$t = null;
			} else {
				$t = sys_db_RecordType::DString($param);
			}
		}break;
		case "INT":{
			if($param === 11 && $fdesc->remove("AUTO_INCREMENT")) {
				$t = sys_db_RecordType::$DId;
			} else {
				if($param === 10 && $fdesc->remove("UNSIGNED")) {
					if($fdesc->remove("AUTO_INCREMENT")) {
						$t = sys_db_RecordType::$DUId;
					} else {
						$t = sys_db_RecordType::$DUInt;
					}
				} else {
					if($param === 11) {
						$t = sys_db_RecordType::$DInt;
					} else {
						$t = null;
					}
				}
			}
		}break;
		case "BIGINT":{
			if($fdesc->remove("AUTO_INCREMENT")) {
				$t = sys_db_RecordType::$DBigId;
			} else {
				$t = sys_db_RecordType::$DBigInt;
			}
		}break;
		case "DOUBLE":{
			$t = sys_db_RecordType::$DFloat;
		}break;
		case "FLOAT":{
			$t = sys_db_RecordType::$DSingle;
		}break;
		case "DATE":{
			$t = sys_db_RecordType::$DDate;
		}break;
		case "DATETIME":{
			$t = sys_db_RecordType::$DDateTime;
		}break;
		case "TIMESTAMP":{
			$t = sys_db_RecordType::$DTimeStamp;
		}break;
		case "TINYTEXT":{
			$t = sys_db_RecordType::$DTinyText;
		}break;
		case "TEXT":{
			$t = sys_db_RecordType::$DSmallText;
		}break;
		case "MEDIUMTEXT":{
			$t = sys_db_RecordType::$DText;
		}break;
		case "BLOB":{
			$t = sys_db_RecordType::$DSmallBinary;
		}break;
		case "MEDIUMBLOB":{
			$t = sys_db_RecordType::$DBinary;
		}break;
		case "LONGBLOB":{
			$t = sys_db_RecordType::$DLongBinary;
		}break;
		case "TINYINT":{
			if($param !== null) {
				switch($param) {
				case 1:{
					$fdesc->remove("UNSIGNED");
					$t = sys_db_RecordType::$DBool;
				}break;
				case 4:{
					$t = sys_db_RecordType::$DTinyInt;
				}break;
				case 3:{
					if($fdesc->remove("UNSIGNED")) {
						$t = sys_db_RecordType::$DTinyUInt;
					} else {
						$t = null;
					}
				}break;
				default:{
					if(sys_db_TableInfos::$OLD_COMPAT) {
						$t = sys_db_RecordType::$DInt;
					} else {
						$t = null;
					}
				}break;
				}
			} else {
				if(sys_db_TableInfos::$OLD_COMPAT) {
					$t = sys_db_RecordType::$DInt;
				} else {
					$t = null;
				}
			}
		}break;
		case "SMALLINT":{
			if($fdesc->remove("UNSIGNED")) {
				$t = sys_db_RecordType::$DSmallUInt;
			} else {
				$t = sys_db_RecordType::$DSmallInt;
			}
		}break;
		case "MEDIUMINT":{
			if($fdesc->remove("UNSIGNED")) {
				$t = sys_db_RecordType::$DMediumUInt;
			} else {
				$t = sys_db_RecordType::$DMediumInt;
			}
		}break;
		case "BINARY":{
			if($param === null) {
				$t = null;
			} else {
				$t = sys_db_RecordType::DBytes($param);
			}
		}break;
		default:{
			$t = null;
		}break;
		}
		if($t === null) {
			$GLOBALS['%s']->pop();
			return null;
		}
		while($fdesc->length > 0) {
			$d = $fdesc->shift();
			switch($d) {
			case "NOT":{
				if($fdesc->shift() !== "NULL") {
					$GLOBALS['%s']->pop();
					return null;
				}
				$nullable = false;
			}break;
			case "DEFAULT":{
				$v = $fdesc->shift();
				if($nullable) {
					if($v === "NULL") {
						continue 2;
					}
					{
						$GLOBALS['%s']->pop();
						return null;
					}
				}
				$def = null;
				switch($t->index) {
				case 0:case 2:case 1:case 3:case 8:case 6:case 7:case 20:case 5:case 4:case 23:case 24:{
					$def = "'0'";
				}break;
				case 25:case 26:case 27:case 29:case 28:{
					$def = "'0'";
				}break;
				case 13:case 15:case 9:case 14:case 21:{
					$def = "''";
				}break;
				case 11:case 12:{
					if(strlen($v) > 0 && _hx_char_at($v, strlen($v) - 1) !== "'") {
						$v .= " " . _hx_string_or_null($fdesc->shift());
					}
					$def = "'0000-00-00 00:00:00'";
				}break;
				case 10:{
					$def = "'0000-00-00'";
				}break;
				case 16:case 18:case 17:case 22:case 19:case 33:case 32:{
					$def = null;
				}break;
				case 30:{
					$def = null;
				}break;
				case 31:{
					$def = "'0'";
				}break;
				}
				if($v !== $def && !sys_db_TableInfos::$OLD_COMPAT) {
					$GLOBALS['%s']->pop();
					return null;
				}
			}break;
			case "NULL":{
				if(!$nullable) {
					$GLOBALS['%s']->pop();
					return null;
				}
				$nullable = true;
				continue 2;
			}break;
			default:{
				$GLOBALS['%s']->pop();
				return null;
			}break;
			}
			unset($d);
		}
		{
			$tmp = _hx_anonymous(array("t" => $t, "nullable" => $nullable));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function fromDescription($desc) {
		$GLOBALS['%s']->push("sys.db.TableInfos::fromDescription");
		$__hx__spos = $GLOBALS['%s']->length;
		$r = new EReg("^CREATE TABLE `([^`]*)` \\((.*)\\)( ENGINE=([^ ]+))?( AUTO_INCREMENT=[^ ]+)?( DEFAULT CHARSET=.*)?\$", "sm");
		if(!$r->match($desc)) {
			throw new HException("Invalid " . _hx_string_or_null($desc));
		}
		$tname = $r->matched(1);
		if(strtoupper($r->matched(4)) !== "INNODB") {
			throw new HException("Table " . _hx_string_or_null($tname) . " should be INNODB");
		}
		$matches = _hx_explode(",\x0A", $r->matched(2));
		$field_r = new EReg("^[ \x0D\x0A]*`(.*)` (.*)\$", "");
		$primary_r = new EReg("^[ \x0D\x0A]*PRIMARY KEY +\\((.*)\\)[ \x0D\x0A]*\$", "");
		$index_r = new EReg("^[ \x0D\x0A]*(UNIQUE )?KEY `(.*)` \\((.*)\\)[ \x0D\x0A]*\$", "");
		$foreign_r = new EReg("^[ \x0D\x0A]*CONSTRAINT `(.*)` FOREIGN KEY \\(`(.*)`\\) REFERENCES `(.*)` \\(`(.*)`\\) ON DELETE (SET NULL|CASCADE)[ \x0D\x0A]*\$", "");
		$index_key_r = new EReg("^`?(.*?)`?(\\([0-9+]\\))?\$", "");
		$fields = new haxe_ds_StringMap();
		$nulls = new haxe_ds_StringMap();
		$indexes = new haxe_ds_StringMap();
		$relations = new _hx_array(array());
		$primary = null;
		{
			$_g = 0;
			while($_g < $matches->length) {
				$f = $matches[$_g];
				++$_g;
				if($field_r->match($f)) {
					$fname = $field_r->matched(1);
					$ftype = sys_db_TableInfos::fromTypeDescription($field_r->matched(2));
					if($ftype === null) {
						throw new HException("Unknown description '" . _hx_string_or_null($field_r->matched(2)) . "'");
					}
					$fields->set($fname, $ftype->t);
					if($ftype->nullable) {
						$nulls->set($fname, true);
					}
					unset($ftype,$fname);
				} else {
					if($primary_r->match($f)) {
						if($primary !== null) {
							throw new HException("Duplicate primary key");
						}
						$primary = _hx_explode(",", $primary_r->matched(1));
						{
							$_g2 = 0;
							$_g1 = $primary->length;
							while($_g2 < $_g1) {
								$i = $_g2++;
								$k = sys_db_TableInfos::unescape($primary[$i]);
								$primary[$i] = $k;
								unset($k,$i);
							}
							unset($_g2,$_g1);
						}
					} else {
						if($index_r->match($f)) {
							$unique = $index_r->matched(1);
							$idxname = $index_r->matched(2);
							$fs = Lambda::hlist(_hx_explode(",", $index_r->matched(3)));
							{
								$value = _hx_anonymous(array("keys" => $fs->map(array(new _hx_lambda(array(&$_g, &$desc, &$f, &$field_r, &$fields, &$foreign_r, &$fs, &$idxname, &$index_key_r, &$index_r, &$indexes, &$matches, &$nulls, &$primary, &$primary_r, &$r, &$relations, &$tname, &$unique), "sys_db_TableInfos_3"), 'execute')), "unique" => $unique !== "" && $unique !== null, "name" => $idxname));
								$indexes->set($idxname, $value);
								unset($value);
							}
							unset($unique,$idxname,$fs);
						} else {
							if($foreign_r->match($f)) {
								$name = $foreign_r->matched(1);
								$key = $foreign_r->matched(2);
								$table = $foreign_r->matched(3);
								$table = _hx_string_or_null(strtoupper(_hx_substr($table, 0, 1))) . _hx_string_or_null(_hx_substr($table, 1, null));
								$id = $foreign_r->matched(4);
								$setnull = null;
								if($foreign_r->matched(5) === "SET NULL") {
									$setnull = true;
								} else {
									$setnull = null;
								}
								$relations->push(_hx_anonymous(array("name" => $name, "key" => $key, "table" => $table, "id" => $id, "setnull" => $setnull)));
								unset($table,$setnull,$name,$key,$id);
							} else {
								throw new HException("Invalid " . _hx_string_or_null($f) . " in " . _hx_string_or_null($desc));
							}
						}
					}
				}
				unset($f);
			}
		}
		{
			$tmp = _hx_anonymous(array("table" => $tname, "fields" => $fields, "nulls" => $nulls, "indexes" => $indexes, "relations" => $relations, "primary" => $primary));
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function sameDBStorage($dt, $rt) {
		$GLOBALS['%s']->push("sys.db.TableInfos::sameDBStorage");
		$__hx__spos = $GLOBALS['%s']->length;
		switch($rt->index) {
		case 20:{
			$tmp = $dt === sys_db_RecordType::$DInt;
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		case 23:{
			$auto = _hx_deref($rt)->params[1];
			$fl = _hx_deref($rt)->params[0];
			if($auto) {
				if($fl->length <= 8) {
					$tmp = $dt === sys_db_RecordType::$DTinyUInt;
					$GLOBALS['%s']->pop();
					return $tmp;
				} else {
					if($fl->length <= 16) {
						$tmp = $dt === sys_db_RecordType::$DSmallUInt;
						$GLOBALS['%s']->pop();
						return $tmp;
					} else {
						if($fl->length <= 24) {
							$tmp = $dt === sys_db_RecordType::$DMediumUInt;
							$GLOBALS['%s']->pop();
							return $tmp;
						} else {
							$tmp = $dt === sys_db_RecordType::$DInt;
							$GLOBALS['%s']->pop();
							return $tmp;
						}
					}
				}
			} else {
				$tmp = $dt === sys_db_RecordType::$DInt;
				$GLOBALS['%s']->pop();
				return $tmp;
			}
		}break;
		case 21:{
			$tmp = $dt === sys_db_RecordType::$DText;
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		case 22:{
			$tmp = $dt === sys_db_RecordType::$DBinary;
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		case 30:{
			$tmp = $dt === sys_db_RecordType::$DBinary;
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		case 31:{
			$tmp = $dt === sys_db_RecordType::$DTinyUInt;
			$GLOBALS['%s']->pop();
			return $tmp;
		}break;
		default:{
			$GLOBALS['%s']->pop();
			return false;
		}break;
		}
		$GLOBALS['%s']->pop();
	}
	static function allTablesRequest() {
		$GLOBALS['%s']->push("sys.db.TableInfos::allTablesRequest");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$GLOBALS['%s']->pop();
			return "SHOW TABLES";
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'sys.db.TableInfos'; }
}
function sys_db_TableInfos_0(&$__hx__this, &$f) {
	{
		$_g = $f->type;
		switch($_g->index) {
		case 0:{
			return "INT AUTO_INCREMENT";
		}break;
		case 2:{
			return "INT UNSIGNED AUTO_INCREMENT";
		}break;
		case 1:case 20:{
			return "INT";
		}break;
		case 23:{
			$auto = _hx_deref($_g)->params[1];
			$fl = _hx_deref($_g)->params[0];
			if($auto) {
				if($fl->length <= 8) {
					return "TINYINT UNSIGNED";
				} else {
					if($fl->length <= 16) {
						return "SMALLINT UNSIGNED";
					} else {
						if($fl->length <= 24) {
							return "MEDIUMINT UNSIGNED";
						} else {
							return "INT";
						}
					}
				}
			} else {
				return "INT";
			}
			unset($fl,$auto);
		}break;
		case 24:{
			return "TINYINT";
		}break;
		case 3:{
			return "INT UNSIGNED";
		}break;
		case 6:{
			return "FLOAT";
		}break;
		case 7:{
			return "DOUBLE";
		}break;
		case 8:{
			return "TINYINT(1)";
		}break;
		case 9:{
			$n = _hx_deref($_g)->params[0];
			return "VARCHAR(" . _hx_string_rec($n, "") . ")";
		}break;
		case 10:{
			return "DATE";
		}break;
		case 11:{
			return "DATETIME";
		}break;
		case 12:{
			return "TIMESTAMP" . _hx_string_or_null(((($__hx__this->nulls->exists($f->name)) ? " NULL DEFAULT NULL" : " DEFAULT 0")));
		}break;
		case 13:{
			return "TINYTEXT";
		}break;
		case 14:{
			return "TEXT";
		}break;
		case 15:case 21:{
			return "MEDIUMTEXT";
		}break;
		case 16:{
			return "BLOB";
		}break;
		case 18:case 22:{
			return "MEDIUMBLOB";
		}break;
		case 30:{
			return "MEDIUMBLOB";
		}break;
		case 31:{
			return "TINYINT UNSIGNED";
		}break;
		case 17:{
			return "LONGBLOB";
		}break;
		case 5:{
			return "BIGINT";
		}break;
		case 4:{
			return "BIGINT AUTO_INCREMENT";
		}break;
		case 19:{
			$n1 = _hx_deref($_g)->params[0];
			return "BINARY(" . _hx_string_rec($n1, "") . ")";
		}break;
		case 25:{
			return "TINYINT UNSIGNED";
		}break;
		case 26:{
			return "SMALLINT";
		}break;
		case 27:{
			return "SMALLINT UNSIGNED";
		}break;
		case 28:{
			return "MEDIUMINT";
		}break;
		case 29:{
			return "MEDIUMINT UNSIGNED";
		}break;
		case 33:case 32:{
			throw new HException("assert");
		}break;
		}
		unset($_g);
	}
}
function sys_db_TableInfos_1(&$o, $p) {
	{
		$GLOBALS['%s']->push("sys.db.TableInfos::identifier@301");
		$__hx__spos2 = $GLOBALS['%s']->length;
		{
			$tmp = _hx_explode(".", Std::string(Reflect::field($o, $p)))->join("~");
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
function sys_db_TableInfos_2(&$__hx__this, &$cond, &$count, &$f, &$m, &$order, &$p, &$params, &$pos, &$rop, &$v) {
	try {
		return sys_db_Id::encode($v);
	}catch(Exception $__hx__e) {
		$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
		$e = $_ex_;
		{
			$GLOBALS['%e'] = (new _hx_array(array()));
			while($GLOBALS['%s']->length >= $__hx__spos) {
				$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
			}
			$GLOBALS['%s']->push($GLOBALS['%e'][0]);
			return 0;
		}
	}
}
function sys_db_TableInfos_3(&$_g, &$desc, &$f, &$field_r, &$fields, &$foreign_r, &$fs, &$idxname, &$index_key_r, &$index_r, &$indexes, &$matches, &$nulls, &$primary, &$primary_r, &$r, &$relations, &$tname, &$unique, $r1) {
	{
		$GLOBALS['%s']->push("sys.db.TableInfos::fromDescription@518");
		$__hx__spos2 = $GLOBALS['%s']->length;
		if(!$index_key_r->match($r1)) {
			throw new HException("Invalid index key " . _hx_string_or_null($r1));
		}
		{
			$tmp = $index_key_r->matched(1);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
}
