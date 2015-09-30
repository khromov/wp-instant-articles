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

	var $prerender_links = array();

	function __construct() {
		add_action('wp_head', array(&$this, '_execute_prerender'), 11);
	}

	function _execute_prerender() {

		//Make it possible to override the default prerender pages completely
		$prerender_override = apply_filters('wpinstant_prerendered_urls_override_defaults', false);

		if(WPIAC::cmb2_get_option('wpinstant_options', 'prerender_homepage', false) && !$prerender_override) {
			$this->prerender_links = array_merge($this->prerender_links, $this->_prerender_latest_posts());
		}

		if(WPIAC::cmb2_get_option('wpinstant_options', 'prerender_sticky_posts', false) && !$prerender_override) {
			$this->prerender_links = $prerender_links = array_merge($this->prerender_links, $this->_prerender_sticky_post());
		}

		if(WPIAC::cmb2_get_option('wpinstant_options', 'prerender_pagination', false) && !$prerender_override) {
			$this->prerender_links = array_merge($this->prerender_links, $this->_prerender_next_previous_single());
		}

		WPInstantArticles_Common::print_prerender_markup(apply_filters('wpinstant_prerendered_urls', $this->prerender_links));
	}

	/**
	 * Prerenders "sticky" posts
	 *
	 * https://codex.wordpress.org/Sticky_Posts
	 */
	function _prerender_sticky_post() {
		$sticky_posts_query = new WP_Query(array(
				'post__in'  => get_option( 'sticky_posts' ),
				'posts_per_page' => apply_filters('wpinstant_prerender_number_of_sticky_posts', 2),
				'ignore_sticky_posts' => true
		));

		$urls = array();
		foreach($sticky_posts_query->posts as $post) {
			$urls[] = get_the_permalink($post->ID);
		}

		return $urls;
	}

	/**
	 * Prerender latest posts
	 *
	 * If If General -> Reading is set to "Your latest posts", this will preload
	 */
	function _prerender_latest_posts() {
		global $wp_query;

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$posts_to_prerender = array();

		$urls = array();

		//If General -> Reading is set to "Your latest posts", piggyback on the main query
		if(WPInstantArticles_Common::is_valid_latest_posts_request()) {
			if($paged === 1) {
				$posts_to_prerender = array_slice($wp_query->posts, 0, apply_filters('wpinstant_prerender_number_of_posts', 2));
			}
		}
		else if(is_front_page()) { //If General -> Reading is set to "A static page", grab the latest 2 posts
			$latest_posts_query = new WP_Query(array(
					'post_type' => apply_filters('wpinstant_post_types', array('post')),
					'posts_per_page' => apply_filters('wpinstant_prerender_number_of_posts', 2)
			));

			$posts_to_prerender = $latest_posts_query->posts;
		}
		else if(is_archive()) {
			//TODO: Handle in prerender-archives.php
		}

		foreach($posts_to_prerender as $post) {
			$urls[] = get_the_permalink($post->ID);
		}

		return $urls;
	}

	/**
	 * Prerender next/previous links for single pages
	 */
	function _prerender_next_previous_single() {
		$urls = array();

		if(is_singular()) {
			// get previous post permalink
			$prev_post = get_adjacent_post(false, apply_filters('wpinstant_adjacent_post_excluded_terms', ''), false, apply_filters('wpinstant_adjacent_post_taxonomy', 'category'));
			// get next post permalink
			$next_post = get_adjacent_post(false, apply_filters('wpinstant_adjacent_post_excluded_terms', ''), true, apply_filters('wpinstant_adjacent_post_taxonomy', 'category'));

			if($prev_post) {
				$urls[] = get_permalink($prev_post);
			}

			if($next_post) {
				$urls[] = get_permalink($next_post);
			}
		}

		return $urls;
	}
}