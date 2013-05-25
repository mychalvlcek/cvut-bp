<?php

class AuthViewModel extends ViewModel {
	
	public function __construct(AuthModel $model, SessionManager $sessionManager) {
		parent::__construct($model, $sessionManager);
	}
	
	public function checkLogin($data = array()) {
		if(isset($data['username']) && isset($data['password']) && count($data) == 2) {
			$user = $this->model->findUser($data['username'], $data['password']);
			if(count($user) == 1) {
				$this->setSession('user', $user[0]);
				$this->addInfo('info', 'Přihlášen');
				return true;
			} else {
				$this->addInfo('error', 'Nesprávné přihlašovací údaje');
				return false;
			}
		}
	}

	public function changePassword($data = array()) {
		if(isset($data['old_password']) && isset($data['password']) && isset($data['confirm']) && count($data) == 3) {
			if(isset($data['old_password']) && strlen($data['old_password']) < 1 ) {
				$this->addInfo('error', 'Zadejte staré heslo');
			}
			if( isset($data['password']) && isset($data['confirm']) && $data['password'] != $data['confirm'] ) {
				$this->addInfo('error', 'Zadaná hesla se neshodují');
			}
			if(count($this->getInfo()) == 0) {
				$data['id'] = $this->getUser()->id;
				$res = $this->model->checkUserPassword($data['id'], $data['old_password']);
				if($res == 1) {
					if($this->model->changePassword($data)) {
						$this->addInfo('info', 'Heslo úspěšně změněno');
						return true;
					} else {
						$this->addInfo('error', 'Heslo se nepodařilo změnit');
						return false;
					}
				} else {
					$this->addInfo('error', 'Špatné původní heslo');
					return false;
				}
			} else {
				return false;
			}
		} else {
			$this->addInfo('error', 'Špatně zadané údaje.');
		}
	}

	public function registerUser($data = array()) {
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
			if(!$this->model->userExists($data['email'], $data['username'])) {
				$user = $this->model->createUser($data);
				if($user) {
					$this->addInfo('info', 'Uživatel byl vytvořen');
					return true;
				} else {
					$this->addInfo('error', 'Registrace selhala');
					return false;
				}
			} else {
				$this->addInfo('error', 'Uživatel se zadanými údaji již existuje');
				return false;
			}
		} else {
			return false;
		}
	}

}

?>