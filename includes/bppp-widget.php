<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * Buddy Progress Bar Widget
 *
 * Buils the widget
 * 
 * since 1.0
*/
class progress_bar_widget extends WP_Widget {

	// constructor
	function __construct() {
		parent::__construct( 
		'progress_bar_widget', // Base ID
		__( '(Progress Bar) Profile progression', 'buddy-progress-bar' ), // Name
		array( 'description' => __( 'Display profile progress bar', 'buddy-progress-bar' ), ) // Args
		);
	}

	// widget form creation
	function form( $instance ) {

	// Check values
	if( $instance ) {
		$title = esc_attr( $instance['title'] );
		$textarea = esc_textarea( $instance['textarea'] );
			} else {
		$title = '';
		$textarea = '';
	}
	?>

	<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title', 'buddy-progress-bar' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id( 'textarea' ); ?>"><?php _e( 'Message:', 'buddy-progress-bar' ); ?></label>
	<textarea class="widefat" id="<?php echo $this->get_field_id( 'textarea' ); ?>" name="<?php echo $this->get_field_name( 'textarea' ); ?>"><?php echo $textarea; ?></textarea>
	</p>
	<?php
	}

	// update widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		// fields
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['textarea'] = strip_tags( $new_instance['textarea'] );
	return $instance;
	}

	// display widget
	function widget( $args, $instance ) {

	if ( is_user_logged_in() ):

	// setting vars
	$user_id = bp_loggedin_user_id();
	$user_percent = get_user_meta( $user_id, '_progress_bar_percent_level', true );
	$profile_completed = bp_get_option( 'bppp-completed-title-embed', '' );	
	$profile_empty = bp_get_option( 'bppp-empty-profile-embed' );
	$award = bp_get_option ( 'bppp-award-embed' );

	extract( $args );

	// widget title
	$title = apply_filters( 'widget_title', $instance['title'] );

	// add a textarea for long messages
	$textarea = $instance['textarea'];

	echo $before_widget;

	// Display the widget content
	echo '<div class="widget-text wp_widget_plugin_box">';

	// Check if title is set
	if ( $title ) {
		echo $before_title . $title . $after_title;
	}

		if( empty( $user_percent ) || $user_percent == 0 ) {		
			echo '<p>'. $profile_empty .'</p>';
		}

		if(  $user_percent == 100 && $award == 1 )  {
			echo '<div class="bppp-congrats"><span class="dashicons dashicons-awards"></span>' . $profile_completed . '</div>';
		} elseif ( $user_percent == 100 && $award == 0 ) {
				echo  '<div class="bppp-congrats">' . $profile_completed . '</div>';
			} 

		if( $user_percent > 0 && $user_percent !=100 ) {
			echo '
			<div class="bppp-stat">				  
				<div class="bppp-widget-bar">
					<div class="bppp-bar-mask" style="width: ' . (int)(100-$user_percent) . '%"></div> 
				</div>  
				<div class="bppp-stat-percent">' . $user_percent . '%</div>    
			</div>';
		}

	// Check if textarea is set
	if( $textarea ) {
		
		echo '<p class="wp_widget_plugin_textarea">' . sanitize_text_field( $textarea ) . '</p>';
	}
	echo '</div>';

	echo $after_widget;

	endif;
	}
}
// register widget
add_action( 'widgets_init', create_function( '', 'return register_widget( "progress_bar_widget" );' ) );