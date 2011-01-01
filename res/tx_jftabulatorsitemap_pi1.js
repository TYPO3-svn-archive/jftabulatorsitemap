
<h2>TEMPLATE_TAB_JS:</h2>

<!-- ###TEMPLATE_TAB_JS### begin -->
jQuery(document).ready(function(){
	jQuery('####KEY###').tabs({
		###OPTIONS###
	});
	<!-- ###PANEL_SPINNER### begin -->
	jQuery('####KEY###').bind("tabsload", function(event, ui) {
		jQuery(".tab-loading").remove();
	});
	jQuery('####KEY###').bind("tabsselect", function(event, ui) {
		var $panel = jQuery(ui.panel);
		var $tab = jQuery('####KEY###');
		if ($panel.is(":empty")) {
			var idPrefix = $tab.tabs('option', 'idPrefix');
			var selected = $tab.tabs('option', 'selected') + 1;
			var spinner  = $tab.tabs("option", "spinnerPanel");
			jQuery('#' + idPrefix + selected).###SPINNER_PANEL_POSITION###('<div class="tab-loading">' + spinner + '</div>')
		}
	});
	<!-- ###PANEL_SPINNER### begin -->
	<!-- ###TAB_PRELOAD### begin -->
	for (var tabi=0; jQuery('####KEY###').tabs('length') > tabi ; tabi++) {
		jQuery('####KEY###').tabs('load', tabi);
	}
	<!-- ###TAB_PRELOAD### end -->
});
<!-- ###TEMPLATE_TAB_JS### end -->

