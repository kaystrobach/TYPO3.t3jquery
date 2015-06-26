<?php
if (!defined ('TYPO3_MODE')) {
	die('Access denied.');
}


if (TYPO3_MODE == 'BE') {
	// get extension configuration
	$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3jquery']);

	if ($confArr['enableStyleStatic']) {
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/bootstrap',         'T3JQUERY Style: Bootstrap 2 default');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/bootstrap-3.0.x',   'T3JQUERY Style: Bootstrap 3 default');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/mobile',            'T3JQUERY Style: Mobiles default');
		if ($confArr['jQueryUiVersion'] == '1.9.x') {
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/base',           'T3JQUERY Style: UI Base');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/black-tie',      'T3JQUERY Style: UI Black-Tie');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/blitzer',        'T3JQUERY Style: UI Blitzer');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/cupertino',      'T3JQUERY Style: UI Cupertino');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/dark-hive',      'T3JQUERY Style: UI Dark-Hive');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/dot-luv',        'T3JQUERY Style: UI Dot-Luv');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/eggplant',       'T3JQUERY Style: UI Eggplant');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/excite-bike',    'T3JQUERY Style: UI Excite-Bike');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/flick',          'T3JQUERY Style: UI Flick');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/hot-sneaks',     'T3JQUERY Style: UI Hot-Sneaks');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/humanity',       'T3JQUERY Style: UI Humanity');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/le-frog',        'T3JQUERY Style: UI Le-Frog');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/mint-choc',      'T3JQUERY Style: UI Mint-Choc');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/overcast',       'T3JQUERY Style: UI Overcast');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/pepper-grinder', 'T3JQUERY Style: UI Pepper-Grinder');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/redmond',        'T3JQUERY Style: UI Redmond');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/smoothness',     'T3JQUERY Style: UI Smoothness');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/south-street',   'T3JQUERY Style: UI South-Street');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/start',          'T3JQUERY Style: UI Start');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/sunny',          'T3JQUERY Style: UI Sunny');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/swanky-purse',   'T3JQUERY Style: UI Swanky-Purse');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/trontastic',     'T3JQUERY Style: UI Trontastic');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/ui-darkness',    'T3JQUERY Style: UI UI-Darkness');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/ui-lightness',   'T3JQUERY Style: UI UI-Lightness');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.9.x/vader',          'T3JQUERY Style: UI Vader');
		} elseif ($confArr['jQueryUiVersion'] == '1.10.x') {
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/black-tie',      'T3JQUERY Style: UI Black-Tie');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/blitzer',        'T3JQUERY Style: UI Blitzer');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/cupertino',      'T3JQUERY Style: UI Cupertino');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/dark-hive',      'T3JQUERY Style: UI Dark-Hive');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/dot-luv',        'T3JQUERY Style: UI Dot-Luv');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/eggplant',       'T3JQUERY Style: UI Eggplant');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/excite-bike',    'T3JQUERY Style: UI Excite-Bike');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/flick',          'T3JQUERY Style: UI Flick');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/hot-sneaks',     'T3JQUERY Style: UI Hot-Sneaks');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/humanity',       'T3JQUERY Style: UI Humanity');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/le-frog',        'T3JQUERY Style: UI Le-Frog');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/mint-choc',      'T3JQUERY Style: UI Mint-Choc');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/overcast',       'T3JQUERY Style: UI Overcast');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/pepper-grinder', 'T3JQUERY Style: UI Pepper-Grinder');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/redmond',        'T3JQUERY Style: UI Redmond');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/smoothness',     'T3JQUERY Style: UI Smoothness');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/south-street',   'T3JQUERY Style: UI South-Street');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/start',          'T3JQUERY Style: UI Start');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/sunny',          'T3JQUERY Style: UI Sunny');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/swanky-purse',   'T3JQUERY Style: UI Swanky-Purse');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/trontastic',     'T3JQUERY Style: UI Trontastic');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/ui-darkness',    'T3JQUERY Style: UI UI-Darkness');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/ui-lightness',   'T3JQUERY Style: UI UI-Lightness');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui-1.10.x/vader',          'T3JQUERY Style: UI Vader');
		} else {
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/blitzer',        'T3JQUERY Style: UI Blitzer');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/cupertino',      'T3JQUERY Style: UI Cupertino');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/dark-hive',      'T3JQUERY Style: UI Dark-Hive');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/eggplant',       'T3JQUERY Style: UI Eggplant');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/excite-bike',    'T3JQUERY Style: UI Excite-Bike');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/flick',          'T3JQUERY Style: UI Flick');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/hot-sneaks',     'T3JQUERY Style: UI Hot-Sneaks');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/humanity',       'T3JQUERY Style: UI Humanity');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/le-frog',        'T3JQUERY Style: UI Le-Frog');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/overcast',       'T3JQUERY Style: UI Overcast');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/pepper-grinder', 'T3JQUERY Style: UI Pepper-Grinder');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/redmond',        'T3JQUERY Style: UI Redmond');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/smoothness',     'T3JQUERY Style: UI Smoothness');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/south-street',   'T3JQUERY Style: UI South-Street');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/start',          'T3JQUERY Style: UI Start');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/sunny',          'T3JQUERY Style: UI Sunny');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/typo3',          'T3JQUERY Style: UI Typo3');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/ui-darkness',    'T3JQUERY Style: UI UI-Darkness');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/ui-lightness',   'T3JQUERY Style: UI UI-Lightness');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Resources/Public/Static/ui/vader',          'T3JQUERY Style: UI Vader');
		}
	}

	if (! $confArr['integrateFromCDN']) {
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
			'tools_txt3jqueryM1',
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Module/'
		);
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
			'tools',
			'txt3jqueryM1',
			'',
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Module/'
		);
	}
}

?>
