<?php
/*
Plugin Name: Instant Articles
Plugin URI: https://wordpress.org/plugins/instant-articles/
Description: -
Version: 1.0
Author: khromov
Author URI: https://khromov.se
*/

require 'libraries/common.php';

/**
 * Main plugin class
 *
 * Class WPInstantArticles_Plugin
 */
class WPInstantArticles_Plugin {
	var $modules = array();

	function __construct() {
		$modules = array(
				'dns-prefetch' => 'WPInstantArticles_DNS_Prefetch',
				'prerender' => 'WPInstantArticles_PreRender',
				'pro/prerender-archives' => 'WPInstantArticles_PreRender_Archives'
		);

		$modules_directory = plugin_dir_path(__FILE__) . 'modules/';

		/**
		 * Load modules
		 */
		foreach($modules as $module_file => $module_class) {
			if(file_exists("{$modules_directory}{$module_file}.php")) {
				require "{$modules_directory}{$module_file}.php";
				$this->modules[$module_file] = new $module_class();
			}
		}

		//FIXME: Which hook?
		add_action('init', array(&$this, 'load_admin_interface'));
	}

	function load_admin_interface() {
		require_once plugin_dir_path(__FILE__) . 'libraries/cmb2/init.php';
		require_once plugin_dir_path(__FILE__) . 'libraries/cmb2-notification-field.php';
		require_once plugin_dir_path(__FILE__) . 'admin/options.php';
	}
}
$wp_instant_articles = new WPInstantArticles_Plugin();

/**
 * FIXME: Move to better place
 *
 * //TODO: VALIDATION IN CMB2
 */
add_filter('wpinstant_dns_prefetch_domains', function($domains) {
	$domains = array();
	foreach (WPIAC::cmb2_get_option('wpinstant_options', 'dns-prefetch', array()) as $domain) {

		//If this looks like a naked domain name, prepend http:// so we can get through parse_url
		if(!preg_match('/^(http|https)/', $domain)) {
			$domain = "http://{$domain}";
		}
		$parsed = parse_url($domain);
		if(isset($parsed['host'])) {
			$domains[] = '//' . $parsed['host'];
		}
	}
	return $domains;
});