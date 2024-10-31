<?php
/*Create Table for settings*/
function play_pause_settings() {    
global $wpdb;
$table_name = $wpdb->prefix . "Play_pause_video";
$sql = "CREATE TABLE IF NOT EXISTS $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,     
      ss_play_button_status varchar(255) NULL,
      ss_float_status TINYINT(2) NOT NULL,
      iframe_status TINYINT(2) NOT NULL,
      PRIMARY KEY id (id)
    ) ";
require_once(ABSPATH . "wp-admin/includes/upgrade.php");
    dbDelta($sql);

    /*Check if table not empty start*/
	global $wpdb;
	$table_name = $wpdb->prefix . "Play_pause_video";
	$result = $wpdb->get_var("SELECT * FROM $table_name group by id DESC");
	if(count($result) == 0)
	{
		$qry = $wpdb->query( "INSERT INTO $table_name (ss_play_button_status,ss_float_status,iframe_status) VALUES ('1','1','1')");
		$wpdb->query($qry);
	}
	/*Check if table not empty start*/

}
add_action('admin_menu', 'play_pause_settings');
require_once(ABSPATH.'wp-admin/includes/user.php');

add_action("admin_menu" , "play_pause_dashboard");

/*Admin menu creation start*/
function play_pause_dashboard()
{
    add_menu_page( "Play Pause Video" , "Play Pause Video" , "manage_options" , "floating_video_settings", "floating_video_settings", plugins_url( 'play-pause-button-for-video/img/icon.png' ), 10 );
}
function floating_video_settings()
{
require( plugin_dir_path( __FILE__ ) . 'include/play-pause-db-settings-insert.php');
}
/*Admin menu creation End*/
