<?php
class CMB2_Notification_Field {

	function __construct() {
		$this->register();
	}

	function register() {
		add_action( 'cmb2_render_notification', array(&$this, 'render'), 10, 5 );
	}

	function render($field, $escaped_value, $object_id, $object_type, $field_type_object) {
		?>
		<div class="notice notice-success below-h2 <?php echo trim(implode(' ', $field->args['classes'])); ?>" style="padding-top: 1px; padding-bottom: 1px;">
			<p>
				<?php echo $field->args['desc']; ?>
			</p>
		</div>
		<?php
	}
}

$cmb2_notification_field = new CMB2_Notification_Field();