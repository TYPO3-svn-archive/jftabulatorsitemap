<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Juergen Furrer <juergen.furrer@gmail.com>
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
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(PATH_tslib.'class.tslib_pibase.php');

if (t3lib_extMgm::isLoaded('t3jquery')) {
	require_once(t3lib_extMgm::extPath('t3jquery').'class.tx_t3jquery.php');
}

/**
 * Plugin 'Tabulator Sitemap' for the 'jftabulatorsitemap' extension.
 *
 * @author	Juergen Furrer <juergen.furrer@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_jftabulatorsitemap
 */
class tx_jftabulatorsitemap_pi1 extends tslib_pibase
{
	public $prefixId      = 'tx_jftabulatorsitemap_pi1';
	public $scriptRelPath = 'pi1/class.tx_jftabulatorsitemap_pi1.php';
	public $extKey        = 'jftabulatorsitemap';
	public $pi_checkCHash = TRUE;
	private $contentKey = null;
	private $templateFileJS = null;
	private $jsFiles = array();
	private $js = array();
	private $cssFiles = array();
	private $css = array();

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website (Menu)
	 */
	public function main($content, $conf)
	{
		$this->conf = $conf;

		// define the key of the element
		$this->contentKey = "jftabulatorsitemap_c" . $this->cObj->data['uid'];

		// Read the flexform if list_type is set
		if ($this->cObj->data['list_type'] == $this->extKey.'_pi1') {

			// It's a content, all data from flexform

			$this->lConf['tabCollapsible'] = $this->getFlexformData('general', 'tabCollapsible');
			$this->lConf['tabOpen']        = $this->getFlexformData('general', 'tabOpen');
			$this->lConf['tabRandomTab']   = $this->getFlexformData('general', 'tabRandomTab');
			$this->lConf['tabFxHeight']    = $this->getFlexformData('general', 'tabFxHeight');
			$this->lConf['tabFxOpacity']   = $this->getFlexformData('general', 'tabFxOpacity');
			$this->lConf['tabFxDuration']  = $this->getFlexformData('general', 'tabFxDuration');
			$this->lConf['tabCache']       = $this->getFlexformData('general', 'tabCache');
			$this->lConf['tabPreload']     = $this->getFlexformData('general', 'tabPreload');
			$this->lConf['tabTitles']      = $this->getFlexformData('general', 'tabTitles');

			$this->lConf['tabShowSpinner']       = $this->getFlexformData('spinner', 'tabShowSpinner');
			$this->lConf['spinnerPanel']         = $this->getFlexformData('spinner', 'spinnerPanel');
			$this->lConf['spinnerPanelPosition'] = $this->getFlexformData('spinner', 'spinnerPanelPosition');

			// tab
			if ($this->lConf['tabCollapsible'] < 2) {
				$this->conf['tabCollapsible'] = $this->lConf['tabCollapsible'];
			}
			if ($this->lConf['tabFxHeight'] < 2) {
				$this->conf['tabFxHeight'] = $this->lConf['tabFxHeight'];
			}
			if ($this->lConf['tabFxOpacity'] < 2) {
				$this->conf['tabFxOpacity'] = $this->lConf['tabFxOpacity'];
			}
			if ($this->lConf['tabFxDuration'] > 0) {
				$this->conf['tabFxDuration'] = $this->lConf['tabFxDuration'];
			}
			if ($this->lConf['tabOpen'] > 0) {
				$this->conf['tabOpen'] = $this->lConf['tabOpen'];
			}
			if ($this->lConf['tabRandomTab'] < 2) {
				$this->conf['tabRandomTab'] = $this->lConf['tabRandomTab'];
			}
			if ($this->lConf['tabCache'] < 2) {
				$this->conf['tabCache'] = $this->lConf['tabCache'];
			}
			if ($this->lConf['tabPreload'] < 2) {
				$this->conf['tabPreload'] = $this->lConf['tabPreload'];
			}
			if ($this->lConf['tabShowSpinner'] < 2) {
				$this->conf['tabShowSpinner'] = $this->lConf['tabShowSpinner'];
			}
			if ($this->lConf['spinnerPanel'] < 2) {
				$this->conf['spinnerPanel'] = $this->lConf['spinnerPanel'];
			}
			if ($this->lConf['spinnerPanelPosition']) {
				$this->conf['spinnerPanelPosition'] = $this->lConf['spinnerPanelPosition'];
			}
			if ($this->lConf['tabTitles']) {
				$this->conf['tabTitles'] = $this->lConf['tabTitles'];
			}
		}

		// The template for JS
		if (! $this->templateFileJS = $this->cObj->fileResource($this->conf['templateFileJS'])) {
			$this->templateFileJS = $this->cObj->fileResource("EXT:jftabulatorsitemap/res/tx_jftabulatorsitemap_pi1.js");
		}

		$menuPids = t3lib_div::trimExplode(",", $this->cObj->data['pages'] ? $this->cObj->data['pages'] : intval($GLOBALS['TSFE']->id), 1);

		// define the select hidden / nav_hide
		$select = array();
		if (! $this->conf['showNavHidePages']) {
			$select[] = 'AND nav_hide=0';
		}
		$doktypes = t3lib_div::intExplode(',', $this->conf['showDoktypes'], TRUE);
		if (count($doktypes) > 0) {
			$select[] = 'AND doktype IN ('.implode(',', $doktypes).')';
		}
		$items = null;
		$itemName = array();
		$current = 0;
		if (count($menuPids) > 0) {
			foreach ($menuPids as $menuPid) {
				$menuItems_level1 = $GLOBALS['TSFE']->sys_page->getMenu($menuPid, '*', 'sorting', implode(" ", $select), 1);
				reset($menuItems_level1);
				while(list($uid, $pages_row) = each($menuItems_level1)) {
					$newId = $this->cleanTitel($pages_row['title'], $itemName, 0);
					$itemName[] = $newId;
					$GLOBALS['TSFE']->register['key']              = $this->contentKey;
					$GLOBALS['TSFE']->register['uid']              = $pages_row['uid'];
					$GLOBALS['TSFE']->register['target']           = $pages_row['target'];
					$GLOBALS['TSFE']->register['uniquetitle']      = $newId;
					$GLOBALS['TSFE']->register['titles']           = $this->conf['tabTitles'];
					$GLOBALS['TSFE']->register['SITE_NUM_CURRENT'] = $current;
					$item   = trim($this->cObj->cObjGetSingle($this->conf['tabItem'], $this->conf['tabItem.']));
					$items .= $this->cObj->stdWrap($item, $this->conf['tabWrap.']);
					$current ++;
				}
			}
		}
		$content = $this->cObj->stdWrap($items, $this->conf['stdWrap.']);

		// define the jQuery mode and function
		if ($this->conf['jQueryNoConflict']) {
			$jQueryNoConflict = "jQuery.noConflict();";
		} else {
			$jQueryNoConflict = "";
		}

		// Set FX for tab
		$fx = array();
		if ($this->conf['tabFxHeight']) {
			$fx[] = "height: 'toggle'";
		}
		if ($this->conf['tabFxOpacity']) {
			$fx[] = "opacity: 'toggle'";
		}
		if ($this->conf['tabFxDuration'] || is_numeric($this->conf['tabFxDuration'])) {
			$fx[] = "duration: ".(is_numeric($this->conf['tabFxDuration']) ? $this->conf['tabFxDuration'] : "'{$this->conf['tabFxDuration']}'");
		}
		// Set options for tab
		$options = array();
		if (count($fx) > 0) {
			$options[] = "fx: {".implode(",", $fx)."}";
		}
		if ($this->conf['tabCollapsible']) {
			$options['collapsible'] = "collapsible: true";
		}
		if ($this->conf['tabRandomTab']) {
			$options['selected'] = "selected: Math.floor(Math.random()*".count($menuItems_level1).")";
		} elseif (is_numeric($this->conf['tabOpen'])) {
			$options['selected'] = "selected: ".(($this->conf['tabOpen'] > count($menuItems_level1) ? count($menuItems_level1) : $this->conf['tabOpen']) - 1);
		}
		if ($this->conf['tabCache']) {
			$options['cache'] = "cache: true";
		}
		$spinner = t3lib_div::slashJS(trim($this->cObj->cObjGetSingle($this->conf['tabSpinner'], $this->conf['tabSpinner.'])));
		if ($this->conf['tabShowSpinner']) {
			$options['spinner'] = "spinner: '".$spinner."'";
		} else {
			$options['spinner'] = "spinner: ''";
		}

		// get the Template of the Javascript
		$markerArray = array();
		// get the template
		if (! $templateCode = trim($this->cObj->getSubpart($this->templateFileJS, "###TEMPLATE_TAB_JS###"))) {
			$templateCode = $this->outputError("Template TEMPLATE_TAB_JS is missing", TRUE);
		}

		// TAB_PRELOAD
		$tabPreload = null;
		if ($this->conf['tabPreload']) {
			$options['ajaxOptions'] = "ajaxOptions: {async: false}";
			$tabPreload = trim($this->cObj->getSubpart($templateCode, "###TAB_PRELOAD###"));
		}
		$templateCode = $this->cObj->substituteSubpart($templateCode, '###TAB_PRELOAD###', $tabPreload, 0);

		// PANEL_SPINNER
		$spinnerPanel = null;
		if ($this->conf['spinnerPanel']) {
			$options['ajaxOptions'] = "ajaxOptions: {async: false}";
			$options['spinnerPanel'] = "spinnerPanel: '".$spinner."'";
			$spinnerPanel = trim($this->cObj->getSubpart($templateCode, "###PANEL_SPINNER###"));
			if ($this->conf['spinnerPanelPosition'] == 'html') {
				// cache is not permitted (results in empty panel)
				$options['cache'] = "cache: false";
			}
		}
		$templateCode = $this->cObj->substituteSubpart($templateCode, '###PANEL_SPINNER###', $spinnerPanel, 0);

		// Replace default values
		$markerArray["KEY"]     = $this->contentKey;
		$markerArray["OPTIONS"] = implode(", ", $options);
		$markerArray["SPINNER_PANEL_POSITION"] = ($this->conf['spinnerPanelPosition'] ? $this->conf['spinnerPanelPosition'] : 'prepend');
		$templateCode = $this->cObj->substituteMarkerArray($templateCode, $markerArray, '###|###', 0);

		$this->addCssFile($this->conf['jQueryUIstyle']);

		// If the request comes via AJAX, the JS will be added to the content
		if ($this->isAjax()) {
			$content .= t3lib_div::wrapJS($jQueryNoConflict . $templateCode);
		} else {
			$this->addJS($jQueryNoConflict . $templateCode);
		}

		// Add the ressources
		$this->addResources();

		return $this->pi_wrapInBaseClass($content);
	}

	/**
	 * Cleans a string from spaces and check its unique in a given array
	 * @param string  $title
	 * @param string  $spaceCharacter
	 * @param array   $itemsArray
	 * @param integer $iterator
	 * @return string
	 */
	private function cleanTitel($title='', $itemsArray=array(), $iterator=0)
	{
		// add the iterator when set
		if ($iterator > 0) {
			$title .= ' '.$iterator;
		}

		// Fetch character set:
		$charset = $GLOBALS['TYPO3_CONF_VARS']['BE']['forceCharset'] ? $GLOBALS['TYPO3_CONF_VARS']['BE']['forceCharset'] : $GLOBALS['TSFE']->defaultCharSet;

		// Convert to lowercase:
		$processedTitle = $GLOBALS['TSFE']->csConvObj->conv_case($charset, $title, 'toLower');

		// Strip tags
		$processedTitle = strip_tags($processedTitle);

		// Convert some special tokens to the space character
		$space = (isset($this->conf['spaceCharacter']) ? $this->conf['spaceCharacter'] : '-');
		$processedTitle = preg_replace('/[ \-+_]+/', $space, $processedTitle); // convert spaces

		// Convert extended letters to ascii equivalents
		$processedTitle = $GLOBALS['TSFE']->csConvObj->specCharsToASCII($charset, $processedTitle);

		// Strip the rest
		if ($space) {
			$processedTitle = preg_replace('/[^a-zA-Z0-9\\' . $space . ']/', '', $processedTitle);
			$processedTitle = preg_replace('/\\' . $space . '{2,}/', $space, $processedTitle); // Convert multiple 'spaces' to a single one
		}
		$processedTitle = trim($processedTitle, $space);

		// check if the string is allready in use
		if (in_array($processedTitle, $itemsArray)) {
			return $this->cleanTitel($title, $itemsArray, $iterator+1);
		} else {
			return strtolower($processedTitle);
		}
	}

	/**
	 * Include all defined resources (JS / CSS)
	 *
	 * @return void
	 */
	private function addResources()
	{
		// checks if t3jquery is loaded
		if (T3JQUERY === TRUE) {
			tx_t3jquery::addJqJS();
		} else {
			$this->addJsFile($this->conf['jQueryLibrary'], TRUE);
			$this->addJsFile($this->conf['jQueryUI']);
		}
		if (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
			$pagerender = $GLOBALS['TSFE']->getPageRenderer();
		}
		// Fix moveJsFromHeaderToFooter (add all scripts to the footer)
		if ($GLOBALS['TSFE']->config['config']['moveJsFromHeaderToFooter']) {
			$allJsInFooter = TRUE;
		} else {
			$allJsInFooter = FALSE;
		}
		// add all defined JS files
		if (count($this->jsFiles) > 0) {
			foreach ($this->jsFiles as $jsToLoad) {
				if (T3JQUERY === TRUE) {
					$conf = array(
						'jsfile' => $jsToLoad,
						'tofooter' => ($this->conf['jsInFooter'] || $allJsInFooter),
						'jsminify' => $this->conf['jsMinify'],
					);
					tx_t3jquery::addJS('', $conf);
				} else {
					$file = $this->getPath($jsToLoad);
					if ($file) {
						if (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
							if ($allJsInFooter) {
								$pagerender->addJsFooterFile($file, 'text/javascript', $this->conf['jsMinify']);
							} else {
								$pagerender->addJsFile($file, 'text/javascript', $this->conf['jsMinify']);
							}
						} else {
							$temp_file = '<script type="text/javascript" src="'.$file.'"></script>';
							if ($allJsInFooter) {
								$GLOBALS['TSFE']->additionalFooterData['jsFile_'.$this->extKey.'_'.$file] = $temp_file;
							} else {
								$GLOBALS['TSFE']->additionalHeaderData['jsFile_'.$this->extKey.'_'.$file] = $temp_file;
							}
						}
					} else {
						t3lib_div::devLog("'{$jsToLoad}' does not exists!", $this->extKey, 2);
					}
				}
			}
		}
		// add all defined JS script
		if (count($this->js) > 0) {
			foreach ($this->js as $jsToPut) {
				$temp_js .= $jsToPut;
			}
			$conf = array();
			$conf['jsdata'] = $temp_js;
			if (T3JQUERY === TRUE && t3lib_div::int_from_ver($this->getExtensionVersion('t3jquery')) >= 1002000) {
				$conf['tofooter'] = ($this->conf['jsInFooter'] || $allJsInFooter);
				$conf['jsminify'] = $this->conf['jsMinify'];
				$conf['jsinline'] = $this->conf['jsInline'];
				tx_t3jquery::addJS('', $conf);
			} else {
				// Add script only once
				$hash = md5($temp_js);
				if ($this->conf['jsInline']) {
					$GLOBALS['TSFE']->inlineJS[$hash] = $temp_css;
				} elseif (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
					if ($this->conf['jsInFooter'] || $allJsInFooter) {
						$pagerender->addJsFooterInlineCode($hash, $temp_js, $this->conf['jsMinify']);
					} else {
						$pagerender->addJsInlineCode($hash, $temp_js, $this->conf['jsMinify']);
					}
				} else {
					if ($this->conf['jsMinify']) {
						$temp_js = t3lib_div::minifyJavaScript($temp_js);
					}
					if ($this->conf['jsInFooter'] || $allJsInFooter) {
						$GLOBALS['TSFE']->additionalFooterData['js_'.$this->extKey.'_'.$hash] = t3lib_div::wrapJS($temp_js, TRUE);
					} else {
						$GLOBALS['TSFE']->additionalHeaderData['js_'.$this->extKey.'_'.$hash] = t3lib_div::wrapJS($temp_js, TRUE);
					}
				}
			}
		}
		// add all defined CSS files
		if (count($this->cssFiles) > 0) {
			foreach ($this->cssFiles as $cssToLoad) {
				// Add script only once
				$file = $this->getPath($cssToLoad);
				if ($file) {
					if (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
						$pagerender->addCssFile($file, 'stylesheet', 'all', '', $this->conf['cssMinify']);
					} else {
						$GLOBALS['TSFE']->additionalHeaderData['cssFile_'.$this->extKey.'_'.$file] = '<link rel="stylesheet" type="text/css" href="'.$file.'" media="all" />'.chr(10);
					}
				} else {
					t3lib_div::devLog("'{$cssToLoad}' does not exists!", $this->extKey, 2);
				}
			}
		}
		// add all defined CSS Script
		if (count($this->css) > 0) {
			foreach ($this->css as $cssToPut) {
				$temp_css .= $cssToPut;
			}
			$hash = md5($temp_css);
			if (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
				$pagerender->addCssInlineBlock($hash, $temp_css, $this->conf['cssMinify']);
			} else {
				// addCssInlineBlock
				$GLOBALS['TSFE']->additionalCSS['css_'.$this->extKey.'_'.$hash] .= $temp_css;
			}
		}
	}

	/**
	 * Return the webbased path
	 * 
	 * @param string $path
	 * return string
	 */
	private function getPath($path="")
	{
		return $GLOBALS['TSFE']->tmpl->getFileName($path);
	}

	/**
	 * Add additional JS file
	 * 
	 * @param string $script
	 * @param boolean $first
	 * @return void
	 */
	private function addJsFile($script="", $first=FALSE)
	{
		if ($this->getPath($script) && ! in_array($script, $this->jsFiles)) {
			if ($first === TRUE) {
				$this->jsFiles = array_merge(array($script), $this->jsFiles);
			} else {
				$this->jsFiles[] = $script;
			}
		}
	}

	/**
	 * Add JS to header
	 * 
	 * @param string $script
	 * @return void
	 */
	private function addJS($script="")
	{
		if (! in_array($script, $this->js)) {
			$this->js[] = $script;
		}
	}

	/**
	 * Add additional CSS file
	 * 
	 * @param string $script
	 * @return void
	 */
	private function addCssFile($script="")
	{
		if ($this->getPath($script) && ! in_array($script, $this->cssFiles)) {
			$this->cssFiles[] = $script;
		}
	}

	/**
	 * Add CSS to header
	 * 
	 * @param string $script
	 * @return void
	 */
	private function addCSS($script="")
	{
		if (! in_array($script, $this->css)) {
			$this->css[] = $script;
		}
	}

	/**
	 * Returns the version of an extension (in 4.4 its possible to this with t3lib_extMgm::getExtensionVersion)
	 * @param string $key
	 * @return string
	 */
	private function getExtensionVersion($key)
	{
		if (! t3lib_extMgm::isLoaded($key)) {
			return '';
		}
		$_EXTKEY = $key;
		include(t3lib_extMgm::extPath($key) . 'ext_emconf.php');
		return $EM_CONF[$key]['version'];
	}

	/**
	 * Extract the requested information from flexform
	 * @param string $sheet
	 * @param string $name
	 * @param boolean $devlog
	 * @return string
	 */
	protected function getFlexformData($sheet='', $name='', $devlog=true)
	{
		$this->pi_initPIflexForm();
		$piFlexForm = $this->cObj->data['pi_flexform'];
		if (! isset($piFlexForm['data'])) {
			if ($devlog === true) {
				t3lib_div::devLog("Flexform Data not set", $this->extKey, 1);
			}
			return null;
		}
		if (! isset($piFlexForm['data'][$sheet])) {
			if ($devlog === true) {
				t3lib_div::devLog("Flexform sheet '{$sheet}' not defined", $this->extKey, 1);
			}
			return null;
		}
		if (! isset($piFlexForm['data'][$sheet]['lDEF'][$name])) {
			if ($devlog === true) {
				t3lib_div::devLog("Flexform Data [{$sheet}][{$name}] does not exist", $this->extKey, 1);
			}
			return null;
		}
		if (isset($piFlexForm['data'][$sheet]['lDEF'][$name]['vDEF'])) {
			return $this->pi_getFFvalue($piFlexForm, $name, $sheet);
		} else {
			return $piFlexForm['data'][$sheet]['lDEF'][$name];
		}
	}

	/**
	 * Return a errormessage if needed
	 * @param string $msg
	 * @param boolean $js
	 * @return string
	 */
	private function outputError($msg='', $js=FALSE)
	{
		t3lib_div::devLog($msg, $this->extKey, 3);
		if ($this->confArr['frontendErrorMsg'] || ! isset($this->confArr['frontendErrorMsg'])) {
			return ($js ? "alert(".t3lib_div::quoteJSvalue($msg).")" : "<p>{$msg}</p>");
		} else {
			return null;
		}
	}

	/**
	 * Returns TRUE, if the request comes via AJAX
	 * @return boolean
	 */
	private function isAjax()
	{
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jftabulatorsitemap/pi1/class.tx_jftabulatorsitemap_pi1.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jftabulatorsitemap/pi1/class.tx_jftabulatorsitemap_pi1.php']);
}

?>