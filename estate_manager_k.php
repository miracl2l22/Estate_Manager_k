<?php
/**
 * Plugin Name: Estate Manager k
 * Plugin URI: http://
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

if ( ! class_exists( 'Estate_Manager_k' ) ) {

  final class Estate_Manager_k {
   
    private static $instance;
   
    public function __construct() {
	  self::$instance->load_files();
    }
    
    public function load_files() {
      require_once ( 'includes/class-core.php' );
    }

	public static function getInstance() {
	  if ( ! isset( self::$instance ) ) {
		self::$instance = new Estate_Manager_k;
	  }
	  return self::$instance;
	}
  }
}

function Estate_Manager_k(){
	return Estate_Manager_k::getInstance();
}

Estate_Manager_k();
