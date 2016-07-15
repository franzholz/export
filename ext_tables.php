<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

// \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(EXPORT_EXT, 'Configuration/TypoScript', 'Export Task');


if (TYPO3_MODE === 'BE') {

	// Add context sensitive help (csh) to the backend module
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
		EXPORT_CSHKEY,
		'EXT:' . EXPORT_EXT . '/Resources/Private/Language/locallang_csh_export.xlf'
	);
}

