<?php
/**
 * Abstract TOP-LEVEL model
 */
class Model {
	protected $db;

	protected $perPage = 15;
	protected $page = 1;
	protected $sort = 'id';
	protected $sortOrder = 'DESC';

	public function __construct(PDO $db) {
		$this->db = $db;
	}

	protected function getLimitString() {
		return 'LIMIT '.($this->page-1)*$this->perPage.', '.$this->perPage;
	}

	protected function fields($data) {
		$val = '';
		foreach ( $data as $k => $v ) {
			$val .= '`'.$k.'` = ?, ';
		}
		return substr($val, 0, -2);
	}

	public function setSort($sort = 'id', $sortOrder = 'DESC') {
		$this->sort = $sort;
		$this->sortOrder = $sortOrder;
	}

	public function setPage($page = 1) {
		$this->page = $page;
	}

	public function getPage() {
		return $this->page;
	}

	public function getRecordsPerPage() {
		return $this->perPage;
	}

}

?>