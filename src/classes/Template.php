<?php

class Template {
	private $fileName;
	private $variables = array();
	private $info = array();
	private $form_elem = array();

	public function __construct($fileName = '') {
		$this->fileName = $fileName.'.html';
	}

	public function output($layout = true) {
		//print_r($this->info);
		$template = $this->loadTemplate($layout);
		$template = $this->addIncludes($template);
		$template = $this->processLoops($template);
		$template = $this->processConditions($template);
		$template = $this->makeSortableLinks($template);
		$template = $this->printAlerts($template);
		$template = $this->setValues($template);
		$template = $this->setFormValues($template);
		return $template;
	}

	public function setTemplate($fileName) {
		$this->fileName = $fileName;
	}

	public function set($name, $value) {
		$this->variables[$name] = $value;
	}

	public function get($name) {
		if(array_key_exists($name, $this->variables))
			return $this->variables[$name];
		return null;
	}

	public function setVariables($values) {
		if ( is_array($values) ) {
			$this->variables = $values;
		}
	}

	public function addVariables($var) {
		if (is_array($var)) {
			foreach ( $var as $k => $v ) {
				$this->set($k, $v);
			}
		}
	}

	public function setInfo($value) {
		$this->info = $value;
	}

	public function getVariables() {
		return $this->variables;
	}

	private function loadTemplate($layout) {
		if($layout) {
			$template = file_get_contents(PATH.'src/templates/_layout.html');
			return $this->addTemplate($template);
		} else {
			$path = PATH.'src/templates/'.$this->fileName;
			if ( is_file($path) ) {
				return file_get_contents($path);
			} else {
				return $this->loadTemplate(true);
			}
		}
	}

	private function addTemplate($template) {
		while ( preg_match("/<!--{template_file}-->/", $template, $regs) ) {
			$path = PATH.'src/templates/' .$this->fileName;
			$include = '';
			if ( !is_file($path) ) {
				if(DEVELOPMENT)
					trigger_error('Could not load template. Non-exists template "'.$path.'".', E_USER_NOTICE);
				$include = file_get_contents(PATH.'src/templates/error.html');
			} else {
				$include = file_get_contents($path);
			}
			$template = str_replace($regs[0], $include, $template);
		}
		return $template;
	}
	// update
	private function addIncludes($template) {
		$filename = $this->fileName;

		while ( preg_match("/<!--(!)?include ([a-zA-Z0-9_\/-]+\.html)-->/", $template, $regs) ) {
			if ( $filename == $regs[2] ) {
				trigger_error("Rekurentní načítání šablony \"".$regs[2]."\".", E_USER_ERROR);
			}
			$path = PATH."src/templates/".$regs[2];
			if ( $regs[1] == "!" ) {
				$required = true;
			} else {
				$required = false;
			}
			$include = "";
			if ( is_file($path) ) {
				$include = file_get_contents($path);
			} else {
				trigger_error("Nelze načíst obsah pro vložení. Neexistující šablona \"".$path."src/\".", $required?E_USER_ERROR:E_USER_WARNING);
			}
			$template = str_replace($regs[0], $include, $template);
		}
		return $template;
	}

	private function processConditions ( $template ) {
		$iter = 0;
		//while ( preg_match("/<!--(if )?([a-z0-9_]+) *(==? *([a-z0-9_]+))? *\?([^;]*);([^-]*)-->/", $template, $regs) ) {
		while ( preg_match("#<!--\{(if )?([a-z0-9_]+) *(==? *([a-z0-9_]+))? *\?([^:]*):([^/]*(?=\{/if\}-->))\{/if\}-->#", $template, $regs) ) {
			if ( strlen($regs[4]) > 0 ) {
				if ( $this->get($regs[2]) == $this->get($regs[4]) || $this->get($regs[2]) == $regs[4] ) {
					$replace = $regs[5];
				} else {
					$replace = $regs[6];
				}
			} else {
				if ( $this->get($regs[2]) ) {
					$replace = $regs[5];
				} else {
					$replace = $regs[6];
				}
			}
			$template = str_replace($regs[0], $replace, $template);
			$iter++;
			if ( $iter == 100 ) {
				trigger_error("Překročen maximální počet volání 'if' v šabloně '".$this->getTemplate()."'.", E_USER_ERROR);
			}
		}
		return $template;
	}

	private function processLoops ( $template ) {
		$iter1 = 0;
		while ( preg_match("/<!--{while ([a-z0-9_]+)}-->/", $template, $regs) ) {
			$start = strpos($template, $regs[0]) + strlen($regs[0]);
			$end = strpos($template, "<!--{/while}-->");
			$loop = substr($template, $start, $end-$start);
			$data = $this->get($regs[1]);
			$replace = "";
			if ( is_array($data) ) {
				for ( $i = 0; $i < sizeof($data); $i++ ) {
					$iter = $loop;
					$iter2 = 0;
					while ( preg_match("#<!--\{(if )?([a-z0-9_]+) *(==? *([a-z0-9_]+))? *\?([^:]*):(.*(?=\{/if\}-->))\{/if\}-->#", $iter, $parts) ) {
						if ( strlen($parts[4]) > 0 ) {
							if ( isset($data[$i][$parts[2]]) ) {
								if ( $data[$i][$parts[2]] == $this->get($parts[4]) || $data[$i][$parts[2]] == $parts[4] ) {
									$rep = $parts[5];
								} else {
									$rep = $parts[6];
								}
							} else {
								$rep = "";
							}
						} else {
							if ( (isset($data[$i][$parts[2]]) && $data[$i][$parts[2]]) || $this->get($parts[2]) ) {
								$rep = $parts[5];
							} else {
								$rep = $parts[6];
							}
						}
						$iter = str_replace($parts[0], $rep, $iter);
						$iter2++;
						if ( $iter2 == 100 ) {
							trigger_error("Překročen maximální počet volání 'if' v cyklu 'while' v šabloně '".$this->getTemplate()."'.", E_USER_ERROR);
						}
					}
					$iter3 = 0;
					while ( preg_match("/<!--(every|each)\(([0-9]+),([^\)]+)\)-->/", $iter, $parts) ) {
						if ( ($i+1) % $parts[2] == 0 ) {
							if ( $parts[1] == "each" && (($i+1) == 1 || ($i+1) == sizeof($data)) ) {
								$rep = "";
							} else {
								$rep = $parts[3];
							}
						} else {
							$rep = "";
						}
						$iter = str_replace($parts[0], $rep, $iter);
						$iter3++;
						if ( $iter3 == 100 ) {
							trigger_error("Překročen maximální počet proměnných v cyklu 'while' v šabloně '".$this->getTemplate()."'.", E_USER_ERROR);
						}
					}
					$iter4 = 0;
					while ( preg_match("/<!--{([a-z0-9_]+)}-->/", $iter, $parts) ) {
						if ( isset($data[$i][$parts[1]]) ) {
							$rep = stripslashes($data[$i][$parts[1]]);
						} elseif($this->get($parts[1]) != '') {
							$rep = stripslashes($this->get($parts[1]));
						} else {
							$rep = "";
						}
						$iter = str_replace($parts[0], $rep, $iter);
						$iter4++;
						if ( $iter4 == 100 ) {
							trigger_error("Překročen maximální počet proměnných v cyklu 'while' v šabloně '".$this->getTemplate()."'.", E_USER_ERROR);
						}
					}
					$replace .= $iter;
				}
			}
			$template = str_replace($regs[0].$loop."<!--{/while}-->", $replace, $template);
			$iter1++;
			if ( $iter1 == 100 ) {
				trigger_error("Překročen maximální počet volání 'while' v šabloně '".$this->getTemplate()."'.", E_USER_ERROR);
			}
		}
		return $template;
	}

	private function makeSortableLinks ( $template ) {
		while ( preg_match("#<!--{sortable ([a-z0-9_]+)}-->#", $template, $regs) ) {
			$start = strpos($template, $regs[0]) + strlen($regs[0]);
			$end = strpos($template, "<!--{/sortable}-->");
			$name = substr($template, $start, $end-$start);
			$active = false;
			if ( isset($_GET['sort']) && $_GET['sort'] == $regs[1] ) {
				$sort = $regs[1];
				$active = true;
				if ( isset($_GET['order']) && $_GET['order'] == 'asc' ) {
					$order = 'desc';
				} else {
					$order = 'asc';
				}
			} else {
				$sort = $regs[1];
				$order = 'asc';
			}
			$back = $_GET;
			unset($_GET['rt']);
			unset($_GET['page']);
			$_GET['sort'] = $sort;
			$_GET['order'] = $order;
			$qs = '?'.http_build_query($_GET, "", "&amp;");
			$_GET = $back;
			$template = str_replace($regs[0].$name."<!--{/sortable}-->", '<a href="'.$qs.'" class="nolink'.($active?'-active':'').'">'.$name.'</a>', $template);
		}
		return $template;
	}

	private function printAlerts ( $template ) {
		while ( preg_match('#(?i)<!--!alerts-->#', $template, $regs) ) {
			$replace = '';
			foreach( $this->info as $level => $messages ) {
				$replace .= '<div class="alert alert-block alert-'.$level.' fade in"><a class="close" data-dismiss="alert" href="#">&times;</a><ul>';
				foreach( $messages as $msg)
					$replace .= '<li>'.(count($messages) == 1?'':'- ').$msg.'</li>';
				$replace .= '</ul></div>';
			}
			$template = str_replace($regs[0], $replace, $template);
		}
		return $template;
	}

	private function setValues ( $template ) {
		$variables = $this->getVariables();
		while ( preg_match('#<!--{([a-z0-9_]+)}-->#', $template, $regs) ) {
			if ( isset($variables[$regs[1]]) ) {
				if(is_array($variables[$regs[1]])) {
					$replace = stripslashes($variables[$regs[1]]);
					$replace = "'".join("', '", $variables[$regs[1]])."'";
				} else {
					$replace = stripslashes($variables[$regs[1]]);
				}
			} else {
				$replace = "";
			}
			$template = str_replace($regs[0], $replace, $template);
		}
		return $template;
	}

	private function setFormValues ( $template ) {
		if ( preg_match_all('#<input[^>]+>#', $template, $regs) ) {
			for ( $i = 0; $i < sizeof($regs[0]); $i++ ) {
				preg_replace_callback("/([a-z-]+)(=\"([^\"]*)\")?/", array($this, "currFormInput"), $regs[0][$i]);
				if ( isset($this->form_elem['name']) && isset($this->form_elem['type']) ) {
					$value = $this->get($this->form_elem['name']);
					if ( $this->form_elem['type'] == 'text' || $this->form_elem['type'] == 'email' || $this->form_elem['type'] == 'hidden' || $this->form_elem['type'] == 'number' ) {
						$this->form_elem['value'] = $value;
					} elseif ( $this->form_elem['type'] == 'checkbox' ) {
						if(strpos($this->form_elem['name'], '[')) {
							if(isset($this->form_elem['value']) && is_array($value)) {
								if(in_array($this->form_elem['value'], $value)) {
									$this->form_elem['checked'] = 'checked';
								}
							}
						} else {
							if ( strlen($value) > 0 ) {
								if(is_numeric($value)) {
									if($value != 0)
										$this->form_elem['checked'] = 'checked';
								} else {
									$this->form_elem['checked'] = 'checked';
								}
							} elseif ( strlen($value) <= 0 && array_key_exists('checked', $this->form_elem) ) {
								unset($this->form_elem['checked']);
							}
						}
					} elseif ( $this->form_elem['type'] == 'radio' ) {
						if ( strlen($value) > 0 && array_key_exists('value', $this->form_elem) && $this->form_elem['value'] == $value ) {
							$this->form_elem['checked'] = "checked";
						} elseif ( array_key_exists("checked", $this->form_elem) && (strlen($value) <= 0 || $this->form_elem['value'] != $value) ) {
							unset($this->form_elem['checked']);
						}
					}
					$elem = "<";
					foreach ( $this->form_elem as $k => $v ) {
						if ( is_null($v) ) {
							$elem .= $k." ";
						} else {
							$elem .= $k."=\"".$v."\" ";
						}
					}
					$elem .= "/>";
					$template = str_replace($regs[0][$i], $elem, $template);
				}
				$this->form_elem = array();
			}
		}
		//select
		if ( preg_match_all("/<select[^>]+>(\s*<option[^>]*>[^<]*<\/option>)+\s*<\/select>/", $template, $regs) ) {
			for ( $i = 0; $i < sizeof($regs[0]); $i++ ) {
				if ( !preg_match("/<select[^>]+name=\"([^\"]+)\"[^>]*>/", $regs[0][$i], $match) ) {
					continue;
				}
				if ( preg_match_all("/<option([^>]*)>([^<]*)<\/option>/", $regs[0][$i], $matches) ) {
					$select = $match[0]."\n";
					$name = $match[1];
					$value = stripslashes($this->get($name));
					for ( $j = 0; $j < sizeof($matches[1]); $j++ ) {
						$opt_val = $matches[2][$j];
						preg_replace_callback("/([a-z]+)(=\"([^\"]*)\")?/", array($this, "currFormInput"), $matches[1][$j]);
						if ( strlen($value) > 0 && array_key_exists("value", $this->form_elem) && $this->form_elem['value'] == $value ) {
							$this->form_elem['selected'] = 'selected';
						} elseif ( array_key_exists('selected', $this->form_elem) && (strlen($value) <= 0 || $this->form_elem['value'] != $value) ) {
							unset($this->form_elem['selected']);
						}
						$select .= "<option";
						foreach ( $this->form_elem as $k => $v ) {
							if ( is_null($v) ) {
								$select .= " ".$k;
							} else {
								$select .= " ".$k."=\"".$v."\"";
							}
						}
						$select .= ">".$opt_val."</option>\n";
						$this->form_elem = array();
					}
					$select .= "</select>";
					$template = str_replace($regs[0][$i], $select, $template);
				}
			}
		}
		//textarea
		if ( preg_match_all("/<textarea([^>]+)name=\"([^\"]+)\"([^>]*)>(.*)<\/textarea>/", $template, $regs) ) {
			for ( $i = 0; $i < sizeof($regs[0]); $i++ ) {
				$new_ta = "<textarea".$regs[1][$i]."name=\"".$regs[2][$i]."\"".$regs[3][$i].">".stripslashes($this->get($regs[2][$i]))."</textarea>";
				$template = str_replace($regs[0][$i], $new_ta, $template);
			}
		}
		return $template;
	}

	/**
	 * parsuje formuláře
	 * @param array $data data formulářového pole
	 * @return string
	 */
	private function currFormInput ( $data ) {
		if ( sizeof($data) == 2 ) {
			$this->form_elem[$data[1]] = null;
		} elseif ( sizeof($data) == 4 ) {
			$this->form_elem[$data[1]] = $data[3];
		} else {
			trigger_error("Nevalidní form element '".htmlspecialchars($data[0])."'", E_USER_WARNING);
		}
		return $data[0];
	}

}

?>
