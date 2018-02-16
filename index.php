<?php
   /*
   Plugin Name: Missing Pieces Utilities
   Plugin URI: http://flatlinegraphics.com/Missing-Pieces
   Description: Add custom functionality to Wordpress
   Version: 1.0
   Author: MPU
   Author URI: http://flatlinegraphics.com
   License: GPL2
   */
// Block direct requests
if ( !defined('ABSPATH') )
die('-1');

//load modules
require 'inc/customclass.php';
require 'inc/seo.php';
//require 'inc/news.php';
//require 'inc/breadcrumbs.php';
require 'inc/options.php';
require 'inc/shortcodes.php';
require 'inc/homepage.php';
require 'inc/sidebar.php';


//load plugin js & css
function MPU_enqueue(){
  wp_enqueue_style('thickbox');
  wp_enqueue_script('media-upload');
  wp_enqueue_script('thickbox');
  wp_enqueue_style( 'wp-color-picker');
  wp_enqueue_script( 'wp-color-picker');
  wp_enqueue_style( 'MP', '/wp-content/plugins/Missing-Pieces/css/MP_utilities.css');
  wp_enqueue_script('hrw', '/wp-content/plugins/Missing-Pieces/js/MPU_init.js', null, null, true);
}
add_action('admin_enqueue_scripts', 'MPU_enqueue');

//custom functions
 function MP_utilities_enque() {
    wp_enqueue_style( 'MP_utilities', '/wp-content/plugins/Missing-Pieces/css/MP_utilities_frontend.css' );
    //wp_enqueue_script( 'MP_utilities', '/wp-content/plugins/Missing-Pieces/js/MP_utilities_init.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'MP_utilities_enque' );



?>