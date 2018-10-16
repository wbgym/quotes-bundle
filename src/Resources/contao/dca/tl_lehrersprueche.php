<?php

/**
 * WBGym
 * 
 * Copyright (C) 2015 Webteam Weinberg-Gymnasium Kleinmachnow
 * 
 * @package     WGBym
 * @author      Malte Metze <malte.metze@gmx.de>
 * @license     http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Table tl_christmasmarket
 */
$GLOBALS['TL_DCA']['tl_lehrersprueche'] = array(
	// Config
	'config' => array(
		'dataContainer'		=> 'Table',
		'enableVersioning'	=> true,
		'sql' 				=> array(
			'keys' => array(
				'id' => 'primary'
			)
		)
	),

	// List
	'list' => array(
		'sorting' => array(
			'mode'	=> 1,
			'flag'		=> 2,
			'fields'	=> array('from_student','teacher','subject'),
			'panelLayout' => 'filter,sort;search,limit',
	),
	'label' => array(
		'fields'		=> array('from_student','teacher','subject'),
		'showColumns'	=> true,
		'label_callback'=> array('tl_lehrersprueche','generateLabels'),
	),
	'global_operations' => array(
			'all' => array(
				'label'		=> &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'		=> 'act=select',
				'class'		=> 'header_edit_all',
				'attributes'=> 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array(
			'edit' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_lehrersprueche']['edit'],
				'href'		=> 'act=edit',
				'icon'		=> 'edit.gif'
			),
			'copy' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_lehrersprueche']['copy'],
				'href'		=> 'act=copy',
				'icon'		=> 'copy.gif'
			),
			'delete' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_lehrersprueche']['delete'],
				'href'		=> 'act=delete',
				'icon'		=> 'delete.gif',
				'attributes'=> 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_lehrersprueche']['show'],
				'href'		=> 'act=show',
				'icon'		=> 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array(
		'__selector__' => array(''),
		'default' => '{person_header},teacher,from_student;{info_header},spruch,subject'
	),

	// Fields
	'fields' => array(
		'id' => array(
			'sql'		=> "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array(
			'sql'		=> "int(10) unsigned NOT NULL default '0'"
		),
		'subject' => array(
			'label'		=> &$GLOBALS['TL_LANG']['tl_lehrersprueche']['subject'],
			'exclude'	=> false,
			'inputType'	=> 'select',
			'options_callback' => array('WBGym\WBGym','subjectList'),
			'foreignKey'=> 'tl_subject.name',
			'eval'		=> array('mandatory'=> true),
			'sql'		=> "varchar(64) NOT NULL default ''"
		),
		'teacher' => array(
			'label'		=> &$GLOBALS['TL_LANG']['tl_lehrersprueche']['teacher'],
			'exclude'	=> false,
			'inputType'	=> 'select',
			'options_callback' => array('WBGym\WBGym','teacherList'),
			'foreignKey'=> 'tl_member.username',
			'eval'		=> array('mandatory'=> true,'tl_class'=>'w50'),
			'sql'		=> "varchar(64) NOT NULL default ''"
		),
		'from_student' => array(
			'label'		=> &$GLOBALS['TL_LANG']['tl_lehrersprueche']['from_student'],
			'exclude'	=> false,
			'inputType'	=> 'select',
			'options_callback' => array('tl_lehrersprueche','getStudents'),
			'foreignKey'=> 'tl_member.username',
			'eval'		=> array('mandatory'=> true,'tl_class'=>'w50'),
			'sql'		=> "varchar(64) NOT NULL default ''"
		),
		'spruch' => array(
			'label'		=> &$GLOBALS['TL_LANG']['tl_lehrersprueche']['spruch'],
			'exclude'	=> false,
			'inputType'	=> 'textarea',
			'search'	=> true,
			'sorting'	=> true,
			'eval'		=> array('mandatory' => true,'rte'=>'tinyMCE'),
			'sql'		=> "varchar(500) NOT NULL default ''"
		)
	)
);

class tl_lehrersprueche extends Backend {
	
	function getStudents() {
		$arrStudents = WBGym\WBGym::studentList();
		foreach ($arrStudents as $id => $student) {
			if(WBGym\WBGym::grade(WBGym\WBGym::courseOf($id)) == 12) {
				$arrStudentsNew[$id] = $student;
			}
		}
		return $arrStudentsNew;
	}
	
	function generateLabels($row, $label, DataContainer $dc, $args) {
		$args[0] = WBGym\WBGym::student($row['from_student']);
		$args[1] = WBGym\WBGym::teacher($row['teacher']);
		$args[2] = WBGym\WBGym::subject($row['subject']);
		return $args;
	}
}