<?php

if(!defined('WPINC')) // MUST have WordPress.
    exit('Do NOT access this file directly: '.basename(__FILE__));


if ( ! function_exists('embroidery_pricing_post') ) {

// Register Custom Post Type
function embroidery_pricing_post() {

	$labels = array(
		'name'                  => _x( 'All Embroidery Pricing', 'Post Type General Name', 'wc-product-options' ),
		'singular_name'         => _x( 'Embroidery Pricing', 'Post Type Singular Name', 'wc-product-options' ),
		'menu_name'             => __( 'All Embroidery Pricing', 'wc-product-options' ),
		'name_admin_bar'        => __( 'Embroidery Pricing', 'wc-product-options' ),
		'archives'              => __( 'Item Archives', 'wc-product-options' ),
		'parent_item_colon'     => __( 'Parent Item:', 'wc-product-options' ),
		'all_items'             => __( 'All Embroidery Pricing', 'wc-product-options' ),
		'add_new_item'          => __( 'Add Embroidery Pricing', 'wc-product-options' ),
		'add_new'               => __( 'Add New', 'wc-product-options' ),
		'new_item'              => __( 'New Embroidery Pricing', 'wc-product-options' ),
		'edit_item'             => __( 'Edit Embroidery Pricing', 'wc-product-options' ),
		'update_item'           => __( 'Update Embroidery Pricing', 'wc-product-options' ),
		'view_item'             => __( 'View Embroidery Pricing', 'wc-product-options' ),
		'search_items'          => __( 'Search Embroidery Pricing', 'wc-product-options' ),
		'not_found'             => __( 'Not found', 'wc-product-options' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'wc-product-options' ),
		'featured_image'        => __( 'Featured Image', 'wc-product-options' ),
		'set_featured_image'    => __( 'Set featured image', 'wc-product-options' ),
		'remove_featured_image' => __( 'Remove featured image', 'wc-product-options' ),
		'use_featured_image'    => __( 'Use as featured image', 'wc-product-options' ),
		'insert_into_item'      => __( 'Insert into item', 'wc-product-options' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'wc-product-options' ),
		'items_list'            => __( 'Items list', 'wc-product-options' ),
		'items_list_navigation' => __( 'Items list navigation', 'wc-product-options' ),
		'filter_items_list'     => __( 'Filter items list', 'wc-product-options' ),
	);
	$capabilities = array(
		'edit_post'             => 'edit_post',
		'read_post'             => 'read_post',
		'delete_post'           => 'delete_post',
		'edit_posts'            => 'edit_posts',
		'edit_others_posts'     => 'edit_others_posts',
		'publish_posts'         => 'publish_posts',
		'read_private_posts'    => 'read_private_posts',
	);
	$args = array(
		'label'                 => __( 'Embroidery Pricing', 'wc-product-options' ),
		'description'           => __( 'Custom Embroidery Pricing', 'wc-product-options' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'custom-fields', 'page-attributes', ),
		/*'taxonomies'            => array( 'category', 'post_tag' ),*/
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-feedback',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		/*'capabilities'          => $capabilities,*/
	);
	register_post_type( 'embroidery_pricing', $args );

}



add_action( 'init', 'embroidery_pricing_post', 0 );

}

add_action( 'admin_menu', 'remove_mega_menu_option' );
add_action( 'do_meta_boxes', 'remove_mega_menu_option' );

function remove_mega_menu_option() {

	if (!empty(get_current_screen()->post_type) && get_current_screen()->post_type !== 'embroidery_pricing')
		return;

	if (!empty($_GET['post_type']) && $_GET['post_type'] !== 'embroidery_pricing')
		return;

	remove_meta_box( 'postcustom', 'embroidery_pricing', 'normal' );
	remove_meta_box( 'mm_general', 'embroidery_pricing', 'normal' );
	remove_meta_box( 'mymetabox_revslider_0', 'embroidery_pricing', 'normal' );
	remove_meta_box( 'mymetabox_revslider_0', 'embroidery_pricing', 'advanced' );
	remove_meta_box( 'categorydiv', 'embroidery_pricing', 'side' );

}




if ( ! function_exists( 'embroidery_size' ) ) {

// Register Custom Taxonomy
function embroidery_size() {

	$labels = array(
		'name'                       => _x( 'All Embroidery Size', 'Taxonomy General Name', 'wc-product-options' ),
		'singular_name'              => _x( 'Embroidery Size', 'Taxonomy Singular Name', 'wc-product-options' ),
		'menu_name'                  => __( 'Embroidery Size', 'wc-product-options' ),
		'all_items'                  => __( 'All Embroidery Size', 'wc-product-options' ),
		'parent_item'                => __( 'Parent Embroidery Size', 'wc-product-options' ),
		'parent_item_colon'          => __( 'Parent Embroidery Size:', 'wc-product-options' ),
		'new_item_name'              => __( 'New Embroidery Size', 'wc-product-options' ),
		'add_new_item'               => __( 'Add Embroidery Size', 'wc-product-options' ),
		'edit_item'                  => __( 'Edit Embroidery Size', 'wc-product-options' ),
		'update_item'                => __( 'Update Embroidery Size', 'wc-product-options' ),
		'view_item'                  => __( 'View Embroidery Size', 'wc-product-options' ),
		'separate_items_with_commas' => __( 'Separate Embroidery Size with commas', 'wc-product-options' ),
		'add_or_remove_items'        => __( 'Add or remove Embroidery Size', 'wc-product-options' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'wc-product-options' ),
		'popular_items'              => __( 'Popular Embroidery Size', 'wc-product-options' ),
		'search_items'               => __( 'Search Items', 'wc-product-options' ),
		'not_found'                  => __( 'Not Found', 'wc-product-options' ),
		'no_terms'                   => __( 'No items', 'wc-product-options' ),
		'items_list'                 => __( 'Items list', 'wc-product-options' ),
		'items_list_navigation'      => __( 'Items list navigation', 'wc-product-options' ),
	);
	$capabilities = array(
		'manage_terms'               => 'manage_categories',
		'edit_terms'                 => 'manage_categories',
		'delete_terms'               => 'manage_categories',
		'assign_terms'               => 'edit_posts',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
		'capabilities'               => $capabilities,
	);
	register_taxonomy( 'embroidery_size', array( 'embroidery_pricing' ), $args );

}
add_action( 'init', 'embroidery_size', 0 );

}

add_action( 'do_meta_boxes', 'change_meta_box_postion_custom' );

function change_meta_box_postion_custom() {


}

/*
	Usage: sizes_get_meta( 'sizes_sizes' )
*/




?>
