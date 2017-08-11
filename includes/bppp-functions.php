<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * Returns plugin version
 * 
 * @uses bppp() plugin's main instance
 *
 * since 1.0
 */
function bppp_get_plugin_version() {
	return bppp()->version;
}


/**
 * Url to images dir
 *
 * @uses  bppp()
 * @return string the url
 *
 * since 1.0
 */
function bppp_get_images_url() {
	return bppp()->images_url;
}


/**
 * Register points filter
 *
 * The callback must either return bool (eg. TRUE, which equals 100%) or a percentage (eg. 50)
 * @param type	 $label
 * @param type	 $callback
 * @param type	 $points
 * @param type	 $args 
 * 
 * since 1.0
 */
function bppp_register_progression_point( $label, $name, $callback, $points, $args = false ) {
	
	$point = array(
		'label'		=> $label,		// label for this item aka 
		'name'		=> $name,		// display name 
		'callback'	=> $callback,	// name of the function used to retrieve the user's percents for this item
		'points'	=> $points		// number of points this item potentially gives  
	);

    if( $args )
        $point['args'] = $args;

    bppp()->query->points[] = apply_filters( 'bppp_register_progression_point_'. $label, $point );
}

/**
 * Get points total
 * 
 * @return int
 *
 * since 1.0
*/
function bppp_get_total_points() {

    $total = 0;

    foreach( ( array ) bppp()->query->points as $item ) {
        $total+= $item['points'];
    }

    return $total;
}


/**
* Builds a link to message composer on users list
*
* Display progression percent in Profile Status column
* if no data is found, shows a send message button
*
* @since 1.0
*/
function progress_bar_add_percent_column_content( $value, $column_name, $user_id ) {

	if ( 'progress_profile' == $column_name ) {
		if( !bp_is_active( 'messages') ) {
			  $warning = __( 'BuddyPress Message Component must be activated.', 'buddy-progress-bar' );
				return $warning;
		  }

		$user			= get_userdata( $user_id );
		$user_percent	= get_user_meta( $user_id, '_progress_bar_percent_level', true );
	  
		if( bp_is_active( 'messages') ) {
		  $link			= wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( $user_id ) );
		}
		$recipient		= '&nbsp;'. bp_core_get_username( $user_id );
		$ico 			= '<span class="dashicons dashicons-email-alt"></span>';
	  
		$defaults = array(
		  'id' => 'complete_profile_message-'.$user_id,
		  'component' => 'messages',
		  'must_be_logged_in' => true,
		  'block_self' => true,  
		  'wrapper_id' => 'complete-profile-message-'.$user_id,
		  'wrapper_class' =>'complete-profile-message',
		  'link_href' => $link,
		  'link_title' => __( 'Send a message to', 'buddy-progress-bar' ) . $recipient,
		  'link_text' => $ico,
		  'link_class' => 'send-message',
		);

		if( isset( $user_percent ) && $user_percent != 0 ) {
			  return sprintf( '%s %%', $user_percent );		
		  } else { 
			  $btn = bp_get_button( $defaults ); 
			return apply_filters( 'progress_bar_get_send_private_message_button', $btn );
		  }	
	}
  
  return $value;
}

add_filter( 'manage_users_custom_column','progress_bar_add_percent_column_content', 10, 3 );

/**
* Add Welcome page menu
*
* @since 1.0
*/
function bppp_about_screen_page() {
  add_dashboard_page(
    'About Progress Bar',
    'About Progress Bar',
    'read',
    'bppp-about',
    'bppp_about_screen'
  );
}
add_action('admin_menu', 'bppp_about_screen_page');

/**
* Remove welcome link from wp admin menu
*
* @since 1.0
*/
function bppp_about_screen_remove_menu() {
    remove_submenu_page( 'index.php', 'bppp-about' );
}
add_action( 'admin_head', 'bppp_about_screen_remove_menu' );