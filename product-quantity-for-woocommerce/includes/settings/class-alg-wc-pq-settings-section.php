<?php
/**
 * Product Quantity for WooCommerce - Section Settings
 *
 * @version 4.9.3
 * @since   1.0.0
 * @author  WPFactory
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_PQ_Settings_Section' ) ) :

class Alg_WC_PQ_Settings_Section {
	
	/**
	 * qty_step_settings  
	 *
	 * @var   string
	 * @since 4.6.8
	 */
	public $qty_step_settings = 1;
	
	/**
	 * Constructor.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 */
	function __construct() {
		add_filter( 'woocommerce_get_sections_alg_wc_pq',              array( $this, 'settings_section' ) );
		add_filter( 'woocommerce_get_settings_alg_wc_pq_' . $this->id, array( $this, 'get_settings' ), PHP_INT_MAX );
	}

	/**
	 * message_replaced_values.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function message_replaced_values( $values ) {
		$message_template = ( 1 == count( $values ) ?
			__( 'Replaced value: %s.', 'product-quantity-for-woocommerce' ) : __( 'Replaced values: %s.', 'product-quantity-for-woocommerce' ) );
		return sprintf( $message_template, '<code>' . implode( '</code>, <code>', $values ) . '</code>' );
	}

	/**
	 * get_qty_step_settings.
	 *
	 * @version 4.6.8
	 * @since   1.6.0
	 * @todo    [dev] customizable `$qty_step_settings` (i.e. instead of always `0.000001`)
	 */
	function get_qty_step_settings() {
		/*if ( ! isset( $this->qty_step_settings ) ) {*/
			$this->qty_step_settings = ( 'yes' === get_option( 'alg_wc_pq_decimal_quantities_enabled', 'no' ) ? 0.000001 : 1 );
		/*}*/
		return $this->qty_step_settings;
	}

	/**
	 * settings_section.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function settings_section( $sections ) {
		$sections[ $this->id ] = $this->desc;
		return $sections;
	}

	/**
	 * array_to_html_list_items.
	 *
	 * @version 4.9.3
	 * @since   4.9.3
	 *
	 * @param $items
	 *
	 * @return string
	 */
	function array_to_html_list_items( $items ) {
		// Ensure the input is an array
		if ( is_array( $items ) ) {
			return '<li>' . implode( '</li><li>', array_map( 'wp_kses_post', $items ) ) . '</li>';
		}

		return '';
	}

}

endif;
