<?php

require_once $_SERVER["DOCUMENT_ROOT"].'/tests/AbstractDatabaseTestCase.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/src/classes/Config.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/src/classes/Database.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/src/models/Model.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/src/models/UserModel.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/cfg.php';

class UserModelTest extends AbstractDatabaseTestCase {
	protected $m;
 
	protected function setUp() {
		// before
		$this->m = new UserModel(Database::getInstance());
	}

	protected function tearDown() {
		// after
	}

	public function testGetAll() {
		$data = $this->m->getAll();
		//$this->assertEquals(2, $this->getConnection()->getRowCount('users'));
		$this->assertEquals(2, sizeof($data));
	}

	/*
	public function testBalanceCannotBecomeNegative2() {
		try {
			$this->ba->depositMoney(-1);
		}
 
		catch (BankAccountException $e) {
			$this->assertEquals(0, $this->ba->getBalance());
 
			return;
		}
 
		$this->fail();
	}
	*/
 
	/**
	 * @covers BankAccount::getBalance
	 * @covers BankAccount::depositMoney
	 * @covers BankAccount::withdrawMoney
	 */
 	/*
	public function testDepositWithdrawMoney() {
		$this->assertEquals(0, $this->ba->getBalance());
		$this->ba->depositMoney(1);
		$this->assertEquals(1, $this->ba->getBalance());
		$this->ba->withdrawMoney(1);
		$this->assertEquals(0, $this->ba->getBalance());
	}
	*/
}

?>