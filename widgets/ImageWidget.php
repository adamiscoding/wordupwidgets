<?php
include_once 'BaseWidget.php';

class ImageWidget extends BaseWidget {

    public function __construct() {
        WP_Widget::__construct(
            'image_widget',
            'Image widget'
            );
    }

    public function content($args, $instance) {
        $this->title($args, $instance);
        if ( isset($instance['image'])) {
            echo wp_get_attachment_image( $instance['image'], array(128,128) );
        }
    }

    public function form($instance) {
        parent::form($instance); 
        if ( isset( $instance[ 'image' ] ) ) {
            $image = $instance[ 'image' ];
            $image_src = wp_get_attachment_image_src( $image );
            $image_src = $image_src[0];
        }
        else {
            $image = __( 'Choose image', 'html5blank' );
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'image:' ); ?></label><br>
            <img src="<?php if(isset($image_src)) echo $image_src; ?>" alt="chosen image">
            <input id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" type="hidden" value="<?php echo esc_attr( $image ); ?>">
            <input id="" class="button upload_image_button" type="button" value="Choose or upload" />
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = parent::update($new_instance, $old_instance);
        return $instance;
    }
}

add_action('widgets_init', function () { register_widget('ImageWidget'); });

add_action('admin_enqueue_scripts', function( $hook_suffix ) {
        if ( 'widgets.php' == $hook_suffix ) {
            wp_enqueue_media();
            wp_register_script('widgets-js', plugins_url('js/images.js', __FILE__), array('jquery',  'wp-color-picker'));
            wp_enqueue_script('widgets-js');
        }
});