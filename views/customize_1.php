<div class="container">
    <div class="row">

<form action=""></form>

        <div class="col-sm-4">
        	<?php 

        		WC_pro_opt__Product_Frontend::render_color_name($_POST['product_id']);

        	 ?>

        </div>
        <div class="col-sm-4">

	       	<?php 

        		WC_pro_opt__Product_Frontend::render_product_sizes($_POST['product_id']);

        	 ?>


        </div>
        <div class="col-sm-4">
        	
		<?php 

		 		WC_pro_opt__Product_Frontend::add_basket_total_customizer_2();

		 ?>

        </div>
    </div>
</div>