<?php
/*
Plugin Name: WP Instant Articles
Plugin URI: http://wp-instant-articles.com
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

		foreach($modules as $module_file => $module_class) {
			if(file_exists("{$modules_directory}{$module_file}.php")) {
				require "{$modules_directory}{$module_file}.php";
				$this->modules[$module_file] = new $module_class();
			}
		}
	}
}
$wp_instant_articles = new WPInstantArticles_Plugin();

/**
 * FIXME: Temporary dummy data
 */
add_filter('wpinstant_dns_prefetch_domains', function($domains) {
	return array('//google.com', '//aftonbladet.se', 'http://reddit.com');
});