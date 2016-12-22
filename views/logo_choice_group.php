<?php

if(!defined('WPINC')) // MUST have WordPress.
	exit('Do NOT access this file directly: '.basename(__FILE__));

ob_start();

$term_name = "logo_choice_group";
$post_id = $_GET['post'];
if (empty($post_id))
	return;

// $terms = wp_get_post_terms( $post_id, 'logo_choice_group_size' );
//
// if (empty($terms))
// 	return;


//foreach ($terms as $term_key => $term) {

  $get_data_prev = (!empty(get_post_meta( $post_id, 'row_data_'.$term_name."_".$post_id, true )) ? get_post_meta( $post_id, 'row_data_'.$term_name."_".$post_id, true ) : array());



	_e('<div class="logo_choice_group_size logo_choice_group_'.strtolower(str_replace(' ', '', $term_name)).'" id="unique_'.$post_id."_".strtolower(str_replace(' ', '', $term_name)).'">');


	_e("<div class='logo_choice_group_size_title' id='unique_title_".strtolower(str_replace(' ', '', $term_name))."'></div>");
	_e("<br>");

	$term_name = strtolower(str_replace(' ', '', $term_name));



  $html_data = '<div class="container image_upload_sections section_row_'.$term_name.'">';

  $count_col = 1;
  $element_count = 0;
  foreach ($get_data_prev as $key => $prev_data) {


    if ($count_col%3 === 0)
        $html_data .= '<div class="row">';


        $html_data .= '<div class="col-sm-4"><div>';
        $html_data .= '<img height="140" width="100" src="'.$get_data_prev[$element_count]['area_src'].'" />';
        $html_data .= '<span><a href="#" class="delete_this_img">X</a></span>';
        $html_data .= '</div><br><div>';
        $html_data .= '<input type="hidden" name="'.$term_name.'_'.$post_id.'_area_src[]" value="'.$get_data_prev[$element_count]['area_src'].'">';
        //col_data .= '<br><br>';
        $html_data .= '<input type="text" name="'.$term_name.'_'.$post_id.'_area_title[]" value="'.$get_data_prev[$element_count]['area_title'].'"><br><br></div></div>';

    if ($count_col%3 === 0)
    $html_data .= '</div>';

    $count_col++;
    $element_count++;
  }

    $html_data .= '<div class="row">

    </div>
</div>';

_e($html_data);


	_e('</div>');
	_e("<br>");
	_e("<br><hr>");

//}

$output = ob_get_clean();

echo $output;

?>
