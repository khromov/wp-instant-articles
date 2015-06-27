<?php
/*
Plugin Name: Instant Articles
Plugin URI: http://wpinstant.io
Description: Increase your site performance with DNS prefetching and HTML5 prerender
Version: 1.2
Author: khromov, titanas
Author URI: http://titan.as
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
			'prerender' => 'WPInstantArticles_PreRender'
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