<?php

namespace JambageCom\Export\Task;


/***************************************************************
*  Copyright notice
*
*  (c) 2017 Franz Holzinger (franz@ttproducts.de)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Export Task
 *
 * @author	Franz Holzinger <franz@ttproducts.de>
 * @maintainer Franz Holzinger <franz@ttproducts.de>
 * @package TYPO3
 * @subpackage export
 */

class ExportTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

    /**
    * Array of tables to export
    *
    * @var array $tableArray
    */
    public $tableArray;

    public function __construct() {
        parent::__construct();
        // Your code here...
    }

    public function execute () {

        $result = FALSE;
        $hookDefinitionArray = \JambageCom\Export\Api\HookApi::getHookDefinitionArray();

        if (
            isset($this->tableArray) &&
            is_array($this->tableArray) &&
            !empty($this->tableArray)
        ) {
            $result = TRUE;
            $localDefinitionArray = \JambageCom\Export\Api\ExportApi::getLocalDefinitionArray();
            $definitionArray = array_merge($localDefinitionArray, $hookDefinitionArray);

            foreach ($definitionArray as $definition) {
                if (
                    !isset($definition['tables']) ||
                    !is_array($definition['tables'])
                ) {
                    continue;
                }

                if (isset($definition['ext'])) {

                    $foreignExtension = $definition['ext'];
                    if (
                        $foreignExtension != EXPORT_EXT &&
                        !\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded($foreignExtension)
                    ) {
                        return FALSE;
                    }
                }

                $extensionTables = array();
                foreach ($definition['tables'] as $definition) {
                    $extensionTables[] = $definition['table'];
                }
                $theTableArray = array();

                foreach ($this->tableArray as $table) {
                    if (in_array($table, $extensionTables)) {
                        $theTableArray[] = $table;
                    }
                }

                if (!empty($theTableArray)) {
                    if (isset($definition['class'])) {

                        $foreignClass = $definition['class'];
                        if (
                            class_exists($foreignClass) &&
                            method_exists($foreignClass, 'execute')
                        ) {
                            $result = call_user_func($foreignClass . '::execute', $theTableArray);
                        } else {
                            $result = FALSE;
                            break;
                        }
                    } else {
                        \JambageCom\Export\Api\ExportApi::execute($theTableArray);
                    }
                }
            }
        }

        return $result;

    }


    public function getAdditionalInformation () {
    }
}


