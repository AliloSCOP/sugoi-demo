<?php

class Xml {
	public function __construct($nodeType) {
		if(!php_Boot::$skip_constructor) {
		$GLOBALS['%s']->push("Xml::new");
		$__hx__spos = $GLOBALS['%s']->length;
		$this->nodeType = $nodeType;
		$this->children = (new _hx_array(array()));
		$this->attributeMap = new haxe_ds_StringMap();
		$GLOBALS['%s']->pop();
	}}
	public $nodeType;
	public $nodeName;
	public $nodeValue;
	public $parent;
	public $children;
	public $attributeMap;
	public function get($att) {
		$GLOBALS['%s']->push("Xml::get");
		$__hx__spos = $GLOBALS['%s']->length;
		if((is_object($_t = $this->nodeType) && !($_t instanceof Enum) ? $_t !== Xml::$Element : $_t != Xml::$Element)) {
			throw new HException("Bad node type, expected Element but found " . _hx_string_rec($this->nodeType, ""));
		}
		{
			$tmp = $this->attributeMap->get($att);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function set($att, $value) {
		$GLOBALS['%s']->push("Xml::set");
		$__hx__spos = $GLOBALS['%s']->length;
		if((is_object($_t = $this->nodeType) && !($_t instanceof Enum) ? $_t !== Xml::$Element : $_t != Xml::$Element)) {
			throw new HException("Bad node type, expected Element but found " . _hx_string_rec($this->nodeType, ""));
		}
		$this->attributeMap->set($att, $value);
		$GLOBALS['%s']->pop();
	}
	public function exists($att) {
		$GLOBALS['%s']->push("Xml::exists");
		$__hx__spos = $GLOBALS['%s']->length;
		if((is_object($_t = $this->nodeType) && !($_t instanceof Enum) ? $_t !== Xml::$Element : $_t != Xml::$Element)) {
			throw new HException("Bad node type, expected Element but found " . _hx_string_rec($this->nodeType, ""));
		}
		{
			$tmp = $this->attributeMap->exists($att);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	public function firstElement() {
		$GLOBALS['%s']->push("Xml::firstElement");
		$__hx__spos = $GLOBALS['%s']->length;
		if((is_object($_t = $this->nodeType) && !($_t instanceof Enum) ? $_t !== Xml::$Document : $_t != Xml::$Document) && (is_object($_t2 = $this->nodeType) && !($_t2 instanceof Enum) ? $_t2 !== Xml::$Element : $_t2 != Xml::$Element)) {
			throw new HException("Bad node type, expected Element or Document but found " . _hx_string_rec($this->nodeType, ""));
		}
		{
			$_g = 0;
			$_g1 = $this->children;
			while($_g < $_g1->length) {
				$child = $_g1[$_g];
				++$_g;
				if((is_object($_t3 = $child->nodeType) && !($_t3 instanceof Enum) ? $_t3 === Xml::$Element : $_t3 == Xml::$Element)) {
					$GLOBALS['%s']->pop();
					return $child;
				}
				unset($child,$_t3);
			}
		}
		{
			$GLOBALS['%s']->pop();
			return null;
		}
		$GLOBALS['%s']->pop();
	}
	public function addChild($x) {
		$GLOBALS['%s']->push("Xml::addChild");
		$__hx__spos = $GLOBALS['%s']->length;
		if((is_object($_t = $this->nodeType) && !($_t instanceof Enum) ? $_t !== Xml::$Document : $_t != Xml::$Document) && (is_object($_t2 = $this->nodeType) && !($_t2 instanceof Enum) ? $_t2 !== Xml::$Element : $_t2 != Xml::$Element)) {
			throw new HException("Bad node type, expected Element or Document but found " . _hx_string_rec($this->nodeType, ""));
		}
		if($x->parent === $this) {
			$GLOBALS['%s']->pop();
			return;
		} else {
			if($x->parent !== null) {
				$x->parent->removeChild($x);
			}
		}
		$this->children->push($x);
		$x->parent = $this;
		$GLOBALS['%s']->pop();
	}
	public function removeChild($x) {
		$GLOBALS['%s']->push("Xml::removeChild");
		$__hx__spos = $GLOBALS['%s']->length;
		if((is_object($_t = $this->nodeType) && !($_t instanceof Enum) ? $_t !== Xml::$Document : $_t != Xml::$Document) && (is_object($_t2 = $this->nodeType) && !($_t2 instanceof Enum) ? $_t2 !== Xml::$Element : $_t2 != Xml::$Element)) {
			throw new HException("Bad node type, expected Element or Document but found " . _hx_string_rec($this->nodeType, ""));
		}
		{
			$tmp = $this->children->remove($x);
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
	static $Element;
	static $PCData;
	static $CData;
	static $Comment;
	static $DocType;
	static $ProcessingInstruction;
	static $Document;
	static function parse($str) {
		$GLOBALS['%s']->push("Xml::parse");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = haxe_xml_Parser::parse($str, null);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	static function createElement($name) {
		$GLOBALS['%s']->push("Xml::createElement");
		$__hx__spos = $GLOBALS['%s']->length;
		$xml = new Xml(Xml::$Element);
		{
			if((is_object($_t = $xml->nodeType) && !($_t instanceof Enum) ? $_t !== Xml::$Element : $_t != Xml::$Element)) {
				throw new HException("Bad node type, expected Element but found " . _hx_string_rec($xml->nodeType, ""));
			}
			$xml->nodeName = $name;
		}
		{
			$GLOBALS['%s']->pop();
			return $xml;
		}
		$GLOBALS['%s']->pop();
	}
	static function createPCData($data) {
		$GLOBALS['%s']->push("Xml::createPCData");
		$__hx__spos = $GLOBALS['%s']->length;
		$xml = new Xml(Xml::$PCData);
		{
			if((is_object($_t = $xml->nodeType) && !($_t instanceof Enum) ? $_t === Xml::$Document : $_t == Xml::$Document) || (is_object($_t2 = $xml->nodeType) && !($_t2 instanceof Enum) ? $_t2 === Xml::$Element : $_t2 == Xml::$Element)) {
				throw new HException("Bad node type, unexpected " . _hx_string_rec($xml->nodeType, ""));
			}
			$xml->nodeValue = $data;
		}
		{
			$GLOBALS['%s']->pop();
			return $xml;
		}
		$GLOBALS['%s']->pop();
	}
	static function createCData($data) {
		$GLOBALS['%s']->push("Xml::createCData");
		$__hx__spos = $GLOBALS['%s']->length;
		$xml = new Xml(Xml::$CData);
		{
			if((is_object($_t = $xml->nodeType) && !($_t instanceof Enum) ? $_t === Xml::$Document : $_t == Xml::$Document) || (is_object($_t2 = $xml->nodeType) && !($_t2 instanceof Enum) ? $_t2 === Xml::$Element : $_t2 == Xml::$Element)) {
				throw new HException("Bad node type, unexpected " . _hx_string_rec($xml->nodeType, ""));
			}
			$xml->nodeValue = $data;
		}
		{
			$GLOBALS['%s']->pop();
			return $xml;
		}
		$GLOBALS['%s']->pop();
	}
	static function createComment($data) {
		$GLOBALS['%s']->push("Xml::createComment");
		$__hx__spos = $GLOBALS['%s']->length;
		$xml = new Xml(Xml::$Comment);
		{
			if((is_object($_t = $xml->nodeType) && !($_t instanceof Enum) ? $_t === Xml::$Document : $_t == Xml::$Document) || (is_object($_t2 = $xml->nodeType) && !($_t2 instanceof Enum) ? $_t2 === Xml::$Element : $_t2 == Xml::$Element)) {
				throw new HException("Bad node type, unexpected " . _hx_string_rec($xml->nodeType, ""));
			}
			$xml->nodeValue = $data;
		}
		{
			$GLOBALS['%s']->pop();
			return $xml;
		}
		$GLOBALS['%s']->pop();
	}
	static function createDocType($data) {
		$GLOBALS['%s']->push("Xml::createDocType");
		$__hx__spos = $GLOBALS['%s']->length;
		$xml = new Xml(Xml::$DocType);
		{
			if((is_object($_t = $xml->nodeType) && !($_t instanceof Enum) ? $_t === Xml::$Document : $_t == Xml::$Document) || (is_object($_t2 = $xml->nodeType) && !($_t2 instanceof Enum) ? $_t2 === Xml::$Element : $_t2 == Xml::$Element)) {
				throw new HException("Bad node type, unexpected " . _hx_string_rec($xml->nodeType, ""));
			}
			$xml->nodeValue = $data;
		}
		{
			$GLOBALS['%s']->pop();
			return $xml;
		}
		$GLOBALS['%s']->pop();
	}
	static function createProcessingInstruction($data) {
		$GLOBALS['%s']->push("Xml::createProcessingInstruction");
		$__hx__spos = $GLOBALS['%s']->length;
		$xml = new Xml(Xml::$ProcessingInstruction);
		{
			if((is_object($_t = $xml->nodeType) && !($_t instanceof Enum) ? $_t === Xml::$Document : $_t == Xml::$Document) || (is_object($_t2 = $xml->nodeType) && !($_t2 instanceof Enum) ? $_t2 === Xml::$Element : $_t2 == Xml::$Element)) {
				throw new HException("Bad node type, unexpected " . _hx_string_rec($xml->nodeType, ""));
			}
			$xml->nodeValue = $data;
		}
		{
			$GLOBALS['%s']->pop();
			return $xml;
		}
		$GLOBALS['%s']->pop();
	}
	static function createDocument() {
		$GLOBALS['%s']->push("Xml::createDocument");
		$__hx__spos = $GLOBALS['%s']->length;
		{
			$tmp = new Xml(Xml::$Document);
			$GLOBALS['%s']->pop();
			return $tmp;
		}
		$GLOBALS['%s']->pop();
	}
	function __toString() { return 'Xml'; }
}
Xml::$Element = 0;
Xml::$PCData = 1;
Xml::$CData = 2;
Xml::$Comment = 3;
Xml::$DocType = 4;
Xml::$ProcessingInstruction = 5;
Xml::$Document = 6;
