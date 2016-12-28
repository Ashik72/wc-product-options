<div class="container logo_select">
  <div class="title_customize">
    <h2>Choose Embroidery or Printing for your logo</h2>
  </div>

<?php

$get_logo_choice = (int) get_post_meta($post_id, '_my_custom_logo_positioning_group_data', true);

if (empty($get_logo_choice))
  wp_die();

$get_logo_data = get_post_meta($get_logo_choice, 'row_data_logo_choice_group_'.$get_logo_choice, true);

$get_logo_data = ( (empty($get_logo_data) || !is_array($get_logo_data)) ? array() : $get_logo_data );
$count = 1;
foreach ($get_logo_data as $key => $single_logo_data) {
      if ($count%3 === 0 || $count === 1)
          $html_data .= '<div class="row">';

          $html_data .= '<div class="col-sm-4">';
          $html_data .= '<input type="radio" name="logo_selection[]" data-uid="'.$unique_id.'" data-src="'.$single_logo_data['area_src'].'" data-title="'.$single_logo_data['area_title'].'" value=""> <img src="'.$single_logo_data['area_src'].'" />  <br>';
          $html_data .= '</div>';

      if ($count%3 === 0)
        $html_data .= '</div>';


        $count++;
}



_e($html_data);

?>

</div>

<div class="choose_logo_option"><br>

  <a href="#" class="btn_choose_logo_opt general_btn">Choose Logo Option</a>

</div>
