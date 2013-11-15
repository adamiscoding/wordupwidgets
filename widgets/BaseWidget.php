<?php

class BaseWidget extends WP_Widget {

    public function widget($args, $instance) {

        extract($args);

        ob_start();

        echo $before_widget;

        $this->content($args, $instance);

        echo $after_widget;

        ob_end_flush();
    }

    public function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : '';
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">
                    <?php _e('Title:'); ?>
                </label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $new_instance['title'] = strip_tags($new_instance['title']);
        return $new_instance;
    }

    public function content($args, $instance) {
        $this->title($args, $instance);    
    }

    public function title($args, $instance) {
        echo $args['before_title'] . $instance['title'] . $args['after_title'];
    }
}