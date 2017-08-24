<?php

namespace JambageCom\Export\Api;


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
 * Export Hook Api
 *
 * @author	Franz Holzinger <franz@ttproducts.de>
 * @maintainer Franz Holzinger <franz@ttproducts.de>
 * @package TYPO3
 * @subpackage export
 */


class HookApi {

    static public function getHookArray () {
        $result = array();

                // Hook to handle own checks
        if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][EXPORT_EXT]['hook'])) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][EXPORT_EXT]['hook'] as $key => $classRef) {
                $hookObj = \TYPO3\CMS\Core\Utility\GeneralUtility::getUserObj($classRef);
                if (is_object($hookObj)) {
                    $result[$key] = $hookObj;
                }
            }
        }

        return $result;
    }

// The hook definition array must have this format:
//
//     $hookDefinitionArray =
//     array(
//         'ext' => 'export_tt_products',
//         'class' => 'JambageCom\\ExportTtProducts\\Api\\ExportApi',
//         'tables' => array(
//             array(
//                 'table' => 'sys_products_orders',
//                 'title' => 'Bestellungen'
//             ),
//             array(
//                 'table' => 'test',
//                 'title' => 'Test'
//             ),
//         )
//     );

    static public function getHookDefinitionArray () {
        $hookArray = self::getHookArray();
        $result = array();

        if (is_array($hookArray)) {
            foreach ($hookArray as $hookObj) {
                if (method_exists($hookObj, 'getDefinitionArray')) {
                    $definitionArray = $hookObj->getDefinitionArray();
                    if (
                        isset($definitionArray) &&
                        is_array($definitionArray) &&
                        isset($definitionArray['ext']) &&
                        isset($definitionArray['tables']) &&
                        is_array($definitionArray['tables'])
                    ) {
                        $result[] = $definitionArray;
                    }
                }
            }
        }
        return $result;
    }
}


