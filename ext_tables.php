<?php
defined('TYPO3_MODE') or die();

if ('BE' === TYPO3_MODE) {
    \TomasNorre\Crawler\Utility\BackendUtility::registerInfoModuleFunction();
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_crawler_configuration');
}
