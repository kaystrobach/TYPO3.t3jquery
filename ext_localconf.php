<?php
/* Add Hooks */
if (TYPO3_MODE != 'BE') {
	$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3jquery']);
	if ($confArr['alwaysIntegrate']) {
		\T3Ext\T3jquery\Utility\T3jqueryUtility::addJqJS();
	}
}