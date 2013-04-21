<?php

class UserDetailViewModel extends ViewModel implements Detailable, Editable {
	private $userId;
	
	public function __construct(UserModel $model) {
		$this->model = $model;
	}
	
	public function edit($data) {
		//return $this->model->update($data);
	}

	public function setId($id) {
		$this->userId = $id;
	}

	public function getDetail() {
		return $this->model->findById($this->userId);
	}
}

?>