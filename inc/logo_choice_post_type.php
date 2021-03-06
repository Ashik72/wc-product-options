<?php

if(!defined('WPINC')) // MUST have WordPress.
    exit('Do NOT access this file directly: '.basename(__FILE__));


if ( ! function_exists('logo_choice_group_post') ) {

  // Register Custom Post Type
  function logo_choice_group_post() {

  	$labels = array(
  		'name'                  => _x( 'All Logo Choice', 'Post Type General Name', 'wc-product-options' ),
  		'singular_name'         => _x( 'Logo Choice', 'Post Type Singular Name', 'wc-product-options' ),
  		'menu_name'             => __( 'All Logo Choice', 'wc-product-options' ),
  		'name_admin_bar'        => __( 'Logo Choice', 'wc-product-options' ),
  		'archives'              => __( 'Item Archives', 'wc-product-options' ),
  		'parent_item_colon'     => __( 'Parent Item:', 'wc-product-options' ),
  		'all_items'             => __( 'All Logo Choice', 'wc-product-options' ),
  		'add_new_item'          => __( 'Add Logo Choice', 'wc-product-options' ),
  		'add_new'               => __( 'Add New', 'wc-product-options' ),
  		'new_item'              => __( 'New Logo Choice', 'wc-product-options' ),
  		'edit_item'             => __( 'Edit Logo Choice', 'wc-product-options' ),
  		'update_item'           => __( 'Update Logo Choice', 'wc-product-options' ),
  		'view_item'             => __( 'View Logo Choice', 'wc-product-options' ),
  		'search_items'          => __( 'Search Logo Choice', 'wc-product-options' ),
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
  		'label'                 => __( 'Logo Choice', 'wc-product-options' ),
  		'description'           => __( 'Custom Logo Choice', 'wc-product-options' ),
  		'labels'                => $labels,
  		'supports'              => array( 'title', 'custom-fields', 'page-attributes', ),
  		/*'taxonomies'            => array( 'category', 'post_tag' ),*/
  		'hierarchical'          => false,
  		'public'                => false,
  		'show_ui'               => true,
  		'show_in_menu'          => true,
  		'menu_position'         => 5,
  		'menu_icon'             => 'dashicons-pressthis',
  		'show_in_admin_bar'     => true,
  		'show_in_nav_menus'     => true,
  		'can_export'            => true,
  		'has_archive'           => true,
  		'exclude_from_search'   => true,
  		'publicly_queryable'    => true,
  		/*'capabilities'          => $capabilities,*/
  	);
  	register_post_type( 'logo_choice_group', $args );

  }
  add_action( 'init', 'logo_choice_group_post', 0 );


}

add_action( 'admin_menu', 'remove_mega_menu_option_logo_choice_group' );
add_action( 'do_meta_boxes', 'remove_mega_menu_option_logo_choice_group' );

function remove_mega_menu_option_logo_choice_group() {

	if (!empty(get_current_screen()->post_type) && get_current_screen()->post_type !== 'logo_choice_group')
		return;

	if (!empty($_GET['post_type']) && $_GET['post_type'] !== 'logo_choice_group')
		return;

	remove_meta_box( 'postcustom', 'logo_choice_group', 'normal' );
	remove_meta_box( 'mm_general', 'logo_choice_group', 'normal' );
	remove_meta_box( 'mymetabox_revslider_0', 'logo_choice_group', 'normal' );
	remove_meta_box( 'mymetabox_revslider_0', 'logo_choice_group', 'advanced' );
	remove_meta_box( 'categorydiv', 'logo_choice_group', 'side' );

}




if ( ! function_exists( 'logo_choice_group_size' ) ) {

// Register Custom Taxonomy
function logo_choice_group_size() {

	$labels = array(
		'name'                       => _x( 'All Logo Choice Area', 'Taxonomy General Name', 'wc-product-options' ),
		'singular_name'              => _x( 'Logo Choice Area', 'Taxonomy Singular Name', 'wc-product-options' ),
		'menu_name'                  => __( 'Logo Choice Area', 'wc-product-options' ),
		'all_items'                  => __( 'All Logo Choice Area', 'wc-product-options' ),
		'parent_item'                => __( 'Parent Logo Choice Area', 'wc-product-options' ),
		'parent_item_colon'          => __( 'Parent Logo Choice Area:', 'wc-product-options' ),
		'new_item_name'              => __( 'New Logo Choice Area', 'wc-product-options' ),
		'add_new_item'               => __( 'Add Logo Choice Area', 'wc-product-options' ),
		'edit_item'                  => __( 'Edit Logo Choice Area', 'wc-product-options' ),
		'update_item'                => __( 'Update Logo Choice Area', 'wc-product-options' ),
		'view_item'                  => __( 'View Logo Choice Area', 'wc-product-options' ),
		'separate_items_with_commas' => __( 'Separate Logo Choice Area with commas', 'wc-product-options' ),
		'add_or_remove_items'        => __( 'Add or remove Logo Choice Area', 'wc-product-options' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'wc-product-options' ),
		'popular_items'              => __( 'Popular Logo Choice Area', 'wc-product-options' ),
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
	register_taxonomy( 'logo_choice_group_size', array( 'logo_choice_group' ), $args );

}
add_action( 'init', 'logo_choice_group_size', 0 );

}

add_action( 'do_meta_boxes', 'change_meta_box_postion_custom_logo_choice_group_color' );

function change_meta_box_postion_custom_logo_choice_group_color() {


}

/*
	Usage: sizes_get_meta( 'sizes_sizes' )
*/




?>
