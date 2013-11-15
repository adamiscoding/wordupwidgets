<?php

class MyRecentPosts extends WP_Widget_Recent_Posts {

    public function __construct() {
        $ops = array(
            'classname' => 'my_widget_recent_entries', 
            'description' => __('The most recent posts on your site')
            );
        
        WP_Widget::__construct( 'my-recent-posts', __('My Recent Posts'), $ops);
    }

    function widget( $args, $instance ) {

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        ob_start();
        extract($args);

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
        if ( ! $number )
            $number = 10;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
        if ($r->have_posts()) :
        ?>
        <?php echo $before_widget; ?>
        <?php if ( $title ) echo $before_title . $title . $after_title; ?>
        <ul>
        <?php while ( $r->have_posts() ) : $r->the_post(); ?>
            <li>
                <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>
                <?php if ( has_post_thumbnail() ) {
                    the_post_thumbnail( array( 64, 64) );
                } ?>
            <?php if ( $show_date ) : ?>
                <span class="post-date"><?php echo get_the_date(); ?></span>
            <?php endif; ?>
            </li>
        <?php endwhile; ?>
        </ul>
        <?php echo $after_widget; ?>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        endif;

        ob_get_flush();
    }
}

add_action('widgets_init', function () { register_widget('MyRecentPosts'); });