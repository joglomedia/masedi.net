<?php
/**
 * WPNuke Custom Meta Box
 *
 * Gmap
 *
 * @package nukejob
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( !class_exists( 'RWMB_Gmap_Field' ) )
{
	class RWMB_Gmap_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			wp_enqueue_script( 'googlemap', 'http://maps.google.com/maps/api/js?sensor=false', array(), '', true );
			wp_enqueue_script( 'rwmb-gmap', RWMB_JS_URL . 'gmap.js', array( 'jquery', 'jquery-ui-autocomplete', 'googlemap' ), RWMB_VER, true );
		}

		/**
		 * Get field HTML
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $html, $meta, $field )
		{
			$address = isset( $field['address_field'] ) ? $field['address_field'] : false;
			
			$maps = explode(',', $meta);
			$map_latitude = $maps[0];
			$map_longitude = $maps[1];
			$map_zoom = $maps[2];
			
			$html = sprintf(
				'<div class="rwmb-map-canvas" style="%s"></div>
				<input type="hidden" name="%s" id="rwmb-map-coordinate" value="%s" />',
				isset( $field['style'] ) ? $field['style'] : '',
				$field['field_name'],
				$meta
			);
			
			$html .= "<br />";
			$html .= sprintf(
				'<input type="text" name="map_latitude" id="rmwb-map-latitude" value="%s" /> Geo Latitude',
				$map_latitude
			);
			$html .= "<br />";
			$html .= sprintf(
				'<input type="text" name="map_longitude" id="rmwb-map-longitude" value="%s" /> Geo Longitude',
				$map_longitude
			);
			$html .= sprintf(
				'<input type="hidden" name="map_zoom" id="rmwb-map-zoom" value="%s" />',
				$map_zoom
			);
			
			if ( $address )
			{
				$html .= sprintf(
					'<br /><button class="button" type="button" id="rwmb-map-goto-address-button" value="%s" onclick="geocodeAddress(this.value);">%s</button>',
					is_array( $address ) ? implode( ',', $address ) : $address,
					__( 'Find Address', 'rwmb' )
				);
			}
			return $html;
		}
	}
}