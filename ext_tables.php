<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}



t3lib_extMgm::addStaticFile($_EXTKEY,'static/',      'Tabulator Sitemap');
t3lib_extMgm::addStaticFile($_EXTKEY,'static/ajax/', 'Tabulator Sitemap AJAX');


/*
// tt_content
t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['menu']['subtypes_excludelist'][$_EXTKEY.'_pi1'] = 'layout,select_key';
$TCA['tt_content']['types']['menu']['subtypes_addlist'][$_EXTKEY.'_pi1']     = 'pi_flexform';

t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:'.$_EXTKEY.'/flexform_ds.xml', 'menu');
*/


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:jftabulatorsitemap/locallang_db.xml:tt_content.menu_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'menu_type');


?>