<?php

/**
 * Adds Foo_Widget widget.
 */
class Bech_Contact_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'bech_contact_widget', // Base ID
			'Bechstein Contact Widget', // Name
			[ 'description' => __( 'Widget to add contact information', 'bech' ), ] );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 *
	 * @see WP_Widget::widget()
	 *
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title      = $instance['title'] ?? '';
		$email      = $instance['email'] ?? '';
		$phone      = $instance['phone'] ?? '';
		$short_text = $instance['short_text'] ?? '';

		echo $before_widget; ?>

        <div id="w-node-_341e6c62-62ed-3cc9-423e-d0543ec04ef7-8073c07c" class="yvisit-styk_cont-block">
            <div class="p-30-40 med w35"><?php echo $title; ?></div>
            <div class="rich cont w-richtext">
				<?php if ( ! empty( $email ) ): ?>
                    <p><a href="<?php echo 'mailto:' . $email; ?>"><?php echo $email; ?></a></p>
				<?php endif; ?>
				<?php if ( ! empty( $phone ) ): ?>
                    <p><a href="<?php echo 'tel:' . str_replace( [
								' ',
								'-',
								'–',
								'(',
								')'
							], '', $phone ); ?>"><?php echo $phone; ?></a></p>
				<?php endif; ?>
				<?php if ( ! empty( $short_text ) ): ?>
                    <p><?php echo $short_text; ?></p>
				<?php endif; ?>
            </div>
        </div>

		<?php echo $after_widget;
	}

	/**
	 * Back-end widget form.
	 *
	 * @param array $instance Previously saved values from database.
	 *
	 * @see WP_Widget::form()
	 *
	 */
	public function form( $instance ) {
		$title      = $instance['title'] ?? '';
		$email      = $instance['email'] ?? '';
		$phone      = $instance['phone'] ?? '';
		$short_text = $instance['short_text'] ?? '';
		?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'email' ); ?>"><?php _e( 'Email:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>"
                   name="<?php echo $this->get_field_name( 'email' ); ?>" type="email"
                   value="<?php echo esc_attr( $email ); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'phone' ); ?>"><?php _e( 'Phone:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>"
                   name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text"
                   value="<?php echo esc_attr( $phone ); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'short_text' ); ?>"><?php _e( 'Short text:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'short_text' ); ?>"
                   name="<?php echo $this->get_field_name( 'short_text' ); ?>" type="text"
                   value="<?php echo esc_attr( $short_text ); ?>"/>
        </p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 * @see WP_Widget::update()
	 *
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['email'] = ( ! empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : '';
		$instance['phone'] = ( ! empty( $new_instance['phone'] ) ) ? strip_tags( $new_instance['phone'] ) : '';
		$instance['short_text'] = ( ! empty( $new_instance['short_text'] ) ) ? strip_tags( $new_instance['short_text'] ) : '';

		return $instance;
	}

}

add_action('widgets_init', 'bech_register_contact_widget');
function bech_register_contact_widget(): void
{
	register_widget('Bech_Contact_Widget');
}

?>