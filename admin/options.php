<?php
class WPInstantArticles_Admin {
	/**
	 * Option key, and option page slug
	 * @var string
	 */
	private $key = 'wpinstant_options';

	/**
	 * Options page metabox id
	 * @var string
	 */
	private $metabox_id = 'wpinstant_option_metabox';

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor
	 * @since 0.1.0
	 */
	public function  __construct() {
		// Set our title
		$this->title = __( 'Instant Articles', WPIAC::TD );
	}

	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
	}

	/**
	 * Register our setting to WP
	 * @since  0.1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Print admin css
	 */
	public function admin_enqueue_scripts($hook) {
		if($hook === 'toplevel_page_wpinstant_options') {
			?>
				<style type="text/css">
					body .cmb-th
					{
						padding-bottom: 5px;
					}

					.cmb2-id-prerender-homepage > .cmb-td,
					.cmb2-id-prerender-pagination > .cmb-td,
					.cmb2-id-dns-prefetch-enabled > .cmb-td,
					.cmb2-id-dns-prefetch > .cmb-td
					{
						width: 100%;
					}


					.cmb2-id--notification-prerender-pagination-enabled > .cmb-th
					{
						display: none;
					}

					body .cmb2-id--notification-prerender-pagination-enabled .notice
					{
						margin-bottom: 0;
					}

					#dns-prefetch_repeat .cmb-td
					{
						padding-left: 0;
					}

					.cmb2-id-dns-prefetch button.cmb-add-row-button {
						margin-bottom: 20px;
					}

					#wpinstant_option_metabox > input {
						margin-left: 10px;
					}
				</style>
			<?php
		}
	}

	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) , 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PHN2ZyB3aWR0aD0iMjU2cHgiIGhlaWdodD0iMjU2cHgiIHZpZXdCb3g9IjAgMCAyNTYgMjU2IiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIj4gICAgICAgIDx0aXRsZT5JY29uIFNWRzwvdGl0bGU+ICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPiAgICA8ZGVmcz48L2RlZnM+ICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPiAgICAgICAgPGcgaWQ9Ikljb24tU1ZHIiBza2V0Y2g6dHlwZT0iTVNMYXllckdyb3VwIj4gICAgICAgICAgICA8cmVjdCBpZD0iMjU2IiBmaWxsPSIjNDk5MEUyIiBza2V0Y2g6dHlwZT0iTVNTaGFwZUdyb3VwIiB4PSIwIiB5PSIwIiB3aWR0aD0iMjU2IiBoZWlnaHQ9IjI1NiI+PC9yZWN0PiAgICAgICAgICAgIDxwYXRoIGQ9Ik0xMjgsMjE4IEMxNzcuNzA1NjI3LDIxOCAyMTgsMTc3LjcwNTYyNyAyMTgsMTI4IEMyMTgsNzguMjk0MzcyNSAxNzcuNzA1NjI3LDM4IDEyOCwzOCBDNzguMjk0MzcyNSwzOCAzOCw3OC4yOTQzNzI1IDM4LDEyOCBDMzgsMTc3LjcwNTYyNyA3OC4yOTQzNzI1LDIxOCAxMjgsMjE4IEwxMjgsMjE4IEwxMjgsMjE4IFogTTEyOCw3Ny4zNzUgTDE0NC44NzUsNzcuMzc1IEMxNTQuMTk0ODA1LDc3LjM3NSAxNjEuNzUsODQuOTIzMTMwOSAxNjEuNzUsOTQuMjUwNzMgTDE2MS43NSwxNjEuNzQ5MjcgQzE2MS43NSwxNzEuMDY5NDc4IDE1NC4xOTY4NTQsMTc4LjYyNSAxNDQuODc1LDE3OC42MjUgTDEyOCw3Ny4zNzUgTDEyOCw3Ny4zNzUgWiBNMTIyLjM3NSwxNjEuNzUgTDExMS4xMjUsMTYxLjc1IEMxMDQuOTExNzk3LDE2MS43NSA5OS44NzUsMTU2LjcwNDEzNCA5OS44NzUsMTUwLjQ5MDAyIEw5OS44NzUsMTA1LjUwOTk4IEM5OS44NzUsOTkuMjkxMjY0OCAxMDQuOTEwNDMsOTQuMjUgMTExLjEyNSw5NC4yNSBMMTIyLjM3NSwxNjEuNzUgTDEyMi4zNzUsMTYxLjc1IFoiIGlkPSJPdmFsLTE1IiBmaWxsPSIjRkZGRkZGIiBza2V0Y2g6dHlwZT0iTVNTaGFwZUdyb3VwIj48L3BhdGg+ICAgICAgICA8L2c+ICAgIDwvZz48L3N2Zz4=' );
		// add_action( "admin_head-{$this->options_page}", array( $this, 'enqueue_js' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  0.1.0
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo $this->key; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
		</div>
	<?php
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 */
	function add_options_page_metabox() {

		$cmb = new_cmb2_box( array(
				'id'      => $this->metabox_id,
				'hookup'  => false,
				'show_on' => array(
					// These are important, don't remove
						'key'   => 'options-page',
						'value' => array( $this->key, )
				),
		) );


		$cmb->add_field( array(
				'name' => 'Pre-render homepage',
				'desc' => 'Pre-render latest 2 posts on frontpage',
				'id'   => 'prerender_homepage',
				'type' => 'checkbox'
		));

		$cmb->add_field( array(
				'name' => 'Pre-render pagination links',
				'desc' => 'Pre-render previous and next links on posts, pages and custom post types using rel="next" and rel="prev".',
				'id'   => 'prerender_pagination',
				'type' => 'checkbox'
		));

		//TODO: Not fired properly on form update, needs a reload to work
		//if(WPIAC::cmb2_get_option('wpinstant_options', 'prerender_pagination', false)) :
			$cmb->add_field( array(
					'name' => '&nbsp;',
					'desc' => '<strong>Warning</strong>: This feature may increase server load.',
					'id'   => '_notification_prerender_pagination_enabled',
					'type' => 'notification'
			));
		//endif;

		$cmb->add_field( array(
				'name' => 'DNS prefetch',
				'desc' => 'Enable DNS prefetch',
				'id'   => 'dns_prefetch_enabled',
				'type' => 'checkbox'
		));

		$cmb->add_field( array(
				'name' => 'DNS Prefetch domains',
				'id'   => 'dns-prefetch',
				'type' => 'text',
			  'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		));
	}

	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  0.1.0
	 * @param  string  $field Field to retrieve
	 * @return mixed          Field value or exception is thrown
	 * @throws Exception
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}

		throw new Exception( 'Invalid property: ' . $field );
	}

}

/**
 * Helper function to get/return the Myprefix_Admin object
 * @since  0.1.0
 * @return Myprefix_Admin object
 */
function wpinstant_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new WPInstantArticles_Admin();
		$object->hooks();
	}
	return $object;
}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function wpinstant_get_option( $key = '' ) {
	return cmb2_get_option( wpinstant_admin()->key, $key );
}

// Get it started
wpinstant_admin();
