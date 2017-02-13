<?php
add_action( 'wp_enqueue_scripts', 'wpr_enqueue_scripts' );
/**
 * Enqueue scripts
 */
function wpr_enqueue_scripts() {
	wp_enqueue_style( 'wpr-load-datatables-css', get_stylesheet_directory_uri() . '/css/datatables.min.css', array(), '2.1.0' );
	wp_enqueue_script( 'wpr-load-datatables-js', get_stylesheet_directory_uri() . '/js/datatables.min.js', array( 'jquery' ), '2.1.0', true );
	wp_register_script( 'wpr-features-js', get_stylesheet_directory_uri() . '/js/extra_features.js', array( 'jquery' ), '1.0.4', true );
	wp_localize_script( 'wpr-features-js', 'wpr_plugin_info', array(
		'wpr_ajax_url' => admin_url( 'admin-ajax.php' ),
	) );
	wp_enqueue_script( 'wpr-features-js' );
}

add_action( 'wp_ajax_wpr_get_users_list', 'wpr_get_users_list' );
add_action( 'wp_ajax_nopriv_wpr_get_users_list', 'wpr_get_users_list' );
/**
 * CPT ajax call
 */
function wpr_get_users_list() {
	$args = array(
		'post_type' => array( 'custom_post_type' ),
	);

	$query = new WP_Query( $args );

	$send_posts = array();
	if ( $query->have_posts() ):
		while ( $query->have_posts() ) : $query->the_post();
			$send_posts[] = array(
				'ID'             => get_the_ID(),
				'Title'          => get_the_title(),
				'Published date' => get_the_date(),
				'Status'         => get_post_status( get_the_ID() ),
			);
		endwhile;
	endif;

	wp_reset_postdata();

	wp_send_json( $send_posts );

	wp_die();
}