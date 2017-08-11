<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * Main Buddy Progress Bar Admin Class
 *
 * @package Buddy Progress Bar
 * @subpackage Administration
*/
if ( !class_exists( 'Buddy_Progress_Bar_Admin' ) ) :

class Buddy_Progress_Bar_Admin {

	public function __construct() {
		$this->setup_globals();
		$this->includes();
		$this->setup_actions();
	}


	/**
	* Admin globals
	*
	* @since 1.0
	* @access private
	*/
	private function setup_globals() {		
		$this->user_columns_filter = bp_core_do_network_admin() ? 'wpmu_users_columns' : 'manage_users_columns';		
	}


	/**
	* Setup the admin hooks, actions and filters
	*
	* @since 1.0
	* @access private
	*
	* @uses add_action() To add various actions
	* @uses add_filter() To add various filters
	*/
	private function setup_actions() {		
		add_action( bp_core_admin_hook(),		array( $this, 'admin_menus' ) ); // Add progress infos to admin user list		
		add_action( 'admin_enqueue_scripts',	array( $this, 'bppp_admin_style' ) );
	}


	/**
	* Include required files
	*
	* @since 1.0
	* @access private
	*/
	private function includes() {}


	/**
	 * Add backend stylesheet
	 *
	 * since 1.0
	*/
	function bppp_admin_style() {
		wp_enqueue_style( 'progess-bar-admin', plugin_dir_url( __FILE__ ) . 'css/progress-bar-admin.css' );
	}


	public function admin_menus() {
		// Bail if user cannot manage options
		if ( ! bp_current_user_can( 'manage_options' ) )
			return;
		add_filter( $this->user_columns_filter, array( $this, 'progress_bar_add_percent_column' ) );

		if( bppp_get_plugin_version() != bp_get_option( 'buddy_progress_bar_version' ) )
			bp_update_option( 'buddy_progress_bar_version', bppp_get_plugin_version() ); 	
	}

	public $user_columns_filter = '';

	/**
	* Add a profile status column on admin users list
	*
	* @since 1.0
	* @return  array   $column
	*/
	public function progress_bar_add_percent_column( $columns ) {
    	$columns['progress_profile'] = __( 'Profile Status', 'buddy-progress-bar' ); 
    	return $columns; 
	}		
}
endif; 


function bppp_admin_init() {
    bppp()->admin = new Buddy_Progress_Bar_Admin();
}