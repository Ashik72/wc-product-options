<?php

if(!defined('WPINC')) // MUST have WordPress.
    exit('Do NOT access this file directly: '.basename(__FILE__));

/**
* Admin
*/
class admin_interface_logo_choice
{

  public static $titan;

  public $name = "logo_choice_group";

	function __construct()
	{

    add_action( 'admin_enqueue_scripts', array($this, 'load_custom_wp_admin_style') );
    add_action( 'add_meta_boxes_logo_choice_group', array($this, 'add_meta_box') );
    add_action( 'save_post', array($this, 'on_save_update_post') );
    add_action( 'tf_create_options', array($this, 'wp_expert_custom_options') );
    //add_action('wp_footer', array($this, 'test_check'));

    add_filter( 'woocommerce_product_data_tabs', array( &$this, 'product_write_panel_tab_print_positioning_group' ), 330 );
    add_action( 'woocommerce_product_data_panels',     array( &$this, 'product_write_panel_print_positioning_group' ), 330 );
    add_action( 'woocommerce_process_product_meta', array( &$this, 'woocommerce_process_product_meta_fields_save' ) );

	}

  function woocommerce_process_product_meta_fields_save( $post_id ){

      $woo_embroidery_select = isset( $_POST['_my_custom_logo_positioning_group_data'] ) ? $_POST['_my_custom_logo_positioning_group_data'] : '';
        update_post_meta( $post_id, '_my_custom_logo_positioning_group_data', $woo_embroidery_select );


  }



  public function product_write_panel_tab_print_positioning_group($product_data_tabs) {

      $product_data_tabs['custom-logo-positioning-group-tab'] = array(
          'label' => __( 'Select Logo Profile', 'wc-product-options' ),
          'target' => 'custom_logo_positioning_group_data',
      );

      return $product_data_tabs;

      }

      public function product_write_panel_print_positioning_group() {
          global $woocommerce, $post;
          ?>
          <!-- id below must match target registered in above add_my_custom_product_data_tab function -->
          <div id="custom_logo_positioning_group_data" class="panel woocommerce_options_panel">
              <?php

        global $post;

        $args = array(
          'numberposts' => -1,
          'post_type'   => 'logo_choice_group'
        );

        $screen_printing_size = get_posts( $args );

        $screen_printing_size = (empty($screen_printing_size) ? array() : $screen_printing_size);

        $single_screen_printing_arr = array();

        foreach ($screen_printing_size as $single_screen_printing) {
          if (!empty($single_screen_printing->post_title) && !empty($single_screen_printing->ID))
            $single_screen_printing_arr[$single_screen_printing->ID] = $single_screen_printing->post_title;

        }


        if (!empty($_GET['post']))
          $current_val = get_post_meta( $_GET['post'] , '_my_custom_logo_positioning_group_data', true );
        else
          $current_val = '';

          $single_screen_printing_arr['none'] = 'None';

          woocommerce_wp_select(array(

              'id'            => '_my_custom_logo_positioning_group_data',
              'description'	=> __('Select Profile', 'wc-product-options'),
              'wrapper_class' => 'show_if_simple',
              'options'	=> $single_screen_printing_arr,
              'value'	=> $current_val

            ));


              ?>
          </div>
          <?php
      }

  function test_check() {

    //var_dump(ABSPATH . 'wp-content' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'titan-framework' . DIRECTORY_SEPARATOR . 'titan-framework-embedder.php');

  }

  function load_custom_wp_admin_style($hook) {


        wp_register_script( 'wc-product-options-image-upload-script-choice', wc_product_options_PLUGIN_URL.'upload_custom-logo.js', array( 'jquery' ), '', true );

        if (empty($this->get_post_id()))
          return;

        wp_localize_script( 'wc-product-options-image-upload-script-choice', 'upload_img_data', array( 'ajax_url' => admin_url('admin-ajax.php'), 'post_id' => $this->get_post_id() ));
        if ($this->the_post_type_admin() === 'logo_choice_group')
          wp_enqueue_script( 'wc-product-options-image-upload-script-choice' );


  }


  function the_post_type_admin() {

    if (!empty($_GET['post_type']))
      return $_GET['post_type'];

    if (!empty($_GET['post'])) {

      $post_type = get_post_type((int) $_GET['post']);
      return $post_type;

    }

    return;

  }

function get_post_id() {

  if (!empty($_GET['post']))
    $id = $_GET['post'];

  return $id;

}

  function wp_expert_custom_options() {

  	$titan = TitanFramework::getInstance( 'wc-product-options' );
    $this->titan = $titan;

    $postMetaBox = $titan->createMetaBox( array(
    'name' => 'Upload Media',
    'post_type' => 'logo_choice_group',
    ) );

    $post_id = $_GET['post'];
    if (empty($post_id))
    	return;

    $terms = wp_get_post_terms( $post_id, 'logo_choice_group_size' );

    $term_names = array();

    foreach ($terms as $term_key => $term) {

      $term->name = strtolower(str_replace(' ', '', $term->name));

      $term_names[] = $term->name;

    }

    $postMetaBox->createOption( array(
    'name' => 'Logo Upload',
    'id' => 'logo_choice_group_upload_option',
    'type' => 'upload',
    'desc' => 'Upload your Logo'
    ) );

    $postMetaBox->createOption( array(
    'name' => 'Image Title',
    'id' => 'img_title_logo',
    'type' => 'text',
    'desc' => ''
    ) );

    // $postMetaBox->createOption( array(
    //   'name' => 'For area',
    //   'id' => 'select_printing_area_logo',
    //   'type' => 'select',
    //   'desc' => 'Select Printing Area',
    //   'options' => $term_names,
    //   'default' => 0,
    //   ) );



      $postMetaBox->createOption( array(
        'type' => 'custom',
        'custom' => '<input id="add_to_the_list" class="button button-primary button-large" type="submit" value="Add To The List" name="add_to_the_list">',
        ) );
  }


	public static function logger($data) {

	  $data = maybe_serialize( $data );

      $data = $data."\n\n - ". date("F j, Y, g:i a", time())."\n\n\n";

      return file_put_contents(dirname( __FILE__ )."/log.txt", $data, FILE_APPEND);

    }

  public function add_meta_box() {


		add_meta_box( 'logo_choice_set', 'Logo Choice Set', array($this, 'logo_choice_meta_box'), 'logo_choice_group', 'normal');

	}

  public function logo_choice_meta_box() {

		$template = wc_product_options_PLUGIN_DIR . '/views/logo_choice_group.php';

        if ( file_exists( $template ) )
            include $template;


	}



  public function on_save_update_post($post_id = '') {

    if (empty($post_id))
      return;

    if (empty($_POST['post_type']))
      return;


    if ($_POST['post_type'] !== 'logo_choice_group')
      return;


    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return;

    //$this->add_field_rows($_POST, $post_id);
    $this->add_update_field_data($_POST, $post_id);


  }

  private function add_update_field_data($post_data = '', $post_id = '') {

    if (empty($post_data))
      return;

    if (empty($post_id))
      return;

      // if ( $post_data['post_type'] === 'logo_choice_group')
      //     $terms = wp_get_post_terms( $post_id, 'logo_printing_group_size' );


    //foreach ($terms as $term_key => $term) {

    $term_name = "logo_choice_group";

    $term_name = strtolower(str_replace(' ', '', $term_name));


      $area_src = $post_data[$term_name.'_'.$post_id.'_area_src'];
      $area_title = $post_data[$term_name.'_'.$post_id.'_area_title'];

  		$area_src = (empty($area_src) ? array() : $area_src);
  		$area_title = (empty($area_title) ? array() : $area_title);

      $area_src = array_values($area_src);
  		$area_title = array_values($area_title);

      if (count($area_src) !== count($area_title))
  			return;



        		$final_data = array();


        		for ($i=0; $i < count($area_src); $i++) {

        			$final_data[$i] = array(

        				'area_src' => $area_src[$i],
        				'area_title' => $area_title[$i],

        				);

        		}



        		if (empty($final_data))
        			return;

    $add_data = update_post_meta( $post_id, 'row_data_'.$term_name."_".$post_id, $final_data);

    //}

  }




}

$admin_interface_logo_choice = new admin_interface_logo_choice();

?>
