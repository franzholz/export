<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "export"
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Export Task',
	'description' => 'This extension offers export tasks for the TYPO3 Scheduler which can be extended by other extensions. It is intended to export SQL database tables into files.',
	'category' => 'be',
	'author' => 'Franz Holzinger',
	'author_email' => 'franz@ttproducts.de',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => 'fileadmin/data/export',
	'clearCacheOnLoad' => 0,
	'version' => '0.0.1',
	'constraints' => array(
		'depends' => array(
			'php' => '5.6.0-7.99.99',
			'typo3' => '6.2.5-7.99.99',
			'div2007' => '1.6.12-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);

