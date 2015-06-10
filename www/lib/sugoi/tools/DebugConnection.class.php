<?php

class sugoi_tools_DebugConnection implements sys_db_Connection{
	public function __construct($cnx) {
		if(!php_Boot::$skip_constructor) {
		$this->cnx = $cnx;
		$this->log = new HList();
	}}
	public $cnx;
	public $log;
	public function request($rq) {
		$t = Sys::time();
		$r = $this->cnx->request($rq);
		$explain = null;
		try {
			$explain = $this->cnx->request("EXPLAIN " . _hx_string_or_null($rq))->next();
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
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
		return $r;
	}
	public function close() {
		$this->cnx->close();
	}
	public function startTransaction() {
		$this->cnx->startTransaction();
	}
	public function commit() {
		$this->cnx->commit();
	}
	public function rollback() {
		$this->cnx->rollback();
	}
	public function dbName() {
		return $this->cnx->dbName();
	}
	public function escape($s) {
		return $this->cnx->escape($s);
	}
	public function quote($s) {
		return $this->cnx->quote($s);
	}
	public function addValue($s, $v) {
		$this->cnx->addValue($s, $v);
	}
	public function lastInsertId() {
		return $this->cnx->lastInsertId();
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
		if($explain->error !== null) {
			if(StringTools::startsWith($explain->error, "EXPLAIN INSERT INTO") || StringTools::startsWith($explain->error, "EXPLAIN UPDATE") || StringTools::startsWith($explain->error, "EXPLAIN COMMIT")) {
				return false;
			}
			return true;
		}
		$t = null;
		if($explain->table !== null) {
			$t = Type::resolveClass("db." . _hx_string_or_null($explain->table));
		} else {
			$t = null;
		}
		if($t !== null && $t->IGNORE_PERF_WARNING) {
			return false;
		}
		if($explain->Extra !== null) {
			if(_hx_deref(new EReg("Using filesort", ""))->match($explain->Extra)) {
				return true;
			}
			if(_hx_deref(new EReg("No tables used", ""))->match($explain->Extra)) {
				return false;
			}
			if(_hx_deref(new EReg("Impossible WHERE", ""))->match($explain->Extra)) {
				return false;
			}
		}
		if($explain->type === "ALL") {
			return false;
		}
		if($explain->key === null) {
			return true;
		}
		return false;
	}
	function __toString() { return 'sugoi.tools.DebugConnection'; }
}
