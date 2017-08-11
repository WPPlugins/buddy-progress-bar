<?php
/*
* Plugin Name: Buddy Progress Bar
* Plugin URI: http://bp-fr.net
* Description: Add a progress bar which displays the percentage of profile fields datas filled by users.
* Author: danbp
* Version: 1.0.3
* License: GPL2
* Text Domain: buddy-progress-bar
* Domain Path: /languages
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Buddy_Progress_Bar' ) ) :

class Buddy_Progress_Bar {

	/**
	* @public string plugin version
	*/
	public $version = '1.0.3';

	/**
	* @public string path
	*/
	public $file = '';

	
	/**
	* @public string Basename of the plugin directory
	*/
	public $basename = '';


	/**
	* @public string Absolute path to the plugin directory
	*/
	public $plugin_dir = '';
        
        
	/**
	 * @public string Prefix for the plugin
	 */
	public $prefix = '';

 
	/**
	* @var Instance
	*/
	private static $instance;

        
	/** 
	* User ID for which we want the progression
	*/
	public $user_id;
	

	/** 
	* some plugin $vars
	*/
	public $progression_points = array();
	public $current_point_item = '';


	/**
	* Main Instance
	*
	* Insures that only one instance of the plugin exists in memory at any one
	* time. Also prevents needing to define globals all over the place.
	* 
	*/
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Buddy_Progress_Bar;
			self::$instance->setup_globals();
			self::$instance->includes();
			self::$instance->setup_actions();
		}
		return self::$instance;
	}

        
	private function __construct() { /* Do nothing here */ }

        
	private function setup_globals() {            
		// Setup some base path and URL information
		$this->version          = '1.0.2';
		$this->domain           = 'buddy-progress-bar';
		$this->file				= __FILE__;
		$this->basename			= apply_filters( 'bppp_plugin_basename', plugin_basename( $this->file ) );
		$this->prefix			= 'bppp';
		$this->plugin_dir		= plugin_dir_path( $this->file );
		$this->plugin_url		= plugin_dir_url ( $this->file );	
		$this->lang_dir         = trailingslashit( $this->plugin_dir   . 'languages' );
		$this->includes_dir		= trailingslashit( $this->plugin_dir   . 'includes' );
		$this->includes_url		= trailingslashit( $this->plugin_url   . 'includes' ); 
		$this->images_dir		= trailingslashit( $this->includes_url . 'admin/images' );
		$this->images_url       = trailingslashit( $this->includes_url . 'admin/images' );
		$this->css_dir       	= trailingslashit( $this->plugin_dir   . 'css' );
		$this->css_url      	= trailingslashit( $this->plugin_url   . 'css' );
	}
      

	private function includes() {
		require( $this->includes_dir . 'bppp-functions.php' );
		require( $this->includes_dir . 'bppp-profile-fields-points.php' );
		require( $this->includes_dir . 'bppp-template.php' );
		require( $this->includes_dir . 'bppp-widget.php' );
		require( $this->includes_dir . 'admin/bppp-admin.php' );    
		require( $this->includes_dir . 'admin/bppp-settings.php' );
		require( $this->includes_dir . 'admin/bppp-screens.php' );
	}

	
	function setup_actions() {
		// actions
		add_action( 'init',                         	array($this, 'load_textdomain'));
		add_action( 'init',                         	'bppp_admin_init');
		add_action( 'wp_enqueue_scripts',           	array( $this, 'scripts_styles' ) );		
	}


	/**
	 * Loads the translation files
	 *
	 * @package Buddy Progress Bar
	 * since 1.0
	 * 
	 * @uses get_locale() to get the language of WordPress config
	 * @uses load_texdomain() to load the translation if any is available for the language
	 */

	public function load_textdomain() {
		// try to get locale
		$locale = apply_filters( 'buddy_progress_bar_load_textdomain_get_locale', get_locale(), $this->domain );
		$mofile = sprintf( '%1$s-%2$s.mo', $this->domain, $locale );

		// Setup paths to a buddy-progress-bar subfolder in WP LANG DIR
		$mofile_global = WP_LANG_DIR . '/buddy-progress-bar/' . $mofile;

		// Look in global /wp-content/languages/buddy-progress-bar folder
		if ( ! load_textdomain( $this->domain, $mofile_global ) ) {

			// Look in local /wp-content/plugins/buddy-progress-bar/languages/ folder
			// or /wp-content/languages/plugins/
			load_plugin_textdomain( $this->domain, false, basename( $this->plugin_dir ) . '/languages/' );
		}
	}

	
	function scripts_styles() {
		wp_register_style( $this->prefix.'-style', $this->plugin_url . 'css/progress-bar.css' );
		wp_enqueue_style( $this->prefix.'-style' );
		wp_enqueue_style( 'dashicons' );
	}


	/**
	* Set up the points and iterate current point index.
	*
	* @since 1.0
	* @access public
	*
	* @return point section.
	*/
	function next_point() {
		$this->query->current_point++;
		$this->query->point = $this->query->points[$this->query->current_point];

		return $this->query->point;
	}


	/**
	* Sets up the current point.
	*
	* Retrieves the next point, sets up the point, sets the 'in the loop'
	* property to true.
	*
	* @since 1.0
	* @access public
	* @uses $point
	* @uses do_action_ref_array() Calls 'loop_start' if loop has just started
	*/
	function the_point() {
		$this->query->in_the_loop = true;

		if ( $this->query->current_point == -1 ) // loop has just started
			do_action_ref_array( 'loop_start', array( &$this ) );

		$point = $this->next_point();
	}


	/**
	* Whether there are more points available in the loop.
	*
	* Calls action 'loop_end', when the loop is complete.
	*
	* @since 1.0
	* @access public
	* @uses do_action_ref_array() Calls 'loop_end' if loop is ended
	*
	* @return bool True if points are available, false if end of loop.
	*/
	function have_points() {

		if ( $this->query->current_point + 1 < $this->query->point_count ) {
			return true;
		} elseif ( $this->query->current_point + 1 == $this->query->point_count && $this->query->point_count > 0 ) {
			do_action_ref_array('loop_end', array(&$this));
			// Do some cleaning up after the loop
			$this->rewind_points();
		}

		$this->query->in_the_loop = false;

		return false;
	}


	/**
	* Rewind the points and reset point index.
	*
	* @since 1.0
	* @access public
	*/
	function rewind_points() {
		$this->query->current_point = -1;
		if ( $this->query->point_count > 0 ) {
			$this->query->point = $this->query->points[0];
		}
	}

} // class end here
endif;        
  

/**
 * The main function responsible for returning the one instance
 * to functions everywhere.
 *
 * Example: <?php $bppp = bppp(); ?>
 *
 * @return  instance
*/
function bppp() {
	return Buddy_Progress_Bar::instance();
}
add_action( 'bp_include', 'bppp' );