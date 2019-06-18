<?php
/*
Plugin Name:Posts Number Widget
Plugin URI: http://www.sysbird.jp/wptips/posts-number-widget
Description: The widget display number of posts.
Version: 1.0
Author: Sysbird
Author URI: http://www.sysbird.jp/wptips
License: GPLv2 or later
Text Domain: posts-number-widget
Domain Path: /languages/
*/

class Posts_Number_Widget extends WP_Widget {

	function __construct() {
		$ret = load_plugin_textdomain( 'posts-number-widget', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
		$widget_ops = array('description' => __('The Widget display number of posts.', 'posts-number-widget'));
		parent::__construct(
			false,
			__('Posts Number', 'posts-number-widget'),
			$widget_ops
		);
	}

	public function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'unit' => '' ) );
		$title = $instance['title'];
		$unit = $instance['unit'];

?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'posts-number-widget'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('unit'); ?>"><?php _e('Unit:', 'posts-number-widget'); ?> <input class="widefat" id="<?php echo $this->get_field_id('unit'); ?>" name="<?php echo $this->get_field_name('unit'); ?>" type="text" value="<?php echo esc_attr($unit); ?>" /></label></p>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 'title' => '', 'unit' => '' ));
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['unit'] = strip_tags($new_instance['unit']);
		return $instance;
	}

	public function widget($args, $instance) {

		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$unit = empty( $instance['unit'] ) ? '' : $instance['unit'];
		$number = wp_count_posts('post','publish')->publish;
		echo $before_widget;
		if ( $title ){
			echo $before_title . $title . $after_title;
		}

		echo '<p>' .$number .' ' .$unit .'</p>';
		echo $after_widget;
	}
}

add_action( 'widgets_init', create_function( '', ' return register_widget("Posts_Number_Widget"); ') );