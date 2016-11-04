<?php
/**
* Plugin Name: Estate Manager k
* Description: 한국형 부동산 관리 워드프레스 플러그인
* Version: 0.1
* Author: miracl2l22
*
* Text Domain: estatek
* Domain Path: /languages/
*/

// Exit if accessed directely
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Estate_Manager_k' ) ) {

	class Estate_Manager_k {

		private static $instance;

		public $core;

		public $metabox;

		public function __construct() {
			$this -> load_files();
		}

		public function load_files() {
			require_once ( 'includes/class-core.php' );
			require_once ( 'includes/class-metabox.php' );
		}

		public static function getInstance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance          = new Estate_Manager_k;
				self::$instance->core    = new Estate_Manager_Core;
				self::$instance->metabox = new Estate_Manager_Metabox;
			}
			return self::$instance;
		}
	}
}

function Estate_Manager_k(){
	return Estate_Manager_k::getInstance();
}

Estate_Manager_k();