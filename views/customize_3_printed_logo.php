<div class="embroideryPricingData">

  <div class="title_customize">
    <h2>Step Two - Screen Printing</h2>
    <br>
    <h3>(Need Help? <a href="/screen_printing_help"> Click Here</a>)</h3>
  </div>
<?php
WC_pro_opt__Product_Frontend::displayScreenPrintingDataWithTrsID($transition_uid);

 ?>


 </div>

 <div class="logoPrintPositioning">

 <?php

 $template = wc_product_options_PLUGIN_DIR . '/views/customize_3_general.php';


 if ( file_exists( $template ) )
   include $template;


  ?>

 </div>
