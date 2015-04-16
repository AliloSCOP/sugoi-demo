<?php

class sys_db_Transaction {
	public function __construct(){}
	static function isDeadlock($e) {
		$GLOBALS['%s']->push("sys.db.Transaction::isDeadlock");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = Std::is($e, _hx_qtype("String")) && _hx_deref(new EReg("try restarting transaction", ""))->match($e);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function runMainLoop($mainFun, $logError, $count) {
		$GLOBALS['%s']->push("sys.db.Transaction::runMainLoop");
		$__hx__spos = $GLOBALS['%s']->length;
		try {
			call_user_func($mainFun);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				if($count > 0 && sys_db_Transaction::isDeadlock($e)) {
					sys_db_Manager::cleanup();
					sys_db_Manager::$cnx->rollback();
					sys_db_Manager::$cnx->startTransaction();
					sys_db_Transaction::runMainLoop($mainFun, $logError, $count - 1);
					{
						$GLOBALS['%s']->pop();
						return;
					}
				}
				if($logError === null) {
					sys_db_Manager::$cnx->rollback();
					throw new HException($e);
				}
				call_user_func_array($logError, array($e));
			}
		}
		$GLOBALS['%s']->pop();
	}
	static function main($cnx, $mainFun, $logError = null) {
		$GLOBALS['%s']->push("sys.db.Transaction::main");
		$__hx__spos = $GLOBALS['%s']->length;
		sys_db_Manager::initialize();
		sys_db_Manager::set_cnx($cnx);
		sys_db_Manager::$cnx->startTransaction();
		sys_db_Transaction::runMainLoop($mainFun, $logError, 3);
		try {
			sys_db_Manager::$cnx->commit();
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			if(is_string($e = $_ex_)){
				$GLOBALS['%e'] = (new _hx_array(array()));
				while($GLOBALS['%s']->length >= $__hx__spos) {
					$GLOBALS['%e']->unshift($GLOBALS['%s']->pop());
				}
				$GLOBALS['%s']->push($GLOBALS['%e'][0]);
				if(_hx_deref(new EReg("Database is busy", ""))->match($e)) {
					call_user_func_array($logError, array($e));
				}
			} else throw $__hx__e;;
		}
		sys_db_Manager::$cnx->close();
		sys_db_Manager::set_cnx(null);
		sys_db_Manager::cleanup();
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'sys.db.Transaction'; }
}
