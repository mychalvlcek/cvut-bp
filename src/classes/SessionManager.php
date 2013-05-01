<?PHP

class SessionManager {

	function __constructor() {
		if(session_id() == '') session_start();
	}

	public function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	public function add($key, $subkey, $value) {
		$_SESSION[$key][$subkey][] = $value;
	}

	public function get($key) {
		if( isset($_SESSION[$key]) ) {
			return $_SESSION[$key];
		} else {
			return false;
		}
	}

	public function clear($key) {
		if( isset($_SESSION[$key]) ) {
			unset($_SESSION[$key]);
		}
	}

}

?>