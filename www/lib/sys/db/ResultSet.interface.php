<?php

interface sys_db_ResultSet {
	function get_length();
	function hasNext();
	function next();
	function results();
	function getResult($n);
}
