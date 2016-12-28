
<?php

if(!defined('WPINC')) // MUST have WordPress.
    exit('Do NOT access this file directly: '.basename(__FILE__));

/**
 *
 */
class WC_pro_opt__Product_Frontend
{

  function __construct()
  {

    add_action('template_redirect', array($this, 'load_frontend_product'));
    add_action( 'wp_enqueue_scripts', array($this, 'load_custom_wp_frontend_style_master') );

    add_action( 'wp_ajax_add_product_for_processing', array($this, 'add_product_for_processing_callback') );
    add_action( 'wp_ajax_nopriv_add_product_for_processing', array($this, 'add_product_for_processing_callback') );

    add_action( 'wp_ajax_add_calculate_total_update', array($this, 'add_calculate_total_update_func') );
    add_action( 'wp_ajax_nopriv_add_calculate_total_update', array($this, 'add_calculate_total_update_func') );

    add_action( 'wp_ajax_process_color_amount', array($this, 'process_color_amount_func') );
    add_action( 'wp_ajax_nopriv_process_color_amount', array($this, 'process_color_amount_func') );

    add_action( 'wp_ajax_process_logo_src_title', array($this, 'process_logo_src_title_func') );
    add_action( 'wp_ajax_nopriv_process_logo_src_title', array($this, 'process_logo_src_title_func') );

    add_action( 'wp_ajax_process_final_step', array($this, 'process_final_step_func') );
    add_action( 'wp_ajax_nopriv_process_final_step', array($this, 'process_final_step_func') );

    add_action( 'wp_ajax_process_final_step_none', array($this, 'process_final_step_none_func') );
    add_action( 'wp_ajax_nopriv_process_final_step_none', array($this, 'process_final_step_none_func') );

    add_action('template_redirect', array($this, 'testFooter'));



  }

  public function testFooter() {

    if (empty($_GET['tid']))
      return;

      $get_data = get_transient($_GET['tid']);

      d($get_data);
      //d(self::calculate_emb_color_pric($_GET['tid']));

      foreach ($get_data as $key => $value) {

        if (strcmp($key, "color_val") === 0)
          d($value);

        if (strcmp($key, "size_data") === 0)
          d(self::size_data_toString($value));

        if (strcmp($key, "logo_cat_title") === 0)
          d($value);

        if (strcmp($key, "embroidery_option") === 0)
          d($value);

        if (strcmp($key, "color_option") === 0)
          d($value);

        if (strcmp($key, "image_logo_uploaded") === 0)
          d($value);

        if (strcmp($key, "logo_positioning_select") === 0)
          d(self::logo_pos_toString($value));


      }


    //
    // $base_price = $this->calculate_base_price(8357, 10);
    var_dump($_COOKIE);


    wp_die();
  }


    public static function logo_pos_toString($value_data = null) {

      if (empty($value_data))
        return;

        $value_data = get_object_vars($value_data);
        $value_data = ( ( is_array($value_data) ) ? $value_data : array() );
        $return_string = "";
        foreach ($value_data as $size => $quantiy) {

          $return_string .= $size." : ".$quantiy;
          $return_string .= " | ";

        }

        return $return_string;

    }

  public static function size_data_toString($value_data = null) {

    if (empty($value_data))
      return;

      $value_data = ( ( is_array($value_data) ) ? $value_data : array() );
      $return_string = "";
      foreach ($value_data as $size => $quantiy) {

        $return_string .= $size." : ".$quantiy;
        $return_string .= " | ";

      }

      return $return_string;

  }




public static function calculate_emb_color_pric($transient_id = null) {

  if (empty($transient_id))
    return;

    $get_data = get_transient($transient_id);

    $product_id = $get_data['product_id'];

    if ( (strcmp($get_data['embroidery_option'], "undefined") !== 0 ) )
      $state = 'embroidery_option';
    if ( (strcmp($get_data['color_option'], "undefined") !== 0 ) )
      $state = 'color_option';
    else
      return 0;

    if (empty($get_data['embroidery_option']) || empty($get_data['color_option']))
      return 0;

      $price = 0;

      $total_count_emb = 0;

      if (empty($get_data['size_data']))
        return;


      $size_data = $get_data['size_data'];
      foreach ($size_data as $key => $value) {
        $total_count_emb += (int) $value;
      }

      if (strcmp($state, "embroidery_option") === 0) {

        $get_product_meta_my_custom_embroidery_data = get_post_meta($product_id, '_my_custom_embroidery_data', true);

        $id = $get_product_meta_my_custom_embroidery_data;

        $terms = wp_get_post_terms( $id, 'embroidery_size' );

        $term_name = strtolower(str_replace(' ', '', $get_data['embroidery_option']));
        $term_key_id = 'row_data_'.$term_name."_".$id;
        $emPricingData = get_post_meta( $id, $term_key_id, true );



        foreach ($emPricingData as $price_key => $price_val) {

          if ($total_count_emb >= (int) $price_val['qty_form'] && $total_count_emb <= (int) $price_val['qty_to'])
            $price = $price_val['qty_price'];

        }

      } else if (strcmp($state, "color_option") === 0) {

        $get_product_meta_my_custom_embroidery_data = get_post_meta($product_id, '_my_custom_screen_printing_data', true);

        $id = $get_product_meta_my_custom_embroidery_data;

        $terms = wp_get_post_terms( $id, 'screen_printing_color' );

        $term_name = strtolower(str_replace(' ', '', $get_data['color_option']));
        $term_key_id = 'row_data_'.$term_name."_".$id;
        $emPricingData = get_post_meta( $id, $term_key_id, true );
        //d($emPricingData);
        foreach ($emPricingData as $price_key => $price_val) {

          if ($total_count_emb >= (int) $price_val['qty_form'] && $total_count_emb <= (int) $price_val['qty_to'])
            $price = $price_val['qty_price'];

        }


      }

      return $price * $total_count_emb;

}

public function process_final_step_none_func() {

  if (empty($_POST['transition_uid']))
    return;

  $transition_uid = $_POST['transition_uid'];

  if (isset($_COOKIE['transient_id']))
    setcookie('transient_id', "", time()-(60*60*24), '/');

  setcookie('transient_id', $transition_uid, time()+(60*60*24), '/');


  $wc = WC();

  $cart_url = $wc->cart->get_checkout_url();

  echo json_encode($cart_url);

  wp_die();

}

  public function process_final_step_func() {

    if (empty($_POST['transient_id']))
      return;

    $transition_uid = $_POST['transient_id'];

    if( ! empty( $_FILES ) ) {
      foreach( $_FILES as $file ) {
        if( is_array( $file ) ) {
          $attachment_id = self::upload_user_file( $file );
        }
      }
    }

    $data = get_transient($transition_uid);

    $data['embroidery_option'] = $_POST['embroidery_option'];
    $data['color_option'] = $_POST['color_option'];


    if (!empty($attachment_id))
      $data['image_logo_uploaded'] = wp_get_attachment_url($attachment_id);

    $data['logo_positioning_select'] = json_decode(stripslashes($_POST['logo_positioning_select']));;
    //delete_transient( $transition_uid );
    set_transient( $transition_uid, $data, 60*60*12 );

    $data = get_transient($transition_uid);

    $size_data = $data['size_data'];

    $total_count_emb = 0;
    foreach ($size_data as $key => $value) {
      $total_count_emb += (int) $value;
    }

    if (isset($_COOKIE['transient_id']))
      setcookie('transient_id', "", time()-(60*60*24), '/');

    setcookie('transient_id', $transition_uid, time()+(60*60*24), '/');

    $base_price = $this->calculate_base_price($data['product_id'], $total_count_emb);


    $wc = WC();

    // $wc_product = new WC_Product((int) $data['product_id']);
    //
    // $wc->cart->add_to_cart($data['product_id']);

    $cart_url = $wc->cart->get_checkout_url();

    echo json_encode($cart_url);
    //echo json_encode($transition_uid);

    wp_die();

  }

  public static function upload_user_file( $file = array() ) {

	require_once( ABSPATH . 'wp-admin/includes/admin.php' );
      $file_return = wp_handle_upload( $file, array('test_form' => false ) );
      if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
          return false;
      } else {
          $filename = $file_return['file'];
          $attachment = array(
              'post_mime_type' => $file_return['type'],
              'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
              'post_content' => '',
              'post_status' => 'inherit',
              'guid' => $file_return['url']
          );
          $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );
          require_once(ABSPATH . 'wp-admin/includes/image.php');
          $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
          wp_update_attachment_metadata( $attachment_id, $attachment_data );
          if( 0 < intval( $attachment_id ) ) {
          	return $attachment_id;
          }
      }
      return false;
}

  function add_product_for_processing_callback() {

    ///echo json_encode($_POST);

     $wc = WC();

     try {

        $cart_add = $wc->cart->add_to_cart((int)$_POST['product_id']);
// customize_1
        $template = wc_product_options_PLUGIN_DIR . '/views/customize_1.php';

        if ( file_exists( $template ) )
            include $template;

     } catch (Exception $e) {

           echo json_encode($e);

     }


    wp_die();


  }

  function process_logo_src_title_func() {

    $transition_uid = $_POST['transition_uid'];

    if (empty($transition_uid))
      return;

      $transition_uid = $_POST['transition_uid'];

      $data = get_transient($transition_uid);
      //$data['logo_src'] = $_POST['logo_src'];
      $data['logo_cat_title'] = $_POST['logo_title'];
      //delete_transient( $transition_uid );
      set_transient( $transition_uid, $data, 60*60*12 );
      $data['logo_title'] = $data['logo_cat_title'];

      if (strcmp($data['logo_title'], "embroidery logo") === 0)
        $template = wc_product_options_PLUGIN_DIR . '/views/customize_3_emb_logo.php';
      elseif (strcmp($data['logo_title'], "printed logo") === 0)
        $template = wc_product_options_PLUGIN_DIR . '/views/customize_3_printed_logo.php';
      elseif (strcmp($data['logo_title'], "none") === 0)
        $template = wc_product_options_PLUGIN_DIR . '/views/customize_4.php';
      else
        $template = wc_product_options_PLUGIN_DIR . '/views/customize_3_emb_logo.php';


      if ( file_exists( $template ) )
          include $template;

      //echo json_encode(get_transient($transition_uid));

      wp_die();

  }

  public static function displayScreenPrintingDataWithTrsID($transition_id = null) {

    ob_start();

    //////
    $transient_id = $transition_id;
    $data = get_transient( $transient_id );
    $product_id = $data['product_id'];

    $size_data = $data['size_data'];

    $total_count_emb = 0;
    foreach ($size_data as $key => $value) {
      $total_count_emb += (int) $value;
    }
    // var_dump($total_count_emb);

    ///////


    $data_return = "";

    $get_product_meta_my_custom_embroidery_data = get_post_meta($product_id, '_my_custom_screen_printing_data', true);

    $id = $get_product_meta_my_custom_embroidery_data;

    $terms = wp_get_post_terms( $id, 'screen_printing_color' );

    $emPricingData = array();
    $termNames = array();

  if (empty($id))
    return;

  if (strcmp($id, "none") === 0)
    return;


   foreach ($terms as $term_key => $term) {

    $termNames[] = $term->name;

    $term->name = strtolower(str_replace(' ', '', $term->name));

      $term_key_id = 'row_data_'.$term->name."_".$id;


      $emPricingData[] = get_post_meta( $id, $term_key_id, true );

  }


  $str_single_pricing_data = "";
  $countsingleData = 0;
  $tableData = array();
  $emPricingDataBreakDown = array();
  $termName_key_arr = array();


    $data_return .= "<table>";


    foreach ($termNames as $count => $termName) {

      $termName_key = strtolower(str_replace(' ', '', $termName));

      $termName_key_arr[] = $termName_key;

      $tableData['size'][] = $termName;

      // foreach ($emPricingData as $key => $SingleEmPricingData) {
      //   $emPricingDataBreakDown[$termName_key][] = $SingleEmPricingData;

      //   echo $termName_key;
      //   var_dump($SingleEmPricingData);

      // }

    }

    $termName_key_count = 0;

     foreach ($emPricingData as $key => $SingleEmPricingData) {

        $emPricingDataBreakDown[$termName_key_arr[$termName_key_count]] = $SingleEmPricingData;


      $termName_key_count++;

      }



    foreach ($tableData['size'] as $key => $single_size) {

      $termName_key = strtolower(str_replace(' ', '', $single_size));

      $data_return .= "<tr><td>{$single_size}</td>";

      $data_return .= "<td>";

      $data_return .= "<table class='screenPrintingData_subtable'>";

      $data_return .= "</tr>";

      foreach ($emPricingDataBreakDown[$termName_key] as $key => $valuePricingData) {


        if ( ($valuePricingData['qty_form'] == 0) && ($valuePricingData['qty_to'] == 0) && ($valuePricingData['qty_price'] == 0))
          continue;

        $data_return .= "<td>{$valuePricingData['qty_form']} - {$valuePricingData['qty_to']}</td>";

      }

      $data_return .= "</tr>";

      foreach ($emPricingDataBreakDown[$termName_key] as $key => $valuePricingData) {

        if ( ($valuePricingData['qty_form'] == 0) && ($valuePricingData['qty_to'] == 0) && ($valuePricingData['qty_price'] == 0))
          continue;

        $data_return .= "<td> $";

        $data_return .= floatval( $valuePricingData['qty_price'] );


        $data_return .= "</td>";

      }

      $data_return .= "</tr>";


      /////////

      foreach ($emPricingDataBreakDown[$termName_key] as $key => $valuePricingData) {



        if ( ($valuePricingData['qty_form'] == 0) && ($valuePricingData['qty_to'] == 0) && ($valuePricingData['qty_price'] == 0))
          continue;

        //$data_return .= "<td>{$valuePricingData['qty_form']} - {$valuePricingData['qty_to']}</td>";

        $yes = ( (int) $valuePricingData['qty_form'] <= $total_count_emb) && ($total_count_emb <= (int) $valuePricingData['qty_to']);
        //<td>{$yes}- {$single_size}</td>

          $html_radio = '<input class="embroidery_radio_opt" type="radio" name="embroidery_logo_color_selection[]" data-yes="'.$yes.'" data-embroidery_logo_color="'.$single_size.'" value="">'.$single_size;

          $data_return .= "<td> ";
          $data_return .= ( empty($yes) ? "" : $html_radio);

          $data_return .= "</td>";

      }

      $data_return .= "</tr>";



      $data_return .= "</table>";

      $data_return .= "</td>";
      $data_return .= "</tr>";

    }

    $data_return .= "</table>";








    _e($data_return);

    $output = ob_get_contents();


    return $output;



  }




      public static function displayEmbroiderPricingDataTransID($transient_id = null) {

        ob_start();

        //////

        $data = get_transient( $transient_id );
        // var_dump($data);
        $product_id = $data['product_id'];

        $size_data = $data['size_data'];

        $total_count_emb = 0;
        foreach ($size_data as $key => $value) {
          $total_count_emb += (int) $value;
        }
        // var_dump($total_count_emb);

        ///////
        $data_return = "";

        $get_product_meta_my_custom_embroidery_data = get_post_meta($product_id, '_my_custom_embroidery_data', true);

        $id = $get_product_meta_my_custom_embroidery_data;

      if (empty($id))
        return;

      if (strcmp($id, "none") === 0)
        return;

        $terms = wp_get_post_terms( $id, 'embroidery_size' );

        $emPricingData = array();
        $termNames = array();

       foreach ($terms as $term_key => $term) {

        $termNames[] = $term->name;

        $term->name = strtolower(str_replace(' ', '', $term->name));

          $term_key_id = 'row_data_'.$term->name."_".$id;


          $emPricingData[] = get_post_meta( $id, $term_key_id, true );

      }

      $str_single_pricing_data = "";
      $countsingleData = 0;
      $tableData = array();
      $emPricingDataBreakDown = array();
      $termName_key_arr = array();


        $data_return .= "<table>";

        foreach ($termNames as $count => $termName) {

          $termName_key = strtolower(str_replace(' ', '', $termName));

          $termName_key_arr[] = $termName_key;

          $tableData['size'][] = $termName;

          // foreach ($emPricingData as $key => $SingleEmPricingData) {
          //   $emPricingDataBreakDown[$termName_key][] = $SingleEmPricingData;

          //   echo $termName_key;
          //   var_dump($SingleEmPricingData);

          // }

        }

        $termName_key_count = 0;

         foreach ($emPricingData as $key => $SingleEmPricingData) {

            $emPricingDataBreakDown[$termName_key_arr[$termName_key_count]] = $SingleEmPricingData;


          $termName_key_count++;

          }


        foreach ($tableData['size'] as $key => $single_size) {

          $termName_key = strtolower(str_replace(' ', '', $single_size));

          $data_return .= "<tr><td>{$single_size}</td>";

          $data_return .= "<td>";

          $data_return .= "<table class='embroideryPricingData_subtable'>";

          $data_return .= "</tr>";

          foreach ($emPricingDataBreakDown[$termName_key] as $key => $valuePricingData) {


            if ( ($valuePricingData['qty_form'] == 0) && ($valuePricingData['qty_to'] == 0) && ($valuePricingData['qty_price'] == 0))
              continue;

            $data_return .= "<td>{$valuePricingData['qty_form']} - {$valuePricingData['qty_to']}</td>";

          }

          $data_return .= "</tr>";

          foreach ($emPricingDataBreakDown[$termName_key] as $key => $valuePricingData) {

            if ( ($valuePricingData['qty_form'] == 0) && ($valuePricingData['qty_to'] == 0) && ($valuePricingData['qty_price'] == 0))
              continue;

            $data_return .= "<td> $";

            $data_return .= floatval( $valuePricingData['qty_price'] );


            $data_return .= "</td>";

          }

          $data_return .= "</tr>";

          ///

          foreach ($emPricingDataBreakDown[$termName_key] as $key => $valuePricingData) {


            if ( ($valuePricingData['qty_form'] == 0) && ($valuePricingData['qty_to'] == 0) && ($valuePricingData['qty_price'] == 0))
              continue;

            //$data_return .= "<td>{$valuePricingData['qty_form']} - {$valuePricingData['qty_to']}</td>";

            $yes = ( (int) $valuePricingData['qty_form'] <= $total_count_emb) && ($total_count_emb <= (int) $valuePricingData['qty_to']);
            //<td>{$yes}- {$single_size}</td>
              $html_radio = '<input class="embroidery_radio_opt" type="radio" name="embroidery_logo_size_selection[]" data-yes="'.$yes.'" data-embroidery_logo_size="'.$single_size.'" value="">'.$single_size;

              $data_return .= "<td> ";

              $data_return .= ( empty($yes) ? "" : $html_radio);

              $data_return .= "</td>";


          }

          $data_return .= "</tr>";
          ///

          $data_return .= "</table>";

          $data_return .= "</td>";
          $data_return .= "</tr>";

        }

        $data_return .= "</table>";








        _e($data_return);

        $output = ob_get_contents();


        return $output;

      }





  public function process_color_amount_func() {

    $post_id = $_POST['product_id'];

    if (empty($post_id))
      return;

      $data['product_id'] = $post_id;
      $data['size_data'] = $_POST['size_data'];
      $data['color_val'] = $_POST['color_val'];

      $unique_id = uniqid('user_products_', true);
      delete_transient($unique_id);
      set_transient( $unique_id, $data, 60*60*12 );

      $template = wc_product_options_PLUGIN_DIR . '/views/customize_2.php';

      if ( file_exists( $template ) )
          include $template;

      wp_die();

      //echo json_encode(array('transition_id' => $unique_id, 'content' => $html));


  }


  public function calculate_base_price($product_id = null, $total = null) {

    $post_id = $product_id;
    $total_product = $total;

    $product_ruleset_id = get_post_meta($post_id, '_wc_bulk_pricing_ruleset', true);

    if (empty($product_ruleset_id))
      return;

      $the_ruleset = $this->get_custom_product_ruleset( $product_ruleset_id );

      $match_prices = array();

      foreach ($the_ruleset['rules'] as $key => $value) {


      if ($total_product >= (double) $value['min'] && $total_product <= (double) $value['max'])
         $match_prices[] = 100 - $value['val'];

      if ($total_product >= (double) $value['min'] && empty((double) $value['max']))
         $match_prices[] = 100 - $value['val'];


      }

      $discount_amount = 0;

      foreach ($match_prices as $key => $match_price) {

        if ($match_price > $discount_amount)
          $discount_amount = $match_price;

      }

      $product = new WC_Product($post_id);

       $data = array(
       'base_price' => $product->get_price(),
       'discount_amount' => $discount_amount,
       'single_price_after_discount' => (float) $product->get_price() - (($discount_amount / 100) * $product->get_price()),
       'total_price_after_discount' => (float) $total_product * ($product->get_price() - (($discount_amount / 100) * $product->get_price())),
       'total' => $total_product
        );

      return $data['total_price_after_discount'];

  }



  public function add_calculate_total_update_func() {

    $post_id = $_POST['product_id'];
    $total_product = $_POST['total'];

    $product_ruleset_id = get_post_meta($post_id, '_wc_bulk_pricing_ruleset', true);

    if (empty($product_ruleset_id)) {

      $this->add_calculate_total_update_func_single_price( $_POST );
      wp_die();
    }

    $the_ruleset = $this->get_custom_product_ruleset( $product_ruleset_id );

    $match_prices = array();

    foreach ($the_ruleset['rules'] as $key => $value) {


    if ($total_product >= (double) $value['min'] && $total_product <= (double) $value['max'])
       $match_prices[] = 100 - $value['val'];

    if ($total_product >= (double) $value['min'] && empty((double) $value['max']))
       $match_prices[] = 100 - $value['val'];


    }

    $discount_amount = 0;

    foreach ($match_prices as $key => $match_price) {

      if ($match_price > $discount_amount)
        $discount_amount = $match_price;

    }


    $product = new WC_Product($post_id);

     $data = array(
     'base_price' => $product->get_price(),
     'discount_amount' => $discount_amount,
     'single_price_after_discount' => (float) $product->get_price() - (($discount_amount / 100) * $product->get_price()),
     'total_price_after_discount' => (float) $total_product * ($product->get_price() - (($discount_amount / 100) * $product->get_price())),
     'total' => $total_product
      );

    echo json_encode($data);

    wp_die();

  }


     function get_custom_product_ruleset( $product_ruleset_id = null ) {

        // get custom product rules
        $rules = $this->getRulesetByID($product_ruleset_id);

        return $rules;
    }

   function getRulesetByID( $ruleset_id ) {

        $rulesets = get_option('wc_bulk_pricing_rules', array() );

        if ( isset( $rulesets[ $ruleset_id ] )) {
            return $rulesets[ $ruleset_id ];
        }
        return false;
    }

  public function add_calculate_total_update_func_single_price( $post = "") {


    echo json_encode($post);

  }



  public static function get_color_attributes($post_id = "") {

    if (empty($post_id))
      return array();

  $formatted_attributes = self::get_attr($post_id);

  $color_atts = empty($formatted_attributes['color']) ? array() : $formatted_attributes['color'];

  $color_atts = explode(",", $color_atts);


  array_walk($color_atts, 'self::trim_value');


  return $color_atts;


  }


  public static function get_size_attributes($post_id = "") {

    if (empty($post_id))
      return array();

  $formatted_attributes = self::get_attr($post_id);

  $color_atts = empty($formatted_attributes['sizes']) ? array() : $formatted_attributes['sizes'];

  $color_atts = explode(",", $color_atts);


  array_walk($color_atts, 'self::trim_value');


  return $color_atts;

  }

  public static function trim_value(&$value) {

    $value = preg_replace('/\s+/','', $value);

  }

  private static function get_attr($post_id = "") {

      //$product_id = (int) $_POST['product_id'];

    if (empty($post_id))
      return array();

  $product_id = $post_id;

  $product = new WC_Product($product_id);

  $attributes = $product->get_attributes();

  foreach($attributes as $attr=>$attr_deets){

      $attribute_label = strtolower(wc_attribute_label($attr));

      if ( isset( $attributes[ $attr ] ) || isset( $attributes[ 'pa_' . $attr ] ) ) {

          $attribute = isset( $attributes[ $attr ] ) ? $attributes[ $attr ] : $attributes[ 'pa_' . $attr ];

          if ( $attribute['is_taxonomy'] ) {

              $formatted_attributes[$attribute_label] = implode( ', ', wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) ) );

          } else {

              $formatted_attributes[$attribute_label] = $attribute['value'];
          }

      }
  }

  return $formatted_attributes;

  }

  public static function render_color_name($post_id = "") {

    if (empty($post_id))
      return;

    _e("<div class='color_choose_div'>");

    $html = "";

    foreach (self::get_color_attributes($post_id) as $key => $value) {

        //d(self::color_name_to_hex($value));

        $html .= '<input type="radio" class="single_color_choice" name="single_color_choice_input[]" value='.$value.'> <span class="color" style="background: '.self::color_name_to_hex($value).'; margin: 0 0.5rem 0rem; padding: 0rem 1rem"></span>'.$value.'<br>';


    }

    _e($html);

    _e("</div>");


  }

  public static function add_basket_total_customizer_2() {

    ?>

<div class="add_calculate_total">

  <div class="add_calculate_total_price"><h2>$<span>0.00</span></h2></div>
  <div class="add_calculate_single_price"><b>$<span>0.00</span> <?php _e("per blank item", "wc-product-options"); ?><b></div>
  <div class="add_calculate_to_cart">

<a href="#" class="btn_add_calculate_total general_btn">Add To Cart</a>

  </div>

</div>

    <?php

  }

    public static function render_product_sizes($post_id = "") {

    if (empty($post_id))
      return;

    _e("<div class='product_sizes_div'>");

    $html = "";

    foreach (self::get_size_attributes($post_id) as $key => $value) {


       ?>

<div class='product_sizes_single'>
  <span class='size_title'><?php _e($value); ?></span>
  <span><button class="product_decrement">-</button></span><span class='input_no'><input name="product_sizes_single_input[]" data-size="<?php _e($value); ?>" type="text" value="0"></span><span><button class="product_increment">+</button></span>

</div>

       <?php


    }

    //_e($html);

    _e("</div>");


  }


  function load_custom_wp_frontend_style_master($hook) {

        $the_id = (empty(get_the_ID()) ? "" : get_the_ID());
        $plugins_url = plugins_url( '', dirname(__FILE__) );


        wp_register_script( 'wc-product-frontend-script', wc_product_options_PLUGIN_URL.'script_frontend.js', array( 'jquery' ), '', true );

        wp_localize_script( 'wc-product-frontend-script', 'plugin_frontend', array( 'ajax_url' => admin_url('admin-ajax.php'), 'product_id' => $the_id, 'plugins_url' => $plugins_url ));

        wp_enqueue_script( 'wc-product-frontend-script' );



  }

  public function load_frontend_product() {

    $get_product_meta_my_custom_screen_printing_data = get_post_meta(get_the_ID(), '_my_custom_screen_printing_data', true);
    $get_product_meta_my_custom_sizing_group_data = get_post_meta(get_the_ID(), '_my_custom_sizing_group_data', true);
    $get_product_meta_my_custom_print_positioning_group_data = get_post_meta(get_the_ID(), '_my_custom_print_positioning_group_data', true);
    $get_product_meta_my_custom_embroidery_data = get_post_meta(get_the_ID(), '_my_custom_embroidery_data', true);


    if ((strcmp($get_product_meta_my_custom_screen_printing_data, "none") === 0) && (strcmp($get_product_meta_my_custom_sizing_group_data, "none") === 0) && (strcmp($get_product_meta_my_custom_print_positioning_group_data, "none") === 0) && (strcmp($get_product_meta_my_custom_embroidery_data, "none") === 0))
      return;

    if (empty($get_product_meta_my_custom_screen_printing_data) && empty($get_product_meta_my_custom_sizing_group_data) && empty($get_product_meta_my_custom_print_positioning_group_data) && empty($get_product_meta_my_custom_embroidery_data))
      return;

    add_action( 'wp_enqueue_scripts', array($this, 'load_custom_wp_frontend_style') );

      /**
       * woocommerce_single_product_summary hook
       *
       * @unhooked woocommerce_template_single_title - 5
       * @unhooked woocommerce_template_single_price - 10
       * @unhooked ProductShowReviews() (inc/template-tags.php) - 15
       * @unhooked woocommerce_template_single_excerpt - 20
       * @unhooked woocommerce_template_single_add_to_cart - 30
       * @unhooked woocommerce_template_single_meta - 40
       * @unhooked woocommerce_template_single_sharing - 50
       */
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    //remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

    add_action('woocommerce_single_product_summary', array($this, 'view_woocommerce_before_single_product') ,  45);

    add_action( 'wp_enqueue_scripts', array($this, 'load_custom_product_style') );

    add_action('wp_footer', function() {

      ?>
<style>
.compare.button {
  display: none;
}

.row {
  margin: 0 auto;
  max-width: 120.5em;
  width: 100%;
}

.large-6 {
  position: relative;
  width: 30%;
}

.large-4 {
  position: relative;
  width: 65.333%;
}

</style>
      <?php

    });

  }

  function load_custom_wp_frontend_style($hook) {


    wp_enqueue_style( 'wc-product-options_wp_frontend_css', wc_product_options_PLUGIN_URL.'front_end_styles.css' );

    wp_enqueue_style( 'wc-product-options_wp_frontend_css', wc_product_options_PLUGIN_URL.'front_end_styles_sub_tab.css' );

  }

  public static function color_name_to_hex($color_name = "") {

    if (empty($color_name))
      return "#fff";

  $titan = TitanFramework::getInstance( 'wc-product-options' );

  $color_list_opt = $titan->getOption( 'color_list_opt' );

  $color_list_opt = (empty($color_list_opt) ? "" : $color_list_opt);

  $color_list_opt = explode(PHP_EOL, $color_list_opt);

  $color_list_opt = array_filter($color_list_opt);

  $color_list_opt = (empty($color_list_opt) ? array() : $color_list_opt);

  $search_color = $color_name;

  $color_index = 0;

  foreach ($color_list_opt as $key => $color) {

    $search_color = strtolower($search_color);
    $color = strtolower($color);

    $color = preg_replace('/\s+/','', $color);
    $search_color = preg_replace('/\s+/','', $search_color);

    if (strpos($color, $search_color) === 0) {

      $color_index = $key;
      break;
    }

  }

  $color_index = (empty($color_index) ? 0 : (int) $color_index);

  $the_color = preg_replace('/\s+/','', $color_list_opt[$color_index]);

  $the_color = (empty($the_color) ? "" : $the_color);

  $the_color = explode("|", $the_color);

  $the_color = (empty($the_color[1]) ? "#fff" : $the_color[1]);

  $the_color = ( (strpos($the_color, "#") === 0) ? $the_color : "#".$the_color);


  return $the_color;

  }

  public static function displayPsSizingDiscountData() {

     ob_start();

    $get_product_meta_my_custom_embroidery_data = get_post_meta(get_the_ID(), '_my_custom_sizing_group_data', true);

    $id = $get_product_meta_my_custom_embroidery_data;


  if (empty($id))
    return;

  if (strcmp($id, "none") === 0)
    return;

    $term_key_id = 'row_data_'.'sizing_groups_ps'."_".$id;

    $sizingPriceData = get_post_meta( $id , $term_key_id, true);

    if (empty($sizingPriceData))
      return;
    else
      $sizingPriceData = (is_array($sizingPriceData) ? $sizingPriceData : array());



    _e("<table class='sizing_groups_ps_table' style='float: left'>");

    _e("<tr> <th>Size</th> <th>Width (cm)</th> <th>Length (cm)</th></tr>");

    foreach ($sizingPriceData as $key => $sizingPriceDataSingle) {

    _e("<tr>" );

    _e("<td>{$sizingPriceDataSingle['row_data_sizing_sizing']}</td>");
    _e("<td>{$sizingPriceDataSingle['row_data_sizing_width']}</td>");
    _e("<td>{$sizingPriceDataSingle['row_data_sizing_length']}</td>");

    _e("</tr>");

    }

    _e("</table>");


    _e("<table class='sizing_groups_ps_table sizing_groups_ps_table_inch' style='float: right'>");

    _e("<tr> <th>Size</th> <th>Width (inch)</th> <th>Length (inch)</th></tr>");

    foreach ($sizingPriceData as $key => $sizingPriceDataSingle) {

    _e("<tr>" );

    _e("<td>{$sizingPriceDataSingle['row_data_sizing_sizing']}</td>");
    _e("<td>".round(floatval($sizingPriceDataSingle['row_data_sizing_width'] / 2.2), 2)."</td>");
    _e("<td>".round(floatval($sizingPriceDataSingle['row_data_sizing_length'] / 2.2), 2)."</td>");

    _e("</tr>");

    }

    _e("</table>");

    $output = ob_get_contents();
    return $output;


  }

  public static function displayScreenPrintingData() {

    ob_start();

    $data_return = "";

    $get_product_meta_my_custom_embroidery_data = get_post_meta(get_the_ID(), '_my_custom_screen_printing_data', true);

    $id = $get_product_meta_my_custom_embroidery_data;

    $terms = wp_get_post_terms( $id, 'screen_printing_color' );

    $emPricingData = array();
    $termNames = array();

  if (empty($id))
    return;

  if (strcmp($id, "none") === 0)
    return;


   foreach ($terms as $term_key => $term) {

    $termNames[] = $term->name;

    $term->name = strtolower(str_replace(' ', '', $term->name));

      $term_key_id = 'row_data_'.$term->name."_".$id;


      $emPricingData[] = get_post_meta( $id, $term_key_id, true );

  }


  $str_single_pricing_data = "";
  $countsingleData = 0;
  $tableData = array();
  $emPricingDataBreakDown = array();
  $termName_key_arr = array();


    $data_return .= "<table>";


    foreach ($termNames as $count => $termName) {

      $termName_key = strtolower(str_replace(' ', '', $termName));

      $termName_key_arr[] = $termName_key;

      $tableData['size'][] = $termName;

      // foreach ($emPricingData as $key => $SingleEmPricingData) {
      //   $emPricingDataBreakDown[$termName_key][] = $SingleEmPricingData;

      //   echo $termName_key;
      //   var_dump($SingleEmPricingData);

      // }

    }

    $termName_key_count = 0;

     foreach ($emPricingData as $key => $SingleEmPricingData) {

        $emPricingDataBreakDown[$termName_key_arr[$termName_key_count]] = $SingleEmPricingData;


      $termName_key_count++;

      }



    foreach ($tableData['size'] as $key => $single_size) {

      $termName_key = strtolower(str_replace(' ', '', $single_size));

      $data_return .= "<tr><td>{$single_size}</td>";

      $data_return .= "<td>";

      $data_return .= "<table class='screenPrintingData_subtable'>";

      $data_return .= "</tr>";

      foreach ($emPricingDataBreakDown[$termName_key] as $key => $valuePricingData) {


        if ( ($valuePricingData['qty_form'] == 0) && ($valuePricingData['qty_to'] == 0) && ($valuePricingData['qty_price'] == 0))
          continue;

        $data_return .= "<td>{$valuePricingData['qty_form']} - {$valuePricingData['qty_to']}</td>";

      }

      $data_return .= "</tr>";

      foreach ($emPricingDataBreakDown[$termName_key] as $key => $valuePricingData) {

        if ( ($valuePricingData['qty_form'] == 0) && ($valuePricingData['qty_to'] == 0) && ($valuePricingData['qty_price'] == 0))
          continue;

        $data_return .= "<td> $";

        $data_return .= floatval( $valuePricingData['qty_price'] );


        $data_return .= "</td>";

      }

      $data_return .= "</tr>";

      $data_return .= "</table>";

      $data_return .= "</td>";
      $data_return .= "</tr>";

    }

    $data_return .= "</table>";








    _e($data_return);

    $output = ob_get_contents();


    return $output;



  }



  public static function displayEmbroiderPricingData() {
    ob_start();

    $data_return = "";

    $get_product_meta_my_custom_embroidery_data = get_post_meta(get_the_ID(), '_my_custom_embroidery_data', true);

    $id = $get_product_meta_my_custom_embroidery_data;

  if (empty($id))
    return;

  if (strcmp($id, "none") === 0)
    return;

    $terms = wp_get_post_terms( $id, 'embroidery_size' );

    $emPricingData = array();
    $termNames = array();

   foreach ($terms as $term_key => $term) {

    $termNames[] = $term->name;

    $term->name = strtolower(str_replace(' ', '', $term->name));

      $term_key_id = 'row_data_'.$term->name."_".$id;


      $emPricingData[] = get_post_meta( $id, $term_key_id, true );

  }

  $str_single_pricing_data = "";
  $countsingleData = 0;
  $tableData = array();
  $emPricingDataBreakDown = array();
  $termName_key_arr = array();


    $data_return .= "<table>";

    foreach ($termNames as $count => $termName) {

      $termName_key = strtolower(str_replace(' ', '', $termName));

      $termName_key_arr[] = $termName_key;

      $tableData['size'][] = $termName;

      // foreach ($emPricingData as $key => $SingleEmPricingData) {
      //   $emPricingDataBreakDown[$termName_key][] = $SingleEmPricingData;

      //   echo $termName_key;
      //   var_dump($SingleEmPricingData);

      // }

    }

    $termName_key_count = 0;

     foreach ($emPricingData as $key => $SingleEmPricingData) {

        $emPricingDataBreakDown[$termName_key_arr[$termName_key_count]] = $SingleEmPricingData;


      $termName_key_count++;

      }


    foreach ($tableData['size'] as $key => $single_size) {

      $termName_key = strtolower(str_replace(' ', '', $single_size));

      $data_return .= "<tr><td>{$single_size}</td>";

      $data_return .= "<td>";

      $data_return .= "<table class='embroideryPricingData_subtable'>";

      $data_return .= "</tr>";

      foreach ($emPricingDataBreakDown[$termName_key] as $key => $valuePricingData) {


        if ( ($valuePricingData['qty_form'] == 0) && ($valuePricingData['qty_to'] == 0) && ($valuePricingData['qty_price'] == 0))
          continue;

        $data_return .= "<td>{$valuePricingData['qty_form']} - {$valuePricingData['qty_to']}</td>";

      }

      $data_return .= "</tr>";

      foreach ($emPricingDataBreakDown[$termName_key] as $key => $valuePricingData) {

        if ( ($valuePricingData['qty_form'] == 0) && ($valuePricingData['qty_to'] == 0) && ($valuePricingData['qty_price'] == 0))
          continue;

        $data_return .= "<td> $";

        $data_return .= floatval( $valuePricingData['qty_price'] );


        $data_return .= "</td>";

      }

      $data_return .= "</tr>";



      $data_return .= "</table>";

      $data_return .= "</td>";
      $data_return .= "</tr>";

    }

    $data_return .= "</table>";








    _e($data_return);

    $output = ob_get_contents();


    return $output;

  }

   function generate_discount_table( $post_id, $active_ruleset ) {
        $html = '<div class="bulk_pricing_discounts_wrapper">';

        // header
        if ( isset( $active_ruleset['custom_header'] ) && $active_ruleset['custom_header'] != '' ) {
            $custom_header = stripslashes( $active_ruleset['custom_header'] );
        } else {
            $custom_header = get_option( 'wc_bulk_pricing_default_header', __('Quantity discounts available', 'wc_bulk_pricing') );
            $custom_header = $custom_header ? '<b>'.$custom_header.'</b><br>' : '';
        }
        // apply filter wc_bulk_pricing_custom_header
        $custom_header = apply_filters( 'wc_bulk_pricing_custom_header', $custom_header, $active_ruleset, $post_id );
        if ( $custom_header ) $html .= $custom_header;

        if ( ! isset( $active_ruleset['hide_discount_table'] ) || $active_ruleset['hide_discount_table'] == '0' ) {
            ob_start();
            echo '<div class="bulk_pricing_discounts" id="wpl_bp_wrap">';
            woocommerce_bulk_pricing_shortcode::showHtmlTable( $active_ruleset['rules'], $post_id );
            echo '</div>';
            woocommerce_bulk_pricing_shortcode::showInlineJS( $active_ruleset['id'], $post_id );
            $html .= ob_get_clean();
        }

        // footer
        $custom_footer = '';
        if ( isset( $active_ruleset['custom_footer'] ) && $active_ruleset['custom_footer'] != '' ) {
            $custom_footer = stripslashes( $active_ruleset['custom_footer'] );
        }
        // apply filter wc_bulk_pricing_custom_header
        $custom_footer = apply_filters( 'wc_bulk_pricing_custom_footer', $custom_footer, $active_ruleset, $post_id );
        if ( $custom_footer ) $html .= $custom_footer;

        $html .= '</div>';

        $html .= '<style>
            .bulk_pricing_discounts table {
                width: 100%;
                border: 1px solid #ddd;
            }
            .bulk_pricing_discounts table th,
            .bulk_pricing_discounts table td {
                text-align:center;
                border: 1px solid #eee;
            }
            .bulk_pricing_discounts_wrapper {
                clear: both;
            }
        </style>';

        return $html;
    }


  public function load_custom_product_style() {

        wp_register_script( 'wc-product-options-script-pro_frontend', wc_product_options_PLUGIN_URL.'script_custom_pro_frontend.js', array( 'jquery' ), '', true );

        wp_localize_script( 'wc-product-options-script-pro_frontend', 'plugin_data_pro_frontend', array( 'ajax_url' => admin_url('admin-ajax.php') ));

        wp_enqueue_script( 'wc-product-options-script-pro_frontend' );

  }

  public function view_woocommerce_before_single_product() {



    $template = wc_product_options_PLUGIN_DIR . '/views/product_frontend.php';

        if ( file_exists( $template ) )
            include $template;

  }

}

$WC_pro_opt__Product_Frontend = new WC_pro_opt__Product_Frontend();

 ?>
