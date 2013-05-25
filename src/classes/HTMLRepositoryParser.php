<?php

class HTMLRepositoryParser {
	private $urls = array();
	private $anchors = array();
	private $inputs = array();

	public function addUrl($url) {
		$this->urls[] = $url;
	}

	public function parse() {
		$doc = new DOMDocument;
		foreach($this->urls as $url) {
			$doc->loadHTMLFile($url);

			$xpath = new DOMXPath($doc);

			// anchors
			$links = $xpath->query('//a[@href]');
			foreach($links as $link) {
				$title = strip_tags($link->nodeValue);
				if($title != '' && strlen($title) < 100)
					$this->anchors[] = array('anchor_title' => $title, 'anchor_href' => $link->getAttribute( 'href' ) );
			}

			// inputs
			$inputs = $xpath->query('//input[@name] | //select[@name]');
			foreach($inputs as $input) {
				$labels = $xpath->query('//label[@for="'.$input->getAttribute('id').'"]');
				$label = '';
				if($labels->length) $label = $labels->item(0)->nodeValue;
				if($label != '')
					$this->inputs[] = array('input_label' => $label, 'input_name' => $input->getAttribute('name') );
			}
		}
	}

	public function getAnchors() {
		return $this->anchors;
	}

	public function getInputs() {
		return $this->inputs;
	}
	
} 

?>