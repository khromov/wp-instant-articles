<?php
/**
 * Module for pre-rendering content
 *
 * Sources:
 * https://www.igvita.com/2011/06/25/html5-visibility-api-page-pre-rendering/
 * https://developer.mozilla.org/en-US/docs/Web/HTTP/Link_prefetching_FAQ
 * http://www.sutanaryan.com/preload-pages-or-posts-in-wordpress-using-html5-link-prefetching/
 *
 * Class WPInstantArticles_PreRender
 */
class WPInstantArticles_PreRender_Archives {
	function __construct() {
		add_action('init', array(&$this, '_init'));
	}

	function _init() {
		add_action('wp_head', array(&$this, '_prerender_next_previous_archive'), 12);
	}

	/**
	 * Prerender next/previous links in archives.
	 */
	function _prerender_next_previous_archive() {

		if(is_archive()) {
			$urls = array();
			$next_posts_url = WPInstantArticles_Common::get_next_posts_url();
			$previous_posts_url = WPInstantArticles_Common::get_previous_posts_url();

			if($next_posts_url) {
				$urls[] = $next_posts_url;
			}

			if($previous_posts_url) {
				$urls[] = $previous_posts_url;
			}

			WPInstantArticles_Common::print_prerender_markup($urls);
		}
	}
}