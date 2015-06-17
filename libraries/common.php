<?php
class WPInstantArticles_Common {

	const TD = 'wpinstant';

	/**
	 * Reused from get_next_posts_link
	 *
	 * @param null $label
	 * @param int $max_page
	 * @return string
	 */
	static function get_next_posts_url($label = null, $max_page = 0) {
		global $paged, $wp_query;

		if ( !$max_page )
			$max_page = $wp_query->max_num_pages;

		if ( !$paged )
			$paged = 1;

		$nextpage = intval($paged) + 1;

		if ( !is_single() && ( $nextpage <= $max_page ) ) {
			return next_posts( $max_page, false );
		}

		return null;
	}

	/**
	 * Reused from get_previous_posts_link
	 * @param null $label
	 * @return string
	 */
	static function get_previous_posts_url( $label = null ) {
		global $paged;

		if ( !is_single() && $paged > 1 ) {
			return previous_posts( false );
		}

		return null;
	}

	/**
	 * Check if request is valid "Your latest posts" page request and that the $wp_query global is set up
	 * with the latest posts.
	 *
	 * @return bool
	 */
	static function is_valid_latest_posts_request() {
		global $wp_query;
		return is_home() && isset($wp_query->posts) && is_array($wp_query->posts);
	}

	/**
	 * @param array $urls
	 */
	static function print_prerender_markup(array $urls) {
		/* @var WP_Post $post */
		foreach($urls as $url) {
			echo '<link rel="prerender" href="'. $url .'"/>';
		}
	}

	static function cmb2_get_option($group, $key, $default = null) {
		$group_values = get_option($group);
		return isset($group_values[$key]) ? $group_values[$key] : $default;
	}

	static function template($name) {

		ob_start();
		include __DIR__ . '/../partials/' . $name . '.php';
		return ob_get_clean();
	}
}

/**
 * Class WPIAC - WP Instant Articles Common
 *
 * Provides a shorter name to access WPInstantArticles_Common functions
 */
class WPIAC extends WPInstantArticles_Common {}