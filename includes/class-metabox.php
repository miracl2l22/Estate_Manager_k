<?php
/**
* https://github.com/WebDevStudios/CMB2/blob/master/example-functions.php
* https://github.com/WebDevStudios/CMB2/wiki/Field-Types
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'cmb2_admin_init', 'cbm2_property_metaboxes' );

function cbm2_property_metaboxes() {

	$prefix = 'property_';

	$cmb1 = new_cmb2_box( array(
		'id'               => 'general-info',
		'title'            => __( 'General Info', 'estatek' ),
		'object_types'     => array( 'property', ), // Post type
		'context'          => 'normal',
		'priority'         => 'high',
	) );

	$cmb1->add_field( array(
		'name'             => __( 'Deal Type', 'estatek' ),
		'id'               => $prefix . 'deal_type',
		'type'             => 'radio_inline',
		'options'		       => array(
			'trading'     => __( 'Trading', 'estatek' ),
			'charther'    => __( 'Charter', 'estatek' ),
			'monthly'     => __( 'Monrhly', 'estatek' ),
		),
	) );

	$cmb1->add_field( array(
		'name'             => __( 'Price', 'estatek' ),
		'id'               => $prefix . 'price',
		'type'             => 'text',
		'column'		       => array(
			'position'    => 3,
			'name'        => __( 'Price', 'estatek' ),
		),
	) );

	$cmb1->add_field( array(
		'name'             => __( 'Address', 'estatek' ),
		'id'               => $prefix . 'address',
		'type'             => 'text',
	) );

	$cmb2 = new_cmb2_box( array(
		'id'               => 'additional-info',
		'title'            => __( 'Additional Info', 'estatek' ),
		'object_types'     => array( 'property', ), // Post type
		'context'          => 'normal',
		'priority'         => 'high',
	) );

	$cmb2->add_field( array(
		'name'             => __( 'Options', 'estatek' ),
		'id'               => $prefix . 'options',
		'type'             => 'multicheck_inline',
		'options'          => array(
			'tv'          => __( 'TV', 'estatek' ),
			'frige'       => __( 'Frige', 'estatek' ),
			'washer'      => __( 'Washer', 'estatek' ),
			'aircon'      => __( 'Aircon', 'estatek' ),

			'bed'         => __( 'Bed', 'estatek' ),
			'desk'        => __( 'Desk', 'estatek' ),
			'closet'      => __( 'Closet', 'estatek' ),
			'shoe_closet' => __( 'Shoe Closet', 'estatek' ),

			'range'       => __( 'Range', 'estatek' ),
			'induction'   => __( 'Induction', 'estatek' ),
			'microwave'   => __( 'Microwave', 'estatek' ),

			'doorlock'    => __( 'Doorlock', 'estatek' ),
			'bidet'       => __( 'Bidet', 'estatek' ),
		),
	) );
}