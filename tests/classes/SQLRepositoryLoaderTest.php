<?php

require_once $_SERVER["DOCUMENT_ROOT"].'/src/classes/SQLRepositoryLoader.php';

class SQLRepositoryLoaderTest extends PHPUnit_Framework_TestCase {
	public function testPushAndPop() {
		// dirname(__FILE__).'/test_sql.sql'

		$stack = array();
		$this->assertEquals(0, count($stack));

		array_push($stack, 'foo');
		$this->assertEquals('foo', $stack[count($stack)-1]);
		$this->assertEquals(1, count($stack));

		$this->assertEquals('foo', array_pop($stack));
		$this->assertEquals(0, count($stack));
	}
}

?>