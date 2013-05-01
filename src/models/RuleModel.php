<?php

class RuleModel extends Model {

	public function getAll() {
		return array(
				array('id' => 'PRESNA_SHODA', 'nazev' => 'Přesná shoda řetězce'),
				array('id' => 'SHODA_PODRETEZCE', 'nazev' => 'Shoda podřetězce'),
				array('id' => 'SHODA_S_TOLERANCI', 'nazev' => 'Shoda s tolerancí')
			);
	}
	
}

?>