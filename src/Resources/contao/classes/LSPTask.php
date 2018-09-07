<?php
	namespace LSP;
	
	abstract class WSTask extends \Backend {
		
		public function __construct() {
			parent::__construct();
		}
		
		abstract public function run();
	}
?>