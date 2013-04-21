<?php

class AuthViewModel extends ViewModel {
	
	public function __construct(AuthModel $model) {
		$this->model = $model;
	}
	
	public function checkLogin($data = array()) {
		if(isset($data['username']) && isset($data['password']) && count($data) == 2) {
			$user = $this->model->findUser($data['username'], $data['password']);
			if(count($user) == 1) {
				$this->setSessionData($user[0]);
				$this->addInfo('success', 'Přihlášen');
				return true;
			} else {
				$this->addInfo('error', 'Nesprávné přihlašovací údaje');
				return false;
			}
		}
	}

	public function addUser($data = array()) {
		// server-side validations
		if(count($data) != 4) {
			$this->addInfo('error', 'Špatně zadané údaje');
		}
		if(isset($data['email']) && !preg_match('/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/', $data['email'])) {
			$this->addInfo('error', 'Špatně zadaný email');
		}
		if(isset($data['username']) && strlen($data['username']) < 6 ) {
			$this->addInfo('error', 'Uživatelské jméno musí mít minimálně 6 znaků');
		}
		if( isset($data['password']) && isset($data['confirm']) && $data['password'] != $data['confirm'] ) {
			$this->addInfo('error', 'Zadaná hesla se neshodují');
		}
		if(count($this->getInfo()) == 0) {
			unset($data['confirm']);
			if(!$this->model->userExists($data['email'])) {
				$user = $this->model->createUser($data);
				if($user) {
					$this->addInfo('success', 'Uživatel byl vytvořen');
					return true;
				} else {
					$this->addInfo('error', 'Registrace selhala');
					return false;
				}
			} else {
				$this->addInfo('error', 'Uživatel se zadanou emailovou adresou již existuje');
				return false;
			}
		} else {
			return false;
		}
	}

}

?>