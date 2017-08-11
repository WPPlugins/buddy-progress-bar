<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * add a help tab on settings page
*/
function bppp_help_intro( $contextual_help, $screen_id, $screen ) {
 
    if ( ! method_exists( $screen, 'add_help_tab' ) )
        return $contextual_help;
	$screen = get_current_screen();

	if ( $screen->id != 'settings_page_bppp-settings') return;

	$screen_title = esc_attr_x( 'Introduction', 'Help screen', 'buddy-progress-bar' );

    // Intro screen text
    $variables =  '<h4>' . $screen_title . '</h4>
	<p>' . esc_attr_x( 'Buddy Progress Bar plugin let you add a profile fields completion status in different places. Default display is the profile header. You can also activate the progression on login widget and/or members directory.', 'Help screen', 'buddy-progress-bar' ) . '</p>
	<p>' . esc_attr_x( 'Note that no bar will be displayed on the login widget or on members directory, but only a short title, an icon and user\'s progress percent. Title and icon are optionnal.', 'Help screen', 'buddy-progress-bar' ) .'</p>
	<p>' . esc_attr_x( 'Buddy Progress Bar comes also with his own widget, witch displays a progress bar and his own message, outside of the scope of the plugin settings (excepted percentage). Use it if you want to display user progression on your homepage, secondary blog or elsewhere different as profile header, login widget or members directory.',  'Help screen', 'buddy-progress-bar' ) . '</p>
	<p>' . esc_attr_x( 'Site admin will see each user progression percent on users admin list (or network users list in case of a multisite install) with the possibility to send them a personnal message if their profile is empty. In this case, a Contact User button is displayed. On click, the administrator will be redirected to his BuddyPress Compose Message page from where he can directly contact the member.', 'Help screen', 'buddy-progress-bar' ) . '</p>
	<p>' . esc_attr_x( 'Don\'t forget to click the Save Settings button at the bottom of the screen for new settings to take effect.', 'Help screen', 'buddy-progress-bar' ) . '</p>';  
 
    // Combine $variables list with $hooks list.
    $help_content = $variables;
	

    // Add intro panel
    $screen->add_help_tab( array(
        'id'      => 'bppp-help-screen-0',
        'title'   => $screen_title,
        'content' => $help_content,
    ));
 
    return $contextual_help;
}
add_action( 'contextual_help', 'bppp_help_intro', 10, 3 );


function bppp_help_on_profile( $contextual_help, $screen_id, $screen ) {
 
    if ( ! method_exists( $screen, 'add_help_tab' ) )
        return $contextual_help;
	$screen = get_current_screen();

	if ( $screen->id != 'settings_page_bppp-settings') return;

	$screen_title = esc_attr_x( 'Progress Bar on Profile', 'Help screen', 'buddy-progress-bar' );

	// Progress Bar on Profile help text
    $variables =  '<h4>' . $screen_title . '</h4>
	<ol>
		<li>' . esc_attr_x( 'Default display on each profile header and tabs', 'Help screen', 'buddy-progress-bar' ) . '</li>
		<li>' . esc_attr_x( 'Displays bar only on profile edit tab.', 'Help screen',	'buddy-progress-bar' ) . '</li>
		<li>' . esc_attr_x( 'No progress bar will be shown.', 'Help screen', 'buddy-progress-bar' ) . '</li>							
	</ol>
	<p>' . esc_attr_x( 'The default display of the progress bar includes a title, a progress bar and a percentage value. If you select option 1 or 2, the title can be set in the Bar Titles section below.', 'Help screen', 'buddy-progress-bar' ) . '</p>
	<p>' . esc_attr_x( 'Note: the progress bar is only used on profiles and by the Progress Bar Widget. All other places use only an optionnal title and the percentage value.', 'Help screen', 'buddy-progress-bar' ) . '</p>';
 
    $help_content = $variables;
 
    // Add help panel
    $screen->add_help_tab( array(
        'id'      => 'bppp-help-screen-1',
        'title'   => $screen_title,
        'content' => $help_content,
    ));
 
    return $contextual_help;
}
add_action( 'contextual_help', 'bppp_help_on_profile', 10, 3 );

  
function bppp_help_other_positions( $contextual_help, $screen_id, $screen ) {
 
    if ( ! method_exists( $screen, 'add_help_tab' ) )
        return $contextual_help;
	$screen = get_current_screen();

	if ( $screen->id != 'settings_page_bppp-settings') return;

	$screen_title = esc_attr_x( 'Other positions', 'Help screen', 'buddy-progress-bar' );
 
    // Progression information help text
    $variables =  '<h4>' . $screen_title . '</h4>
	<ol>
		<li>' . esc_attr_x( 'Displays a progress information on BuddyPress Login Widget for the loggedin user. Ensure the widget - "(BuddyPress) Log in" - is active if you want to use this option. Leave unchecked if you don\'t want to use it.', 'Help screen', 'buddy-progress-bar' ) . '</li>
		<li>' . esc_attr_x( 'Displays a progress information on BuddyPress Members Directory. That\'s pure meta information and we don\'t want an extra template for this. Leave unchecked if you don\'t want to use it.', 'Help screen', 'buddy-progress-bar' ) . '</li>
	</ol>';

    $help_content = $variables;
 
    // Add help panel
    $screen->add_help_tab( array(
        'id'      => 'bppp-help-screen-2',
        'title'   => $screen_title,
        'content' => $help_content,
    ));
 
    return $contextual_help;
}
add_action( 'contextual_help', 'bppp_help_other_positions', 10, 3 );


function bppp_help_titles( $contextual_help, $screen_id, $screen ) {
 
    if ( ! method_exists( $screen, 'add_help_tab' ) )
        return $contextual_help;
	$screen = get_current_screen();

	if ( $screen->id != 'settings_page_bppp-settings') return;

	$screen_title = esc_attr_x( 'Bar Titles', 'Help screen', 'buddy-progress-bar' );
 
    // Titles help text
    $variables =  '<h4>' . $screen_title . '</h4>
	<ol>
		<li>' . esc_attr_x( 'Enter a short introduction title to show before the bar or percentage value. Leave blank if you don\'t want to use it.', 'Help screen', 'buddy-progress-bar' ) . '</li>		
	</ol>';  
 
    // Combine $variables list with $hooks list.
    $help_content = $variables;
 
    // Add help panel
    $screen->add_help_tab( array(
        'id'      => 'bppp-help-screen-3',
        'title'   => $screen_title,
        'content' => $help_content,
    ));
 
    return $contextual_help;
}
add_action( 'contextual_help', 'bppp_help_titles', 10, 3 );


function bppp_help_profile_completed( $contextual_help, $screen_id, $screen ) {
 
    if ( ! method_exists( $screen, 'add_help_tab' ) )
        return $contextual_help;
	$screen = get_current_screen();

	if ( $screen->id != 'settings_page_bppp-settings') return;

	$screen_title = esc_attr_x( 'Profile completed message', 'Help screen', 'buddy-progress-bar' );
 
    // Profile completed help text
    $variables =  '<h4>' . $screen_title . '</h4>
	<ol>
		<li>' . esc_attr_x( 'Enter a short introduction to show when a profile is completed to 100%. This will be displayed on any of the previous selected options and on Progress Bar widget. Leave blank if you don\'t want to use it.', 'Help screen', 'buddy-progress-bar' ) . '</li>
		<li>' . esc_attr_x( 'Display an award icon (dashicon) before the percent amount. Alternatively, you can leave the title blank and only check the icon.', 'Help screen', 'buddy-progress-bar' ) . '</li>
	</ol>';
 
    $help_content = $variables;
 
    // Add help panel
    $screen->add_help_tab( array(
        'id'      => 'bppp-help-screen-4',
        'title'   => $screen_title,
        'content' => $help_content,
    ));
 
    return $contextual_help;
}
add_action( 'contextual_help', 'bppp_help_profile_completed', 10, 3 );


function bppp_help_profile_empty( $contextual_help, $screen_id, $screen ) {
 
    if ( ! method_exists( $screen, 'add_help_tab' ) )
        return $contextual_help;
	$screen = get_current_screen();

	if ( $screen->id != 'settings_page_bppp-settings') return;

	$screen_title = esc_attr_x( 'Profile is empty message', 'Help screen', 'buddy-progress-bar' );
 
    // Profile completed help text
    $variables =  '<h4>' . $screen_title . '</h4>
	<ol>
		<li>' . esc_attr_x( 'Enter a medium introduction to show when a profile is empty. This is intended to be shown by default on profile headers, but you can optionally add it to login widget or members directory. Leave blank if you don\'t want to use it.', 'Help screen', 'buddy-progress-bar' ) . '</li>
	</ol>';
 
    $help_content = $variables;
 
    // Add help panel
    $screen->add_help_tab( array(
        'id'      => 'bppp-help-screen-5',
        'title'   => $screen_title,
        'content' => $help_content,
    ));
 
    return $contextual_help;
}
add_action( 'contextual_help', 'bppp_help_profile_empty', 10, 3 );


function bppp_help_points_shares( $contextual_help, $screen_id, $screen ) {
 
    if ( ! method_exists( $screen, 'add_help_tab' ) )
        return $contextual_help;
	$screen = get_current_screen();

	if ( $screen->id != 'settings_page_bppp-settings') return;

	$screen_title = esc_attr_x( 'Points Shares', 'Help screen', 'buddy-progress-bar' );
 
    // Points Shares help text
    $variables =  '<h4>' . $screen_title . '</h4>
	<ol>
		<li>' . esc_attr_x( 'Here you can attribute points (from 0 to 10) for each existing xprofile field, including a custom avatar uploaded by the user. Blank value will be considered as zero point.', 'Help screen', 'buddy-progress-bar' ) . '</li>
		<li>' . esc_attr_x( 'The base field (Name) is ignored and never counted. If you have 10 custom fields and attribute 1 point to each, each field will be worth 10%. If the user fills only 4, his progress bar will show 40%.', 'Help screen', 'buddy-progress-bar' ) . '</li>
	</ol>
	<p>' . esc_attr_x( 'Note: when you change a point value, the progression for each user is automatically recalculated. In some cases, if you don\'t see the new value, simply reload the concerned profile page or close your browser session and start a new one.', 'Help screen', 'buddy-progress-bar' ) . '</p>';
	

    $help_content = $variables;
 
    // Add help panel
    $screen->add_help_tab( array(
        'id'      => 'bppp-help-screen-6',
        'title'   => $screen_title,
        'content' => $help_content,
    ));
 
    return $contextual_help;
}
add_action( 'contextual_help', 'bppp_help_points_shares', 10, 3 );


function bppp_about_screen() {	

	$display_version = bppp_get_plugin_version();

	if( is_multisite() ) {
		$settings_url = add_query_arg( array( 'page' => 'bppp-settings'), admin_url( 'options-general.php?page=bppp-settings' ) );
	} else {
		$settings_url = add_query_arg( array( 'page' => 'bppp-settings'), bp_get_admin_url( 'options-general.php?page=bppp-settings' ) );
	} ?>

<div class="wrap about-wrap">
		
<h1><?php _ex( 'Welcome on Buddy Progress Bar', 'Welcome screen title', 'buddy-progress-bar' ); ?></h1>
<div class="about-text"><?php _ex( 'Thank you for using Buddy Progress Bar', 'Welcome screen sub title', 'buddy-progress-bar' ); ?>&nbsp;<?php echo $display_version; ?></div>
<div class="bppp-badge"></div>

<div class="changelog">		
	<h4><?php _ex( 'Buddy Progress Bar at a glance', 'Welcome screen', 'buddy-progress-bar' ); ?></h4>
		<p><?php _ex( 'Buddy Progress Bar is the ideal tool to show the completion level of each members profile fields. By default, a connected member will see his progression on his profile page.', 'Welcome screen', 'buddy-progress-bar' ); ?></p> 
		<p><?php _ex( 'The goal of Buddy Progress Bar is to kindly remember your community members to complete their profile in a clear, significant and non-obstrusive way. Not only when they visit their profile, but when they connect to your site. Buddy Progress Bar comes with over 10 options for accomplish this.', 'Welcome screen', 'buddy-progress-bar' ); ?></p>
		<p><?php _ex( 'Another cool way to inform your members would be to use the directory option. Ie. combining a relevant title with the award icon can be very efficient in some cases. ', 'Welcome screen', 'buddy-progress-bar' ); ?></p>
		<p><?php _ex( 'While managing the community members, the site admin will see a new profile status column in the list. The best overview to know who filled his profile, with a handy tool to send them a message if necessary.', 'Welcome screen', 'buddy-progress-bar' ); ?></p>
				
	<div class="featured-image">
		<img src="<?php echo esc_url( bppp_get_images_url() . 'progress-bar-profile.png' ); ?>" alt="<?php esc_attr_x( 'The Buddy Profile Progression view', 'Welcome screen img alt', 'buddy-progress-bar' ); ?>">
	</div>	
	<div class="last-feature">
		<h4><?php _ex( 'Buddy Progress Bar Display Options', 'Welcome screen', 'buddy-progress-bar' ); ?></h4>
		<ol>
			<li><?php _ex( 'On profile header display. Options are : on every profile tab, only on profile edit tab, none. ', 'Welcome screen', 'buddy-progress-bar' ); ?></li>
			<li><?php _ex( 'On login widget display. Option: on/off ', 'Welcome screen', 'buddy-progress-bar' ); ?></li>
			<li><?php _ex( 'On members directory display. Option: on/off. ', 'Welcome screen', 'buddy-progress-bar' ); ?></li>
			<li><?php _ex( 'Bar titles display. You can set a different title for each display option. Ie. title on directory can be different from title on login widget. ', 'Welcome screen', 'buddy-progress-bar' ); ?></li>
			<li><?php _ex( 'Profile is empty is a message box where you can briefly write something about profile to your members. This message is only displayed when the user has no percent value attached to his account or when this value is empty or equal to 0. This happens when the plugin is installed or later, when users ignore completely their profile fields. This message is diplayed by default on profile header and can be activated on login widget and members directory.', 'Welcome screen', 'buddy-progress-bar' ); ?></li>
			<li><?php _ex( 'Profile is completed and Show award icon. Once all fields are completed to 100%, you can show a specific title or an award icon. Options are: title and icon, only title, only icon, none', 'Welcome screen', 'buddy-progress-bar' ); ?></li>
			<li><?php _ex( 'Points shares let administrators attribute a point value for each existing xprofile field. So you can handle separately important and secondary fields.', 'Welcome screen', 'Welcome screen', 'buddy-progress-bar' ); ?></li>
			<li><?php _ex( 'Avatar change, from default mytery man to a custom avatar, is also valuable by points', 'Welcome screen', 'Welcome screen', 'buddy-progress-bar' ); ?></li>
			<li><?php _ex( 'Buddy Progress Bar Widget: this feature let site admins the ability to show the progress bar on any widget area, so far a widget compatible theme is used. On a multisite install, the widget can by added to every secondary blog', 'Welcome screen', 'buddy-progress-bar' ); ?></li>
			<li><?php _ex( 'Profile status on users management list. No setting here, except WordPress screen option. If a profile is empty, a clickable message icon is showing, else you will see the percentage.', 'Welcome screen', 'buddy-progress-bar' ); ?></li>
		</ol>
	</div>
	<h3><?php _ex( 'Buddy Progress Bar Settings', 'Welcome screen', 'buddy-progress-bar' ); ?></h3>

	<p><?php _ex( 'Click the Help tab in the top right corner of the settings screen to get more information for each setting.', 'Welcome screen', 'buddy-progress-bar' ); ?></p>

	<h3><?php _ex( 'How to use Buddy Progress Bar options', 'Welcome screen', 'buddy-progress-bar' ); ?></h3>

	<p><?php _ex( 'This really depends on how you manage your community, according to the language and the theme you use. The plugin brings two types of information: one for users, ie. your profile is completed up to 30% and one for site admins to users: (ie. please, complete your profile). ', 'Welcome screen', 'buddy-progress-bar' ); ?></p>
	<p><?php _ex( 'The progress bar appears only on profile headers and on the Buddy Progress Bar Widget. All other places, login widget and members directory show only progression information. At minimum a percentage, ie. (30%)', 'Welcome screen', 'buddy-progress-bar' ); ?></p>
	<p><?php _ex( 'For each place, you can set up a short title to introduce the bar or the percentage to your members. Two other options, allows you to enter a different text, when a profile reached 100% or when it is 0% percent or empty. In case of a completed profile, you have an icon option, so you don\'t need to use any title or message.', 'Welcome screen', 'buddy-progress-bar' ); ?></p>
	<p><?php _ex( 'To calculate the progression profile, the plugin list all your xprofile field and calculate the percentage in function of each point value you set up in the Point Share option. This option let you also give a value point for avatar changes.', 'Welcome screen', 'buddy-progress-bar' ); ?></p>

	<h3>Credits</h3>
		<p><?php _ex( 'Thank you to G. Breant, author and creator of BuddyPress Profile Progression plugin, no more maintained since BP 1.7. Buddy Progress Bar is a fork of that work, partially rewriten and corrected, with much more options.', 'Welcome screen', 'buddy-progress-bar' ); ?></p>
		<p><?php _ex( 'A special great thank you to my friend Pascal for his time for debugging, help and encouragements.', 'Welcome screen', 'buddy-progress-bar' ); ?></p>
</div>

<div class="return-to-settings">
	 <a href="<?php echo $settings_url ?>"><?php echo _x( 'Go to Progress Bar settings', 'Welcome screen', 'buddy-progress-bar' ); ?></a>
</div>

<?php
}