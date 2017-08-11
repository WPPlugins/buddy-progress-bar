<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Buddy_Progress_Bar_Options' ) ) :

class Buddy_Progress_Bar_Options {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'bppp_register_admin_settings' ) );
	}


	function admin_menu() {
		add_options_page( 'Progress bar settings', 'Buddy Progress Bar', 'manage_options', 'bppp-settings',	array( $this, 'bppp_settings_page' ) );
	}


	function bppp_register_admin_settings(){
		
		// Add the settings section
		add_settings_section( 'bppp',      					'',	array( $this, 'settings_section_callback' ),				'bppp-settings');
		
		// Add setting field
		add_settings_field( 'bppp-auto-embed', 				'',	array( $this, 'settings_field_auto_embed_callback' ),		'bppp-settings', 'bppp' );
		add_settings_field( 'bppp-extra-widget-embed', 		'', array( $this, 'settings_field_extra_widget_callback' ),		'bppp-settings', 'bppp' );
		add_settings_field( 'bppp-extra-directory-embed', 	'',	array( $this, 'settings_field_extra_directory_callback' ),	'bppp-settings', 'bppp' );
		add_settings_field( 'bppp-profile-title-embed',		'', array( $this, 'settings_field_profile_title_callback' ),	'bppp-settings', 'bppp' );
		add_settings_field( 'bppp-login-title-embed',		'',	array( $this, 'settings_field_login_title_callback' ),		'bppp-settings', 'bppp' );
		add_settings_field( 'bppp-directory-title-embed',	'', array( $this, 'settings_field_directory_title_callback' ),	'bppp-settings', 'bppp' );
		add_settings_field( 'bppp-completed-title-embed',	'', array( $this, 'settings_field_completed_title_callback' ),	'bppp-settings', 'bppp' );
		add_settings_field( 'bppp-award-embed', 	        '',	array( $this, 'settings_field_award_callback' ),			'bppp-settings', 'bppp' );
		add_settings_field( 'bppp-empty-profile-embed',		'', array( $this, 'settings_field_empty_profile_callback' ),	'bppp-settings', 'bppp' );
		add_settings_field( 'bppp-empty-message-embed',     '',	array( $this, 'settings_field_empty_message_callback' ),	'bppp-settings', 'bppp' );
		add_settings_field( 'bppp-empty-login-embed',     '',	array( $this, 'settings_field_empty_login_callback' ),		'bppp-settings', 'bppp' );
		add_settings_field( 'bppp-points-shares',			'',	array( $this, 'settings_field_points_shares_callback' ),	'bppp-settings', 'bppp' );
		
		// register settings fields
		register_setting( 'bppp-settings', 'bppp-auto-embed', 				array( $this, 'settings_field_sanitize' ) );
		register_setting( 'bppp-settings', 'bppp-extra-widget-embed',		'intval' );
		register_setting( 'bppp-settings', 'bppp-extra-directory-embed',	'intval' );
		register_setting( 'bppp-settings', 'bppp-profile-title-embed',		array( $this, 'settings_field_sanitize' ) );
		register_setting( 'bppp-settings', 'bppp-login-title-embed',		array( $this, 'settings_field_sanitize' ) );
		register_setting( 'bppp-settings', 'bppp-directory-title-embed',	array( $this, 'settings_field_sanitize' ) );
		register_setting( 'bppp-settings', 'bppp-completed-title-embed',	array( $this, 'settings_field_sanitize' ) );
		register_setting( 'bppp-settings', 'bppp-award-embed',				'intval' );
		register_setting( 'bppp-settings', 'bppp-empty-profile-embed',		array( $this, 'settings_field_sanitize' ) );
		register_setting( 'bppp-settings', 'bppp-empty-message-embed',		'intval' );
		register_setting( 'bppp-settings', 'bppp-empty-login-embed',		'intval' );
		register_setting( 'bppp-settings', 'bppp-points-shares',			array( $this, 'settings_field_sanitize' ) );
	}


	/**
	* Adds link to Progress Bar Welcome page
	*
	* @use main section callback so it will displayed at top of the setting page
	*
	* @since 1.0
	*/
	function settings_section_callback(){ 
		if( is_multisite() ) {
			$about_url = add_query_arg( array( 'page' => 'bppp-about'), admin_url( 'index.php?page=bppp-about' ) ); 
		} else {
			$about_url = add_query_arg( array( 'page' => 'bppp-about'), bp_get_admin_url( 'index.php?page=bppp-about' ) );
		}
	?>

	<div class="return-to-dashboard">
		<h3><a href="<?php echo $about_url ?>"><?php echo _x( 'About Buddy Progress Bar', 'welcome screen', 'buddy-progress-bar' ); ?></a></h3>
	</div>
	<?php
	}

	/**
	* Building all Progress Bar option fields:
	*
	* settings_field_auto_embed_callback()
	* settings_field_extra_widget_callback
	* settings_field_extra_directory_callback() 
	* settings_field_profile_title_callback()
	* settings_field_login_title_callback()
	* settings_field_directory_title_callback()
	* settings_field_empty_profile_callback()
	* settings_field_empty_message_callback() 
	* settings_field_empty_login_callback() 
	* settings_field_completed_title_callback() 
	* settings_field_award_callback()
    *
	* @since 1.0
	*/

	function settings_field_auto_embed_callback(){		
		$option = bp_get_option( 'bppp-auto-embed', 'display-profile' );	
		?>
		<h3><?php esc_html_e( 'Progress Bar on Profile', 'buddy-progress-bar' ); ?></h3>
		<input name="bppp-auto-embed" type="radio" value="display-profile" <?php checked( $option,'display-profile' ); ?> />
		<label for="bppp-auto-embed"><?php esc_html_e( 'When displaying a profile', 'buddy-progress-bar' ); ?></label>
		<br/>
		<input name="bppp-auto-embed" type="radio" value="edit-profile" <?php checked( $option,'edit-profile' ); ?> />
		<label for="bppp-auto-embed"><?php esc_html_e( 'When editing a profile', 'buddy-progress-bar' ); ?></label>
		<br/>
		<input name="bppp-auto-embed" type="radio" value="0" <?php checked( empty( $option ) ); ?> />
		<label for="bppp-auto-embed"><?php esc_html_e( 'No auto embed', 'buddy-progress-bar' ); ?></label>
		<?php
	}


	function settings_field_extra_widget_callback() {		
		$option = bp_get_option( 'bppp-extra-widget-embed' );
		?>
		<h3><?php esc_html_e( 'Other positions', 'buddy-progress-bar' ); ?></h3>
		<input name="bppp-extra-widget-embed" type="checkbox" value="1" <?php checked( $option ); ?> />
		<label for="bppp-extra-widget-embed"><?php esc_html_e( 'On login widget', 'buddy-progress-bar' ); ?></label>
		<?php
	}


	function settings_field_extra_directory_callback() {
		$option = bp_get_option( 'bppp-extra-directory-embed', '' );
		?>		
		<input name="bppp-extra-directory-embed" type="checkbox" value="1"<?php checked( $option ); ?> />
		<label for="bppp-extra-directory-embed"><?php esc_html_e( 'On members directory', 'buddy-progress-bar' ); ?></label>		
		<?php
	}


	function settings_field_profile_title_callback() {
		$option = bp_get_option( 'bppp-profile-title-embed', '' );
		?>
		<h3><?php esc_html_e( 'Bar Titles', 'buddy-progress-bar' ); ?></h3>
		<input name="bppp-profile-title-embed" id="bppp-profile-title-embed" type="text" value="<?php echo esc_attr( $option ); ?>" size="30" maxlength="40"/>
		<label for="bppp-profile-title-embed"><?php esc_html_e( 'progress bar title on profile (max char. 40).', 'buddy-progress-bar' ); ?></label>
		<?php
	}

	function settings_field_login_title_callback() {
		$option = bp_get_option( 'bppp-login-title-embed', '' );
		?>
		<input name="bppp-login-title-embed" id="bppp-login-title-embed" type="text" value="<?php echo esc_attr( $option ); ?>" size="30" maxlength="40"/>
		<label for="bppp-login-title-embed"><?php esc_html_e( 'progress bar title on BuddyPress login widget (max char. 40).', 'buddy-progress-bar' ); ?></label>
		<?php
	}

	function settings_field_directory_title_callback() {
		$option = bp_get_option( 'bppp-directory-title-embed', '' );
		?>
		<input name="bppp-directory-title-embed" id="bppp-directory-title-embed" type="text" value="<?php echo esc_attr( $option ); ?>" size="30" maxlength="40"/>
		<label for="bppp-directory-title-embed"><?php esc_html_e( 'progress bar title on members directory (max char. 40).', 'buddy-progress-bar' ); ?></label>
		<?php
	}

	function settings_field_empty_profile_callback() {
		$option = bp_get_option( 'bppp-empty-profile-embed', '' );
		?>	
		<h3><?php esc_html_e( 'Profile is empty message', 'buddy-progress-bar' ); ?></h3>
		<input name="bppp-empty-profile-embed" id="bppp-empty-profile-embed" type="text" value="<?php echo esc_attr( $option ); ?>" maxlength="100" /><br/>
		<label for="bppp-empty-profile-embed"><?php esc_html_e( 'message to show when profile is empty (max char. 100).', 'buddy-progress-bar' ); ?></label>		
		<?php
	}

	function settings_field_empty_message_callback() {		
		$option = bp_get_option( 'bppp-empty-message-embed', '' );
		?>
		<input name="bppp-empty-message-embed" type="checkbox" value="1" <?php checked( $option ); ?> />
		<label for="bppp-empty-message-embed"><?php esc_html_e( 'Show this message on members directory', 'buddy-progress-bar' ); ?></label>
		<?php
	}

	function settings_field_empty_login_callback() {		
		$option = bp_get_option( 'bppp-empty-login-embed', '' );
		?>
		<input name="bppp-empty-login-embed" type="checkbox" value="1" <?php checked( $option ); ?> />
		<label for="bppp-empty-login-embed"><?php esc_html_e( 'Show this message on login widget', 'buddy-progress-bar' ); ?></label>
		<?php
	}

	function settings_field_completed_title_callback() {
		$option = bp_get_option( 'bppp-completed-title-embed', '' );
		?>	
		<h3><?php esc_html_e( 'Profile is completed message', 'buddy-progress-bar' ); ?></h3>
		<input name="bppp-completed-title-embed" id="bppp-completed-title-embed" type="text" value="<?php echo esc_attr( $option ); ?>" size="30" maxlength="40"/>
		<label for="bppp-completed-title-embed"><?php esc_html_e( 'message to show once a profile is completed (max char. 40). ', 'buddy-progress-bar' ); ?></label>		
		<?php
	}

	function settings_field_award_callback() {		
		$option = bp_get_option( 'bppp-award-embed' );
		?>
		<input name="bppp-award-embed" type="checkbox" value="1" <?php checked( $option ); ?> />
		<label for="bppp-award-embed"><?php esc_html_e( 'Show an award icon once a profile is completed.', 'buddy-progress-bar' ); ?></label>
		<?php
	}

	/**
	* Sanitizing values
	*
	* @return (bool)
	*
	* @since 1.0
	*/
	function settings_field_sanitize( $value = false ) {
		return $value;            
	}
  
	/**
	* Displays the point share section
	*
	* @use  have_point()  the_point()
	*
	* @since 1.0
	*/
	function settings_field_points_shares_callback() {
			
		if ( !bppp_has_point_items() ) return false;

		$total_points = bppp_get_total_points();
	?>

	<h3><?php esc_html_e( 'Points Shares', 'buddy-progress-bar' ); ?></h3>
		<p class="description">
			<?php esc_html_e( 'Attribute a number of points for each existing profile field.', 'buddy-progress-bar' ); ?>
		</p>
	<table class="bppp-field-list">		
		<thead>
		<tr>
			<th><?php esc_html_e( 'Field-ID', 'buddy-progress-bar' ) ?></th>
			<th><?php esc_html_e( 'Field name', 'buddy-progress-bar' ) ?></th>
			<th><?php esc_html_e( 'Current point', 'buddy-progress-bar' ) ?></th>
			<th><?php esc_html_e( 'New point', 'buddy-progress-bar' ) ?></th>
			<th><?php esc_html_e( '% ratio', 'buddy-progress-bar' ) ?></th>			
		</tr>
		</thead>
		<tbody>
		<?php	
		while ( bppp()->have_points() ) : bppp()->the_point();

				$current_point = bppp()->query->point;

				$percent = 0;

				if ( $current_point['points'] )
					$percent = round( ( ( $current_point['points']/$total_points )*100 ), 1 ); 	
		?>       
			<tr>
				<td><strong><?php echo $current_point['label']; ?></strong></td>
				<td><strong><?php echo $current_point['name']; ?></strong></td>
				<td><?php printf( '%1d', $current_point['points'] ); ?></td>
				<td><input id="bppp-points-shares-<?php print $current_point['label']; ?>" name="bppp-points-shares[<?php print $current_point['label']; ?>]"
                   value="<?php echo ( !isset( $current_point['points'] )?"0":$current_point['points'] ); ?>" size="2" min="0" max="10" type="number"></td>
				<td><?php printf( '%2d%%', $percent ); ?></td>				
			</tr>

		<?php	endwhile; ?>
		</tbody>
	</table>	
	<?php	
	}


	/**
	*
	* Buddy Progress Bar settings form
	*
	* @since 1.0
	*/
	function bppp_settings_page() {		
		?>

		<div class="wrap">
			<h2><?php esc_html_e( 'Buddy Progress Bar Settings', 'buddy-progress-bar' ); ?></h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'bppp-settings' ); ?>
				<?php do_settings_sections( 'bppp-settings' ); ?>	

			<p class="submit">
				<?php if( bp_core_do_network_admin() ) : wp_nonce_field( 'bppp_settings', '_wpnonce_bppp_setting' ); endif;?>
			<input type="submit" name="submit" class="button-primary" value="<?php esc_html_e( 'Save settings', 'buddy-progress-bar' ); ?>" />
			</p>
			</form>
		</div>
	<?php }
}

new Buddy_Progress_Bar_Options;

endif;