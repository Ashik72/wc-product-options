<?php

if(!defined('WPINC')) // MUST have WordPress.
	exit('Do NOT access this file directly: '.basename(__FILE__));

ob_start();

$post_id = $_GET['post'];
if (empty($post_id))
	return;

$terms = wp_get_post_terms( $post_id, 'embroidery_size' );

if (empty($terms))
	return;



foreach ($terms as $term_key => $term) {



	_e('<div class="discount_entry_embroidery embroidery_'.strtolower(str_replace(' ', '', $term->name)).'" id="unique_'.$post_id."_".strtolower(str_replace(' ', '', $term->name)).'">');


	_e("<div class='embroidery_title' id='unique_title_".strtolower(str_replace(' ', '', $term->name))."'>".$term->name." Logo</div>");
	_e("<br>");

	$term->name = strtolower(str_replace(' ', '', $term->name));

	$row_key = 'needed_row_'.$term->name."_".$post_id;


	$get_data_prev = (!empty(get_post_meta( $post_id, 'row_data_'.$term->name."_".$post_id, true )) ? get_post_meta( $post_id, 'row_data_'.$term->name."_".$post_id, true ) : array());



	$get_needed_field = (int) get_post_meta( $post_id, $row_key, true );
	$get_needed_field = (empty($get_needed_field) ? 5 : $get_needed_field);

	$html_div_table = '';


	$html_div_table .= '<div class="container row_title_embroidery" id="unique_row_title_embroidery_'.strtolower(str_replace(' ', '', $term->name)).'">';
	$html_div_table .= '
    <div class="row">
        <div class="col-sm-4">Qty From</div>
        <div class="col-sm-4">Qty To</div>
        <div class="col-sm-4">Price</div>
    </div>
</div><br>';

	_e($html_div_table);

	for ($i=0; $i < $get_needed_field; $i++) {


		$html_div_table = '<div class="container">
    <div class="row">
        <div class="col-sm-4"><input type="text" name="row_data_qty_form_'.strtolower(str_replace(' ', '', $term->name)).'_'.$post_id.'[]" value="'.(!empty($get_data_prev[$i]['qty_form']) ? $get_data_prev[$i]['qty_form'] : "").'" /></div>
        <div class="col-sm-4"><input type="text" name="row_data_qty_to_'.strtolower(str_replace(' ', '', $term->name)).'_'.$post_id.'[]" value="'.(!empty($get_data_prev[$i]['qty_to']) ? $get_data_prev[$i]['qty_to'] : "").'" /></div>
        <div class="col-sm-4"><input type="text" name="row_data_qty_price_'.strtolower(str_replace(' ', '', $term->name)).'_'.$post_id.'[]" value="'.(!empty($get_data_prev[$i]['qty_price']) ? $get_data_prev[$i]['qty_price'] : "").'" /></div>
    </div>
</div>';
		_e($html_div_table);



	}

	_e("<br>");

	_e('Need <input class="need_row_input" type="text" name="needed_row_'.$term->name."_".$post_id.'" value="'.$get_needed_field.'" /> rows for this one...');
	_e('</div>');
	_e("<br>");
	_e("<br><hr>");

}

$output = ob_get_clean();

echo $output;

?>
