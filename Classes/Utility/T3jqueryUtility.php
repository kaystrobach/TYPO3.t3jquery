<?php
/***************************************************************
 * Copyright notice
 *
 * Based on t3mootools from Peter Klein <peter@umloud.dk>
 * (c) 2007-2010 Juergen Furrer (juergen.furrer@gmail.com)
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace T3Ext\T3jquery\Utility;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

$confArr = T3jqueryUtility::getConf();
if ($_POST['data']['jQueryVersion']) {
	$t3jqueryversion = $_POST['data']['jQueryVersion'];
	if ($_POST['data']['jQueryUiVersion']) {
		$t3jqueryversion .= '-' . $_POST['data']['jQueryUiVersion'];
	}
	if ($_POST['data']['jQueryTOOLSVersion']) {
		$t3jqueryversion .= '-' . $_POST['data']['jQueryTOOLSVersion'];
	}
	if ($_POST['data']['jQueryBootstrapVersion']) {
		$t3jqueryversion .= '-' . $_POST['data']['jQueryBootstrapVersion'];
	}
} else {
	$t3jqueryversion = $confArr['jQueryVersion'];
	if ($confArr['jQueryUiVersion']) {
		$t3jqueryversion .= '-' . $confArr['jQueryUiVersion'];
	}
	if ($confArr['jQueryTOOLSVersion']) {
		$t3jqueryversion .= '-' . $confArr['jQueryTOOLSVersion'];
	}
	if ($confArr['jQueryBootstrapVersion']) {
		$t3jqueryversion .= '-' . $confArr['jQueryBootstrapVersion'];
	}
}
define('T3JQUERYVERSION', $t3jqueryversion);

if (file_exists(PATH_site . T3jqueryUtility::getJqPath() . T3jqueryUtility::getJqName()) || ($confArr['integrateFromCDN'] && isset($confArr['locationCDN']))) {
	// check if dontIntegrateOnUID fit to the actual page
	if (T3jqueryUtility::isIntegrated()) {
		define('T3JQUERY', TRUE);
	}
}

/**
 * jQuery Javascript Loader functions
 *
 * You are encouraged to use this library in your own scripts!
 *
 * USE:
 * The class is intended to be used without creating an instance of it.
 * So: Don't instantiate - call functions with "T3jqueryUtility::" prefixed the function name.
 * So use T3jqueryUtility::[method-name] to refer to the functions, eg. 'T3jqueryUtility::addJqJS()'
 *
 * Example:
 *
 * if (t3lib_extMgm::isLoaded('t3jquery')) {
 *   require_once(t3lib_extMgm::extPath('t3jquery').'class.T3jqueryUtility.php');
 * }
 *
 *
 * if (T3JQUERY === TRUE) {
 *   T3jqueryUtility::addJqJS();
 * } else {
 *   // Here you add your own version of jQuery library, which is used if the
 *   // "t3jquery" extension is not installed.
 *   $GLOBALS['TSFE']->additionalHeaderData[] = ..
 * }
 *
 * @author Juergen Furrer (juergen.furrer@gmail.com)
 * @package TYPO3
 * @subpackage t3jquery
 */
class T3jqueryUtility {

	public static $jQueryTOOLSConfig;

	/**
	 * Adds the jquery script tag to the page headers first place
	 * For frontend usage only.
	 * @return void
	 */
	static public function addJqJS() {
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess']['t3jquery']
			= 'T3Ext\\T3jquery\\Utility\\T3jqueryUtility->addJqJsByHook';
	}

	/**
	 * Get the used Section from Configuration
	 * @return boolean
	 */
	static public function getSection() {
		$confArr = T3jqueryUtility::getConf();
		if ($confArr['integrateToFooter']) {
			return PageRenderer::PART_FOOTER;
		} else {
			return PageRenderer::PART_HEADER;
		}
	}

	/**
	 * Return all scripts to include for CDN
	 * @param $params
	 * @return array
	 */
	static public function getCdnScript(&$params = array()) {
		$confArr = T3jqueryUtility::getConf();
		// The dev version does not exist...
		if (substr($confArr['jQueryTOOLSVersion'], -3) == 'dev') {
			GeneralUtility::devLog('jQuery TOOLS Version \'' . $confArr['jQueryTOOLSVersion'] . '\' not in CDN', 't3jquery', 1);
			$confArr['jQueryTOOLSVersion'] = '1.2.5';
		}
		$temp_config = array();
		// CDN version for jQuery (t3jquery 2.0.0)
		if (preg_match("/x$/", $confArr['jQueryVersion'])) {
			$temp_config = self::$jQueryTOOLSConfig = T3jqueryUtility::getJqueryConfiguration();
			$confArr['jQueryVersion'] = $temp_config['version']['cdn'];
		}
		// CDN version for jQueryUI (t3jquery 2.0.0)
		if (preg_match("/x$/", $confArr['jQueryUiVersion'])) {
			$temp_config = self::$jQueryTOOLSConfig = T3jqueryUtility::getJqueryUiConfiguration();
			$confArr['jQueryUiVersion'] = $temp_config['version']['cdn'];
		}
		// CDN version for TOOLS (t3jquery 2.0.0)
		if (preg_match("/x$/", $confArr['jQueryTOOLSVersion'])) {
			$temp_config = self::$jQueryTOOLSConfig = T3jqueryUtility::getJqueryToolsConfiguration();
			$confArr['jQueryTOOLSVersion'] = $temp_config['version']['cdn'];
		}
		// CDN version for Bootstrap (t3jquery 2.0.0)
		if (preg_match("/x$/", $confArr['jQueryBootstrapVersion'])) {
			$temp_config = self::$jQueryTOOLSConfig = T3jqueryUtility::getJqueryBootstrapConfiguration();
			$confArr['jQueryBootstrapVersion'] = $temp_config['version']['cdn'];
		}
		switch ($confArr['locationCDN']) {
			case 'jquery' : {
				// in jQuery TOOLS jQuery is included
				if ($confArr['jQueryTOOLSVersion'] != '') {
					$params['jsLibs']['jQueryTOOLS'] = array(
						'file' => 'http://cdn.jquerytools.org/' . $confArr['jQueryTOOLSVersion'] . '/jquery.tools.min.js',
						'type' => 'text/javascript',
						'section' => self::getSection(),
						'forceOnTop' => TRUE,
						'disableCompression' => FALSE,
						'excludeFromConcatenation' => TRUE
					);
				} else {
					$params['jsLibs']['jQuery'] = array(
						'file' => 'http://code.jquery.com/jquery-' . $confArr['jQueryVersion'] . '.min.js',
						'type' => 'text/javascript',
						'section' => self::getSection(),
						'forceOnTop' => TRUE,
						'disableCompression' => FALSE,
						'excludeFromConcatenation' => TRUE
					);
				}
				if ($confArr['jQueryUiVersion'] != '') {
					$jsFile = 'http://code.jquery.com/ui/' . $confArr['jQueryUiVersion'] . '/jquery-ui.min.js';
					$params['jsFiles'][$jsFile] = array(
						'file' => $jsFile,
						'type' => 'text/javascript',
						'section' => self::getSection(),
						'forceOnTop' => TRUE,
						'disableCompression' => FALSE,
						'excludeFromConcatenation' => TRUE
					);
				}
				if ($confArr['jQueryBootstrapVersion'] != '') {
					if (T3jqueryUtility::getIntFromVersion($confArr['jQueryBootstrapVersion']) < 3000000) {
						if ($confArr['jQueryBootstrapVersion'] == '2.2.0') {
							GeneralUtility::devLog('jQuery Bootstrap \'' . $confArr['jQueryBootstrapVersion'] . '\' not available', 't3jquery', 1);
							$confArr['jQueryBootstrapVersion'] = '2.2.2';
						}
						$jsFile = '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/' . $confArr['jQueryBootstrapVersion'] . '/js/bootstrap.min.js';
					} else {
						$jsFile = '//netdna.bootstrapcdn.com/bootstrap/' . $confArr['jQueryBootstrapVersion'] . '/js/bootstrap.min.js';
					}
					$params['jsFiles'][$jsFile] = array(
						'file' => $jsFile,
						'type' => 'text/javascript',
						'section' => self::getSection(),
						'forceOnTop' => TRUE,
						'disableCompression' => FALSE,
						'excludeFromConcatenation' => TRUE
					);
				}
				break;
			}
			case 'google' : {
				// in jQuery TOOLS jQuery is included
				if ($confArr['jQueryTOOLSVersion'] != '') {
					$params['jsLibs']['jQueryTOOLS'] = array(
						'file' => 'http://cdn.jquerytools.org/' . $confArr['jQueryTOOLSVersion'] . '/jquery.tools.min.js',
						'type' => 'text/javascript',
						'section' => self::getSection(),
						'forceOnTop' => TRUE,
						'disableCompression' => FALSE,
						'excludeFromConcatenation' => TRUE
					);
				} else {
					if ($confArr['jQueryVersion'] == '2.0.0b1') {
						GeneralUtility::devLog('jQuery \'' . $confArr['jQueryVersion'] . '\' not in Google-CDN', 't3jquery', 1);
						$confArr['jQueryVersion'] = '1.9.1';
					}
					$params['jsLibs']['jQuery'] = array(
						'file' => '//ajax.googleapis.com/ajax/libs/jquery/' . $confArr['jQueryVersion'] . '/jquery.min.js',
						'type' => 'text/javascript',
						'section' => self::getSection(),
						'forceOnTop' => TRUE,
						'disableCompression' => FALSE,
						'excludeFromConcatenation' => TRUE
					);
				}
				if ($confArr['jQueryUiVersion'] != '') {
					$jsFile = '//ajax.googleapis.com/ajax/libs/jqueryui/' . $confArr['jQueryUiVersion'] . '/jquery-ui.min.js';
					$params['jsFiles'][$jsFile] = array(
						'file' => $jsFile,
						'type' => 'text/javascript',
						'section' => self::getSection(),
						'forceOnTop' => TRUE,
						'disableCompression' => FALSE,
						'excludeFromConcatenation' => TRUE
					);
				}
				if ($confArr['jQueryBootstrapVersion'] != '') {
					if (T3jqueryUtility::getIntFromVersion($confArr['jQueryBootstrapVersion']) < 3000000) {
						if ($confArr['jQueryBootstrapVersion'] == '2.2.0') {
							GeneralUtility::devLog('jQuery Bootstrap \'' . $confArr['jQueryBootstrapVersion'] . '\' not available', 't3jquery', 1);
							$confArr['jQueryBootstrapVersion'] = '2.2.2';
						}
						$jsFile = '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/' . $confArr['jQueryBootstrapVersion'] . '/js/bootstrap.min.js';
					} else {
						$jsFile = '//netdna.bootstrapcdn.com/bootstrap/' . $confArr['jQueryBootstrapVersion'] . '/js/bootstrap.min.js';
					}
					$params['jsFiles'][$jsFile] = array(
						'file' => $jsFile,
						'type' => 'text/javascript',
						'section' => self::getSection(),
						'forceOnTop' => TRUE,
						'disableCompression' => FALSE,
						'excludeFromConcatenation' => TRUE
					);
				}
				break;
			}
			case 'msn' : {
				// in jQuery TOOLS jQuery is included
				if ($confArr['jQueryTOOLSVersion'] != '') {
					$params['jsLibs']['jQueryTOOLS'] = array(
						'file' => 'http://cdn.jquerytools.org/' . $confArr['jQueryTOOLSVersion'] . '/jquery.tools.min.js',
						'type' => 'text/javascript',
						'section' => self::getSection(),
						'forceOnTop' => TRUE,
						'disableCompression' => FALSE,
						'excludeFromConcatenation' => TRUE
					);
				} else {
					if ($confArr['jQueryVersion'] == '2.0.0b1') {
						GeneralUtility::devLog('jQuery \'' . $confArr['jQueryVersion'] . '\' not in MSN-CDN', 't3jquery', 1);
						$confArr['jQueryVersion'] = '1.9.1';
					}
					if (T3jqueryUtility::getIntFromVersion($confArr['jQueryVersion']) < 1003002) {
						GeneralUtility::devLog('jQuery \'' . $confArr['jQueryVersion'] . '\' not in MSN-CDN', 't3jquery', 1);
						$confArr['jQueryVersion'] = '1.3.2';
					}
					// The MSN CDN does not support 1.x.0 version it's only available under 1.x
					if (preg_match("/\.0$/", $confArr['jQueryVersion'])) {
						$confArr['jQueryVersion'] = substr($confArr['jQueryVersion'], 0, -2);
					}
					$params['jsLibs']['jQuery'] = array(
						'file' => '//ajax.aspnetcdn.com/ajax/jquery/jquery-' . $confArr['jQueryVersion'] . '.min.js',
						'type' => 'text/javascript',
						'section' => self::getSection(),
						'forceOnTop' => TRUE,
						'disableCompression' => FALSE,
						'excludeFromConcatenation' => TRUE
					);
				}
				if ($confArr['jQueryUiVersion'] != '') {
					if (T3jqueryUtility::getIntFromVersion($confArr['jQueryUiVersion']) < 1008005) {
						GeneralUtility::devLog('jQuery UI \'' . $confArr['jQueryUiVersion'] . '\' not in MSN-CDN', 't3jquery', 1);
						$confArr['jQueryUiVersion'] = '1.8.5';
					}
					if (T3jqueryUtility::getIntFromVersion($confArr['jQueryUiVersion']) == 1008024) {
						GeneralUtility::devLog('jQuery UI \'' . $confArr['jQueryUiVersion'] . '\' not in MSN-CDN', 't3jquery', 1);
						$confArr['jQueryUiVersion'] = '1.8.23';
					}
					$jsFile = '//ajax.aspnetcdn.com/ajax/jquery.ui/' . $confArr['jQueryUiVersion'] . '/jquery-ui.min.js';
					$params['jsFiles'][$jsFile] = array(
						'file' => $jsFile,
						'type' => 'text/javascript',
						'section' => self::getSection(),
						'forceOnTop' => TRUE,
						'disableCompression' => FALSE,
						'excludeFromConcatenation' => TRUE
					);
				}
				if ($confArr['jQueryBootstrapVersion'] != '') {
					if (T3jqueryUtility::getIntFromVersion($confArr['jQueryBootstrapVersion']) < 3000000) {
						if ($confArr['jQueryBootstrapVersion'] == '2.2.0') {
							GeneralUtility::devLog('jQuery Bootstrap \'' . $confArr['jQueryBootstrapVersion'] . '\' not available', 't3jquery', 1);
							$confArr['jQueryBootstrapVersion'] = '2.2.2';
						}
						$jsFile = '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/' . $confArr['jQueryBootstrapVersion'] . '/js/bootstrap.min.js';
					} else {
						$jsFile = '//netdna.bootstrapcdn.com/bootstrap/' . $confArr['jQueryBootstrapVersion'] . '/js/bootstrap.min.js';
					}
					$params['jsFiles'][$jsFile] = array(
						'file' => $jsFile,
						'type' => 'text/javascript',
						'section' => self::getSection(),
						'forceOnTop' => TRUE,
						'disableCompression' => FALSE,
						'excludeFromConcatenation' => TRUE
					);
				}
				break;
			}
			default : {
				GeneralUtility::devLog('Unknown CDN-Provider: \'' . $confArr['locationCDN'] . '\'', 't3jquery', 3);
				break;
			}
		}
	}

	/**
	 * Returns the configuration of jQuery UI
	 * @param mixed $version
	 * @return array
	 */
	static public function getJqueryConfiguration($version = NULL) {
		if ($version === NULL) {
			$confArr = T3jqueryUtility::getConf();
			$version = $confArr['jQueryVersion'];
		}
		$configuration = GeneralUtility::xml2array(GeneralUtility::getUrl(GeneralUtility::getFileAbsFileName('EXT:t3jquery/Resources/Public/Res/jquery/core/' . $version . '/jquery.xml')));
		return $configuration;
	}

	/**
	 * Returns the configuration of jQuery UI
	 * @param mixed $version
	 * @return array
	 */
	static public function getJqueryUiConfiguration($version = NULL) {
		if ($version === NULL) {
			$confArr = T3jqueryUtility::getConf();
			$version = $confArr['jQueryUiVersion'];
		}
		$configuration = GeneralUtility::xml2array(GeneralUtility::getUrl(GeneralUtility::getFileAbsFileName('EXT:t3jquery/Resources/Public/Res/jquery/ui/' . $version . '/jquery.xml')));
		return $configuration;
	}

	/**
	 * Returns the configuration of jQuery TOOLS
	 * @param null $version
	 * @return array
	 */
	static public function getJqueryToolsConfiguration($version = NULL) {
		if ($version === NULL) {
			$confArr = T3jqueryUtility::getConf();
			$version = $confArr['jQueryTOOLSVersion'];
		}
		$configuration = GeneralUtility::xml2array(GeneralUtility::getUrl(GeneralUtility::getFileAbsFileName('EXT:t3jquery/Resources/Public/Res/jquery/tools/' . $version . '/jquery.xml')));
		return $configuration;
	}

	/**
	 * Returns the configuration of jQuery Bootstrap
	 * @param null $version
	 * @return array
	 */
	static public function getJqueryBootstrapConfiguration($version = NULL) {
		if ($version === NULL) {
			$confArr = T3jqueryUtility::getConf();
			$version = $confArr['jQueryBootstrapVersion'];
		}
		$configuration = GeneralUtility::xml2array(GeneralUtility::getUrl(GeneralUtility::getFileAbsFileName('EXT:t3jquery/Resources/Public/Res/jquery/bootstrap/' . $version . '/jquery.xml')));
		return $configuration;
	}

	/**
	 * Hook function for adding script
	 *
	 * @param array Params for hook
	 * @return void
	 */
	function addJqJsByHook($params) {
		$confArr = T3jqueryUtility::getConf();
		if (T3jqueryUtility::isIntegrated()) {
			if ($confArr['integrateFromCDN'] && isset($confArr['locationCDN'])) {
				T3jqueryUtility::getCdnScript($params);
			} else {
				$params['jsLibs']['jQuery'] = array(
					'file' => T3jqueryUtility::getJqJS(TRUE),
					'type' => 'text/javascript',
					'section' => self::getSection(),
					'compress' => FALSE,
					'forceOnTop' => TRUE,
					'allWrap' => ''
				);
			}
			define('T3JQUERY', TRUE);
		} else {
			GeneralUtility::devLog('PID \'' . $GLOBALS['TSFE']->id . '\' in dontIntegrateOnUID', 't3jquery', 1);
			define('T3JQUERY', FALSE);
		}
	}

	/**
	 * Returns TRUE if the lib should be integrated
	 *
	 * @return boolean
	 */
	static public function isIntegrated() {
		$confArr = T3jqueryUtility::getConf();
		if (is_object($GLOBALS['TSFE']) and count($GLOBALS['TSFE']->rootLine) > 0) {
			foreach ($GLOBALS['TSFE']->rootLine as $page) {
				if (in_array($page['uid'], array_values(GeneralUtility::trimExplode(',', $confArr['dontIntegrateInRootline'], TRUE)))) {
					return FALSE;
				}
			}
		}
		return (!$confArr['dontIntegrateOnUID'] || !is_object($GLOBALS['TSFE']) || !in_array($GLOBALS['TSFE']->id, array_values(GeneralUtility::trimExplode(',', $confArr['dontIntegrateOnUID'], TRUE))));
	}

	/**
	 * Returns the path configuration and JS
	 * @return string
	 */
	static public function getJqPath() {
		$confArr = T3jqueryUtility::getConf();
		if (preg_match("/\/$/", $confArr['configDir'])) {
			return $confArr['configDir'];
		} else {
			return $confArr['configDir'] . '/';
		}
	}

	/**
	 * Get the jQuery UI script tag.
	 * For frontend usage only.
	 * @param boolean $urlOnly If TRUE, only the URL is returned, not a full script tag
	 * @return string HTML Script tag to load the jQuery JavaScript library
	 */
	static public function getJqJS($urlOnly = FALSE) {
		$url = T3jqueryUtility::getJqPath() . T3jqueryUtility::getJqName();
		if (file_exists(PATH_site . $url)) {
			// Adding absRefPrefix here, makes sure that jquery gets included correctly
			$url = $GLOBALS['TSFE']->absRefPrefix . $url;
			if ($urlOnly) {
				return $url;
			} else {
				return '<script type="text/javascript" src="' . $url . '"></script>';
			}
		} else {
			GeneralUtility::devLog('\'' . T3jqueryUtility::getJqName() . '\' does not exists!', 't3jquery', 3);
		}
		return FALSE;
	}

	/**
	 * Get the jquery script tag.
	 * For backend usage only.
	 * @param boolean $urlOnly If TRUE, only the URL is returned, not a full script tag
	 * @return string HTML Script tag to load the jQuery JavaScript library
	 */
	static public function getJqJSBE($urlOnly = FALSE) {
		$file = T3jqueryUtility::getJqPath() . T3jqueryUtility::getJqName();
		if (file_exists(PATH_site . $file)) {
			$url = GeneralUtility::resolveBackPath($GLOBALS['BACK_PATH'] . '../' . $file);
			if ($urlOnly) {
				return $url;
			} else {
				return '<script type="text/javascript" src="' . $url . '"></script>';
			}
		} else {
			GeneralUtility::devLog('\'' . T3jqueryUtility::getJqName() . '\' does not exists!', 't3jquery', 3);
		}
		return FALSE;
	}

	/**
	 * Returns the name of the jQuery Lib file
	 */
	static public function getJqName() {
		$confArr = T3jqueryUtility::getConf();
		if ($_POST['data']['jqLibFilename']) {
			$confArr['jqLibFilename'] = $_POST['data']['jqLibFilename'];
		}
		if (!isset($confArr['jqLibFilename'])) {
			$confArr['jqLibFilename'] = 'jquery-###VERSION###.js';
		}
		$nameArr = array(
			'###VERSION###' => T3JQUERYVERSION,
		);
		$filename = str_replace(array_keys($nameArr), array_values($nameArr), $confArr['jqLibFilename']);
		return $filename;
	}

	/**
	 * Return the integer value of a version string
	 *
	 * @param string $versionString
	 * @return integer
	 */
	static public function getIntFromVersion($versionString = NULL) {
		return VersionNumberUtility::convertVersionNumberToInteger($versionString);
	}

	/**
	 * Get the configuration of t3jquery
	 * @return array
	 */
	static public function getConf() {
		return unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3jquery']);
	}

	/**
	 * Function to be used from TypoScript to add Javascript after the jquery.js
	 *
	 * This is a small wrapper for adding javascripts script after the jQuery Library.
	 * This is needed in some situations because headerdata added with "page.headerData"
	 * is placed BEFORE the headerdata which is added using PHP.
	 *
	 * Usage:
	 *
	 * includeLibs.t3jquery = EXT:t3jquery/class.T3jqueryUtility.php
	 * page.10 = USER
	 * page.10.userFunc = T3jqueryUtility->addJS
	 * page.10.jsfile = fileadmin/testscript.js
	 * page.10.jsurl = http://www.example.com/script.js
	 * page.10.jsdata = alert('Hello World!');
	 * page.10.forceOnTop = 0
	 * page.10.compress = 0
	 * page.10.type = text/javascript
	 * page.10.allWrap =
	 * page.10.jsinline = 0
	 * page.10.tofooter = 1
	 *
	 * @param string $content : Content input, ignore (just put blank string)
	 * @param array $conf : TypoScript configuration of the plugin!
	 * @return void
	 */
	static public function addJS($content, $conf) {
		// set the cObj from TSFE
		/** @var ContentObjectRenderer $cObj */
		$cObj = $GLOBALS['TSFE']->cObj;
		// Set the tofooter to TRUE if integrateToFooter is set
		$confArr = T3jqueryUtility::getConf();
		if ($confArr['integrateToFooter']) {
			$conf['tofooter'] = 'footer';
		}
		// If the jQuery lib is not added to page yet, add it!
		T3jqueryUtility::addJqJS();
		// where should be the data stored (footer or header) / Fix moveJsFromHeaderToFooter (add all scripts to the footer)
		$conf['tofooter'] = ($conf['tofooter'] || $GLOBALS['TSFE']->config['config']['moveJsFromHeaderToFooter'] ? 'footer' : 'header');
		$conf['compress'] = ($conf['compress'] || $conf['jsminify']);
		$conf['type'] = $conf['type'] ? $conf['type'] : 'text/javascript';
		// Append JS file
		if ($conf['jsfile'] || $conf['jsfile.']) {
			$jsfile = preg_replace('|^' . PATH_site . '|i', '', GeneralUtility::getFileAbsFileName($cObj->stdWrap($conf['jsfile'], $conf['jsfile.'])));
			// Add the Javascript if file exists
			if ($jsfile != '' && file_exists(PATH_site . $jsfile)) {
				T3jqueryUtility::addJsFile($jsfile, $conf);
			} else {
				GeneralUtility::devLog('\'' . $jsfile . '\' does not exists!', 't3jquery', 2);
			}
		}
		// add JS URL
		if ($conf['jsurl'] || $conf['jsurl.']) {
			T3jqueryUtility::addJsFile($cObj->stdWrap($conf['jsurl'], $conf['jsurl.']), $conf);
		}
		// add JS data
		if ($conf['jsdata'] || $conf['jsdata.']) {
			$jsdata = trim($cObj->stdWrap($conf['jsdata'], $conf['jsdata.']));
			if ($jsdata != '') {
				T3jqueryUtility::addJsInlineCode(md5($jsdata), $jsdata, $conf);
			}
		}
		// add JS ready code
		if ($conf['jsready'] || $conf['jsready.']) {
			$jsready = trim($cObj->stdWrap($conf['jsready'], $conf['jsready.']));
			if ($jsready != '') {
				$temp_js = 'jQuery(document).ready(function() {' . $jsready . '});';
				T3jqueryUtility::addJsInlineCode(md5($jsready), $temp_js, $conf);
			}
		}
	}

	/**
	 * Add JS-File to the HTML
	 *
	 * @param string $file
	 * @param array $conf
	 * @return void
	 */
	static public function addJsFile($file, $conf = array()) {
		if (T3jqueryUtility::getIntFromVersion(TYPO3_version) >= 4003000) {
			/** @var PageRenderer $pagerender */
			$pagerender = $GLOBALS['TSFE']->getPageRenderer();
			if ($conf['tofooter'] == 'footer') {
				$pagerender->addJsFooterFile($file, $conf['type'], $conf['compress'], $conf['forceOnTop'], $conf['allWrap']);
			} else {
				$pagerender->addJsFile($file, $conf['type'], $conf['compress'], $conf['forceOnTop'], $conf['allWrap']);
			}
		} else {
			$temp_file = '<script type="text/javascript" src="' . $file . '"></script>';
			if ($conf['tofooter'] == 'footer') {
				$GLOBALS['TSFE']->additionalFooterData['t3jquery.jsfile.' . $file] = $temp_file;
			} else {
				$GLOBALS['TSFE']->additionalHeaderData['t3jquery.jsfile.' . $file] = $temp_file;
			}
		}
	}

	/**
	 * Add inline code to the HTML
	 *
	 * @param string $name
	 * @param string $block
	 * @param array $conf
	 * @return void
	 */
	static public function addJsInlineCode($name, $block, $conf = array()) {
		if ($conf['jsinline']) {
			$GLOBALS['TSFE']->inlineJS['t3jquery.jsdata.' . $name] = $block;
		} elseif (T3jqueryUtility::getIntFromVersion(TYPO3_version) >= 4003000) {
			/** @var PageRenderer $pagerender */
			$pagerender = $GLOBALS['TSFE']->getPageRenderer();
			if ($conf['tofooter'] == 'footer') {
				$pagerender->addJsFooterInlineCode($name, $block, $conf['compress'], $conf['forceOnTop']);
			} else {
				$pagerender->addJsInlineCode($name, $block, $conf['compress'], $conf['forceOnTop']);
			}
		} else {
			if ($conf['compress']) {
				$block = GeneralUtility::minifyJavaScript($block);
			}
			if ($conf['tofooter'] == 'footer') {
				$GLOBALS['TSFE']->additionalFooterData['t3jquery.jsdata.' . $name] = GeneralUtility::wrapJS($block, TRUE);
			} else {
				$GLOBALS['TSFE']->additionalHeaderData['t3jquery.jsdata.' . $name] = GeneralUtility::wrapJS($block, TRUE);
			}
		}
	}
}
