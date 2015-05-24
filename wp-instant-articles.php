<?php
/*
Plugin Name: WP Instant Articles
Plugin URI: http://wp-instant-articles.com
Description: -
Version: 1.0
Author: khromov
Author URI: https://khromov.se
*/

require 'modules/dns-prefetch.php';
require 'modules/prerender.php';

$wp_instant_articles_modules = array();
$wp_instant_articles_modules['dns-prefetch'] = new WPInstantArticles_DNS_Prefetch();
$wp_instant_articles_modules['prerender'] = new WPInstantArticles_PreRender();

add_filter('wpinstant_dns_prefetch_domains', function($domains) {
	return array('//google.com', '//aftonbladet.se', 'http://reddit.com');
});