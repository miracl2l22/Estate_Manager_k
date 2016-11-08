<?php
/**
* https://github.com/WebDevStudios/CMB2/blob/master/example-functions.php
* https://github.com/WebDevStudios/CMB2/wiki/Field-Types
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Estate_Manager_Meta_Box extends Estate_Manager_k {
	
	private $screens = array( 'property' );

	private $general_fields = array(
		array(
			'id'      => 'deal-type',
			'label'   => '거래 종류',
			'type'    => 'radio',
			'options' => array(
				'trading'   => '매매',
				'charter'   => '전세',
				'monthly'   => '월세',
			),
		),
		array(
			'id'      => 'price',
			'label'   => '가격',
			'type'    => 'text',
		),
		array(
			'id'      => 'address',
			'label'   => '주소',
			'type'    => 'text',
		),
	);

	private $additional_fields = array(
		array(
			'id'      => 'options',
			'label'   => '옵션',
			'type'    => 'checklist',
			'options' => array(
				'tv'        => 'TV',
				'frige'     => '냉장고',
				'washer'    => '세탁기',
				'aricon'    => '에어컨',

				'desk'      => '책상',
				'bed'       => '침대',
				'closet'    => '옷장',
				'shoebox'   => '신발장',

				'range'     => '가스레인지',
				'induction' => '인더션',
				'microwate' => '전자레인지',

				'doorlock'  => '도어락',
				'bidet'     => '비데',
			),
			'options_br' => array( 4, 8, 11 ),
		),
	);

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_general_meta_box' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_additional_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
	}

	public function add_general_meta_box() {
		foreach ( $this->screens as $screen ) {
			add_meta_box(
				'general-info',
				__( 'General Info', 'estatek' ),
				array( $this, 'general_meta_box_cb' ),
				$screen,
				'advanced',
				'default'
			);
		}
	}

	public function add_additional_meta_box() {
		foreach ( $this->screens as $screen ) {
			add_meta_box(
				'additional-info',
				__( 'Additional Info', 'estatek' ),
				array( $this, 'additional_meta_box_cb' ),
				$screen,
				'advanced',
				'default'
			);
		}
	}

	public function general_meta_box_cb( $post ) {
		wp_nonce_field( 'general_info_data', 'general_info_nonce' );
		// echo 'Desc';
		$this->generate_fields( 'general_info_', $this->general_fields, $post );
	}

	public function additional_meta_box_cb( $post ) {
		wp_nonce_field( 'additional_info_data', 'additional_info_nonce' );
		// echo 'Desc';
		$this->generate_fields( 'additional_info_', $this->additional_fields, $post );
	}

	public function generate_fields( $prefix, $fields, $post ) {
		$output = '';
		foreach ( $fields as $field ) {
			$label = '<label for="' . $field['id'] . '">' . __( $field['label'], 'estatek') . '</label>';
			$db_value = get_post_meta( $post->ID, $prefix . $field['id'], true );
			switch ( $field['type'] ) {
				case 'checkbox':
					$input = sprintf(
						'<input %s id="%s" name="%s" type="checkbox" value="1">',
						$db_value === '1' ? 'checked' : '',
						$field['id'],
						$field['id']
					);
					break;
				case 'checklist':
					$input = '<fieldset>';
					$input .= '<legend class="screen-reader-text">' . $field['label'] . '</legend>';
					$i = 0;
					foreach ( $field['options'] as $key => $value ) {
						$db_value = get_post_meta( $post->ID, $prefix . $field['id'] . '_' . $key, true );
						$input .= sprintf(
							'<label><input %s id="%s" name="%s" type="checkbox" value="1"> %s</label> %s',
							$db_value === '1' ? 'checked' : '',
							$field['id'] . '_' . $key,
							$field['id'] . '_' . $key,
							$value,
							$i < count( $field['options'] ) - 1 ? '&nbsp;&nbsp;&nbsp;&nbsp;' : ''
						);
            if ( isset($field['options_br']) && in_array($i+1, $field['options_br']) ) $input .= '<br />';
						$i++;
					}
					$input .= '</fieldset>';
					break;
				case 'radio':
					$input = '<fieldset>';
					$input .= '<legend class="screen-reader-text">' . $field['label'] . '</legend>';
					$i = 0;
					foreach ( $field['options'] as $key => $value ) {
						$field_value = !is_numeric( $key ) ? $key : $value;
						$input .= sprintf(
							'<label><input %s id="%s" name="%s" type="radio" value="%s"> %s</label> %s',
							$db_value === $field_value ? 'checked' : '',
							$field['id'],
							$field['id'],
							$field_value,
							$value,
							$i < count( $field['options'] ) - 1 ? '&nbsp;&nbsp;&nbsp;&nbsp;' : ''
						);
            if ( isset($field['options_br']) && in_array($i+1, $field['options_br']) ) $input .= '<br />';
						$i++;
					}
					$input .= '</fieldset>';
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
		if ( ! isset( $_POST['general_info_nonce'] ) || ! isset( $_POST['additional_info_nonce'] ) )
			return $post_id;

		$g_nonce = $_POST['general_info_nonce'];
		$a_nonce = $_POST['additional_info_nonce'];
		if ( !wp_verify_nonce( $g_nonce, 'general_info_data' ) || !wp_verify_nonce( $a_nonce, 'additional_info_data' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		foreach ( $this->general_fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['type'] ) {
					case 'email':
						$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
						break;
					case 'text':
						$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
						break;
				}
				update_post_meta( $post_id, 'general_info_' . $field['id'], $_POST[ $field['id'] ] );
			} else if ( $field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, 'general_info_' . $field['id'], '0' );
			} else if ( $field['type'] === 'checklist' ) {
				foreach ( $field['options'] as $key => $value ) {
					if ( isset( $_POST[ $field['id'] . '_' . $key ] ) ) {
						update_post_meta( $post_id, 'general_info_' . $field['id'] . '_' . $key, $_POST[ $field['id'] . '_' . $key ] );
					} else {
						update_post_meta( $post_id, 'general_info_' . $field['id'] . '_' . $key, '0' );
					}
				}
			}
		}

		foreach ( $this->additional_fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['type'] ) {
					case 'email':
						$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
						break;
					case 'text':
						$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
						break;
				}
				update_post_meta( $post_id, 'additional_info_' . $field['id'], $_POST[ $field['id'] ] );
			} else if ( $field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, 'additional_info_' . $field['id'], '0' );
			} else if ( $field['type'] === 'checklist' ) {
				foreach ( $field['options'] as $key => $value ) {
					if ( isset( $_POST[ $field['id'] . '_' . $key ] ) ) {
						update_post_meta( $post_id, 'additional_info_' . $field['id'] . '_' . $key, $_POST[ $field['id'] . '_' . $key ] );
					} else {
						update_post_meta( $post_id, 'additional_info_' . $field['id'] . '_' . $key, '0' );
					}
				}
			}
		}
	}
}