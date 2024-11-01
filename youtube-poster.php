<?php

/*
Plugin Name: Youtube Poster
Description: This plugin will take information from a YouTube video URL entered and insert it as a post into Wordpress.
Version: 1.0
Author: Dion Design
Author URI: http://www.diondesign.ca
*/

function dd_ytp_install () 
{
	global $wpdb;

	$table_name = $wpdb->prefix . "dd_ytp";
	$sql = "
	CREATE TABLE IF NOT EXISTS `$table_name` (
	  `variable` varchar(255) NOT NULL,
	  `value` varchar(255) NOT NULL,
	  PRIMARY KEY (`variable`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;

	INSERT INTO `$table_name` (`variable`, `value`) VALUES
	('autohide', '2'),
	('autoplay', '0'),
	('controls', '1'),
	('fs', '0'),
	('hd', '0'),
	('height', '315'),
	('loop', '0'),
	('modestbranding', '0'),
	('rel', '0'),
	('showinfo', '0'),
	('showsearch', '0'),
	('theme', 'light'),
	('width', '560');
	";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}

function dd_ytp_menu() 
{
	add_menu_page('YouTube Poster', 'YouTube Poster', 'manage_options', 'dd_ytp_plugin', 'dd_ytp_intro');
	add_submenu_page('dd_ytp_plugin', 'Post Video', 'Post Video', 'manage_options', 'dd_ytp_post', 'dd_ytp_post');
	add_submenu_page('dd_ytp_plugin', 'Player Settings', 'Player Settings', 'manage_options', 'dd_ytp_settings', 'dd_ytp_settings');
}

function dd_ytp_intro() 
{
	if (!current_user_can('manage_options')) 
		wp_die( __('You do not have sufficient permissions to access this page.') );

	include 'intro.php';
}

function dd_ytp_post() 
{
	if (!current_user_can('manage_options')) 
		wp_die( __('You do not have sufficient permissions to access this page.') );

	include 'post-video.php';
}

function dd_ytp_settings() 
{
	global $wpdb;
	
	if (!current_user_can('manage_options')) 
		wp_die( __('You do not have sufficient permissions to access this page.') );

	include 'player-settings.php';
}

function dd_ytp_shortcode ($atts) 
{
	global $wpdb;

	$rows = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."dd_ytp");
	$width = $wpdb->get_var( $wpdb->prepare("select `value` from ".$wpdb->prefix."dd_ytp where `variable`='width'"));
	$height = $wpdb->get_var( $wpdb->prepare("select `value` from ".$wpdb->prefix."dd_ytp where `variable`='height'"));
	$src = 'http://www.youtube.com/embed/'.$atts['v'].'?';
	$src_array = array();
	
	foreach ($rows as $k => $v)
	{
		if ($v->variable != 'width' && $v->variable != 'height')
			$src_array[] = $v->variable.'='.$v->value;
	}
	
	$src_array = implode('&', $src_array);
	$src .= $src_array;

	echo '<iframe width="'.$width.'" height="'.$height.'" src="'.$src.'" frameborder="0"></iframe>';
}

register_activation_hook(__FILE__,'dd_ytp_install');
add_action('admin_menu', 'dd_ytp_menu');
add_shortcode('dd_ytp', 'dd_ytp_shortcode');

?>