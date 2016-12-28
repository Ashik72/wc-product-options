<div class="embroideryPricingData">

  <div class="title_customize">
    <h2>Step Two - Choose Logo Embroidery</h2>
  </div>
<?php

WC_pro_opt__Product_Frontend::displayEmbroiderPricingDataTransID($transition_uid);


 ?>

 </div>


<div class="logoPrintPositioning">

<?php

$template = wc_product_options_PLUGIN_DIR . '/views/customize_3_general.php';


if ( file_exists( $template ) )
  include $template;


 ?>

</div>
