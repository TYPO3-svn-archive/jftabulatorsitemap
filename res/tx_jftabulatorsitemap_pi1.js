
<h2>TEMPLATE_TAB_JS:</h2>

<!-- ###TEMPLATE_TAB_JS### begin -->
jQuery(document).ready(function(){
	jQuery('####KEY###').tabs({
		###OPTIONS###
	});
	<!-- ###PANEL_SPINNER### begin -->
	jQuery("####KEY### .tab-loading").remove();
	jQuery('####KEY###').bind("tabsshow", function(event, ui) {
		jQuery(".tab-loading").remove();
	});
	jQuery('####KEY###').bind("tabsselect", function(event, ui) {
		if (this.id == jQuery(ui.panel).parent().attr('id')) {
			if (jQuery(ui.panel).is(":empty")) {
				var spinner  = jQuery('####KEY###').tabs("option", "spinnerPanel");
				jQuery('####KEY###').children('.ui-tabs-panel').###SPINNER_PANEL_POSITION###('<span class="tab-loading">' + spinner + '</span>');
			}
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

