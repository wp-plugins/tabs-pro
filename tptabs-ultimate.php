<?php

/*
Plugin Name: Tptabs Ultimate Shortcodes
Plugin URI: http://www.themepoints.com
Description: Tptabs-ultimate shortcodes is a fully responsive Tabs WordPress plugin that offering a modern and engaging user experience.
Version: 1.0
Author: themepoints
Author URI: http://www.themepoints.com
License URI: http://www.themepoints.com/copyright/

*/


if ( ! defined( 'ABSPATH' ) ) exit;

define('TABS_ULTIMATE_SHORTCODE_PLUGIN_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );


/*
========================================
Tabs Ultimate Shortcodes enqueue scripts
========================================
*/

function tp_ultimate_tabs_active_script()
	{
	wp_enqueue_script('jquery');
	wp_enqueue_script('tptabs-main-js', plugins_url( '/js/tptabsultimate.js', __FILE__ ), array('jquery'), '1.0', false);
	wp_enqueue_style('tptabs-main-css', TABS_ULTIMATE_SHORTCODE_PLUGIN_PATH.'css/tptabsultimate.css');
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_script('tptabs-wp-color-picker', plugins_url(), array( 'wp-color-picker' ), false, true );
	}
add_action('init', 'tp_ultimate_tabs_active_script');


/*
=================================
 Tp Tabs Ultimate Content Prefix
=================================
*/

function tptabsfix_p($content) {
	$array = array(
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']'
	);

	$content = strtr($content, $array);

	return $content;
}


/*
=====================================
 Tabs Ultimate Shortcode Register
=====================================
*/


function tptabs_ultimate_shortcodes( $atts, $content = null ) {
	$atts = ( shortcode_atts( array(
		'width' => '',
		'initialtab' => 1,
		'autoplayinterval' => 0,
		'color' => 'dark'
	), $atts ) );

	$colors_available = array('dark', 'blue');

	if(is_numeric($atts['width'])){
		$width = 'width:' . $atts['width'] . 'px';
	}else{
		$width = '';
	}
	if(!in_array($atts['color'], $colors_available)) $atts['color'] = 'dark';

	
	
	
	
	$tptabsclass = $atts['color'] . ' initialTab-' . ($atts['initialtab']-1)  . ' autoplayInterval-' . $atts['autoplayinterval'];

	$output = '<div class="tp_tabs tp_menu '. $tptabsclass .'" style="'. $width .'">';
	$output .= do_shortcode(tptabsfix_p($content));
	$output .= '</div>';

	return $output;
}
add_shortcode('tptabs_ultimate', 'tptabs_ultimate_shortcodes');


function tptabs_tab_container( $atts, $content = null ) {
	$output  = '<ul class="tptabs_content_container_main">';
	$output .= (do_shortcode($content));
	$output .= '</ul>';

	return $output;
}
add_shortcode('tptabs_tab_container', 'tptabs_tab_container');


function tptabs_tab( $atts, $content = null ) {
	$output  = '<li><a>';
	$output .= (do_shortcode($content));
	$output .= '</a></li>';

	return $output;
}
add_shortcode('tptabs_tab', 'tptabs_tab');


function tptabs_content_container( $atts, $content = null ) {
	$output  = '<div class="tptabs_content_container">';
	$output .= '<div class="tptabs_content_container_inner">';
	$output .= (do_shortcode($content));
	$output .= '</div>';
	$output .= '</div>';

	return $output;
}
add_shortcode('tptabs_content_container', 'tptabs_content_container');



function tptabs_content( $atts, $content = null ) {
	$output  = '<div class="tptabs_content_main">';
	$output .= (do_shortcode($content));
	$output .= '</div>';

	return $output;
}
add_shortcode('tptabs_content', 'tptabs_content');


/*
================================================
 Register Shortcode Button on Post Visual Editor
================================================
*/

function tptabs_ultimate_button_function() {
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
   if ( get_user_option('rich_editing') == 'true') {
	add_filter ("mce_external_plugins", "tptabs_ultimate_button_js");
	add_filter ("mce_buttons", "tptabs_ultimate_button");
   }	

}

function tptabs_ultimate_button_js($plugin_array) {
	$plugin_array['TptabsUltimate'] = plugins_url('inc/editor_plugin_button.js', __FILE__);
	return $plugin_array;
}

function tptabs_ultimate_button($buttons) {
	array_push ($buttons, 'tptabs_ultimate');
	return $buttons;
}
add_action ('init', 'tptabs_ultimate_button_function'); 



?>