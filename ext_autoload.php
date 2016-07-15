<?php

$key = 'export';

$extensionPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($key, $script);

return array(
	'JambageCom\\Export\\Task\\ExportTask' => $extensionPath . 'Task/ExportTask.php',
	'JambageCom\\Export\\Task\\ExportTaskAdditionalFieldProvider' => $extensionPath . 'Task/ExportTaskAdditionalFieldProvider.php',
	'JambageCom\\Export\\Api\\CsvApi' => $extensionPath . 'Classes/Api/CsvApi.php',
	'JambageCom\\Export\\Api\\ExportApi' => $extensionPath . 'Classes/Api/ExportApi.php',
	'JambageCom\\Export\\Api\\HookApi' => $extensionPath . 'Classes/Api/HookApi.php',
);


