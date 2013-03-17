<?php

class HomeModel extends Model {
	private $anchors;
	private $file;
	private $db;
	
	public function __construct(Database $db) {
		$this->db = $db;
		$this->anchors = 'Žádné odkazy nebyly nalezeny.';
		$this->file = 'Zde bude zdrojový kód nahraného souboru.';
	}

	public function processUrl($url) {
		if($url != '') {
			$file = file_get_contents(trim($url));
			if ( preg_match_all('#<a[^>]*>([^<]*)<\/a>#i', $file, $matches) ) {
				$this->anchors = implode(', ', $matches[0]);
			}
			$this->file = htmlspecialchars(file_get_contents(trim($url)));
		}
	}

	public function getFile() {
		return $this->file;
	}

	public function getAnchors() {
		return $this->anchors;
	}
}

?>