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

function get_thumbnail_url($post){
	if(has_post_thumbnail($post['id'])){
		$imgArray = wp_get_attachment_image_src( get_post_thumbnail_id( $post['id'] ), 'full' );
		$imgURL = $imgArray[0];
		return $imgURL;
	}else{
		return false;
	}
}

