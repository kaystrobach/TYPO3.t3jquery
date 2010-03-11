<?php
if (!defined ('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE == 'BE') {
	t3lib_extMgm::addModule('tools', 'txt3jqueryM1', '', t3lib_extMgm::extPath($_EXTKEY).'mod1/');
} else {
	// Add Hooks
	$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3jquery']);
	if ($confArr['alwaysIntegrate']) {
		require_once(t3lib_extMgm::extPath('t3jquery').'class.tx_t3jquery.php');
		tx_t3jquery::addJqJS();
	}
}
?>