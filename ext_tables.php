<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::addPlugin(array(
	'LLL:EXT:jftabulatorsitemap/locallang_db.xml:tt_content.menu_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'menu_type');


t3lib_extMgm::addStaticFile($_EXTKEY,'static/', 'Tabulator Sitemap');

?>