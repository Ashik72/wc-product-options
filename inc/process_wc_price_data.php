<?php

if(!defined('WPINC')) // MUST have WordPress.
	exit('Do NOT access this file directly: '.basename(__FILE__));


add_action( 'woocommerce_before_calculate_totals', 'add_custom_price' );

add_action('woocommerce_add_order_item_meta', 'add_order_item_meta_test_raw', 10, 2);

function add_order_item_meta_test_raw($item_id, $values) {

  if (empty($_COOKIE['transient_id']))
    return;

    $transient_id = $_COOKIE['transient_id'];

    $data = get_transient($transient_id);

    $data_items = $data;

    if (empty($data_items))
      return;

      foreach ($data_items as $key => $value) {


                  if (strcmp($key, "color_val") === 0)
                    woocommerce_add_order_item_meta($item_id, "Product Color: ", $value);

                  if (strcmp($key, "size_data") === 0)
                    woocommerce_add_order_item_meta($item_id, "Product Sizes: ", WC_pro_opt__Product_Frontend::size_data_toString($value));

                  if (strcmp($key, "logo_cat_title") === 0)
                    woocommerce_add_order_item_meta($item_id, "Product Logo Type: ", $value);

                  if (strcmp($key, "embroidery_option") === 0)
                    woocommerce_add_order_item_meta($item_id, "Logo Embroidery Option (ignore if undefined): ", $value);

                  if (strcmp($key, "color_option") === 0)
                    woocommerce_add_order_item_meta($item_id, "Logo Color Option (ignore if undefined): ", $value);

                  if (strcmp($key, "image_logo_uploaded") === 0)
                    woocommerce_add_order_item_meta($item_id, "Logo : ", $value);

                  if (strcmp($key, "logo_positioning_select") === 0)
                    woocommerce_add_order_item_meta($item_id, "Product Logo Positions: ", WC_pro_opt__Product_Frontend::logo_pos_toString($value));



      }


    $key = 'k2'; // Define your key here
    $value = 'v2'; // Get your value here
    //woocommerce_add_order_item_meta($item_id, $key, $value);

    delete_transient($transient_id);

}


function add_order_item_meta($item_id) {

		if (empty($_COOKIE['transient_id']))
			return;

      $transient_id = $_COOKIE['transient_id'];

      $data = get_transient($transient_id);

		$data_items = $data;



		//$data_items = maybe_unserialize(stripslashes($data_items));

		$the_item_meta = $data_items;

    $the_item_meta = array('test_k1' => 'val_1', 'test_k2' => 'val_2');

    if(!empty($the_item_meta)){

      $get_meta = $the_item_meta;

      foreach ($get_meta as $key => $value) {

        woocommerce_add_order_item_meta($item_id, $key, $value);

      }

    }

 }

function add_custom_price( $cart_object ) {


if (empty($_COOKIE['transient_id']))
	return;
//
$transient_id = $_COOKIE['transient_id'];
//
$data = get_transient($transient_id);
//

//$data = maybe_unserialize(stripslashes($data));

// $data['product_id'] = 8357;

////Price Generate
//base

if (empty($data['size_data']))
  return;

$size_data = $data['size_data'];

$total_count_emb = 0;
foreach ($size_data as $key => $value) {
  $total_count_emb += (int) $value;
}

$post_id = $data['product_id'];
$total_product = $total_count_emb;

$product_ruleset_id = get_post_meta($post_id, '_wc_bulk_pricing_ruleset', true);
$ruleset_id = $product_ruleset_id;

if (empty($product_ruleset_id))
  return;

$rulesets = get_option('wc_bulk_pricing_rules', array() );

if ( isset( $rulesets[ $ruleset_id ] )) {
    $the_ruleset = $rulesets[ $ruleset_id ];
}

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

$data['base_price_total'] = (float) $total_product * ($product->get_price() - (($discount_amount / 100) * $product->get_price()));

file_put_contents('testBasePrice.txt', $data['base_price_total']);

///base end


// $cart = WC()->instance()->cart;
// $pid = $post_id;
//   $cart_id = $cart->generate_cart_id($pid);
//   $cart_item_id = $cart->find_product_in_cart($cart_id);
//   if($cart_item_id){
//     d($cart->set_quantity($cart_item_id,1));
//     d($cart->set_quantity($cart_item_id, $total_count_emb));
//   }

///emb printed price

$data['emb_printed_price'] = WC_pro_opt__Product_Frontend::calculate_emb_color_pric($transient_id);
//emb printed end

$data['price'] = $data['emb_printed_price'] + $data['base_price_total'];
//$data['price'] = $data['base_price_total'];

////Price Generate ends

$custom_price = (float) $data['price'];

if (empty($custom_price)) {

  $_product = wc_get_product( $data['product_id'] );

  $custom_price = (float) $_product->get_price();

}



$target_product_id = $data['product_id'];

foreach ( $cart_object->cart_contents as $value ) {
    if ( $value['product_id'] == $target_product_id ) {
        $value['data']->price = $custom_price;
        file_put_contents('testPrice.txt', maybe_serialize($custom_price), FILE_APPEND);
    }
    /*
    // If your target product is a variation
    if ( $value['variation_id'] == $target_product_id ) {
        $value['data']->price = $custom_price;
    }
    */
}


///////Item data

$item_id = wc_add_order_item( $target_product_id, array(
  'order_item_name' 		=> "test Name",
  'order_item_type' 		=> 'line_item'
) );

wc_add_order_item_meta( $item_id, 'test_line_data', "ff" );


}
