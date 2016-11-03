<?php
/**
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Estate_Manager_Core extends Estate_Manager_k {

  // Use taxonomy
  private $post_types = array( 'property' );

/*  private $fields = array(
	array(
	  'id' => 'text1',
	  'label' => 'Text1',
	  'type' => 'text',
	),
	array(
	  'id' => 'text2',
	  'label' => 'Text2',
	  'type' => 'text',
	),
	array(
	  'id' => 'number1',
	  'label' => 'Number1',
	  'type' => 'number',
	),
	array(
	  'id' => 'check1',
	  'label' => 'Check1',
	  'type' => 'checkbox',
	),
  );*/

  public function __construct() {
  	add_action( 'init', array( $this, 'init_property_post_type' ) );
	add_action( 'init', array( $this, 'init_property_type_taxonomies' ) );
//	add_action( 'add_meta_boxes', array( $this, 'add_general_meta_boxes' ) );
	//add_action( 'add_meta_boxes', array( $this, 'add_additional_meta_boxes' ) );
//	add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
//	add_action( 'save_post', array( $this, 'save_post' ) );
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

/*  public function add_general_meta_boxes() {
	foreach ( $this->screens as $screen ) {
	  add_meta_box(
	  	'property_general_info',
	  	__( 'Property General Info', 'estatek' ),
	  	array( $this, 'general_meta_box_callback' ),
	  	$screen,
	  	'advanced',
	  	'default'
	  );
	}
  }

  public function add_meta_boxes() {
	foreach ( $this->screens as $screen ) {
	  add_meta_box(
	  	'property_info',
	  	__( 'Property Info', 'estatek' ),
	  	array( $this, 'add_meta_box_callback' ),
	  	$screen,
	  	'advanced',
	  	'default'
	  );
	}
  }

  public function general_meta_box_callback( $post ) {
    wp_nonce_field( 'property_general_info_data', 'property_general_info_nonce' );
	// echo 'Desc'; // Desc
	$this->generate_fields( $post );
  }

  public function add_meta_box_callback( $post ) {
    wp_nonce_field( 'property_info_data', 'property_info_nonce' );
	echo 'Desc';
	$this->generate_fields( $post );
  }

	public function generate_fields( $post ) {
		$output = '';
		foreach ( $this->fields as $field ) {
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value = get_post_meta( $post->ID, 'property_info_' . $field['id'], true );
			switch ( $field['type'] ) {
				case 'checkbox':
					$input = sprintf(
						'<input %s id="%s" name="%s" type="checkbox" value="1">',
						$db_value === '1' ? 'checked' : '',
						$field['id'],
						$field['id']
					);
					break;
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$field['type'] !== 'color' ? 'class="regular-text"' : '',
						$field['id'],
						$field['id'],
						$field['type'],
						$db_value
					);
			}
			$output .= $this->row_format( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	public function row_format( $label, $input ) {
		return sprintf(
			'<tr><th scope="row">%s</th><td>%s</td></tr>',
			$label,
			$input
		);
	}
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['property_info_nonce'] ) )
			return $post_id;

		$nonce = $_POST['property_info_nonce'];
		if ( !wp_verify_nonce( $nonce, 'property_info_data' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		foreach ( $this->fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['type'] ) {
					case 'email':
						$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
						break;
					case 'text':
						$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
						break;
				}
				update_post_meta( $post_id, 'property_info_' . $field['id'], $_POST[ $field['id'] ] );
			} else if ( $field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, 'property_info_' . $field['id'], '0' );
			}
		}
	}*/
}