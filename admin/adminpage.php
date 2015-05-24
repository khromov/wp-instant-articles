<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
//FIXME: Into src/ you go!
class Myprefix_Admin {

	/**
	 * Option key, and option page slug
	 * @var string
	 */
	private $key = 'myprefix_options';

	/**
	 * Options page metabox id
	 * @var string
	 */
	private $metabox_id = 'myprefix_option_metabox';

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
	public function __construct() {
		// Set our title
		$this->title = __( 'Subito', 'myprefix' );
	}

	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );
	}


	/**
	 * Register our setting to WP
	 * @since  0.1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );
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
				'name' => __( 'Website URL', 'cmb' ),
				'id'   => '_wiki_test_facebookurl',
				'type' => 'text_url',
			 'protocols' => array( 'http', 'https' ), // Array of allowed protocols
		) );

		$cmb->add_field( array(
				'name' => 'Test Money',
				'desc' => 'field description (optional)',
				'id' => '_wiki_test_textmoney',
				'type' => 'text_money',
			// 'before_field' => '£', // Replaces default '$'
		) );

		$cmb->add_field( array(
				'name' => 'Test Text Area Code',
				'desc' => 'field description (optional)',
				'default' => 'standard value (optional)',
				'id' => '_wiki_test_textareacode',
				'type' => 'textarea_code'
		) );

		$cmb->add_field( array(
				'name' => 'Test Date Picker',
				'id' => '_wiki_test_texttime',
				'type' => 'text_time'
			// 'time_format' => 'h:i:s A',
		) );

		$cmb->add_field( array(
				'name' => 'Time zone',
				'id'   => '_wiki_test_timezone',
				'type' => 'select_timezone',
		) );

		$cmb->add_field( array(
				'name' => 'Test Date Picker (UNIX timestamp)',
				'id'   => '_wiki_test_textdate_timestamp',
				'type' => 'text_date_timestamp',
			// 'timezone_meta_key' => '_wiki_test_timezone',
			// 'date_format' => 'l jS \of F Y',
		) );

		$cmb->add_field( array(
				'name' => 'Test Date/Time Picker Combo (UNIX timestamp)',
				'id'   => '_wiki_test_datetime_timestamp',
				'type' => 'text_datetime_timestamp',
		) );

		$cmb->add_field( array(
				'name' => 'Test Date/Time Picker/Time zone Combo (serialized DateTime object)',
				'id'   => '_wiki_test_datetime_timestamp_timezone',
				'type' => 'text_datetime_timestamp_timezone',
		) );



		$cmb->add_field( array(
				'name'     => 'Test Taxonomy Select',
				'desc'     => 'Description Goes Here',
				'id'       => '_wiki_test_taxonomy_select',
				'taxonomy' => 'category', //Enter Taxonomy Slug
				'type'     => 'taxonomy_select',
		) );

		$cmb->add_field( array(
				'name'     => 'Test Taxonomy Multicheck',
				'desc'     => 'Description Goes Here',
				'id'       => '_wiki_test_taxonomy_multicheck',
				'taxonomy' => 'category', //Enter Taxonomy Slug
				'type'     => 'taxonomy_multicheck',
		) );

		$cmb->add_field( array(
				'name' => 'Test File List',
				'desc' => '',
				'id'   => '_wiki_test_file_list',
				'type' => 'file_list',
			// 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
		) );

		$cmb->add_field( array(
				'name' => 'oEmbed',
				'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
				'id'   => '_wiki_test_embed',
				'type' => 'oembed',
		) );

		// Set our CMB2 fields

		$cmb->add_field( array(
				'name' => __( 'Test Text', 'myprefix' ),
				'desc' => __( 'field description (optional)', 'myprefix' ),
				'id'   => 'test_text',
				'type' => 'text',
				'default' => 'Default Text',
		) );

		$cmb->add_field( array(
				'name'    => __( 'Test Color Picker', 'myprefix' ),
				'desc'    => __( 'field description (optional)', 'myprefix' ),
				'id'      => 'test_colorpicker',
				'type'    => 'colorpicker',
				'default' => '#bada55',
		) );

		$group_field_id = $cmb->add_field( array(
				'id'          => '_wiki_test_repeat_group',
				'type'        => 'group',
				'description' => __( 'Generates reusable form entries', 'cmb' ),
				'options'     => array(
						'group_title'   => __( 'Entry {#}', 'cmb' ), // since version 1.1.4, {#} gets replaced by row number
						'add_button'    => __( 'Add Another Entry', 'cmb' ),
						'remove_button' => __( 'Remove Entry', 'cmb' ),
						'sortable'      => true, // beta
				),
		) );

// Id's for group's fields only need to be unique for the group. Prefix is not needed.
		$cmb->add_group_field( $group_field_id, array(
				'name' => 'Entry Title',
				'id'   => 'title',
				'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb->add_group_field( $group_field_id, array(
				'name' => 'Description',
				'description' => 'Write a short description for this entry',
				'id'   => 'description',
				'type' => 'textarea_small',
		) );

		$cmb->add_group_field( $group_field_id, array(
				'name' => 'Entry Image',
				'id'   => 'image',
				'type' => 'file',
		) );

		$cmb->add_group_field( $group_field_id, array(
				'name' => 'Image Caption',
				'id'   => 'image_caption',
				'type' => 'text',
		) );

	}

	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  0.1.0
	 * @param  string  $field Field to retrieve
	 * @return mixed          Field value or exception is thrown
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
function myprefix_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new Myprefix_Admin();
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
function myprefix_get_option( $key = '' ) {
	return cmb2_get_option( myprefix_admin()->key, $key );
}

// Get it started
myprefix_admin();
