<?php
/**
 * Plugin Name: Estate Manger k
 * Plugin URI: 
 * Description: Real Estate Management Wordpress Plugin
 * Version: 1.0
 * Author: miracl2l22
 * Author URI: http://
 * Requires at least:
 * Tested up to: 
 *
 * Text Domain: estatek
 * Domain Path: /languages/
 */

// Exit if accessed directely
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Estate_k' ) ) {

  final class Estate_k {
   
    private static $instance;
   
    public function __construct() { 
    }
    
    public function add_file() {
      require_once ( 'includes/class-post-type-property.php' );
      require_once ( 'includes/class-metabox.php' );
    }
  }
}
?>
