<?php

namespace JambageCom\Export\Api;


/***************************************************************
*  Copyright notice
*
*  (c) 2016 Franz Holzinger (franz@ttproducts.de)
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
 * Export CSV Api
 *
 * @author	Franz Holzinger <franz@ttproducts.de>
 * @maintainer Franz Holzinger <franz@ttproducts.de>
 * @package TYPO3
 * @subpackage export
 */


class CsvApi {

	/**
	* Creates and executes a SELECT SQL-statement AND traverse result set and returns array with records in.
	*
	* @param string $filepath Path and name of the file where to write the CSV.
	* @param string $select_fields List of fields to select from the table. This is what comes right after "SELECT ...". Required value.
	* @param string $from_table Table(s) from which to select. This is what comes right after "FROM ...". Required value.
	* @param string $where_clause Additional WHERE clauses put in the end of the query. NOTICE: You must escape values in this argument with $this->fullQuoteStr() yourself! DO NOT PUT IN GROUP BY, ORDER BY or LIMIT!
	* @param string $groupBy Optional GROUP BY field(s), if none, supply blank string.
	* @param string $orderBy Optional ORDER BY field(s), if none, supply blank string.
	* @param string $limit Optional LIMIT value ([begin,]max), if none, supply blank string.
	* @return array|NULL Array of rows, or NULL in case of SQL error
	* @see exec_SELECTquery()
	* @throws \InvalidArgumentException
	*/
	public function exec_SELECTwriteRows (
	 	$filepath,
		$select_fields,
		$from_table,
		$where_clause,
		$groupBy = '',
		$orderBy = '',
		$limit = ''
	) {
		$result = TRUE;
		if ($select_fields == '*') {
			// use only the fields which come from currently installed extensions
			$fieldArray = \JambageCom\Div2007\Utility\TableUtility::getFields($from_table);
			$select_fields = implode(',', $fieldArray);
		} else {
			$fieldArray = explode(',', $select_fields);
		}

		$csvFile = fopen($filepath, 'w');

		if ($csvFile === FALSE) {
			throw new \TYPO3\CMS\Core\Localization\Exception\FileNotFoundException('Export file "' . $filepath . '" is not writable', 3306332397);
		}

		$res =
			$GLOBALS['TYPO3_DB']->exec_SELECTquery(
				$select_fields,
				$from_table,
				$where_clause,
				$groupBy,
				$orderBy,
				$limit
			);
		if ($GLOBALS['TYPO3_DB']->sql_error()) {
			$GLOBALS['TYPO3_DB']->sql_free_result($res);
			return null;
		}

		// header
		$csvLine = \TYPO3\CMS\Core\Utility\GeneralUtility::csvValues($fieldArray);
		fwrite($csvFile, $csvLine);
		fwrite($csvFile, PHP_EOL);

		while ($record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$csvLine = \TYPO3\CMS\Core\Utility\GeneralUtility::csvValues($record);
			fwrite($csvFile, $csvLine);
			fwrite($csvFile, PHP_EOL);
		}
		fclose($csvFile);
		$GLOBALS['TYPO3_DB']->sql_free_result($res);

		return $result;
	}
}
