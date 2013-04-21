<?php

class UserListController extends Controller { 

	public function __construct(UserListViewModel $model) {
		parent::__construct($model);
	}

	public function lst() {
		if(isset($_GET['criterium'])) {
			$this->search($_GET['criterium']);
		}
	}

	public function search($criterium) {
		$this->model->setCriteria($criterium);
	}

}

?>