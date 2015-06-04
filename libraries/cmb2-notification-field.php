<?php
class CMB2_Notification_Field {
	static function register() {
		add_action( 'cmb2_render_notification', function($field, $escaped_value, $object_id, $object_type, $field_type_object) {
			?>
			<div class="warning notice notice-success below-h2" style="max-width: 800px;">
				<p>
					<?php echo $field->args['desc']; ?>
				</p>
			</div>
			<?php
			//echo $field_type_object->input( array( 'type' => 'notification' ) );
		}, 10, 5 );
	}
}

CMB2_Notification_Field::register();