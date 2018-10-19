<?php
add_shortcode('widget_banner', 'widget_banner');
function widget_banner($atts){
	$atts = shortcode_atts( array(
		'foo' => 'no foo',
	), $atts );
}
?>