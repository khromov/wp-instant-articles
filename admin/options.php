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

		//General style for all admin pages
		echo WPInstantArticles_Common::template('admin-global-css');

		//Special style for Instant Articles page
		if($hook === 'toplevel_page_wpinstant_options') {
			echo WPInstantArticles_Common::template('admin-css');
		}
	}

	public function add_help_tab() {
		// Not using chaining here, so as to be parseable by PHP4.
		$screen = get_current_screen();

		$screen->add_help_tab( array(
				'id'      => 'instant-articles-overview',
				'title'   => __( 'Overview' ),
				'content' => WPInstantArticles_Common::template('admin-help-tab-overview'),
		));

		$screen->add_help_tab( array(
				'id'      => 'instant-articles-prerender',
				'title'   => __( 'Pre-render' ),
				'content' => WPInstantArticles_Common::template('admin-help-tab-prerender'),
		));

		$screen->add_help_tab( array(
				'id'      => 'instant-articles-dnsprefetch',
				'title'   => __( 'DNS Prefetch' ),
				'content' => WPInstantArticles_Common::template('admin-help-tab-dnsprefetch'),
		));
	}

	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$svg_icon = plugin_dir_url( __FILE__ ) . '../assets/icon.svg';
		//$image_tag = '<img src="'. $svg_icon .'" alt="Instant Articles Logo>"';
		$this->options_page = add_menu_page( $this->title . ' Settings', $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) , $svg_icon);
		// add_action( "admin_head-{$this->options_page}", array( $this, 'enqueue_js' ) );

		// Adds my_help_tab when my_admin_page loads
		add_action('load-' . $this->options_page, array(&$this, 'add_help_tab'));
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
					'desc' => 'This feature may increase server load.',
					'id'   => '_notification_prerender_pagination_enabled',
					'type' => 'notification',
					'classes' => array('update-nag')
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
				'options' => array(
						'add_row_text' => 'Add Domain'
				)
		));

		$cmb->add_field( array(
				'name' => '&nbsp;',
				'desc' => 'It is recommended to not use more than 5 prefetch domains.',
				'id'   => '_notification_dns_prefetch_recommendation',
				'type' => 'notification',
				'classes' => array()
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
