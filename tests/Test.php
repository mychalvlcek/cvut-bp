<?php

require_once dirname(dirname(__FILE__)).'/tests/AbstractDatabaseTestCase.php';

class Test extends AbstractDatabaseTestCase {

	public function testCreateQueryTable() {
		//$tableNames = array('users');
		$queryTable = $this->getConnection()->createQueryTable('users', 'SELECT * FROM users');
		$expectedTable = $this->createFlatXmlDataSet(dirname(__FILE__).'/dataset.xml')->getTable("users");
		$this->assertTablesEqual($expectedTable, $queryTable);
	}

	public function testGetRowCount() {
		$this->assertEquals(2, $this->getConnection()->getRowCount('users'));
	}

}

?>