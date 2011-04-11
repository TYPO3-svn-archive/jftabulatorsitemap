<?php

########################################################################
# Extension Manager/Repository config file for ext "jftabulatorsitemap".
#
# Auto generated 12-04-2011 01:05
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Tabulator Sitemap',
	'description' => 'Display a sitemap in a jQuery UI tab, requested by ajax. Use t3jquery for better integration of other jQuery extensions.',
	'category' => 'plugin',
	'author' => 'Juergen Furrer',
	'author_email' => 'juergen.furrer@gmail.com',
	'shy' => '',
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author_company' => '',
	'version' => '1.2.0',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '5.0.0-5.3.99',
			'typo3' => '4.3.0-4.5.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:83:{s:21:"ext_conf_template.txt";s:4:"8b02";s:12:"ext_icon.gif";s:4:"437c";s:17:"ext_localconf.php";s:4:"5816";s:14:"ext_tables.php";s:4:"0a53";s:13:"locallang.xml";s:4:"fd0c";s:16:"locallang_db.xml";s:4:"8c79";s:12:"t3jquery.txt";s:4:"93e0";s:24:"compat/flashmessages.css";s:4:"4e2c";s:20:"compat/gfx/error.png";s:4:"e4dd";s:26:"compat/gfx/information.png";s:4:"3750";s:21:"compat/gfx/notice.png";s:4:"a882";s:17:"compat/gfx/ok.png";s:4:"8bfe";s:22:"compat/gfx/warning.png";s:4:"c847";s:14:"doc/manual.sxw";s:4:"da73";s:43:"lib/class.tx_jftabulatorsitemap_tceFunc.php";s:4:"553c";s:47:"lib/class.tx_jftabulatorsitemap_tsparserext.php";s:4:"f7e1";s:14:"pi1/ce_wiz.gif";s:4:"b7d0";s:39:"pi1/class.tx_jftabulatorsitemap_pi1.php";s:4:"db43";s:47:"pi1/class.tx_jftabulatorsitemap_pi1_wizicon.php";s:4:"e77e";s:19:"pi1/flexform_ds.xml";s:4:"015d";s:17:"pi1/locallang.xml";s:4:"5b7c";s:32:"res/tx_jftabulatorsitemap_pi1.js";s:4:"a516";s:54:"res/jquery/css/custom-theme/jquery-ui-1.7.2.custom.css";s:4:"f978";s:76:"res/jquery/css/custom-theme/images/ui-bg_diagonals-thick_18_b81900_40x40.png";s:4:"1c7f";s:76:"res/jquery/css/custom-theme/images/ui-bg_diagonals-thick_20_666666_40x40.png";s:4:"f040";s:66:"res/jquery/css/custom-theme/images/ui-bg_flat_10_000000_40x100.png";s:4:"c18c";s:67:"res/jquery/css/custom-theme/images/ui-bg_glass_100_f6f6f6_1x400.png";s:4:"5f18";s:67:"res/jquery/css/custom-theme/images/ui-bg_glass_100_fdf5ce_1x400.png";s:4:"d26e";s:66:"res/jquery/css/custom-theme/images/ui-bg_glass_65_ffffff_1x400.png";s:4:"e5a8";s:73:"res/jquery/css/custom-theme/images/ui-bg_gloss-wave_35_9f2614_500x100.png";s:4:"946d";s:76:"res/jquery/css/custom-theme/images/ui-bg_highlight-soft_100_eeeeee_1x100.png";s:4:"384c";s:75:"res/jquery/css/custom-theme/images/ui-bg_highlight-soft_75_ffe45c_1x100.png";s:4:"b806";s:62:"res/jquery/css/custom-theme/images/ui-icons_222222_256x240.png";s:4:"9129";s:62:"res/jquery/css/custom-theme/images/ui-icons_228ef1_256x240.png";s:4:"8d4d";s:62:"res/jquery/css/custom-theme/images/ui-icons_65160b_256x240.png";s:4:"9f31";s:62:"res/jquery/css/custom-theme/images/ui-icons_ef8c08_256x240.png";s:4:"47fc";s:62:"res/jquery/css/custom-theme/images/ui-icons_ffd27a_256x240.png";s:4:"f224";s:62:"res/jquery/css/custom-theme/images/ui-icons_ffffff_256x240.png";s:4:"2cc8";s:49:"res/jquery/css/theme-1.8/jquery-ui-1.8.custom.css";s:4:"4387";s:73:"res/jquery/css/theme-1.8/images/ui-bg_diagonals-thick_18_b81900_40x40.png";s:4:"95f9";s:73:"res/jquery/css/theme-1.8/images/ui-bg_diagonals-thick_20_666666_40x40.png";s:4:"f040";s:63:"res/jquery/css/theme-1.8/images/ui-bg_flat_10_000000_40x100.png";s:4:"c18c";s:64:"res/jquery/css/theme-1.8/images/ui-bg_glass_100_f6f6f6_1x400.png";s:4:"5f18";s:64:"res/jquery/css/theme-1.8/images/ui-bg_glass_100_fdf5ce_1x400.png";s:4:"d26e";s:63:"res/jquery/css/theme-1.8/images/ui-bg_glass_65_ffffff_1x400.png";s:4:"e5a8";s:70:"res/jquery/css/theme-1.8/images/ui-bg_gloss-wave_35_9f2614_500x100.png";s:4:"946d";s:73:"res/jquery/css/theme-1.8/images/ui-bg_highlight-soft_100_eeeeee_1x100.png";s:4:"384c";s:72:"res/jquery/css/theme-1.8/images/ui-bg_highlight-soft_75_ffe45c_1x100.png";s:4:"b806";s:59:"res/jquery/css/theme-1.8/images/ui-icons_222222_256x240.png";s:4:"ebe6";s:59:"res/jquery/css/theme-1.8/images/ui-icons_228ef1_256x240.png";s:4:"79f4";s:59:"res/jquery/css/theme-1.8/images/ui-icons_65160b_256x240.png";s:4:"27ac";s:59:"res/jquery/css/theme-1.8/images/ui-icons_ef8c08_256x240.png";s:4:"ef9a";s:59:"res/jquery/css/theme-1.8/images/ui-icons_ffd27a_256x240.png";s:4:"ab8c";s:59:"res/jquery/css/theme-1.8/images/ui-icons_ffffff_256x240.png";s:4:"342b";s:53:"res/jquery/css/theme-1.8.9/jquery-ui-1.8.9.custom.css";s:4:"a795";s:75:"res/jquery/css/theme-1.8.9/images/ui-bg_diagonals-thick_18_b81900_40x40.png";s:4:"95f9";s:75:"res/jquery/css/theme-1.8.9/images/ui-bg_diagonals-thick_20_666666_40x40.png";s:4:"f040";s:65:"res/jquery/css/theme-1.8.9/images/ui-bg_flat_10_000000_40x100.png";s:4:"c18c";s:66:"res/jquery/css/theme-1.8.9/images/ui-bg_glass_100_f6f6f6_1x400.png";s:4:"5f18";s:66:"res/jquery/css/theme-1.8.9/images/ui-bg_glass_100_fdf5ce_1x400.png";s:4:"d26e";s:65:"res/jquery/css/theme-1.8.9/images/ui-bg_glass_65_ffffff_1x400.png";s:4:"e5a8";s:72:"res/jquery/css/theme-1.8.9/images/ui-bg_gloss-wave_35_9f2614_500x100.png";s:4:"946d";s:75:"res/jquery/css/theme-1.8.9/images/ui-bg_highlight-soft_100_eeeeee_1x100.png";s:4:"384c";s:74:"res/jquery/css/theme-1.8.9/images/ui-bg_highlight-soft_75_ffe45c_1x100.png";s:4:"b806";s:61:"res/jquery/css/theme-1.8.9/images/ui-icons_222222_256x240.png";s:4:"ebe6";s:61:"res/jquery/css/theme-1.8.9/images/ui-icons_228ef1_256x240.png";s:4:"79f4";s:61:"res/jquery/css/theme-1.8.9/images/ui-icons_65160b_256x240.png";s:4:"27ac";s:61:"res/jquery/css/theme-1.8.9/images/ui-icons_ef8c08_256x240.png";s:4:"ef9a";s:61:"res/jquery/css/theme-1.8.9/images/ui-icons_ffd27a_256x240.png";s:4:"ab8c";s:61:"res/jquery/css/theme-1.8.9/images/ui-icons_ffffff_256x240.png";s:4:"342b";s:33:"res/jquery/js/jquery-1.3.2.min.js";s:4:"7d91";s:33:"res/jquery/js/jquery-1.4.2.min.js";s:4:"1009";s:33:"res/jquery/js/jquery-1.4.3.min.js";s:4:"e495";s:33:"res/jquery/js/jquery-1.4.4.min.js";s:4:"73a9";s:33:"res/jquery/js/jquery-1.5.0.min.js";s:4:"63c1";s:33:"res/jquery/js/jquery-1.5.2.min.js";s:4:"e85a";s:43:"res/jquery/js/jquery-ui-1.7.2.custom.min.js";s:4:"fca3";s:43:"res/jquery/js/jquery-ui-1.8.9.custom.min.js";s:4:"e960";s:41:"res/jquery/js/jquery-ui-1.8.custom.min.js";s:4:"cacb";s:34:"res/jquery/js/jquery.easing-1.3.js";s:4:"a6f7";s:20:"static/constants.txt";s:4:"5494";s:16:"static/setup.txt";s:4:"a8ea";s:21:"static/ajax/setup.txt";s:4:"d55a";}',
	'suggests' => array(
	),
);

?>