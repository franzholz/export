<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

define('EXPORT_EXT', $_EXTKEY);
define('EXPORT_CSHKEY', '_MOD_system_txschedulerM1_' . $_EXTKEY); // key for the Context Sensitive H

// Add the export task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['JambageCom\\Export\\Task\\ExportTask'] = array(
	'extension' => $_EXTKEY,
	'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:exportTask.name',
	'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:exportTask.description',
	'additionalFields' => 'JambageCom\\Export\\Task\\ExportTaskAdditionalFieldProvider'
);

$_EXTCONF = unserialize($_EXTCONF);    // unserializing the configuration so we can use it here:

if (
	isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY]) &&
	is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY])
) {
	$tmpArray = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY];
} else if (isset($tmpArray)) {
	unset($tmpArray);
}

if (isset($_EXTCONF) && is_array($_EXTCONF)) {
	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY] = $_EXTCONF;
	if (isset($tmpArray) && is_array($tmpArray)) {
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY] =
			array_merge($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY], $tmpArray);
	}
} else if (!isset($tmpArray)) {
	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY] = array();
}


