<?php

class sugoi_tools_DebugConnection implements sys_db_Connection{
	public function __construct($cnx) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("sugoi.tools.DebugConnection::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->cnx = $cnx;
		$this->log = new HList();
		$GLOBALS['%s']->pop();
	}}
	public $cnx;
	public $log;
	public function request($rq) {
		$GLOBALS['%s']->push("sugoi.tools.DebugConnection::request");
		$__hx__spos = $GLOBALS['%s']->length;
		$t = Sys::time();
		$r = $this->cnx->request($rq);
		$explain = null;
		try {
			$explain = $this->cnx->request("EXPLAIN " . _hx_string_or_null($rq))->next();
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				$explain = _hx_anonymous(array("error" => Std::string($e)));
			}
		}
		$buf = new StringBuf();
		{
			$_g = 0;
			$_g1 = Reflect::fields($explain);
			while($_g < $_g1->length) {
				$f = $_g1[$_g];
				++$_g;
				$buf->add($f);
				$buf->add(" : ");
				$buf->add(Reflect::field($explain, $f));
				$buf->add("\\n");
				unset($f);
			}
		}
		$s = haxe_CallStack::callStack();
		$s->pop();
		if(strlen($rq) > 100) {
			$rbig = new EReg("^(UPDATE Session SET.* data = )'(.*?)'([ ,])", "");
			if($rbig->match($rq)) {
				$rq = _hx_string_or_null($rbig->matched(1)) . "[" . _hx_string_rec(strlen(_hx_explode("\\0", $rbig->matched(2))->join("\x00")), "") . " bytes]" . _hx_string_or_null($rbig->matched(3)) . _hx_string_or_null($rbig->matchedRight());
			}
		}
		$this->log->add(_hx_anonymous(array("t" => Std::int((Sys::time() - $t) * 1000), "sql" => $rq, "length" => $r->get_length(), "bad" => sugoi_tools_DebugConnection::isBadSql($explain), "explain" => _hx_explode("\x0A", _hx_explode("\x0D", _hx_explode("'", _hx_explode("\\", $buf->b)->join("\\\\"))->join("\\'"))->join("\\r"))->join("\\n"), "stack" => _hx_explode("\x0A", _hx_explode("\x0D", _hx_explode("'", _hx_explode("\\", haxe_CallStack::toString($s))->join("\\\\"))->join("\\'"))->join("\\r"))->join("\\n"))));
		{
			$GLOBALS['%s']->pop();
			return $r;
		}
		$GLOBALS['%s']->pop();
	}
	public function close() {
		$GLOBALS['%s']->push("sugoi.tools.DebugConnection::close");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->cnx->close();
		$GLOBALS['%s']->pop();
	}
	public function startTransaction() {
		$GLOBALS['%s']->push("sugoi.tools.DebugConnection::startTransaction");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->cnx->startTransaction();
		$GLOBALS['%s']->pop();
	}
	public function commit() {
		$GLOBALS['%s']->push("sugoi.tools.DebugConnection::commit");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->cnx->commit();
		$GLOBALS['%s']->pop();
	}
	public function rollback() {
		$GLOBALS['%s']->push("sugoi.tools.DebugConnection::rollback");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->cnx->rollback();
		$GLOBALS['%s']->pop();
	}
	public function dbName() {
		$GLOBALS['%s']->push("sugoi.tools.DebugConnection::dbName");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->cnx->dbName();
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function escape($s) {
		$GLOBALS['%s']->push("sugoi.tools.DebugConnection::escape");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->cnx->escape($s);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function quote($s) {
		$GLOBALS['%s']->push("sugoi.tools.DebugConnection::quote");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->cnx->quote($s);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function addValue($s, $v) {
		$GLOBALS['%s']->push("sugoi.tools.DebugConnection::addValue");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->cnx->addValue($s, $v);
		$GLOBALS['%s']->pop();
	}
	public function lastInsertId() {
		$GLOBALS['%s']->push("sugoi.tools.DebugConnection::lastInsertId");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = $this->cnx->lastInsertId();
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
	static function isBadSql($explain) {
		$GLOBALS['%s']->push("sugoi.tools.DebugConnection::isBadSql");
		$__hx__spos = $GLOBALS['%s']->length;
		if($explain->error !== null) {
			if(StringTools::startsWith($explain->error, "EXPLAIN INSERT INTO") || StringTools::startsWith($explain->error, "EXPLAIN UPDATE") || StringTools::startsWith($explain->error, "EXPLAIN COMMIT")) {
				$GLOBALS['%s']->pop();
				return false;
			}
			{
				$GLOBALS['%s']->pop();
				return true;
			}
		}
		$t = null;
		if($explain->table !== null) {
			$t = Type::resolveClass("db." . _hx_string_or_null($explain->table));
		} else {
			$t = null;
		}
		if($t !== null && $t->IGNORE_PERF_WARNING) {
			$GLOBALS['%s']->pop();
			return false;
		}
		if($explain->Extra !== null) {
			if(_hx_deref(new EReg("Using filesort", ""))->match($explain->Extra)) {
				$GLOBALS['%s']->pop();
				return true;
			}
			if(_hx_deref(new EReg("No tables used", ""))->match($explain->Extra)) {
				$GLOBALS['%s']->pop();
				return false;
			}
			if(_hx_deref(new EReg("Impossible WHERE", ""))->match($explain->Extra)) {
				$GLOBALS['%s']->pop();
				return false;
			}
		}
		if($explain->type === "ALL") {
			$GLOBALS['%s']->pop();
			return false;
		}
		if($explain->key === null) {
			$GLOBALS['%s']->pop();
			return true;
		}
		{
			$GLOBALS['%s']->pop();
			return false;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'sugoi.tools.DebugConnection'; }
}
