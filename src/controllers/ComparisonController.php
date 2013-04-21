<?php

class ComparisonController extends Controller {

	public function __construct(ComparisonViewModel $model) {
		parent::__construct($model);

		if(count($_POST))
			$this->model->save($_POST);
	}

}

?>