<?php
/**
* @copyright by Webteam des Weinberg Gymnasiums Kleinmachnow / Malte Metze
* @author 	Malte Metze <malte.metze@gmx.de>
**/

namespace WBGym;

class ModuleLehrersprueche extends \Module {
	
	protected $strTemplate = 'wb_lehrersprueche';
		
	public function generate() {
		if (TL_MODE == 'BE') {
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### Lehrersprüche ###';
			$objTemplate->title = 'Lehrersprüche';
			$objTemplate->id = $this->id;
			$objTemplate->link = 'Lehrersprüche';
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}
		return parent::generate();
	}
	
	protected function compile() {
		
		if(FE_USER_LOGGED_IN) $this->import('FrontendUser','User');
		else {
			$objHandler = new $GLOBALS['TL_PTY']['error_403']();
			$objHandler->generate($objPage->id);
		}
		
		$this->import('Database');
		
		
		if(\Input::post('FORM_SUBMIT') == 'lehrerspruch') {
			$this->Database->prepare("INSERT INTO tl_lehrersprueche (tstamp,from_student,teacher,subject,spruch) VALUES(?,?,?,?,?)")
			->execute(time(),$this->User->id,\Input::post('teacher'),\Input::post('subject'),\Input::post('spruch'));
			
			$this->Template->success = true;
		}
		
		$rows = $this->Database->prepare("SELECT * FROM tl_lehrersprueche")->execute();
		while($row = $rows->fetchAssoc()) {
			
			if($row['teacher'] == 0) $row['teacher_str'] = '[sonstiger Lehrer]'; 
				else $row['teacher_str'] = WBGym::teacher($row['teacher']);
			if($row['subject'] == 0) $row['subject_str'] = '[andere Situation]'; 
				else $row['subject_str'] = WBGym::subject($row['subject'],false);
			
			$row['student_str'] = WBGym::student($row['from_student']);
			$arrData[$row['id']] = $row;
		}

		$this->Template->teacherList = WBGym::teacherList();
		$this->Template->subjectList = WBGym::subjectList();
		$this->Template->data = $arrData;
	}
}
?>