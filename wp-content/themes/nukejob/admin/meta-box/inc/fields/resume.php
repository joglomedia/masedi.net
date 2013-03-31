<?php
/**
 * WPNuke Custom Meta Box
 *
 * resume uplaod file
 *
 * @package nukejob
 */
 
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Resume_Field' ) )
{
	class RWMB_Resume_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			wp_enqueue_script( 'rwmb-file', RWMB_JS_URL . 'file.js', array( 'jquery', 'wp-ajax-response' ), RWMB_VER, true );
		}

		/**
		 * Add actions
		 *
		 * @return void
		 */
		static function add_actions()
		{
			// Add data encoding type for file uploading
			add_action( 'post_edit_form_tag', array( __CLASS__, 'post_edit_form_tag' ) );
			
			// Rename file uplaod
			add_filter('wp_handle_upload_prefilter', array( __CLASS__, 'wpnuke_modify_uploaded_file_names'), 1, 1);
			
			// Delete file via Ajax
			add_action( 'wp_ajax_rwmb_delete_file', array( __CLASS__, 'wp_ajax_delete_file' ) );
		}

		/**
		 * Add data encoding type for file uploading
		 *
		 * @return void
		 */
		static function post_edit_form_tag()
		{
			echo ' enctype="multipart/form-data"';
		}

		/**
		 * Ajax callback for deleting files.
		 * Modified from a function used by "Verve Meta Boxes" plugin
		 *
		 * @link http://goo.gl/LzYSq
		 * @return void
		 */
		static function wp_ajax_delete_file()
		{
			$post_id       = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
			$field_id      = isset( $_POST['field_id'] ) ? $_POST['field_id'] : 0;
			$attachment_id = isset( $_POST['attachment_id'] ) ? intval( $_POST['attachment_id'] ) : 0;
			$force_delete  = isset( $_POST['force_delete'] ) ? intval( $_POST['force_delete'] ) : 0;

			check_admin_referer( "rwmb-delete-file_{$field_id}" );

			delete_post_meta( $post_id, $field_id, $attachment_id );
			$ok = $force_delete ? wp_delete_attachment( $attachment_id ) : true;

			if ( $ok )
				RW_Meta_Box::ajax_response( '', 'success' );
			else
				RW_Meta_Box::ajax_response( __( 'Error: Cannot delete file', 'rwmb' ), 'error' );
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
			$i18n_title  = _x( 'Upload files', 'file upload', 'rwmb' );
			$i18n_more   = _x( '+ Add new file', 'file upload', 'rwmb' );			

			// Uploaded files
			$html = self::get_uploaded_files( $meta, $field );

			// Show form upload
			$html .= sprintf(
				'<h4>%s</h4>
				<div class="new-files">
					<div class="file-input"><input type="file" name="%s[]" /></div>
					<a class="rwmb-add-file" href="#"><strong>%s</strong></a>
				</div>',
				$i18n_title,
				$field['id'],
				$i18n_more
			);

			return $html;
		}
		
		static function get_uploaded_files( $files, $field ) 
		{			
			$delete_nonce = wp_create_nonce( "rwmb-delete-file_{$field['id']}" );
			$ol = '<ol class="rwmb-uploaded" data-field_id="%s" data-delete_nonce="%s" data-force_delete="%s" data-max_file_uploads="%s" data-mime_type="%s" data-allowed_ext="%s">';
			$html .= sprintf(
				$ol,
				$field['id'],
				$delete_nonce,
				$field['force_delete'] ? 1 : 0,
				$field['max_file_uploads'],
				$field['mime_type'],
				$field['allowed_ext']
			);
			

			foreach ( $files as $attachment_id )
			{			
				// modify
				if (!empty($attachment_id)) {
					if ($attachment_id != "fail") {
						$html .= self::file_html( $attachment_id );
					} elseif ($attachment_id == "fail") {
						$html .= '<li>File upload fail! Please check your file type/size/extension!</li>';
					} else {
					}
				}
			}

			$html .= '</ol>';
			
			return $html;
		}
		
		static function file_html( $attachment_id ) 
		{
			$i18n_delete = _x( 'Delete', 'file upload', 'rwmb' );
			$li = '<li>%s (<a title="%s" class="rwmb-delete-file" href="#" data-attachment_id="%s">%s</a>)</li>';
			
			$attachment = wp_get_attachment_link( $attachment_id );
			return sprintf(
				$li,
				$attachment,
				$i18n_delete,
				$attachment_id,
				$i18n_delete
			);
		}

		/**
		 * Get meta values to save
		 *
		 * @param mixed $new
		 * @param mixed $old
		 * @param int   $post_id
		 * @param array $field
		 *
		 * @return array|mixed
		 */
		static function value( $new, $old, $post_id, $field )
		{
			$name = $field['id'];
			if ( empty( $_FILES[ $name ] ) )
				return $new;

			$new = array();
			$files	= self::fix_file_array( $_FILES[ $name ] );

			foreach ( $files as $file_item )
			{			
				// modify for uploading only file with allowed extension

				if ( ! empty($file_item['name']) ) {
					
					$wp_filetype = wp_check_filetype($file_item['name']);
					
					$file_ext = (!empty($wp_filetype['ext'])) ? $wp_filetype['ext'] : '';
					
					$allowed_exts = explode(',', $field['allowed_ext']);
					/*
					$file_exts = explode('.', $file_item['name']);
					$count_ext = count($file_exts);
					$file_ext = $file_exts[$count_ext - 1];
					*/

					if ( in_array( $file_ext, $allowed_exts ) ) {

						$file = wp_handle_upload( $file_item, array( 'test_form' => false ) );

						if ( ! isset( $file['file'] ) )
							continue;

						$file_name = $file['file'];
						
						$attachment = array(
							'post_mime_type'	=> $file['type'],
							'guid'				=> $file['url'],
							'post_parent'		=> $post_id,
							'post_title'		=> preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
							'post_content'		=> '',
							//'post_status'		=> 'inherit'
						);
						$id = wp_insert_attachment( $attachment, $file_name, $post_id );
						
						if ( ! is_wp_error( $id ) )
						{
							wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file_name ) );

							// Save file ID in meta field
							$new[] = $id;
						}
					
					} else {
						// save fail parameter in meta field to tell user that file ext failed to upload
						//$new[] = 'fail';
					}
				}
			}

			return array_unique( array_merge( $old, $new ) );
		}

		/**
		 * Fixes the odd indexing of multiple file uploads from the format:
		 *	 $_FILES['field']['key']['index']
		 * To the more standard and appropriate:
		 *	 $_FILES['field']['index']['key']
		 *
		 * @param array $files
		 *
		 * @return array
		 */
		static function fix_file_array( $files )
		{
			$output = array();
			foreach ( $files as $key => $list )
			{
				foreach ( $list as $index => $value )
				{
					$output[$index][$key] = $value;
				}
			}
			return $output;
		}

		/**
		 * Normalize parameters for field
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function normalize_field( $field )
		{
			$field = wp_parse_args( $field, array(
				'std'          => array(),
				'force_delete' => false,
				'max_file_uploads' => 0
			) );
			$field['multiple'] = true;
			return $field;
		}
		
		/**
		 * Standard meta retrieval
		 *
		 * @param mixed $meta
		 * @param int   $post_id
		 * @param array $field
		 * @param bool  $saved
		 *
		 * @return mixed
		 */
		static function meta( $meta, $post_id, $saved, $field )
		{
			global $wpdb;

			$meta = RW_Meta_Box::meta( $meta, $post_id, $saved, $field );

			if ( empty( $meta ) )
				return array();

			return (array) $meta;
		}
		
		/**
		 * Rename uploaded file via wp_handle_upload_prefilter filter hook
		 *
		 * @param array $file_item
		 *
		 * @return mixed
		 */
		static function wpnuke_modify_uploaded_file_names($file_item)
		{
			global $post;
			
			$author_id = $post->post_author;
			
			$wp_filetype = wp_check_filetype($file_item['name']);
			$file_ext = (!empty($wp_filetype['ext'])) ? $wp_filetype['ext'] : '';
			//$file_token = uniqid(md5($file_item['name']), true);
			$file_token = uniqid(base64_encode($author_id));
			$file_item['name'] = $file_token . '_' . $file_item['name'];
			
			return $file_item;
		}
	}
}