<?php
/* Add Hooks */
if (TYPO3_MODE != 'BE') {
	if (class_exists(t3lib_utility_VersionNumber)) {
		$TYPO3_version = t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version);
	} else {
		$TYPO3_version = t3lib_div::int_from_ver(TYPO3_version);
	}
	if ($TYPO3_version >= 4003000) {
		$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3jquery']);
		if ($confArr['alwaysIntegrate']) {
			tx_t3jquery::addJqJS();
		}
	}
}
?>