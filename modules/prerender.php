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
class WPInstantArticles_PreRender {
	function __construct() {
		add_action('init', array(&$this, '_init'));
	}

	function _init() {
		if(WPIAC::cmb2_get_option('wpinstant_options', 'prerender_homepage', false)) {
			add_action('wp_head', array(&$this, '_prerender_latest_posts'), 11);
		}

		if(WPIAC::cmb2_get_option('wpinstant_options', 'prerender_pagination', false)) {
			add_action('wp_head', array(&$this, '_prerender_next_previous_single'), 12);
		}

	}

	/**
	 * Prerender latest posts
	 *
	 * If If General -> Reading is set to "Your latest posts", this will preload
	 *
	 */
	function _prerender_latest_posts() {
		global $wp_query;

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$posts_to_prerender = array();

		//If General -> Reading is set to "Your latest posts", piggyback on the main query
		if(WPInstantArticles_Common::is_valid_latest_posts_request()) {
			if($paged === 1) {
				$posts_to_prerender = array_slice($wp_query->posts, 0, apply_filters('wpinstant_prerender_number_of_posts', 2));
			}
		}
		//If General -> Reading is set to "A static page", grab the latest 2 posts
		else if(is_front_page()) {

			$latest_posts_query = new WP_Query(array(
					'post_type' => apply_filters('wpinstant_post_types', array('post')),
					'posts_per_page' => apply_filters('wpinstant_prerender_number_of_posts', 2)
			));

			$posts_to_prerender = $latest_posts_query->posts;
		}
		else if(is_archive()) {
			//TODO: Handle in prerender-archives.php
		}

		$urls = array();
		foreach($posts_to_prerender as $post) {
			$urls[] = get_the_permalink($post->ID);
		}

		WPInstantArticles_Common::print_prerender_markup($urls);
	}

	/**
	 * Prerender next/previous links for single pages
	 */
	function _prerender_next_previous_single() {
		if(is_singular()) {
			// get previous post permalink
			$prev_post = get_adjacent_post(false, apply_filters('wpinstant_adjacent_post_excluded_terms', ''), false, apply_filters('wpinstant_adjacent_post_taxonomy', 'category'));
			// get next post permalink
			$next_post = get_adjacent_post(false, apply_filters('wpinstant_adjacent_post_excluded_terms', ''), true, apply_filters('wpinstant_adjacent_post_taxonomy', 'category'));

			$urls = array();
			if($prev_post) {
				$urls[] = get_permalink($prev_post);
			}

			if($next_post) {
				$urls[] = get_permalink($next_post);
			}

			WPInstantArticles_Common::print_prerender_markup($urls);
		}
	}
}