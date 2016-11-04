<?php
/**
*
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Estate_Manager_Core extends Estate_Manager_k {

	// Use taxonomy
	private $post_types = array( 'property' );

	public function __construct() {
		add_action( 'init', array( $this, 'init_property_post_type' ) );
		add_action( 'init', array( $this, 'init_property_type_taxonomies' ) );
	}

	public static function init_property_post_type() {
		$labels = array (
			'name'          => __( 'Properties', 'estatek' ),
			'singular_name' => __( 'Property', 'estatek' ),
			'all_items'     => __( 'All Properties', 'estatek' ),
			'add_new'       => __( 'New Property', 'estatek' ),
			'add_new_item'  => __( 'Add New Property', 'estatek' ),
			'edit_item'     => __( 'Edit Property', 'estatek' ),
			'search_items'  => __( 'Search Properties', 'estatek' ),
		);
		$args = array (
			'labels'        => $labels,
			'description'   => __( 'Description', 'estatek' ),
			'supports'      => array( 'title' ),
			'public'        => true,
			'menu_position' => 5,
			'menu_icon'     => 'dashicons-admin-home',
			'has_archive'   => true,
		);
		register_post_type( 'property', $args );
	}

	public static function init_property_type_taxonomies() {
		$labels = array (
			'name'          => __( 'Properties Type', 'estatek' ),
			'singular_name' => __( 'Property Type', 'estatek' ),
			'all_items'     => __( 'All Properties Type', 'estatek' ),
		);
		$args = array (
			'labels'        => $labels,
			'hierarchical'  => true,
			'public'        => true,
			'rewrite'       => array( 'slug' => 'property_type' ),
		);
		register_taxonomy( 'property_type', $this->post_types, $args );
	}
}