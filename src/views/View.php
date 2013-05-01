<?php
class View {
	protected $model;
	protected $route;
	protected $template;

	public function __construct($route, ViewModel $model, Template $template) {
		$this->model = $model;
		$this->route = $route;
		$this->template = $template;
	}
	/**
	 * View init
	 * Loads global variables.
	 */
	public function init() {
		$this->template->set('menu', $this->model->getMenu());
		$this->template->set('route', $this->route);
		$this->template->setInfo($this->model->getInfo());
		$user = $this->model->getUser();
		$this->template->set('auth_username', $user?$user->username:0);
	}

	public function pagination($records = 0, $limit = 20, $page = 1) {
		$url = parse_url($_SERVER['REQUEST_URI']);
		$urlParams = preg_replace('#page=([0-9]+)#i', '', isset($url['query'])?$url['query']:'');
		$urlParams = '?'.($urlParams != ''?$urlParams.'&amp;page=':'page=');
		$url = $url['path'].$urlParams;

		$adjacents = 3; // How many adjacent pages should be shown on each side?
		
		$prev = $page - 1;
		$next = $page + 1;
		$lastpage = ceil($records/$limit);
		$lpm1 = $lastpage - 1;

		$pagination = '';

		if($lastpage > 1) {
			$pagination .= '<ul>';
			//previous button
			if ($page > 1) {
				$pagination.= '<li><a href="'.$url.$prev.'">«</a></li>';
			} else {
				$pagination.= '<li class="disabled"><a href="#">«</a></li>';
			}
			//pages	
			if ($lastpage < 7 + ($adjacents * 2)) {
				for ($counter = 1; $counter <= $lastpage; $counter++) {
					if ($counter == $page) {
						$pagination.= '<li class="active"><a href="#">'.$counter.'</a></li>';
					} else {
						$pagination.= '<li><a href="'.$url.$counter.'">'.$counter.'</a></li>';
					}
				}
			} elseif($lastpage > 5 + ($adjacents * 2)) {
				if($page < 1 + ($adjacents * 2)) {
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
						if ($counter == $page) {
							$pagination.= '<li class="active"><a href="#">'.$counter.'</a></li>';
						} else {
							$pagination.= '<li><a href="'.$url.$counter.'">'.$counter.'</a></li>';
						}
					}
					$pagination.= '<li class="disabled"><a href="#">...</a></li>';
					$pagination.= '<li><a href="'.$url.$lpm1.'">'.$lpm1.'</a></li>';
					$pagination.= '<li><a href="'.$url.$lastpage.'">'.$lastpage.'</a></li>';
				} elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
					$pagination.= '<li><a href="'.$url.'1">1</a></li>';
					$pagination.= '<li><a href="'.$url.'2">2</a></li>';
					$pagination.= '<li class="disabled"><a href="#">...</a></li>';
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
						if ($counter == $page) {
							$pagination.= '<li class="active"><a href="#">'.$counter.'</a></li>';
						} else {
							$pagination.= '<li><a href="'.$url.$counter.'">'.$counter.'</a></li>';
						}
					}
					$pagination.= '<li class="disabled"><a href="#">...</a></li>';
					$pagination.= '<li><a href="'.$url.$lpm1.'">'.$lpm1.'</a></li>';
					$pagination.= '<li><a href="'.$url.$lastpage.'">'.$lastpage.'</a></li>';
				} else {
					$pagination.= '<li><a href="'.$url.'1">1</a></li>';
					$pagination.= '<li><a href="'.$url.'2">2</a></li>';
					$pagination.= '<li class="disabled"><a href="#">...</a></li>';
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
						if ($counter == $page) {
							$pagination.= '<li class="active"><a href="#">'.$counter.'</a></li>';
						} else {
							$pagination.= '<li><a href="'.$url.$counter.'">'.$counter.'</a></li>';
						}
					}
				}
			}
			//next button
			if ($page < $counter - 1) {
				$pagination.= "<li><a href=\"$url$next\">»</a></li>";
			} else {
				$pagination.= "<li class=\"disabled\"><a href=\"#\">»</a></li>";
			}
			$pagination.= '</ul>';		
		}
		return $pagination;
	}

	public function output() {
		return $this->template->output();
	}

}

?>