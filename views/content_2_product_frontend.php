<div class="qtyDiscountData">

<h2>Base Pricing</h2>
<?php 

echo do_shortcode('[wcbp_discount_table id="'.get_the_ID().'"]');

 ?>
 </div>

<div class="embroideryPricingData">

<h2>Embroidery</h2>
<?php 

WC_pro_opt__Product_Frontend::displayEmbroiderPricingData();

 ?>


 </div>


<div class="screenPrintingData">

<h2>Screen Printing</h2>

<?php 

WC_pro_opt__Product_Frontend::displayScreenPrintingData();

 ?>
 </div>


<!-- <a href="#" class="btn_cr_order">Create Order</a>
 -->