<?php

if(!defined('WPINC')) // MUST have WordPress.
    exit('Do NOT access this file directly: '.basename(__FILE__));

/**
* Admin
*/
class admin_interface
{

	function __construct()
	{
		add_action( 'admin_enqueue_scripts', array($this, 'load_custom_wp_admin_style') );
    add_action( 'wp_enqueue_scripts', array($this, 'load_custom_wp_frontend_style') );

		add_action( 'save_post', array($this, 'on_save_update_post') );
		add_action('init', array($this, 'the_temp_data_viewer') );
		add_action( 'add_meta_boxes_embroidery_pricing', array($this, 'add_meta_box') );

        add_filter( 'woocommerce_product_data_tabs', array( &$this, 'product_write_panel_tab' ), 300 );

        add_action( 'woocommerce_product_data_panels',     array( &$this, 'product_write_panel' ), 300 );

		add_action( 'woocommerce_process_product_meta', array( &$this, 'woocommerce_process_product_meta_fields_save' ) );

    //////screen printing
    add_action( 'add_meta_boxes_screen_printing', array($this, 'add_meta_box') );
    add_action( 'save_post', array($this, 'on_save_update_post_screen_printing') );
    add_filter( 'woocommerce_product_data_tabs', array( &$this, 'product_write_panel_tab_screen_printing' ), 310 );
    add_action( 'woocommerce_product_data_panels',     array( &$this, 'product_write_panel_screen_printing' ), 300 );

    //sizing groups
    add_action( 'add_meta_boxes_sizing_groups_ps', array($this, 'add_meta_box') );
    add_action( 'save_post', array($this, 'on_save_update_post_sizing_groups_ps') );
    add_filter( 'woocommerce_product_data_tabs', array( &$this, 'product_write_panel_tab_sizing_group' ), 310 );
    add_action( 'woocommerce_product_data_panels',     array( &$this, 'product_write_panel_sizing_group' ), 300 );


	}

	function woocommerce_process_product_meta_fields_save( $post_id ){
	    // This is the case to save custom field data of checkbox. You have to do it as per your custom fields
	    $woo_embroidery_select = isset( $_POST['_my_custom_embroidery_data'] ) ? $_POST['_my_custom_embroidery_data'] : '';
	    update_post_meta( $post_id, '_my_custom_embroidery_data', $woo_embroidery_select );

      $woo_embroidery_select = isset( $_POST['_my_custom_screen_printing_data'] ) ? $_POST['_my_custom_screen_printing_data'] : '';
	    update_post_meta( $post_id, '_my_custom_screen_printing_data', $woo_embroidery_select );

      $woo_embroidery_select = isset( $_POST['_my_custom_sizing_group_data'] ) ? $_POST['_my_custom_sizing_group_data'] : '';
	    update_post_meta( $post_id, '_my_custom_sizing_group_data', $woo_embroidery_select );


	}


    public function product_write_panel_tab($product_data_tabs) {

		    $product_data_tabs['custom-embroidery-tab'] = array(
		        'label' => __( 'Embroidery Pricing Profile', 'wc-product-options' ),
		        'target' => 'custom_embroidery_data',
		    );

		    return $product_data_tabs;

        }

        public function product_write_panel_tab_screen_printing($product_data_tabs) {

    		    $product_data_tabs['custom-screen-printing-tab'] = array(
    		        'label' => __( 'Screen Printing Color Profile', 'wc-product-options' ),
    		        'target' => 'custom_screen_printing_data',
    		    );

    		    return $product_data_tabs;

            }
///


    public function product_write_panel_tab_sizing_group($product_data_tabs) {

		    $product_data_tabs['custom-sizing-group-tab'] = array(
		        'label' => __( 'Sizing Group Profile', 'wc-product-options' ),
		        'target' => 'custom_sizing_group_data',
		    );

		    return $product_data_tabs;

        }

        public function product_write_panel_sizing_group() {
            global $woocommerce, $post;
            ?>
            <!-- id below must match target registered in above add_my_custom_product_data_tab function -->
            <div id="custom_sizing_group_data" class="panel woocommerce_options_panel">
                <?php

          global $post;

          $args = array(
            'numberposts' => -1,
            'post_type'   => 'sizing_groups_ps'
          );

          $screen_printing_size = get_posts( $args );

          $screen_printing_size = (empty($screen_printing_size) ? array() : $screen_printing_size);

          $single_screen_printing_arr = array();

          foreach ($screen_printing_size as $single_screen_printing) {
            if (!empty($single_screen_printing->post_title) && !empty($single_screen_printing->ID))
              $single_screen_printing_arr[$single_screen_printing->ID] = $single_screen_printing->post_title;

          }


          if (!empty($_GET['post']))
            $current_val = get_post_meta( $_GET['post'] , '_my_custom_sizing_group_data', true );
          else
            $current_val = '';

            $single_screen_printing_arr['none'] = 'None';

            woocommerce_wp_select(array(

                'id'            => '_my_custom_sizing_group_data',
                'description'	=> __('Select Profile', 'wc-product-options'),
                'wrapper_class' => 'show_if_simple',
                'options'	=> $single_screen_printing_arr,
                'value'	=> $current_val

              ));


                ?>
            </div>
            <?php
        }

// adds the tab panel content on the edit product page
public function product_write_panel_screen_printing() {
    global $woocommerce, $post;
    ?>
    <!-- id below must match target registered in above add_my_custom_product_data_tab function -->
    <div id="custom_screen_printing_data" class="panel woocommerce_options_panel">
        <?php

  global $post;

  $args = array(
    'numberposts' => -1,
    'post_type'   => 'screen_printing'
  );

  $screen_printing_size = get_posts( $args );

  $screen_printing_size = (empty($screen_printing_size) ? array() : $screen_printing_size);

  $single_screen_printing_arr = array();

  foreach ($screen_printing_size as $single_screen_printing) {
    if (!empty($single_screen_printing->post_title) && !empty($single_screen_printing->ID))
      $single_screen_printing_arr[$single_screen_printing->ID] = $single_screen_printing->post_title;

  }


  if (!empty($_GET['post']))
    $current_val = get_post_meta( $_GET['post'] , '_my_custom_screen_printing_data', true );
  else
    $current_val = '';

    $single_screen_printing_arr['none'] = 'None';

    woocommerce_wp_select(array(

        'id'            => '_my_custom_screen_printing_data',
        'description'	=> __('Select Profile', 'wc-product-options'),
        'wrapper_class' => 'show_if_simple',
        'options'	=> $single_screen_printing_arr,
        'value'	=> $current_val

      ));

        ?>
    </div>
    <?php
}
    // adds the tab panel content on the edit product page
		public function product_write_panel() {
		    global $woocommerce, $post;
		    ?>
		    <!-- id below must match target registered in above add_my_custom_product_data_tab function -->
		    <div id="custom_embroidery_data" class="panel woocommerce_options_panel">
		        <?php

			global $post;

			$args = array(
			  'numberposts' => -1,
			  'post_type'   => 'embroidery_pricing'
			);

			$embroidery_size = get_posts( $args );

			$embroidery_size = (empty($embroidery_size) ? array() : $embroidery_size);

			$single_embroidery_arr = array();

			foreach ($embroidery_size as $single_embroidery) {
				if (!empty($single_embroidery->post_title) && !empty($single_embroidery->ID))
					$single_embroidery_arr[$single_embroidery->ID] = $single_embroidery->post_title;

			}


			if (!empty($_GET['post']))
				$current_val = get_post_meta( $_GET['post'] , '_my_custom_embroidery_data', true );
			else
				$current_val = '';
        $single_embroidery_arr['none'] = 'None';

		    woocommerce_wp_select(array(

		        'id'            => '_my_custom_embroidery_data',
		        'description'	=> __('Select Profile', 'wc-product-options'),
		        'wrapper_class' => 'show_if_simple',
		        'options'	=> $single_embroidery_arr,
		        'value'	=> $current_val

		    	));


		        ?>
		    </div>
		    <?php
		}

	public function add_meta_box() {


		add_meta_box( 'discount_set', 'Discount Set', array($this, 'discount_set_meta_box'), 'embroidery_pricing', 'normal');
    add_meta_box( 'color_set', 'Color Set', array($this, 'color_set_meta_box'), 'screen_printing', 'normal');
    add_meta_box( 'sizing_group', 'Sizing Options', array($this, 'sizing_group_meta_box'), 'sizing_groups_ps', 'normal');

	}

  public function sizing_group_meta_box() {

		$template = wc_product_options_PLUGIN_DIR . '/views/template_sizing_group.php';

        if ( file_exists( $template ) )
            include $template;


	}

	public function discount_set_meta_box() {

		$template = wc_product_options_PLUGIN_DIR . '/views/template_empty_embroidery.php';

        if ( file_exists( $template ) )
            include $template;


	}

  public function color_set_meta_box() {
		$template = wc_product_options_PLUGIN_DIR . '/views/template_empty_colorset.php';

        if ( file_exists( $template ) )
            include $template;


	}

	function load_custom_wp_admin_style($hook) {

        wp_enqueue_style( 'wc-product-options_wp_admin_css', wc_product_options_PLUGIN_URL.'admin-style.css' );

        wp_register_script( 'wc-product-options-script', wc_product_options_PLUGIN_URL.'script_custom.js', array( 'jquery' ), '', true );

		    wp_localize_script( 'wc-product-options-script', 'plugin_data', array( 'ajax_url' => admin_url('admin-ajax.php') ));

		    wp_enqueue_script( 'wc-product-options-script' );

        if ( ! ( (strcmp(get_post_type($_GET['post']), "product") === 0) || (strcmp($_GET['post_type'], "product") === 0) ) )
          wp_enqueue_style( 'wc-product-options_bootstrap', wc_product_options_PLUGIN_URL.'bootstrap.css' );

        wp_enqueue_script( 'bootstrapjs', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'), '', true );


	}



  function load_custom_wp_frontend_style($hook) {


        wp_register_script( 'wc-product-options-script', wc_product_options_PLUGIN_URL.'script_custom.js', array( 'jquery' ), '', true );

        wp_localize_script( 'wc-product-options-script', 'plugin_data', array( 'ajax_url' => admin_url('admin-ajax.php') ));

        wp_enqueue_script( 'wc-product-options-script' );

        wp_enqueue_style( 'wc-product-options_bootstrap', wc_product_options_PLUGIN_URL.'bootstrap.css' );

        wp_enqueue_script( 'bootstrapjs', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'), '', true );


  }

	public function on_save_update_post($post_id = '') {

		if (empty($post_id))
			return;

		if (empty($_POST['post_type']))
			return;


		if ($_POST['post_type'] !== 'embroidery_pricing')
			return;


		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		$terms = wp_get_post_terms( $post_id, 'embroidery_size' );

		if (empty($terms))
			return;

		$this->add_field_rows($_POST, $post_id);
		$this->add_update_field_data($_POST, $post_id);


	}


  public function on_save_update_post_screen_printing($post_id = '') {

		if (empty($post_id))
			return;

		if (empty($_POST['post_type']))
			return;


		if ($_POST['post_type'] !== 'screen_printing')
			return;


		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		$terms = wp_get_post_terms( $post_id, 'screen_printing_color' );

		if (empty($terms))
			return;

		$this->add_field_rows($_POST, $post_id);
		$this->add_update_field_data($_POST, $post_id);


	}




    public function on_save_update_post_sizing_groups_ps($post_id = '') {


  		if (empty($post_id))
  			return;

  		if (empty($_POST['post_type']))
  			return;


  		if ($_POST['post_type'] !== 'sizing_groups_ps')
  			return;


  		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
  			return;


  		$this->add_field_rows_sizing_groups_ps($_POST, $post_id);
  		$this->add_update_field_data_sizing_groups_ps($_POST, $post_id);


  	}

    private function add_update_field_data_sizing_groups_ps($post_data = '', $post_id = '') {

      if (empty($post_data))
        return;

      if (empty($post_id))
        return;

        $post_type = strtolower(str_replace(' ', '', $post_data['post_type']));

        $data = array();

        $row_data_sizing_order = (empty($post_data['row_data_sizing_order_'.$post_type."_".$post_id]) ? $post_data['row_data_sizing_order_'.$post_type."_"] : $post_data['row_data_sizing_order_'.$post_type."_".$post_id]);
        $row_data_sizing_sizing = (empty($post_data['row_data_sizing_sizing_'.$post_type."_".$post_id]) ? $post_data['row_data_sizing_sizing_'.$post_type."_"] : $post_data['row_data_sizing_sizing_'.$post_type."_".$post_id]);
        $row_data_sizing_width = (empty($post_data['row_data_sizing_width_'.$post_type."_".$post_id]) ? $post_data['row_data_sizing_width_'.$post_type."_"] : $post_data['row_data_sizing_width_'.$post_type."_".$post_id]);
        $row_data_sizing_length = (empty($post_data['row_data_sizing_length_'.$post_type."_".$post_id]) ? $post_data['row_data_sizing_length_'.$post_type."_"] : $post_data['row_data_sizing_length_'.$post_type."_".$post_id]);


        $row_data_sizing_order = (empty($row_data_sizing_order) ? array() : $row_data_sizing_order);
        $row_data_sizing_sizing = (empty($row_data_sizing_sizing) ? array() : $row_data_sizing_sizing);
        $row_data_sizing_width = (empty($row_data_sizing_width) ? array() : $row_data_sizing_width);
        $row_data_sizing_length = (empty($row_data_sizing_length) ? array() : $row_data_sizing_length);

        $row_data_sizing_order_filtered = array_map('intval', $row_data_sizing_order );
        $row_data_sizing_sizing_filtered = array_map('strval', $row_data_sizing_sizing );
    		$row_data_sizing_width_filtered = array_map('floatval', $row_data_sizing_width);
        $row_data_sizing_length_filtered = array_map('floatval', $row_data_sizing_length);

        $row_data_sizing_order = array_values($row_data_sizing_order_filtered);
    		$row_data_sizing_sizing = array_values($row_data_sizing_width_filtered);
    		$row_data_sizing_width = array_values($row_data_sizing_length_filtered);
        $row_data_sizing_length = array_values($row_data_sizing_length_filtered);


        $final_data = array();


    		for ($i=0; $i < count($row_data_sizing_order_filtered); $i++) {

    			$final_data[$i] = array(

    				'row_data_sizing_order' => $row_data_sizing_order_filtered[$i],
    				'row_data_sizing_sizing' => $row_data_sizing_sizing_filtered[$i],
    				'row_data_sizing_width' => $row_data_sizing_width_filtered[$i],
            'row_data_sizing_length' => $row_data_sizing_length_filtered[$i],

    				);

    		}

        //usort($final_data, $this->sizing_sort);

        usort($final_data, function($a, $b) {
          return $a['row_data_sizing_order'] - $b['row_data_sizing_order'];
        });

        foreach ($final_data as $key => $final_data_val) {

          if (empty($final_data_val['row_data_sizing_order']) && empty($final_data_val['row_data_sizing_sizing']) && empty($final_data_val['row_data_sizing_width']) && empty($final_data_val['row_data_sizing_length']))
            unset($final_data[$key]);

        }
        $final_data = array_values($final_data);

        $add_data = update_post_meta( $post_id, 'row_data_'.$post_type."_".$post_id, $final_data);


    }

    private function sizing_sort($a, $b) {

      if ($a['row_data_sizing_order'] == $b['row_data_sizing_order']) return 0;

      return ($a['row_data_sizing_order'] > $b['row_data_sizing_order']) ? 1 : -1;

    }

    private function add_field_rows_sizing_groups_ps($post_data = '', $post_id = '') {

      if (empty($post_data))
        return;

      if (empty($post_id))
        return;


    if ( $post_data['post_type'] !== 'sizing_groups_ps')
      return;
    //$terms = wp_get_post_terms( $post_id, 'embroidery_size' );


    $post_type = strtolower(str_replace(' ', '', $post_data['post_type']));

    $row_key = 'needed_row_'.$post_type."_".$post_id;


    $needed_row = (empty($post_data['needed_row_'.$post_type."_".$post_id]) ? $post_data['needed_row_'.$post_type."_"] : $post_data['needed_row_'.$post_type."_".$post_id]);

    update_post_meta( $post_id, $row_key, $needed_row);


    }

	private function add_update_field_data($post_data = '', $post_id = '') {

		if (empty($post_data))
			return;

		if (empty($post_id))
			return;

      if ( $post_data['post_type'] === 'embroidery_pricing')
      		$terms = wp_get_post_terms( $post_id, 'embroidery_size' );
      elseif ($post_data['post_type'] === 'screen_printing')
          $terms = wp_get_post_terms( $post_id, 'screen_printing_color' );

		//$terms = wp_get_post_terms( $post_id, 'embroidery_size' );

		foreach ($terms as $term_key => $term) {

		$term->name = strtolower(str_replace(' ', '', $term->name));

		$qty_form = $post_data['row_data_qty_form_'.$term->name."_".$post_id];
		$qty_to = $post_data['row_data_qty_to_'.$term->name."_".$post_id];
		$qty_price = $post_data['row_data_qty_price_'.$term->name."_".$post_id];

		$qty_form = (empty($qty_form) ? array() : $qty_form);
		$qty_to = (empty($qty_to) ? array() : $qty_to);
		$qty_price = (empty($qty_price) ? array() : $qty_price);



		//$qty_form = array_map(function ($v) { return (int) $v; }, $qty_form);


		$qty_form_filtered = array_map('intval', $qty_form );
		$qty_to_filtered = array_map('intval', $qty_to);
		$qty_price_filtered = array_map('floatval', $qty_price);

		$qty_form = array_values($qty_form_filtered);
		$qty_to = array_values($qty_to_filtered);
		$qty_price = array_values($qty_price_filtered);


		if (count($qty_form_filtered) !== count($qty_to_filtered) || count($qty_to_filtered) !== count($qty_price_filtered) || count($qty_form_filtered) !== count($qty_price_filtered))
			return;


		$final_data = array();


		for ($i=0; $i < count($qty_form_filtered); $i++) {

			$final_data[$i] = array(

				'qty_form' => $qty_form_filtered[$i],
				'qty_to' => $qty_to_filtered[$i],
				'qty_price' => $qty_price_filtered[$i],

				);

		}



		if (empty($final_data))
			return;


		$add_data = update_post_meta( $post_id, 'row_data_'.$term->name."_".$post_id, $final_data);

		}



	}

	private function add_field_rows($post_data = '', $post_id = '') {

		if (empty($post_data))
			return;

		if (empty($post_id))
			return;


  if ( $post_data['post_type'] === 'embroidery_pricing')
  		$terms = wp_get_post_terms( $post_id, 'embroidery_size' );
  elseif ($post_data['post_type'] === 'screen_printing')
      $terms = wp_get_post_terms( $post_id, 'screen_printing_color' );

	//$terms = wp_get_post_terms( $post_id, 'embroidery_size' );


	foreach ($terms as $term_key => $term) {

		$term->name = strtolower(str_replace(' ', '', $term->name));


		$row_key = 'needed_row_'.$term->name."_".$post_id;

		$get_post_meta = get_post_meta( $post_id, $row_key, true );

		$needed_row = $post_data['needed_row_'.$term->name."_".$post_id];


		update_post_meta( $post_id, $row_key, $needed_row);

	}




	}

	public static function logger($data) {

	  $data = maybe_serialize( $data );

      $data = $data."\n\n - ". date("F j, Y, g:i a", time())."\n\n\n";

      return file_put_contents(dirname( __FILE__ )."/log.txt", $data, FILE_APPEND);

    }


	public function the_temp_data_viewer() {

		if (empty($_REQUEST['temp_data']))
			return;

		$read_data = stripslashes($_REQUEST['temp_data']);
		$read_data_stat = maybe_unserialize( $read_data );


		if (empty($read_data_stat))
			d($read_data);
		else
			d($read_data_stat);

    	//file_put_contents(wp_expert_custom_PLUGIN_temp_DIR.'test_js_file.txt', serialize($args));

		die();
	}


}

$admin_interface = new admin_interface();


///////

//add_filter( 'woocommerce_product_tabs', 'wc_product_options_woo_new_product_tab' );
function wc_product_options_woo_new_product_tab( $tabs ) {

	// Adds the new tab

	$tabs['test_tab'] = array(
		'title' 	=> __( 'New Product Tab', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'wc_product_options_woo_new_product_tab_content'
	);

	return $tabs;

}
function wc_product_options_woo_new_product_tab_content() {

	// The new tab content

	echo '<h2>New Product Tab</h2>';
	echo '<p>Here\'s your new product tab.</p>';

}

?>
