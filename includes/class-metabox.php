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
        'id'            => 'general-info',
        'title'         => __( 'General Info', 'estatek' ),
        'object_types'  => array( 'property', ), // Post type
				// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
				// 'context'    => 'normal',
				// 'priority'   => 'high',
				// 'show_names' => true, // Show field names on the left
				// 'cmb_styles' => false, // false to disable the CMB stylesheet
				// 'closed'     => true, // true to keep the metabox closed by default
				// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
				// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
				// 'show_in_rest' => WP_REST_Server::READABLE|WP_REST_Server::ALLMETHODS|WP_REST_Server::EDITABLE, // Determines which HTTP methods the box is visible in. More here: https://github.com/WebDevStudios/CMB2/wiki/REST-API
    ) );

		$cmb1->add_field( array(
        'name'          => __( 'Price', 'estatek' ),
        // 'desc'         => __( 'field description (optional)', 'estatek' ),
        'id'            => $prefix . 'price',
        'type'          => 'text',
				'column'		    => true,
    ) );

    $cmb1->add_field( array(
        'name' => __( 'Address', 'estatek' ),
        //'desc' => __( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'address',
        'type' => 'text',
    ) );

    $cmb2 = new_cmb2_box( array(
        'id'            => 'additional-info',
        'title'         => __( 'Additional Info', 'estatek' ),
        'object_types'  => array( 'property', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

		$cmb2->add_field( array(
				'name'          => __( 'Options', 'estatek' ),
				// 'desc'          => 'field description (optional)',
        'id'            => $prefix . 'options',
				'type'          => 'multicheck_inline',
				'options'       => array(
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