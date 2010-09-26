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
	var $prefixId      = 'tx_jftabulatorsitemap_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_jftabulatorsitemap_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'jftabulatorsitemap';	// The extension key.
	var $pi_checkCHash = true;
	var $contentKey = null;
	var $jsFiles = array();
	var $js = array();
	var $cssFiles = array();
	var $css = array();

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website (Menu)
	 */
	function main($content, $conf)
	{
		$this->conf = $conf;

		// define the key of the element
		$this->contentKey = "jftabulatorsitemap_c" . $this->cObj->data['uid'];

		$menuPid = intval($this->cObj->data['pages'] ? $this->cObj->data['pages'] : $GLOBALS['TSFE']->id);

		// define the select hidden / nav_hide
		$select = array();
		if (! $this->conf['showNavHidePages']) {
			$select[] = 'AND nav_hide=0';
		}
		$doktypes = t3lib_div::intExplode(',', $this->conf['showDoktypes'], true);
		if (count($doktypes) > 0) {
			$select[] = 'AND doktype IN ('.implode(',', $doktypes).')';
		}
		$menuItems_level1 = $GLOBALS['TSFE']->sys_page->getMenu($menuPid, '*', 'sorting', implode(" ", $select), 1);

		reset($menuItems_level1);

		$items = null;
		while(list($uid, $pages_row) = each($menuItems_level1)) {
			$GLOBALS['TSFE']->register['key']    = $this->contentKey;
			$GLOBALS['TSFE']->register['uid']    = $pages_row['uid'];
			$GLOBALS['TSFE']->register['target'] = $pages_row['target'];
			$item   = trim($this->cObj->cObjGetSingle($this->conf['tabItem'], $this->conf['tabItem.']));
			$items .= $this->cObj->stdWrap($item, $this->conf['tabWrap.']);
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
			$fx[] = "height:'toggle'";
		}
		if ($this->conf['tabFxOpacity']) {
			$fx[] = "opacity:'toggle'";
		}
		if ($this->conf['tabFxDuration'] || is_numeric($this->conf['tabFxDuration'])) {
			$fx[] = "duration:".(is_numeric($this->conf['tabFxDuration']) ? $this->conf['tabFxDuration'] : "'{$this->conf['tabFxDuration']}'");
		}
		// Set options for tab
		$options = array();
		if (count($fx) > 0) {
			$options[] = "fx:{".implode(",", $fx)."}";
		}
		if ($this->conf['tabCollapsible']) {
			$options[] = "collapsible:true";
		}
		if ($this->conf['tabRandomTab']) {
			$options[] = "selected:Math.floor(Math.random()*".count($menuItems_level1).")";
		}
		if ($this->conf['tabCache']) {
			$options[] = "cache:true";
		}
		$tabPreload = null;
		if ($this->conf['tabPreload']) {
			$options[] = "ajaxOptions:{async:false}";
			$tabPreload = "
	for (var tabi=0; jQuery('#{$this->contentKey}').tabs('length') > tabi ; tabi++) {
		jQuery('#{$this->contentKey}').tabs('load',tabi);
	}";
		}

		$this->addCssFile($this->conf['jQueryUIstyle']);

		$this->addJS($jQueryNoConflict . "
jQuery(document).ready(function() {
	jQuery('#{$this->contentKey}').tabs(".(count($options) ? "{".implode(", ", $options)."}" : "").");{$tabPreload}
});");

		// Add the ressources
		$this->addResources();

		return $this->pi_wrapInBaseClass($content);
	}


	/**
	 * Include all defined resources (JS / CSS)
	 *
	 * @return void
	 */
	function addResources()
	{
		// checks if t3jquery is loaded
		if (T3JQUERY === true) {
			tx_t3jquery::addJqJS();
		} else {
			$this->addJsFile($this->conf['jQueryLibrary'], true);
			$this->addJsFile($this->conf['jQueryUI']);
		}
		if (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
			$pagerender = $GLOBALS['TSFE']->getPageRenderer();
		}
		// Fix moveJsFromHeaderToFooter (add all scripts to the footer)
		if ($GLOBALS['TSFE']->config['config']['moveJsFromHeaderToFooter']) {
			$allJsInFooter = true;
		} else {
			$allJsInFooter = false;
		}
		// add all defined JS files
		if (count($this->jsFiles) > 0) {
			foreach ($this->jsFiles as $jsToLoad) {
				if (T3JQUERY === true) {
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
								$pagerender->addJsFooterFile($file, $type, $this->conf['jsMinify']);
							} else {
								$pagerender->addJsFile($file, $type, $this->conf['jsMinify']);
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
			if (T3JQUERY === true && t3lib_div::int_from_ver($this->getExtensionVersion('t3jquery')) >= 1002000) {
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
						$GLOBALS['TSFE']->additionalFooterData['js_'.$this->extKey.'_'.$hash] = t3lib_div::wrapJS($temp_js, true);
					} else {
						$GLOBALS['TSFE']->additionalHeaderData['js_'.$this->extKey.'_'.$hash] = t3lib_div::wrapJS($temp_js, true);
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
						$GLOBALS['TSFE']->additionalHeaderData['cssFile_'.$this->extKey.'_'.$file] = '<link rel="stylesheet" type="text/css" href="'.$file.'" medai="all" />'.chr(10);
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
	function getPath($path="")
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
	function addJsFile($script="", $first=false)
	{
		if ($this->getPath($script) && ! in_array($script, $this->jsFiles)) {
			if ($first === true) {
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
	function addJS($script="")
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
	function addCssFile($script="")
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
	function addCSS($script="")
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
	function getExtensionVersion($key)
	{
		if (! t3lib_extMgm::isLoaded($key)) {
			return '';
		}
		$_EXTKEY = $key;
		include(t3lib_extMgm::extPath($key) . 'ext_emconf.php');
		return $EM_CONF[$key]['version'];
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jftabulatorsitemap/pi1/class.tx_jftabulatorsitemap_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jftabulatorsitemap/pi1/class.tx_jftabulatorsitemap_pi1.php']);
}

?>