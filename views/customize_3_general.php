<?php

$transient = get_transient($transition_uid);

$product_id = $transient['product_id'];

// $product_id = 8357;
// $transition_uid = "fake";

$get_logo_print_positioning = get_post_meta($product_id, '_my_custom_print_positioning_group_data', TRUE);
$post_id = $get_logo_print_positioning;

$terms = wp_get_post_terms( $post_id, 'logo_printing_group_size' );
$html = "";
$term_names = array();

  foreach ($terms as $term_key => $term) {
    $html .= "<div class='term_product_data_logo_positioning'>";
    $html .= "<div class='title_term_product'><h2>".ucfirst($term->name)."</h2></div>";

    $term->name = strtolower(str_replace(' ', '', $term->name));

    $get_data = get_post_meta( $post_id, 'row_data_'.$term->name."_".$post_id, TRUE);

    $get_data = ( (empty($get_data) || !is_array($get_data)) ? array() : $get_data );
    $term_names[] = $term->name;
    $count = 1;

      foreach ($get_data as $key => $each_term_data) {

        $each_term_data = ( (empty($each_term_data) || !is_array($each_term_data)) ? array() : $each_term_data );


        if ($count%3 === 0 || $count === 1)
            $html .= '<div class="row">';

            $html .= '<div class="col-sm-4">';
            $html .= '<input type="radio" name="logo_position_selection_'.$term->name.'[]" class="logo_position" data-uid="'.$transition_uid.'" data-src="'.$each_term_data['area_src'].'" data-title="'.$each_term_data['area_title'].'" value=""> <img src="'.$each_term_data['area_src'].'" />  <br>';
            $html .= '</div>';

        if ($count%3 === 0)
          $html .= '</div>';

        $count++;

      }

      $html .= "</div><br><br>";


    }

_e($html);


 ?>


<div class="upload_custom_logo">
  <div class="transient_id" data-uid="<?php echo $transition_uid; ?>" >  </div>
  <form method="post" enctype="multipart/form-data">
      Logo upload:<br><br>
      <input type="file" name="logoUserSelected" id="logoUserSelected">
  </form>

</div>

 <div class="choose_logo_option"><br>

   <a href="#" data-terms="<?php foreach($term_names as $term_name) { _e($term_name."|"); } ?>" class="go_to_final general_btn">Final Instruction</a>

 </div>
