<?php
/**
 * Module for Subresource
 *
 * Class WPInstantArticles_Subresource
 */
class WPInstantArticles_Prefetch {
	function __construct() {
		add_action('init', array(&$this, '_init'));
	}

	function _init() {
		if(WPIAC::cmb2_get_option('wpinstant_options', 'prefetch_enabled', false)) {
			add_action('wp_head', array(&$this, '_wp_head'), 10);
		}

		add_filter('wpinstant_prefetch_links', array(&$this, 'links'));
	}

	function links() {

		$links = array();
		foreach (WPIAC::cmb2_get_option('wpinstant_options', 'prefetch_links', array()) as $link) {
			$links[] = esc_url($link);
		}

		return $links;
	}

	function _wp_head() {
		foreach(apply_filters('wpinstant_prefetch_links', array()) as $link) {
			echo '<link rel="prefetch" href="'. trim($link) .'">';
		}
	}
}