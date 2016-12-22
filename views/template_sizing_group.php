<?php

if(!defined('WPINC')) // MUST have WordPress.
	exit('Do NOT access this file directly: '.basename(__FILE__));

ob_start();
  $post_id = $_GET['post'];

if (empty($post_id))
  	$box_type = "blank";

if (!empty($_GET['post_type']))
  $_GET['post_type'] = $_GET['post_type'];
elseif (!empty($_GET['post']))
  $_GET['post_type'] = get_post_type($_GET['post']);


    $post_type = strtolower(str_replace(' ', '', $_GET['post_type']));
  	$row_key = 'needed_row_'.$post_type."_".$post_id;
    $get_needed_field = (int) get_post_meta( $post_id, $row_key, true );

    if ($get_needed_field === 0 && $box_type === "blank")
      $the_needed_field = 10;
    else
      $the_needed_field = $get_needed_field;


    $html_div_table .= '<div class="container row_title_screen_printing" id="unique_row_screen_printing'.strtolower(str_replace(' ', '', $term->name)).'">';
  	$html_div_table .= '
      <div class="row">
          <div class="col-sm-3">Order</div>
          <div class="col-sm-3">Sizing</div>
          <div class="col-sm-3">Width (cm)</div>
          <div class="col-sm-3">Length (cm)</div>
      </div>
  </div><br>';

  	_e($html_div_table);

    $get_data_prev = (!empty(get_post_meta( $post_id, 'row_data_'.$post_type."_".$post_id, true )) ? get_post_meta( $post_id, 'row_data_'.$post_type."_".$post_id, true ) : array());


  	for ($i=0; $i < $the_needed_field; $i++) {


  		$html_div_table = '<div class="container">
      <div class="row">
          <div class="col-sm-3"><input type="text" name="row_data_sizing_order_'.strtolower(str_replace(' ', '', $post_type)).'_'.$post_id.'[]" value="'.(!empty($get_data_prev[$i]['row_data_sizing_order']) ? $get_data_prev[$i]['row_data_sizing_order'] : "").'" /></div>
          <div class="col-sm-3"><input type="text" name="row_data_sizing_sizing_'.strtolower(str_replace(' ', '', $post_type)).'_'.$post_id.'[]" value="'.(!empty($get_data_prev[$i]['row_data_sizing_sizing']) ? $get_data_prev[$i]['row_data_sizing_sizing'] : "").'" /></div>
          <div class="col-sm-3"><input type="text" name="row_data_sizing_width_'.strtolower(str_replace(' ', '', $post_type)).'_'.$post_id.'[]" value="'.(!empty($get_data_prev[$i]['row_data_sizing_width']) ? $get_data_prev[$i]['row_data_sizing_width'] : "").'" /></div>
          <div class="col-sm-3"><input type="text" name="row_data_sizing_length_'.strtolower(str_replace(' ', '', $post_type)).'_'.$post_id.'[]" value="'.(!empty($get_data_prev[$i]['row_data_sizing_length']) ? $get_data_prev[$i]['row_data_sizing_length'] : "").'" /></div>
      </div>
  </div>';
  		_e($html_div_table);

}

_e('<br><br>Need <input class="need_row_input" type="text" name="needed_row_'.$post_type."_".$post_id.'" value="'.$the_needed_field.'" /> rows for this one...');

$output = ob_get_clean();

echo $output;

?>
