<?php
	if (!IN_DREAMFORGERY) die();
	include_once('phpQuery/selector.inc');
	
	class domQuery {
		public $html = '';
		
		public function load($html) {
			$this->html = $html;
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
			$divs = $dom->select($selector);
			//injectView($selector, $mode, $view_filename) {
		}
	}

?>