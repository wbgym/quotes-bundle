<?php
	namespace LSP;
	
	class LSPuebersicht extends \LSPTask{
		
		public function run() {
			$result = $this->Database->prepare("SELECT * FROM tl_lehrersprueche")->execute();
			while($row = $result->fetchAssoc()) {
				$rows[] = $row;
			}
				
			foreach ($rows as $row) {
				echo "<div class=\"spruch\">";
				echo "<p>" . $row['spruch'] . "</p>"; 
				echo "</div>";
			}
		}
	}
?>