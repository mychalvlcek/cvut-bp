<?php

class Template {
	private $fileName;
	private $variables = array();

	public function __construct($fileName = '') {
		$this->fileName = $fileName.'.html';
	}

	public function output($layout = true) {
		$template = $this->loadTemplate($layout);
		$template = $this->addIncludes($template);
		$template = $this->processConditions($template);
		$template = $this->processLoops($template);
		$template = $this->setValues($template);
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

	public function gets() {
		return $this->variables;
	}

	private function loadTemplate($layout) {
		if($layout) {
			$template = file_get_contents(PATH.'templates/_layout.html');
			return $this->addTemplate($template);
			//return file_get_contents(PATH.'templates/'.$this->fileName);
		} else {
			return file_get_contents(PATH.'templates/'.$this->fileName);
		}
	}

	private function addTemplate($template) {
		while ( preg_match("/<!--{template_file}-->/", $template, $regs) ) {
			$path = PATH. 'templates/' .$this->fileName;
			$include = '';
			if ( !is_file($path) )
				trigger_error('Could not load template. Non-exists template "'.$path.'".', E_USER_ERROR);
			$include = file_get_contents($path);
			$template = str_replace($regs[0], $include, $template);
		}
		return $template;
	}

	private function addIncludes($template) {
		$filename = $this->fileName;

		while ( preg_match("/<!--(!)?include ([a-zA-Z0-9_\/-]+\.html)-->/", $template, $regs) ) {
			if ( $filename == $regs[2] ) {
				trigger_error("Rekurentní načítání šablony \"".$regs[2]."\".", E_USER_ERROR);
			}
			$path = web_abs_path."view/web/".web_template."/".$regs[2];
			if ( $regs[1] == "!" ) {
				$required = true;
			} else {
				$required = false;
			}
			$include = "";
			if ( is_file($path) ) {
				$include = file_get_contents($path);
			} else {
				trigger_error("Nelze načíst obsah pro vložení. Neexistující šablona \"".$path."\".", $required?E_USER_ERROR:E_USER_WARNING);
			}
			$template = str_replace($regs[0], $include, $template);
		}
		return $template;
	}

	private function processConditions ( $template ) {
		$iter = 0;
		while ( preg_match("/<!--(if )?([a-z0-9_]+) *(==? *([a-z0-9_]+))? *\?([^;]*);([^-]*)-->/", $template, $regs) ) {
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
		while ( preg_match("/<!--while ([a-z0-9_]+)-->/", $template, $regs) ) {
			$start = strpos($template, $regs[0]) + strlen($regs[0]);
			$end = strpos($template, "<!--/while-->");
			$loop = substr($template, $start, $end-$start);
			$data = $this->get($regs[1]);
			$replace = "";
			if ( is_array($data) ) {
				for ( $i = 0; $i < sizeof($data); $i++ ) {
					$iter = $loop;
					$iter2 = 0;
					while ( preg_match("/<!--(if )?([a-z0-9_]+) *(==? *([a-z0-9_]+))? *\?([^;]*);([^XXX]*)XXX-->/", $iter, $parts) ) {
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
							if ( $this->get($parts[2]) ) {
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
					while ( preg_match("/<!--([a-z0-9_]+)-->/", $iter, $parts) ) {
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
			$template = str_replace($regs[0].$loop."<!--/while-->", $replace, $template);
			$iter1++;
			if ( $iter1 == 100 ) {
				trigger_error("Překročen maximální počet volání 'while' v šabloně '".$this->getTemplate()."'.", E_USER_ERROR);
			}
		}
		return $template;
	}

	private function setValues ( $template ) {
		$variables = $this->gets();
		while ( preg_match("/<!--{([a-z0-9_]+)}-->/", $template, $regs) ) {
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

}

?>
