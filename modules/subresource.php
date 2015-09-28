<?php
/**
 * Module for Subresource
 *
 * Class WPInstantArticles_Subresource
 */
class WPInstantArticles_Subresource {
	function __construct() {
		add_action('init', array(&$this, '_init'));
	}

	function _init() {
		if(WPIAC::cmb2_get_option('wpinstant_options', 'subresources_enabled', false)) {
			add_action('wp_head', array(&$this, '_wp_head'), 2);
		}

		add_filter('wpinstant_subresources', array(&$this, 'subresources'));
	}

	function subresources($domains) {

		$subresources = array();
		foreach (WPIAC::cmb2_get_option('wpinstant_options', 'subresources', array()) as $subresource) {
			$subresources[] = esc_url($subresource);
		}

		return $subresources;
	}

	function _wp_head() {
		foreach(apply_filters('wpinstant_subresources', array()) as $subresource) {
			echo '<link rel="subresource" href="'. trim($subresource) .'">';
		}
	}
}