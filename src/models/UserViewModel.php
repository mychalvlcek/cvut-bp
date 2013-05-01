<?php

class UserViewModel extends ViewModel {
	
	public function __construct(UserModel $model) {
		$this->model = $model;
	}
	
	public function edit($data) {
		//return $this->model->update($data);
	}
}

?>