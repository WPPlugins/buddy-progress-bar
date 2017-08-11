<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
* Display progress bar on profile header
*
* @since 1.0
*/  
function bppp_template() {

	if ( class_exists( 'Buddy_Progress_Bar' ) && bp_is_active( 'xprofile' ) ) :
	
		$auto_embed	= bp_get_option( 'bppp-auto-embed', 'display-profile' );
		$profile_title = bp_get_option( 'bppp-profile-title-embed', '' );
		$profile_completed = bp_get_option( 'bppp-completed-title-embed', '' );
		$profile_empty = bp_get_option( 'bppp-empty-profile-embed' ); // fetch the profile is empty message
		$award = bp_get_option ( 'bppp-award-embed' );
	
	if ( empty( $auto_embed ) ) return false;

	if ( ( !bp_is_user_profile_edit() ) && ( $auto_embed == 'edit-profile' ) ) {
		return false;
	}

	$bppp_get_user_progression_percent = bppp_get_user_progression_percent();

		if( empty( $bppp_get_user_progression_percent ) || $bppp_get_user_progression_percent == 0 ) {		
			echo '<p>'. $profile_empty .'</p>';
		}

		if(  $bppp_get_user_progression_percent == 100 && $award == 1 )  {
			echo '<div class="bppp-congrats"><span class="dashicons dashicons-awards"></span>' . $profile_completed . '</div>';
			} elseif (  $bppp_get_user_progression_percent == 100 && $award == 0 ) {
			echo  '<div class="bppp-congrats">' . $profile_completed . '</div>';
		} 

		if( $bppp_get_user_progression_percent > 0 && $bppp_get_user_progression_percent !=100 ) {	
			echo '
			<div class="bppp-stat">
				<div class="bppp-stat-title">'. $profile_title .'</div>    
					<div class="bppp-bar">
						<div class="bppp-bar-mask" style="width: '. (int)(100-$bppp_get_user_progression_percent) .'%"></div> 
					</div>  
				<div class="bppp-stat-percent">'.$bppp_get_user_progression_percent .'%</div>    
			</div>';
		}

	endif;
}
add_action( 'bp_before_member_header_meta', 'bppp_template' );


/**
* Display the progress bar on members_directory
* 
* @since 1.0
*/ 
function progress_bar_on_members_directory() {

	if ( class_exists( 'Buddy_Progress_Bar' ) && ( is_user_logged_in() ) && bp_is_members_directory() ) :

		$user_percent = get_user_meta( bp_get_member_user_id(), '_progress_bar_percent_level', true );
		$option = bp_get_option( 'bppp-extra-directory-embed', '' );
		$directory_title = bp_get_option( 'bppp-directory-title-embed' );
		$profile_empty = bp_get_option( 'bppp-empty-profile-embed' );  // fetch the profile is empty message
		$empty_display = bp_get_option( 'bppp-empty-message-embed' );  // show/hide the profile is empty message 
		$profile_completed = bp_get_option( 'bppp-completed-title-embed', '' );
		$award = bp_get_option ( 'bppp-award-embed' );		

		if ( empty( $user_percent ) && $empty_display == 1 ) {
			echo $profile_empty;
			} elseif ( empty( $user_percent ) && $empty_display == 0 ) {
				return;
		}

		if( $option == 0 || empty( $option ) || empty( $directory_title )) {
				return;
			} elseif( $user_percent > 0 && $user_percent != 100 && !empty( $directory_title ) ) { 
			echo '<div class="item-meta"><span class="activity">' . $directory_title .'&nbsp;' . $user_percent . '%</span></div>';	
		}	
		
		if( $profile_completed && $award == 1 && $user_percent == 100 ) {
			echo '<div class="item-meta"><span class="activity"><span class="dashicons dashicons-awards"></span>' . $profile_completed . '</span></div>';		
		} elseif ( $user_percent == 100 && $award == 0 ) {
			echo  '<div class="bppp-congrats">' . $profile_completed . '</div>';
		}

	endif;
}
add_filter ( 'bp_directory_members_item', 'progress_bar_on_members_directory' );	


/**
* Display the progress bar on login widget
* 
* @since 1.0*
*/ 
function progress_bar_on_login_widget() {

	if ( !class_exists( 'Buddy_Progress_Bar' ) ) {
		return;
	}

	if ( ! bp_loggedin_user_id() ) {
		return;
	}

	$user_id = bp_loggedin_user_id();
	$user_percent = get_user_meta( $user_id, '_progress_bar_percent_level', true ); 


	$option = bp_get_option( 'bppp-extra-widget-embed' );
	$login_title = bp_get_option( 'bppp-login-title-embed' );
	$profile_completed = bp_get_option ( 'bppp-completed-title-embed' );
	$profile_empty = bp_get_option( 'bppp-empty-profile-embed' ); // fetch the profile is empty message
	$empty_display = bp_get_option( 'bppp-empty-login-embed' );  // show/hide the profile is empty message
	$award = bp_get_option ( 'bppp-award-embed' );

	if ( empty( $user_percent ) && $empty_display == 1 ) {
		echo $profile_empty;
		} elseif ( empty( $user_percent ) && $empty_display == 0 ) {
			return;
	}

	if( $option == 0 || empty( $option ) || empty( $login_title ) ) { 
		return;
	} elseif ( $user_percent > 0 && $user_percent != 100 && !empty( $login_title ) ) { 
		echo $login_title .'&nbsp;' . $user_percent . '%';	
	}


	if( $profile_completed && $award == 1 && $user_percent == 100 ) {
		echo '<span class="dashicons dashicons-awards"></span>' . $profile_completed;		
	} elseif ( $user_percent == 100 && $award == 0 ) {
		echo  $profile_completed;
	}
	
}
add_action( 'bp_after_login_widget_loggedin', 'progress_bar_on_login_widget' );


/**
 * Builds the Bar title 
 *
 * since 1.0
*/
function bppp_title() {
    
    $user_id = bp_displayed_user_id();    
    $title = bppp_get_title();
    
    if( bp_is_my_profile() ) {
        $title = '<a title="'.bppp_get_title( $user_id ).'" href="'.bppp_get_link( $user_id ).'">'.$title.'</a>';
    }    
    echo $title;    
}


function bppp_get_title() {

	$user_id = bp_displayed_user_id();	 		
			
	if ( is_user_logged_in() ) {
			$title = bp_get_option( 'bppp-profile-title-embed' );
		return apply_filters( 'bppp_title', $title, $user_id );
	}   
}


/**
 * Add a link to profile edit on Bar Title when current user is on his profile
 *
 * since 1.0
*/    
function bppp_link() {
    echo bppp_get_link();
}

function bppp_get_link() {
	global $bp;
	
	$user_id = bp_displayed_user_id();

	if ( bp_loggedin_user_id() != bp_displayed_user_id() ) {
		return false;
	}
	
	$domain = bp_core_get_user_domain();

	$link = $domain.$bp->profile->slug . '/edit';
	
	return apply_filters( 'bppp_link', $link );
}

    
/**
 * Checks if we have points registered.
 * Contains the hook onto which the points must be registered.
 *
 * since 1.0
*/    
function bppp_has_point_items() {

    do_action( 'bppp_register_progression_points' );

    $available_points = bppp()->query->points;
    $valid_points = array();

    //check points are valid
    foreach( ( array ) $available_points as $point_item ) {
        if ( !$point_item['callback'] ) continue;
        if ( !function_exists( $point_item['callback'] ) ) continue;
        $valid_points[] = $point_item;
    }
   
    bppp()->query->current_point = -1;
    bppp()->query->points = $valid_points;
    bppp()->query->point_count = count( $valid_points );

    return apply_filters( 'bppp_has_points', bppp()->have_points(), bppp()->query->points );            
}


function bppp_user_progression_percent() {
    echo bppp_get_user_progression_percent();
}


/**
 * Calculate user progression percent 
 * and register it in user_meta table
 *
 * @return  (int)
 *
 * since 1.0
*/
function bppp_get_user_progression_percent( $user_id = false ) {
global $bp;

	$user_id = bp_displayed_user_id();

	$potential_points = 0;
	$user_points = 0;
	$percent = '';

	if( !$user_id ) return false;

	if ( !bppp_has_point_items() ) return false;

	while ( bppp()->have_points() ) : bppp()->the_point();

		$item = bppp()->query->point;
		$potential_points+= $item['points'];

		$item_points = bppp()->query->point['callback']();

		if( $item_points === true ) { //returned TRUE, wich means 100% of potential points
			$item_points = 100;
		}

		//balance points for this item
		$add_points = ($item_points/100)*$item['points'];

		$user_points+= $add_points;

	endwhile;

	//calculate total
	if ( !empty( $potential_points ) ) {	
			$percent = round( ( $user_points/$potential_points )*100 );
	}

	/**
	* store percentage as usermeta
	*
	* since 1.0
	*/
	$percent_val = $percent;
	$meta_key = '_progress_bar_percent_level';

	if( empty( $potential_points ) || $percent_val == 0 || $percent_val > 0 ) {
		update_user_meta( $user_id, $meta_key, $percent_val ); 
	}

	return (int)$percent;     
}


/**
 * Avatar point action hook
 * 
 * @use bppp_register_progression_points
 *
 * since 1.0
*/
function bppp_avatar_register_point() {

  $points = bp_get_option( 'bppp-points-shares', '' );	

  if ( !isset( $points["Avatar"] ) ) {
    $point = 0;
  } else {
    $point = $points["Avatar"];
  }

 	bppp_register_progression_point(
	'Avatar',                       // label 
	'Avatar',                       // name for this custom point 
	'bp_get_user_has_avatar',       // callback
	$point                  		// points
	);
}
add_action( 'bppp_register_progression_points', 'bppp_avatar_register_point' ); 