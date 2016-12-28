<?php

if(!defined('WPINC')) // MUST have WordPress.
	exit('Do NOT access this file directly: '.basename(__FILE__));

require_once( 'titan-framework-checker.php' );
require_once( 'titan-framework-options.php' );

require_once(ABSPATH . 'wp-content' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'titan-framework' . DIRECTORY_SEPARATOR . 'titan-framework-embedder.php');


/*if ( ! class_exists( 'WP_List_Table' ) )
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
*/
//require_once( plugin_dir_path( __FILE__ ) . '/inc/embroidery_list_tables.php' );

require_once( plugin_dir_path( __FILE__ ) . '/inc/class.WooCommerceProductOptions.php' );
require_once( plugin_dir_path( __FILE__ ) . '/inc/admin_engine.php' );
require_once( plugin_dir_path( __FILE__ ) . '/inc/admin_engine_logo_printing_size.php' );
require_once( plugin_dir_path( __FILE__ ) . '/inc/admin_engine_logo_choice.php' );

require_once( plugin_dir_path( __FILE__ ) . '/inc/embroidery_post_type.php' );
require_once( plugin_dir_path( __FILE__ ) . '/inc/screen_printing_post_type.php' );

require_once( plugin_dir_path( __FILE__ ) . '/inc/sizing_groups_post_type.php' );

require_once( plugin_dir_path( __FILE__ ) . '/inc/logo_printing_post_type.php' );

require_once( plugin_dir_path( __FILE__ ) . '/inc/logo_choice_post_type.php' );

require_once( plugin_dir_path( __FILE__ ) . '/inc/product_frontend.php' );

require_once( plugin_dir_path( __FILE__ ) . '/inc/process_wc_price_data.php' );


//add_action('wp_footer', 'testFuncWPO' );

function testFuncWPO() {

	        $rulesets        = get_option('wc_bulk_pricing_rules', array() );

	        //d($rulesets);
}

?>
