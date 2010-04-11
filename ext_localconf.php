<?php
/* Add Hooks */
if (TYPO3_MODE != 'BE' && t3lib_div::compat_version("4.3.0")) {
	$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3jquery']);
	if ($confArr['alwaysIntegrate']) {
		require_once(t3lib_extMgm::extPath('t3jquery').'class.tx_t3jquery.php');
		tx_t3jquery::addJqJS();
	}
}
?>