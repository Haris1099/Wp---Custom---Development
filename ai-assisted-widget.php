<?php
/**
 * AI-Assisted Custom WordPress Widget
 * Purpose: Creates a simple "Client Testimonials Summary" widget.
 * * * Note: The class scaffolding and basic register function were generated
 * * using Cursor/Replit AI to rapidly prototype the module structure.
 */

class Haris_Testimonial_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'haris_testimonial_widget',
            __('Client Testimonials Summary', 'text_domain'),
            array( 'description' => __( 'A summary widget for recent client testimonials.', 'text_domain' ) )
        );
    }

    // Front-end display of the widget
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        
        // Custom logic to fetch and display one recent testimonial title
        $testimonials = get_posts(array(
            'post_type' => 'testimonial', // Assumes CPT from plugin-core-logic.php is registered
            'posts_per_page' => 1,
            'post_status' => 'publish'
        ));

        if ( $testimonials ) {
            echo '<p>Most Recent Feedback:</p>';
            echo '<ul>';
            foreach ( $testimonials as $testimonial ) {
                echo '<li><a href="' . esc_url(get_permalink($testimonial->ID)) . '">' . esc_html($testimonial->post_title) . '</a></li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No testimonials available.</p>';
        }

        echo $args['after_widget'];
    }

    // Backend widget form (options) - omitted for brevity, but a real widget would have this.
    public function form( $instance ) {
        // ... (form fields for title etc.)
    }
}

// Register and load the widget
function haris_load_testimonial_widget() {
    register_widget( 'Haris_Testimonial_Widget' );
}
add_action( 'widgets_init', 'haris_load_testimonial_widget' );

// End of file
