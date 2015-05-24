<?php
/**
 * Module for pre-rendering content
 *
 * Sources:
 * https://www.igvita.com/2011/06/25/html5-visibility-api-page-pre-rendering/
 * https://developer.mozilla.org/en-US/docs/Web/HTTP/Link_prefetching_FAQ
 *
 * Class WPInstantArticles_PreRender
 */
class WPInstantArticles_PreRender {
	function __construct() {
		add_action('init', array(&$this, '_init'));
	}

	function _init() {
		add_action('wp_head', array(&$this, '_prerender_latest_posts'), 11);
		add_action('wp_head', array(&$this, '_prerender_next_previous'), 12);
	}

	/**
	 * Prerender latest posts
	 *
	 * If If General -> Reading is set to "Your latest posts", this will preload
	 *
	 */
	function _prerender_latest_posts() {
		global $wp_query;
		$posts_to_prerender = array();

		//If General -> Reading is set to "Your latest posts", piggyback on the main query
		if($this->is_valid_latest_posts_request()) {
			$posts_to_prerender = array_slice($wp_query->posts, 0, apply_filters('wpinstant_prerender_number_of_posts', 2));
		}
		//If General -> Reading is set to "A static page", grab the latest 2 posts
		else if(is_front_page()) {

			$latest_posts_query = new WP_Query(array(
				'post_type' => apply_filters('wpinstant_post_types', array('post')),
				'posts_per_page' => apply_filters('wpinstant_prerender_number_of_posts', 2)
			));

			$posts_to_prerender = $latest_posts_query->posts;
		}
		else if(is_archive()) { //FIXME: Premium only?
			
		}

		$urls = array();
		foreach($posts_to_prerender as $post) {
			$urls[] = get_the_permalink($post->ID);
		}

		$this->print_prerender_markup($urls);
	}

	/**
	 * Prerender next/previous links.
	 */
	function _prerender_next_previous() {
		$urls = array();
		$next_posts_url = $this->get_next_posts_url();
		$previous_posts_url = $this->get_previous_posts_url();

		if($next_posts_url) {
			$urls[] = $next_posts_url;
		}

		if($previous_posts_url) {
			$urls[] = $previous_posts_url;
		}

		$this->print_prerender_markup($urls);
	}

	/**
	 * Check if request is valid "Your latest posts" page request and that the $wp_query global is set up
	 * with the latest posts.
	 *
	 * @return bool
	 */
	private function is_valid_latest_posts_request() {
		global $wp_query;
		return is_home() && isset($wp_query->posts) && is_array($wp_query->posts);
	}

	/**
	 * @param array $urls
	 */
	private function print_prerender_markup(array $urls) {
		/* @var WP_Post $post */
		foreach($urls as $url) {
			echo '<link rel="prerender" href="'. $url .'"/>';
		}
	}

	/**
	 * Reused from get_next_posts_link
	 *
	 * @return string
	 */
	private function get_next_posts_url($label = null, $max_page = 0) {
		global $paged, $wp_query;

		if ( !$max_page )
			$max_page = $wp_query->max_num_pages;

		if ( !$paged )
			$paged = 1;

		$nextpage = intval($paged) + 1;

		if ( !is_single() && ( $nextpage <= $max_page ) ) {
			return next_posts( $max_page, false );
		}
	}

	private function get_previous_posts_url( $label = null ) {
		global $paged;

		if ( !is_single() && $paged > 1 ) {
			return previous_posts( false );
		}
	}
}