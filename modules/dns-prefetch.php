<?php
/**
 * Module for DNS prefetching
 *
 * Class WPInstantArticles_DNS_Prefetch
 */
class WPInstantArticles_DNS_Prefetch {
	function __construct() {
		add_action('init', array(&$this, '_init'));
	}

	function _init() {
		if(WPIAC::cmb2_get_option('wpinstant_options', 'dns_prefetch_enabled', false)) {
			add_action('wp_head', array(&$this, '_wp_head'), 1);
		}
	}

	function _wp_head() {
		echo '<meta http-equiv="x-dns-prefetch-control" content="on">';
		foreach(apply_filters('wpinstant_dns_prefetch_domains', array()) as $domain) {
			echo '<link rel="dns-prefetch" href="'. trim($domain) .'">';
		}
	}
}