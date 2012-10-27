
<h2>TEMPLATE_TAB_JS:</h2>

<!-- ###TEMPLATE_TAB_JS### begin -->
jQuery(document).ready(function(){
	jQuery('####KEY###').tabs({
		###OPTIONS###
	});
	<!-- ###TAB_PRELOAD### begin -->
	for (var tabi=0; jQuery('####KEY###').tabs('length') > tabi ; tabi++) {
		jQuery('####KEY###').tabs('load', tabi);
	}
	<!-- ###TAB_PRELOAD### end -->
});
<!-- ###TEMPLATE_TAB_JS### end -->

