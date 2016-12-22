<?php

if(!defined('WPINC')) // MUST have WordPress.
    exit('Do NOT access this file directly: '.basename(__FILE__));

/**
 * Admin Menu
 */
class WooCommerceProductOptions {

    /**
     * Kick-in the class
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );

        //d(dirname(dirname( __FILE__ )));

    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {

        /** Top Menu **/

        //add_menu_page( __( 'WooCommerce Product Options', 'wc-product-options' ), __( 'WooCommerce Product Options', 'wc-product-options' ), 'manage_options', 'wc-product-options', array( $this, 'plugin_page' ), 'dashicons-networking', null );

        //add_submenu_page( 'wc-product-options', __( 'WooCommerce Product Options', 'wc-product-options' ), __( 'WooCommerce Product Options', 'wc-product-options' ), 'manage_options', 'wc-product-options', array( $this, 'plugin_page' ) );

        //add_submenu_page( 'wc-product-options', __( 'Embroidery Pricing', 'wc-product-options' ), __( 'Embroidery Pricing', 'wc-product-options' ), 'manage_options', 'wc-embroidery-pricing', array( $this, 'embroidery_pricing_page' ) );


    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ($action) {
            case 'view':

                $template = dirname( __FILE__ ) . '/views/wc-product-options-single.php';
                break;

            case 'edit':
                $template = dirname( __FILE__ ) . '/views/wc-product-options-edit.php';
                break;

            case 'new':
                $template = dirname( __FILE__ ) . '/views/wc-product-options-new.php';
                break;

            default:
                $template = dirname( __FILE__ ) . '/views/wc-product-options-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }


    public function embroidery_pricing_page() {

        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'embroidery_list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ($action) {
            case 'view':

                $template = wc_product_options_PLUGIN_DIR . '/views/view_all_embroidery.php';
                break;

            case 'edit':
                check_admin_referer( 'embroidery-single-edit_'.$_GET['name'], 'wpnonce' );
                $template = wc_product_options_PLUGIN_DIR . '/views/edit_single_embroidery.php';
                break;

            case 'delete':
                check_admin_referer( 'embroidery-single-edit_'.$_GET['name'], 'wpnonce' );
                $template = wc_product_options_PLUGIN_DIR . '/views/edit_single_embroidery.php';
                break;

            case 'new':
                $template = wc_product_options_PLUGIN_DIR . '/views/view_single_embroidery.php';
                break;

            default:
                $template = wc_product_options_PLUGIN_DIR . '/views/view_all_embroidery.php';
                break;
        }


        if ( file_exists( $template ) ) {
            include $template;
        }



    }

}

$WooCommerceProductOptions = new WooCommerceProductOptions();


?>