<?php
class CMB2_Notification_Field {
	static function register() {
		add_action( 'cmb2_render_notification', function($field, $escaped_value, $object_id, $object_type, $field_type_object) {
			?>
			<div class="notice notice-success below-h2 <?php echo trim(implode(' ', $field->args['classes'])); ?>" style="padding-top: 1px; padding-bottom: 1px;">
				<p>
					<?php echo $field->args['desc']; ?>
				</p>
			</div>
			<?php
		}, 10, 5 );
	}
}

CMB2_Notification_Field::register();