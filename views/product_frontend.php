<?php

if(!defined('WPINC')) // MUST have WordPress.
    exit('Do NOT access this file directly: '.basename(__FILE__));

///






///

// d($get_product_meta_my_custom_screen_printing_data);
// d($get_product_meta_my_custom_sizing_group_data);
// d($get_product_meta_my_custom_print_positioning_group_data);
// d($get_product_meta_my_custom_embroidery_data);
//d(WC_pro_opt__Product_Frontend::color_name_to_hex("DarkSalmon"));

?>
	<div id="containerProductTab" class="ProductFrontend">
		<!--Pestaña 1 activa por defecto-->
	    <input id="tab-1" type="radio" name="tab-group" checked="checked" />
	    <label for="tab-1" data-class="content-1">Features </label>
	    <!--Pestaña 2 inactiva por defecto-->
	    <input id="tab-2" type="radio" name="tab-group" />
	    <label for="tab-2" data-class="content-2">Prices</label>
	    <!--Pestaña 3 inactiva por defecto-->
	    <input id="tab-3" type="radio" name="tab-group" />
	    <label for="tab-3" data-class="content-3">Sizes</label>
	    <!--Contenido a mostrar/ocultar-->
	    <div id="content" class="general_tab_content">


	    	<!--Contenido de la Pestaña 1-->
	        <div id="content-1" class="tab-de-general">
			
			<?php the_content(); ?>


	        </div>



	        <!--Contenido de la Pestaña 2-->
	        <div id="content-2" class="tab-de-general">

		<?php 

    	//$template = wc_product_options_PLUGIN_DIR . '/views/content_2_product_frontend.php';
    	$template = wc_product_options_PLUGIN_DIR . '/views/content_2_product_frontend.php';

        if ( file_exists( $template ) )
            include $template;


		?>


	        </div>
	        <!--Contenido de la Pestaña 3-->
	        <div id="content-3" class="tab-de-general">

			<?php 

    	//$template = wc_product_options_PLUGIN_DIR . '/views/content_2_product_frontend.php';
    	$template = wc_product_options_PLUGIN_DIR . '/views/content_3_product_frontend.php';

        if ( file_exists( $template ) )
            include $template;


		?>


	        </div>
	    </div>

<div class="order_out"><a href="#" class="btn_cr_order">Create Order</a></div>

	</div>


