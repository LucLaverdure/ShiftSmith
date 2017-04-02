<?php
	if (!IN_SHIFTSMITH) die();
	include_once($main_path.'core/phpQuery/selector.php');
	
	class domQuery {
		public $html = '';
		
		public function setHtml($loadhtml) {
			$this->html = $loadhtml;
		}
		public function prepend($selector, $template) {
			return str_replace($this->select($selector), $template.$this->html, $template);
		}
		public function append($selector, $template) {
			return str_replace($this->select($selector), $this->html.$template, $template);
		}
		public function replace($selector, $template) {
			return str_replace($this->select($selector), $this->html, $template);
		}
		public function select($selector) {
			$dom = new SelectorDom($this->html);
			$divs = $dom->select('div a');

 			return $divs;
		}
		
		public function getHtml() {
			return $this->html;
		}
	}

?>