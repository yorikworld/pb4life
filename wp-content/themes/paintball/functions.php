<?php
add_theme_support( 'post-thumbnails' );
add_post_type_support( 'post', 'excerpt' );
remove_filter( 'the_excerpt', 'wpautop' );
add_action( 'rest_api_init', 'insert_thumbnail_url' );

function insert_thumbnail_url() {
		register_rest_field( 'post',
				'thumbnail',
				array(
						'get_callback'    => 'get_thumbnail_url',
						'update_callback' => null,
						'schema'          => null,
				)
		);
}

function get_thumbnail_url( $post ) {
		if ( has_post_thumbnail( $post['id'] ) ) {
				$imgArray = wp_get_attachment_image_src( get_post_thumbnail_id( $post['id'] ), 'full' );
//				$imgArray = wp_get_attachment_image_src( get_post_thumbnail_id( $post['id'] ), 'carousel' );
				$imgURL   = $imgArray[0];

				return $imgURL;
		} else {
				return false;
		}
}

function post_view_count_callback() {
		$id = $_GET['id'];
		if ( $id ) {
				$tmp   = get_post_meta( $id, 'views_count', true );
				$count = $tmp ? $tmp : 0;
				echo update_post_meta( $id, 'views_count', ++ $count );
				wp_die();
		}
}

//function my_load_field($field) {
//
//
//				$field['readonly'] = 1;
//
//	return $field;
//}
//
//add_filter("acf/load_field", "my_load_field");

////if ( function_exists( 'add_image_size' ) ) {
//		add_image_size( 'category-thumb', 300 ); // 300 pixels wide (and unlimited height)
//		add_image_size( 'carousel', 560, 426, true ); // (cropped)
//}

add_action( 'wp_ajax_post_view_count', 'post_view_count_callback' );
add_action( 'wp_ajax_nopriv_post_view_count', 'post_view_count_callback' );
